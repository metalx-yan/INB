@extends('main')

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
                   
                            <div class="row">
                                <input type="hidden" name="id">
                                <div class="col-md-3">
                                    <label for="">Jenis</label>
                                    <select name="categories" id="categories" class="form-control">
                                        <option value="null">=====</option>
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
                                            <i class="glyphicon glyphicon-cog"></i>
                                            <span class="caret" style="margin-left:88%;"></span>
                                        </button>
                                        <ul class="dropdown-menu checkbox-menu allow-focus" id="menus" aria-labelledby="dropdownMenu1" style="width:210%;">
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
                                        <option value="null">=====</option>
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
                                            <i class="glyphicon glyphicon-cog"></i>
                                            <span class="caret" style="margin-left:88%;"></span>
                                        </button>
                                        <ul class="dropdown-menu checkbox-menu allow-focus" id="menu" aria-labelledby="dropdownMenu1" style="width:210%;">
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
                                    <label for="">Column</label>
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
                                        <option value="">=====</option>
                                    </select>
                                </div>
                               
                                <div class="col-md-3">
                                    <label for="">Bulan</label>
                                    <br>
                                    <select name="months" id="months" class="form-control">
                                        <option value="">=====</option>
                                    </select>
                                </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Tanggal</label>
                                        <br>
                                        <select name="days" id="days" class="form-control">
                                            <option value="">=====</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">&nbsp;</label>
                                        <br>
                                        <button type="submit" id="btnFilterSubmitSearch" class="btn btn-primary" style="margin-left: 404%;">Execute</button>
                                    </div>
                                </div>
                        
                            <hr>
                        <div id="hides" style="display:none">

                            <table class="table border" id="myTable" >
                                <thead>
                                        <tr>
                                                <td>AS_OF_DATE</td>
                                                <td>GL_ACCOUNT_ID</td>
                                                <td>BRANCH_CODE</td>
                                                <td>MARKET_SEGMENT_CD</td>
                                                <td>BNI_CIF_KEY</td>
                                                <td>ID_NUMBER</td>
                                                <td>BNI_ACCOUNT_TYPE</td>
                                                <td>BNI_SUB_CATEGORY</td>
                                                <td>ACCOUNT_OPEN_DATE</td>
                                                <td>BNI_ACC_CLOSE_DATE</td>
                                                <td>BNI_ACCOUNT_STATUS</td>
                                                <td>ISO_CURRENCY_CD</td>
                                                <td>AVG_BOOK_BAL</td>
                                                <td>BNI_CUR_BOOK_BAL_IDR</td>
                                                <td>CUR_BOOK_BAL</td>
                                                <td>BNI_LAST_TRX_DATE</td>
                                                <td>BNI_YESTERDAY_END_BAL</td>
                                                <td>BNI_LAST_EOM_BAL</td>
                                                <td>BNI_LAST_EOY_BAL</td>
                                                <td>BNI_CLR_TRX_TODAY</td>
                                                <td>BNI_CLR_TRX_YESTERDAY</td>
                                                <td>BNI_CREDIT_TRX_TODAY</td>
                                                <td>BNI_DEBIT_TRX_TODAY</td>
                                                <td>BNI_LOWEST_BAL</td>
                                                <td>BNI_HIGHEST_BAL</td>
                                                <td>BNI_TAPENAS_MTH_PAY</td>
                                                <td>BNI_USER_CD</td>
                                                <td>KLN_CD</td>
                                                <td>PRODUCT_CATEGORY</td>
                                                <td>PRODUCT_NAME</td>
                                                <td>ACCT_BLOCK_DT</td>
                                                <td>BAL_BLOCK_DT</td>
                                                {{-- <td>BLOCK_REASON</td>
                                                <td>BLOCKED_BALANCE</td> --}}
                                                {{-- <td>TAPENAS_TERM</td>
                                                <td>TAPENAS_ARO_FLAG</td> --}}
                                                {{-- <td>AFFILIATED_ACC_NO</td>
                                                <td>CUR_GROSS_RATE</td>
                                                <td>SPECIAL_INT_RATE</td>
                                                <td>BNI_TELLER_ID</td> --}}
                                            </tr>
                                    </thead>
                            </table>
                        </div>

                        </div>
                    </div>
            </div>

@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="{{ asset('js/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('js/js/jszip.min.js') }}"></script>
<script src="{{ asset('js/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/js/buttons.print.min.js') }}"></script>
<link rel="stylesheet" href=" {{ asset('css/jquery.multiselect.css') }} ">
<script src=" {{ asset('js/jquery.multiselect.js') }} "></script>
   
<script>
    $('#accounts').multiselect();
</script>

