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
                    <form action="{{ route('query-upload.post') }}" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <input type="hidden" name="id">
                                <div class="col-md-4">
                                    <label for="">Jenis</label>
                                    <select name="categories" id="categories" class="form-control">
                                        <option value="">Pilih Jenis</option>
                                        @foreach ($categories as $category)
                                                <option value="{{ $category->jenis }}">{{ $category->jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="">Pilihan Kunci</label>
                                    <select name="choose" id="choose" class="form-control" >
                                        <option value="">Pilih Kunci</option>
                                        <option value="ID_NUMBER">No Account</option>
                                        <option value="BNI_CIF_KEY">BNI Cif Key</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="">Upload File</label>
                                    <input type="file" name="upload" id="upload">
                                    <label for=""><i style="font-size: 10px; color:red;">Upload dengan ekstensi .txt</i></label>
                                </div>
                                
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Column</label>
                                    <br>
                                    <select name="accounts[]" id="accounts" class="form-control" multiple>
                                        @for($i = 0; $i < sizeof($cols); $i++)
                                            <option value="{{ $cols[$i] }}">{{ ucfirst(str_replace('_', ' ',$cols[$i]) )}}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="">Tahun</label>
                                    <br>
                                    <select name="years" id="years" class="form-control">
                                        <option value="">Pilih Tahun</option>
                                    </select>
                                </div>
                               
                                <div class="col-md-4">
                                    <label for="">Bulan</label>
                                    <br>
                                    <select name="months" id="months" class="form-control">
                                        <option value="">Pilih Bulan</option>
                                    </select>
                                </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Tanggal</label>
                                        <br>
                                        <select name="days" id="days" class="form-control">
                                            <option value="">Pilih Tanggal</option>
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

                            @if ($account == null)
                                
                            @else
                                
                            {{-- <a href="{{ route('export.file') }}" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a> --}}
                            <table class="table border" id="myTable">
                                <thead>
                                    <tr>
                                            @for($i = 0; $i < sizeof($cols); $i++)
                                                @if ($account != null)
                                                    @foreach ($account as $accn)
                                                        @if ($cols[$i] == $accn)
                                                            <th>{{ ucfirst(str_replace('_', ' ',$cols[$i]) )}}</th>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <th></th>
                                                @endif
                                            @endfor
                                    </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($queries->toArray() as $row) 
                                            <tr>
                                                    @foreach ($row as $column => $value)
                                                        @foreach ($account as $acct)
                                                            @if ($acct == $column)
                                                                    <td>{{ $value }}</td>
                                                            @endif
                                                        @endforeach
                                                     @endforeach
                                            </tr>
                                            @endforeach
                                </tbody>
                            </table>
                            @endif

                        </div>
                    </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> --}}
