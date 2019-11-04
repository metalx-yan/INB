@extends('main')

@section('title', 'Upload File')

@section('content')
    <div class="container-fluid">
       
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Query Balace</li>
                </ol>
            </div>
        </div>
        
        <div class="card">
            <div class="card-title">
                <br>
                <div class="container">
                    <form action="{{ route('upload-file') }}" method="get" enctype="multipart/form-data">
                            <div class="row">
                                <input type="hidden" name="id">
                                <div class="col-md-4">
                                    <label for="">Jenis</label>
                                    <select name="categories" id="categories" class="form-control">
                                        <option value="">=====</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="">Pilihan Kunci</label>
                                    <select name="key" id="key" class="form-control" >
                                        <option value="">=====</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="">Upload File</label>
                                    <input type="file" name="upload" id="upload">
                                </div>
                                
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Column</label>
                                    <br>
                                    <select name="accounts[]" id="accounts" class="form-control" multiple>
                                        @for($i = 0; $i < sizeof($columns); $i++)
                                            <option value="{{ $columns[$i] }}">{{ ucfirst(str_replace('_', ' ',$columns[$i]) )}}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="">Tahun</label>
                                    <br>
                                    <select name="years" id="years" class="form-control">
                                        <option value="">=====</option>
                                        @foreach ($acc as $accs => $dis)
                                        <option value="{{ $accs }}">{{ $accs }}</option>
                                        @endforeach
                                    </select>
                                </div>
                               
                                <div class="col-md-4">
                                    <label for="">Bulan</label>
                                    <br>
                                    <select name="months" id="months" class="form-control">
                                        <option value="">=====</option>
                                        @foreach ($accn as $accnt => $disa)
                                            {{ var_dump($accnt) }}
                                            <option value="{{ $accnt }}">{{ $accnt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">&nbsp;</label>
                                        <br>
                                        <button type="submit" id="button" class="btn btn-primary" style="margin-left: 404%;">Execute</button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            {{-- <a href="{{ route('export.file') }}" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a> --}}
                            {{-- <table class="table border" id="myTable">
                                <thead>
                                    <tr>
                                        @for($i = 0; $i < sizeof($columns); $i++)
                                            @if ($account != null)
                                                @foreach ($account as $accn)
                                                    @if ($columns[$i] == $accn)
                                                        <th>{{ ucfirst(str_replace('_', ' ',$columns[$i]) )}}</th>
                                                    @endif
                                                @endforeach
                                            @else
                                                <th></th>
                                            @endif
                                        @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($records as $row)
                                            <tr>
                                                @foreach($row as $key => $data)
                                                    @if ($account != null)
                                                        @foreach ($account as $accn)
                                                            @if ($key == $accn)
                                                                <td>{{ $data }}</td>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                </tbody>
                            </table> --}}
                        </div>
                    </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
   
    <script type="text/javascript"> 
        $(document).ready(function () {
                $('#myTable').DataTable({
                    dom: 'Bfrtip',
                    buttons: ['excel']
                });
            
        });
    </script>

    {{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href=" {{ asset('css/jquery.multiselect.css') }} ">
    <script src=" {{ asset('js/jquery.multiselect.js') }} "></script>
    <script>
    $(document).ready(function(){
        $('#products').multiselect({
        columns  : 3,
        search   : true,
        selectAll: true,
        texts    : {
            placeholder: 'Select States',
            search     : 'Search States'
        }
    }); 
    });
    </script>

    <script>
        $('#accounts').multiselect();
    </script>

    <script>
    $(document).ready(function(){
        $('#regions').on('change', function(e){
            console.log(e.target.value);
            var region_id = e.target.value;
            $.get('/api/json-branches?region_id=' + region_id , function(data){
                console.log(data);
                $('#branches').empty();
                $('#branches').append('<option value="0" disabled="true" selected="true">=======</option>');

                $.each(data, function(index, branchesObj) {
                    console.log(branchesObj.id + '-' + branchesObj.name);
                    $('#branches').append('<option value="' + branchesObj.id + '" >' + branchesObj.name.substring( 0, 1 ).toUpperCase() + branchesObj.name.substring( 1 ) + '</option>');
                });
            });
        });
    });
    </script>
    
    <script>
        $(document).ready(function(){
            $('#categories').on('change', function(e){
                console.log(e.target.value);
                var category_id = e.target.value;
                $.get('/api/json-products?category_id=' + category_id , function(data){
                    console.log(data);
                    $('#products').empty();
                    $('#products').append('<option value="0" selected="true">=======</option>');

                    $.each(data, function(index, productsObj) {
                        console.log(productsObj.id + '-' + productsObj.name);
                        $('#products').append('<option value="' + productsObj.id + '" >' + productsObj.name.substring( 0, 1 ).toUpperCase() + productsObj.name.substring( 1 ) + '</option>');
                    });
                });
            });
        });
    </script>

<script>
        $(document).ready(function(){
            $('#years').on('change', function(e){
                console.log(e.target.value);
                // var category_id = e.target.value;
                // $.get('/api/json-products?category_id=' + category_id , function(data){
                //     console.log(data);
                //     $('#products').empty();
                //     $('#products').append('<option value="0" selected="true">=======</option>');

                //     $.each(data, function(index, productsObj) {
                //         console.log(productsObj.id + '-' + productsObj.name);
                //         $('#products').append('<option value="' + productsObj.id + '" >' + productsObj.name.substring( 0, 1 ).toUpperCase() + productsObj.name.substring( 1 ) + '</option>');
                //     });
                // });
            });
        });
    </script>

    
@endsection