<script>

    $(document).ready( function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#myTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['excel'],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('user/serverside') }}",
                type: 'GET', 
                data: function(data) {
                    data.as_of_date = $('#as_of_date').val();
                    data.id_number = $('#id_number').val();
                    console.log(data.as_of_date);
                }
            },
            columns: [
                    { data : 'AS_OF_DATE', name: 'AS_OF_DATE'},
                    { data : 'GL_ACCOUNT_ID', name: 'GL_ACCOUNT_ID'},
                    { data : 'BRANCH_CODE', name: 'BRANCH_CODE'},
                    { data : 'MARKET_SEGMENT_CD', name: 'MARKET_SEGMENT_CD'},
                    { data : 'BNI_CIF_KEY', name: 'BNI_CIF_KEY'},
                    { data : 'ID_NUMBER', name: 'ID_NUMBER'},
                    { data : 'BNI_ACCOUNT_TYPE', name: 'BNI_ACCOUNT_TYPE'},
                    { data : 'BNI_SUB_CATEGORY', name: 'BNI_SUB_CATEGORY'},
                    { data : 'ACCOUNT_OPEN_DATE', name: 'ACCOUNT_OPEN_DATE'},
                    { data : 'BNI_ACC_CLOSE_DATE', name: 'BNI_ACC_CLOSE_DATE'},
                    { data : 'BNI_ACCOUNT_STATUS', name: 'BNI_ACCOUNT_STATUS'},
                    { data : 'ISO_CURRENCY_CD', name: 'ISO_CURRENCY_CD'},
                    { data : 'AVG_BOOK_BAL', name: 'AVG_BOOK_BAL'},
                    { data : 'BNI_CUR_BOOK_BAL_IDR', name: 'BNI_CUR_BOOK_BAL_IDR'},
                    { data : 'CUR_BOOK_BAL', name: 'CUR_BOOK_BAL'},
                    { data : 'BNI_LAST_TRX_DATE', name: 'BNI_LAST_TRX_DATE'},
                    { data : 'BNI_YESTERDAY_END_BAL', name: 'BNI_YESTERDAY_END_BAL'},
                    { data : 'BNI_LAST_EOM_BAL', name: 'BNI_LAST_EOM_BAL'},
                    { data : 'BNI_LAST_EOY_BAL', name: 'BNI_LAST_EOY_BAL'},
                    { data : 'BNI_CLR_TRX_TODAY', name: 'BNI_CLR_TRX_TODAY'},
                    { data : 'BNI_CLR_TRX_YESTERDAY', name: 'BNI_CLR_TRX_YESTERDAY'},
                    { data : 'BNI_CREDIT_TRX_TODAY', name: 'BNI_CREDIT_TRX_TODAY'},
                    { data : 'BNI_DEBIT_TRX_TODAY', name: 'BNI_DEBIT_TRX_TODAY'},
                    { data : 'BNI_LOWEST_BAL', name: 'BNI_LOWEST_BAL'},
                    { data : 'BNI_HIGHEST_BAL', name: 'BNI_HIGHEST_BAL'},
                    { data : 'BNI_TAPENAS_MTH_PAY', name: 'BNI_TAPENAS_MTH_PAY'},
                    { data : 'BNI_USER_CD', name: 'BNI_USER_CD'},
                    { data : 'KLN_CD', name: 'KLN_CD'},
                    { data : 'PRODUCT_CATEGORY', name: 'PRODUCT_CATEGORY'},
                    { data : 'PRODUCT_NAME', name: 'PRODUCT_NAME'},
                    { data : 'ACCT_BLOCK_DT', name: 'ACCT_BLOCK_DT'},
                    { data : 'BAL_BLOCK_DT', name: 'BAL_BLOCK_DT'},
                    // { data : 'BLOCK_REASON', name: 'BLOCK_REASON'},
                    // { data : 'BLOCKED_BALANCE', name: 'BLOCKED_BALANCE'},
                    // { data : 'TAPENAS_TERM', name: 'TAPENAS_TERM'},
                    // { data : 'TAPENAS_ARO_FLAG', name: 'TAPENAS_ARO_FLAG'},
                    // { data : 'AFFILIATED_ACC_NO', name: 'AFFILIATED_ACC_NO'},
                    // { data : 'CUR_GROSS_RATE', name: 'CUR_GROSS_RATE'},
                    // { data : 'SPECIAL_INT_RATE', name: 'SPECIAL_INT_RATE'},
                    // { data : 'BNI_TELLER_ID', name: 'BNI_TELLER_ID'},
            ]
        });

        var array = @json($dip);
        var colum = @json($cols);

        for (let index = 0; index < colum.length; index++) {
            const element = colum[index];
            console.log(element);

            array.forEach( function(el) {
                console.log(el);

                if (element == el) {
                    table.columns(index).visible(false);
                }
            });
        }
    });

    $('#btnFilterSubmitSearch').click(function(){
        $('#myTable').DataTable().draw(true);
        $('#hides').css("display", "block");
    });

</script>