<script src="{{ asset('js/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('js/js/jszip.min.js') }}"></script>
<script src="{{ asset('js/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/js/buttons.print.min.js') }}"></script>
   
    <script type="text/javascript"> 
        $(document).ready(function () {
                $('#myTable').DataTable({
                    dom: 'Bfrtip',
                    buttons: ['excel'],
                    "ordering": false,
                    "info": false,
                    pageLength : 10,
                    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
                });
        });
    </script>

    {{-- <script>
        $(function() {
            var table = $('#myTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('query-upload.post') }}",
                
                columns: [
                    { data : 'AS_OF_DATE', name : 'AS_OF_DATE' },
                    { data : 'GL_ACCOUNT_ID', name : 'GL_ACCOUNT_ID' },
                    { data : 'BRANCH_CODE', name : 'BRANCH_CODE' },
                    { data : 'MARKET_SEGMENT_CD', name : 'MARKET_SEGMENT_CD' },
                    { data : 'BNI_CIF_KEY', name : 'BNI_CIF_KEY' },
                    { data : 'ID_NUMBER', name : 'ID_NUMBER' }
                ]
            });
    
            var test = @json($cols);
            for (let index = 0; index < test.length; index++) {
                var element = test[index];
                console.log(element);
                // var asek = @json($cals);
                // asek.forEach(function(entry) {
                // });
            }
        });
    </script> --}}

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
            $('#categories').on('change', function(e){
                console.log(e.target.value);
                var category_id = e.target.value;

                if (category_id == "DEPOSITO") {
                    $.get('http://192.168.7.32:8080/bni/public/api/json-year-balance?TABLE_NAME=pdm_hsl_summary_deposito_', function(data){
                        console.log(data);
                        var as = data.map(item => item.TABLE_NAME.slice(0,29))
                        .filter((value, index, self) => self.indexOf(value) === index)
                        $('#years').empty();
                        $('#years').append('<option value="0" selected="true">Pilih Tahun</option>');
                        
                        $.each(as, function(index, yearsObj) {
                            if (yearsObj.substr(25,4).includes('_') == false ) {
                                console.log(yearsObj.substr(0,29));
                                $('#years').append('<option value="' + yearsObj.substr(0, 29) + '" >' + yearsObj.substr(25,4) + '</option>');
                            } 
                        }); 
                    });
                } else {
                    $.get('http://192.168.7.32:8080/bni/public/api/json-year-balance?TABLE_NAME=deposit_prod_', function(data){
                        console.log(data);
                        var ass = data.map(item => item.TABLE_NAME.slice(0,17))
                        .filter((value, index, self) => self.indexOf(value) === index)
                        $('#years').empty();
                        $('#years').append('<option value="0" selected="true">Pilih Tahun</option>');
                        
                        $.each(ass, function(index, yearsObj) {
                            if (yearsObj.substr(13, 4).includes('_') == false ) {
                                console.log(yearsObj.substr(0,17));
                                $('#years').append('<option value="' + yearsObj.substr(0, 17) + '" >' + yearsObj.substr(13,4) + '</option>');
                            }
                        }); 
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            $('#years').on('change', function(e){
                var year = e.target.value;
                var sub = year.substr(0,25);
                if (sub.includes("PDM_HSL_SUMMARY_DEPOSITO_")) {
                    $.get('http://192.168.7.32:8080/bni/public/api/json-month-balance?TABLE_NAME=' + year , function(data){
                        console.log(data);
                        var as = data.map(item => item.TABLE_NAME.slice(0,31))
                        .filter((value, index, self) => self.indexOf(value) === index)
                        $('#months').empty();
                        $('#months').append('<option value="0" selected="true">Pilih Bulan</option>');

                        $.each(as, function(index, monthsObj) {
                            console.log(monthsObj);
                            $('#months').append('<option value="' + monthsObj + '" >' + monthsObj.substr(29,2) + '</option>');
                        });
                    });
                } else {
                    $.get('http://192.168.7.32:8080/bni/public/api/json-month-balance?TABLE_NAME=' + year , function(data){
                        console.log(data);
                        var as = data.map(item => item.TABLE_NAME.slice(0,19))
                        .filter((value, index, self) => self.indexOf(value) === index)
                        $('#months').empty();
                        $('#months').append('<option value="0" selected="true">Pilih Bulan</option>');

                        $.each(as, function(index, monthsObj) {
                            console.log(monthsObj);
                            $('#months').append('<option value="' + monthsObj + '" >' + monthsObj.substr(17,2) + '</option>');
                        });
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            $('#months').on('change', function(e){
                var month = e.target.value;
                var sub = month.substr(0,25);
                if (sub.includes("PDM_HSL_SUMMARY_DEPOSITO_")) {
                    $.get('http://192.168.7.32:8080/bni/public/api/json-day-balance?TABLE_NAME=' + month , function(data){
                        console.log(data);
                        var year = data.yearss;
                        var as = year.map(item => item.TABLE_NAME.slice(0,33))
                        .filter((value, index, self) => self.indexOf(value) === index)
                        $('#days').empty();
                        $('#days').append('<option value="0" selected="true">Pilih Tanggal</option>');

                        $.each(as, function(index, daysObj) {
                            console.log(daysObj);
                            $('#days').append('<option value="' + daysObj + '" >' + daysObj.substr(31,2) + '</option>');
                        });
                    });
                } else {
                    $.get('http://192.168.7.32:8080/bni/public/api/json-day-balance?TABLE_NAME=' + month , function(data){
                        var year = data.yearss;
                        var as = year.map(item => item.TABLE_NAME.slice(0,21))
                        .filter((value, index, self) => self.indexOf(value) === index)
                        $('#days').empty();
                        $('#days').append('<option value="0" selected="true">Pilih Tanggal</option>');
                        
                        $.each(as, function(index, daysObj) {
                            console.log(daysObj);
                            $('#days').append('<option value="' + daysObj + '" >' + daysObj.substr(19,2) + '</option>');
                        });
                    });
                }

            });
        });
    </script>

    <script>
    $(document).ready(function(){
        $('#regions').on('change', function(e){
            console.log(e.target.value);
            var region_id = e.target.value;
            $.get('/api/json-branches?region_id=' + region_id , function(data){
                console.log(data);
                $('#branches').empty();
                $('#branches').append('<option value="0" disabled="true" selected="true">Pilih Branch</option>');

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
                    $('#products').append('<option value="0" selected="true">Pilih Product</option>');

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
                var year = e.target.value;
                $.get('/api/json-month-upload?created_at=' + year , function(data){
                    console.log(data);
                    $('#months').empty();
                    $('#months').append('<option value="0" selected="true">Pilih Bulan</option>');

                    $.each(data, function(index, monthsObj) {
                        console.log(monthsObj.month);
                        $('#months').append('<option value="' + monthsObj.month + '" >' + monthsObj.month + '</option>');
                    });
                });
            });
        });
    </script>

    
@endsection