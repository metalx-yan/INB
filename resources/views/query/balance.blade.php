@extends('main')

@section('content')
    <div class="container-fluid">
       
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Query Balace</li>
                    {{-- <li class="breadcrumb-item active">List</li> --}}
                </ol>
            </div>
        </div>
        
        <div class="card">
            <div class="card-title">
                <br>
                <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="">Jenis</label>
                                <select name="" id="categories" class="form-control">
                                    <option value="">=====</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="">Region</label>
                                <select name="" id="regions" class="form-control">
                                    <option value="">=====</option>
                                    @foreach ($regions as $region)
                                        <option value=" {{ $region->id }} ">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="">Branch</label>
                                <select name="" id="branches" class="form-control">
                                </select>
                            </div>

                            {{-- <input type="button" id="buts" onclick="showData();" value="Submit"> --}}
                            <div class="col-md-3">
                                <label for="">Product</label>
                                <select name="" id="products" class="form-control">
                                    
                                </select>
                            </div>
                            {{-- Exam : <label for="" id="perint"></label> --}}
                        </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href=" {{ asset('css/jquery.multiselect.css') }} ">
    <script src=" {{ asset('js/jquery.multiselect.js') }} "></script>
    {{-- <script>
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
    </script> --}}

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
                    $('#branches').append('<option value="' + branchesObj.id + '" >' + branchesObj.name + '</option>');
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
                        $('#products').append('<option value="' + productsObj.id + '" >' + productsObj.name + '</option>');
                    });
                });
            });
        });
        </script>
@endsection