<script>
        $(document).ready(function(){
            $('#regions').on('change', function(e){
                console.log(e.target.value);
                var region_id = e.target.value;
                if (region_id=="all_region") {
                    $.get('http://localhost:8080/bni/public/api/json-branches' , function(data){
    
                    $('#branchess').empty();
                
                    $.each(data, function(index, branchesObj) {
                        $('#branchess').append('<li><label><input name="branches[]" type="checkbox" class="bran" value="'+ branchesObj.branch_name +'">' +  branchesObj.branch_name +  '</label></li>');
                    });
                }); 
                } else {
                    $.get('http://localhost:8080/bni/public/api/json-branches?regDigit=' + region_id , function(data){
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
                        $.get('http://localhost:8080/bni/public/api/json-products', function(data){
                        console.log(data);
                        $('#products').empty();
    
                        $.each(data, function(index, productsObj) {
                            console.log(productsObj);
                            $('#products').append('<li><label><input name="products[]" type="checkbox" class="brans" value="'+ productsObj.bni_account_type + '-' +productsObj.bni_sub_category +'">' + productsObj.bni_account_type + '-' +productsObj.bni_sub_category + '-' +productsObj.product_name +  '</label></li>');
                            
                        }); 
                    });
    
                    } else {
                        
                    $.get('http://localhost:8080/bni/public/api/json-products?Jenis=' + category_id , function(data){
                        console.log(data);
                        $('#products').empty();
    
                        $.each(data, function(index, productsObj) {
                            console.log(productsObj);
                            $('#products').append('<li><label><input name="products[]" type="checkbox" class="brans" value="'+ productsObj.bni_account_type + '-' +productsObj.bni_sub_category +'">' + productsObj.bni_account_type + '-' +productsObj.bni_sub_category + '-' +productsObj.product_name + '</label></li>');
                            
                        }); 
                            
                    });
                    }
    
                    if (category_id == "DEPOSITO") {
                        $.get('http://localhost:8080/bni/public/api/json-year-balance?TABLE_NAME=pdm_hsl_summary_deposito_', function(data){
                            console.log(data);
                            var as = data.map(item => item.TABLE_NAME.slice(0,29))
                            .filter((value, index, self) => self.indexOf(value) === index)
                            $('#years').empty();
                            $('#years').append('<option value="0" selected="true">=====</option>');
                            
                            $.each(as, function(index, yearsObj) {
                                if (yearsObj.substr(25,4).includes('_') == false ) {
                                    console.log(yearsObj.substr(0,29));
                                    $('#years').append('<option value="' + yearsObj.substr(0, 29) + '" >' + yearsObj.substr(25,4) + '</option>');
                                } 
                            }); 
                        });
                    } else {
                        $.get('http://localhost:8080/bni/public/api/json-year-balance?TABLE_NAME=deposit_prod_', function(data){
                            console.log(data);
                            var ass = data.map(item => item.TABLE_NAME.slice(0,17))
                            .filter((value, index, self) => self.indexOf(value) === index)
                            $('#years').empty();
                            $('#years').append('<option value="0" selected="true">=====</option>');
                            
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
                        $.get('http://localhost:8080/bni/public/api/json-month-balance?TABLE_NAME=' + year , function(data){
                            console.log(data);
                            var as = data.map(item => item.TABLE_NAME.slice(0,31))
                            .filter((value, index, self) => self.indexOf(value) === index)
                            $('#months').empty();
                            $('#months').append('<option value="0" selected="true">=====</option>');
    
                            $.each(as, function(index, monthsObj) {
                                console.log(monthsObj);
                                $('#months').append('<option value="' + monthsObj + '" >' + monthsObj.substr(29,2) + '</option>');
                            });
                        });
                    } else {
                        $.get('http://localhost:8080/bni/public/api/json-month-balance?TABLE_NAME=' + year , function(data){
                            console.log(data);
                            var as = data.map(item => item.TABLE_NAME.slice(0,19))
                            .filter((value, index, self) => self.indexOf(value) === index)
                            $('#months').empty();
                            $('#months').append('<option value="0" selected="true">=====</option>');
    
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
                        $.get('http://localhost:8080/bni/public/api/json-day-balance?TABLE_NAME=' + month , function(data){
                            console.log(data);
                            var as = data.map(item => item.TABLE_NAME.slice(0,33))
                            .filter((value, index, self) => self.indexOf(value) === index)
                            $('#days').empty();
                            $('#days').append('<option value="0" selected="true">=====</option>');
    
                            $.each(as, function(index, daysObj) {
                                console.log(daysObj);
                                $('#days').append('<option value="' + daysObj + '" >' + daysObj.substr(31,2) + '</option>');
                            });
                        });
                    } else {
                        $.get('http://localhost:8080/bni/public/api/json-day-balance?TABLE_NAME=' + month , function(data){
                            console.log(data);
                            var as = data.map(item => item.TABLE_NAME.slice(0,21))
                            .filter((value, index, self) => self.indexOf(value) === index)
                            $('#days').empty();
                            $('#days').append('<option value="0" selected="true">=====</option>');
    
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