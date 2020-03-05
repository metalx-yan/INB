@extends('main')

@section('links')
    <style>
        /* body {
  padding: 15px;
    } */

    .checkbox-menu li label {
        display: block;
        padding: 3px 10px;
        clear: both;
        font-weight: normal;
        line-height: 1.42857143;
        color: #333;
        white-space: nowrap;
        margin:0;
        transition: background-color .4s ease;
    }
    .checkbox-menu li input {
        margin: 0px 5px;
        top: 2px;
        position: relative;
    }

    .checkbox-menu li.active label {
        background-color: #cbcbff;
        font-weight:bold;
    }

    .checkbox-menu li label:hover,
    .checkbox-menu li label:focus {
        background-color: #f5f5f5;
    }

    .checkbox-menu li.active label:hover,
    .checkbox-menu li.active label:focus {
        background-color: #b8b8ff;
    }
    </style>
@endsection

@section('title', 'Query Balance')

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
                    <form action="{{ route('query-balance') }}" method="get">
                            <div class="row">
                                <input type="hidden" name="id">
                                <div class="col-md-3">
                                    <label for="">Jenis</label>
                                    <select name="categories" id="categories" class="form-control">
                                        <option value="null">Pilih Category</option>
                                        @foreach ($categories as $category)
                                                <option value="{{ $category->jenis }}">{{ $category->jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="">Product</label>
                                    <br>
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" 
                                                id="dropdownMenu1" data-toggle="dropdown" 
                                                aria-haspopup="true" aria-expanded="true" style="border-color:#ced4da; width:100%;">
                                            
                                            <span class="caret" style="margin-left:-49%;">Pilih Products</span>
                                        </button>
                                        <ul class="dropdown-menu checkbox-menu allow-focus" id="menus" aria-labelledby="dropdownMenu1" style="width:210%; top:265px; bottom:-420px; left:0; right:0; overflow-y: auto;">
                                                <input type="text" id="myInputs" class="form-control" placeholder="Search Data" onkeyup="myFunctions()" title="Type in a name" style="width:95%; margin-left:6px; padding: 12px 20px 12px 40px; background-repeat:no-repeat; background-size: 35px; ">
                                                <p style="margin-top:14px; margin-left:15px;">
                                                <b><input type="checkbox" name="select-alls" id="select-alls"> Select All</b>
                                                <hr>
                                                    <div id="products">
                                                    </div>
                                        </ul>
                                    </div>
                                    
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="">Region</label>
                                    <select name="regions" id="regions" class="form-control" >
                                        <option value="null">Pilih Region</option>
                                        @foreach ($regions as $region)
                                                <option value="{{ $region->regDigit }}">{{ $region->reg }} - {{ $region->regDigit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="">Branch</label>
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" 
                                                id="dropdownMenu1" data-toggle="dropdown" 
                                                aria-haspopup="true" aria-expanded="true" style="border-color:#ced4da; width:100%;">
                                            
                                            <span class="caret" style="margin-left:-49%;">Pilih Category</span>
                                        </button>
                                        <ul class="dropdown-menu checkbox-menu allow-focus" id="menu" aria-labelledby="dropdownMenu1" style="width:210%; top:265px; bottom:-420px; left:0; right:0; overflow-y: auto;">
                                                <input type="text" id="myInput" class="form-control" placeholder="Search Data" onkeyup="myFunction()" title="Type in a name" style="width:95%; margin-left:6px; padding: 12px 20px 12px 40px; background-repeat:no-repeat; background-size: 35px; ">
                                                <p style="margin-top:14px; margin-left:15px;">
                                                <b><input type="checkbox" name="select-all" id="select-all"> Select All</b>
                                                <hr>
                                                <div id="branchess">
                                                </div>
                                                
                                        </ul>
                                    </div>
                                </div>
                                
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Status</label>
                                    <br>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Pilih Status</option>
                                        {{-- <option value="">All Status</option> --}}
                                        <option value="1">Dormant</option>
                                        <option value="0">Active</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="">Pilih Column</label>
                                    <br>
                                    <select name="accounts[]" id="accounts" class="form-control" multiple>
                                        @for($i = 0; $i < sizeof($cols); $i++)
                                            <option value="{{ $cols[$i] }}">{{ ucfirst(str_replace('_', ' ',$cols[$i]) )}}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="">Tahun</label>
                                    <br>
                                    <select name="years" id="years" class="form-control">
                                        <option value="">Pilih Tahun</option>
                                    </select>
                                </div>
                               
                                <div class="col-md-3">
                                    <label for="">Bulan</label>
                                    <br>
                                    <select name="months" id="months" class="form-control">
                                        <option value="">Pilih Bulan</option>
                                    </select>
                                </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
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

                            @if ($status == null)
                                
                            @else
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
                                        @foreach ($queq as $item)
                                            <tr>
                                                @foreach ($item as $key => $val)
                                                    @foreach ($account as $acc)
                                                        @if ($key == $acc)
                                                             <td> {{ $val }}</td>
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
                    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]]
                });
            
        });
    </script>

    {{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href=" {{ asset('css/jquery.multiselect.css') }} ">
    <script src=" {{ asset('js/jquery.multiselect.js') }} "></script>
   
    <script>
        $('#accounts').multiselect();
    </script>

    <script>
    $(document).ready(function(){
        $('#regions').on('change', function(e){
            console.log(e.target.value);
            var region_id = e.target.value;
            if (region_id=="all_region") {
                $.get('http://192.168.7.32:8080/bni/public/api/json-branches' , function(data){

                $('#branchess').empty();
            
                $.each(data, function(index, branchesObj) {
                    $('#branchess').append('<li><label><input name="branches[]" type="checkbox" class="bran" value="'+ branchesObj.branch_name +'">' +  branchesObj.branch_name +  '</label></li>');
                });
            }); 
            } else {
                $.get('http://192.168.7.32:8080/bni/public/api/json-branches?regDigit=' + region_id , function(data){
                console.log(data);
                $('#branchess').empty();

                $.each(data, function(index, branchesObj) {
                    console.log(branchesObj);
                    $('#branchess').append('<li><label><input name="branches[]" type="checkbox" class="bran" value="'+ branchesObj.branch_name +'">' + branchesObj.branch_name +  '</label></li>');
                });
            });    
            }
        });
    });  
    </script>
    
    <script>
        $(document).ready(function(){
            $('#categories').on('change', function(e){
                console.log(e.target.value);
                var category_id = e.target.value;
                if (category_id == "all_category") {
                    $.get('http://192.168.7.32:8080/bni/public/api/json-products', function(data){
                    console.log(data);
                    $('#products').empty();

                    $.each(data, function(index, productsObj) {
                        console.log(productsObj);
                        $('#products').append('<li><label><input name="products[]" type="checkbox" class="brans" value="'+ productsObj.bni_account_type + '-' +productsObj.bni_sub_category +'">' + productsObj.bni_account_type + '-' +productsObj.bni_sub_category + '-' +productsObj.product_name +  '</label></li>');
                        
                    }); 
                });

                } else {
                    
                $.get('http://192.168.7.32:8080/bni/public/api/json-products?Jenis=' + category_id , function(data){
                    console.log(data);
                    $('#products').empty();

                    $.each(data, function(index, productsObj) {
                        console.log(productsObj);
                        $('#products').append('<li><label><input name="products[]" type="checkbox" class="brans" value="'+ productsObj.bni_account_type + '-' +productsObj.bni_sub_category +'">' + productsObj.bni_account_type + '-' +productsObj.bni_sub_category + '-' +productsObj.product_name + '</label></li>');
                        
                    }); 
                        
                });
                }

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
                        console.log(data);
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
    $('#select-all').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $('.bran').each(function() {
                this.checked = true;                        
            });
        } else {
            $('.bran').each(function() {
                this.checked = false;                       
            });
        }
    });
</script>

<script>
    function myFunction() {
        var FilterValue, input, ul, li, i;
            input = document.getElementById('myInput');
            FilterValue = input.value;
            ul = document.getElementById('menu');
            li = ul.getElementsByTagName('li');

            for (i = 0; i < li.length ; i++) {
                var a = li[i].getElementsByTagName('label')[0];
                if (a.innerHTML.indexOf(FilterValue) > -1 ) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
</script>

<script>
    $('#select-alls').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $('.brans').each(function() {
                this.checked = true;                        
            });
        } else {
            $('.brans').each(function() {
                this.checked = false;                       
            });
        }
    });
</script>

<script>
    function myFunctions() {
        var FilterValue, input, ul, li, i;
            input = document.getElementById('myInputs');
            FilterValue = input.value;
            ul = document.getElementById('menus');
            li = ul.getElementsByTagName('li');

            for (i = 0; i < li.length ; i++) {
                var a = li[i].getElementsByTagName('label')[0];
                if (a.innerHTML.indexOf(FilterValue) > -1 ) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
</script>

    
@endsection