@extends('main')

@section('title', 'Top Bottom Nasabah')

@section('content')
<div class="container-fluid">
       
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Top/Bottom Nasabah</li>
                </ol>
            </div>
        </div>

        {{-- onfocus='this.size=5;' onblur='this.size=1;' onchange='this.size=1; this.blur();'
onfocus='this.size=5;' onblur='this.size=1;' onchange='this.size=1; this.blur();'
onfocus='this.size=5;' onblur='this.size=1;' onchange='this.size=1; this.blur();' --}}
        <div class="card">
            <div class="card-title">
                <div class="container">
                    <form action="{{ route('funding-top-bottom-nasabah') }}" method="post">
                        @csrf
                        <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Tanggal</label>
                                    <select name="years" id="years" class="form-control" required>
                                        <option value="">Pilih Tanggal</option>
                                        {{-- @foreach (array_unique($tahun) as $year) --}}
                                            <option value=""></option>
                                        {{-- @endforeach --}}
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                        <label for="">Region</label>
                                        <br>
                                        <div class="dropdown">
                                            <button class="btn btn-default dropdown-toggle" type="button" 
                                                    id="dropdownMenu1" data-toggle="dropdown" 
                                                    aria-haspopup="true" aria-expanded="true" style="border-color:#ced4da; width:100%;" >
                                                <i class="glyphicon glyphicon-cog"></i>
                                                <span class="caret" style="margin-left:88%;"></span>
                                            </button>
                                            <ul class="dropdown-menu checkbox-menu allow-focus" id="menu" aria-labelledby="dropdownMenu1" style="width:100%; top:265px; bottom:-420px; left:0; right:0; overflow-y: auto;">
                                                    <input type="text" id="myInput" class="form-control" placeholder="Search Data" onkeyup="myFunction()" title="Type in a name" style="width:95%; margin-left:6px; padding: 12px 20px 12px 40px; background-repeat:no-repeat; background-size: 35px; ">
                                                    <p style="margin-top:14px; margin-left:15px;">
                                                    <b><input type="checkbox" name="select-all" id="select-all"> Select All</b>
                                                    <hr>
                                                    <div id="type">
                                                    @foreach ($regions as $region)
                                                            <li>
                                                                <label>
                                                                    <input type="checkbox" name="region[]" style="margin-left: 15px;" class="region" value="{{ $region->regDigit }}"> {{ $region->region }} - {{ $region->regDigit }}
                                                                </label>
                                                            </li>
                                                            @endforeach
                                                        </div>
                                            </ul>
                                        </div>
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
                                            <ul class="dropdown-menu checkbox-menu allow-focus" id="menus" aria-labelledby="dropdownMenu1" style="width:210%; top:265px; bottom:-420px; left:0; right:0; overflow-y: auto;">
                                                    <input type="text" id="myInputs" class="form-control" placeholder="Search Data" onkeyup="myFunctions()" title="Type in a name" style="width:95%; margin-left:6px; padding: 12px 20px 12px 40px; background-repeat:no-repeat; background-size: 35px; ">
                                                    <p style="margin-top:14px; margin-left:15px;">
                                                    <b><input type="checkbox" name="select-alls" id="select-alls"> Select All</b>
                                                    <hr>
                                                    <div id="branchess">
                                                    </div>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="">Products</label>
                                        <br>
                                        <div class="dropdown">
                                            <button class="btn btn-default dropdown-toggle" type="button" 
                                                    id="dropdownMenu1" data-toggle="dropdown" 
                                                    aria-haspopup="true" aria-expanded="true" style="border-color:#ced4da; width:100%;" >
                                                <i class="glyphicon glyphicon-cog"></i>
                                                <span class="caret" style="margin-left:88%;"></span>
                                            </button>
                                            <ul class="dropdown-menu checkbox-menu allow-focus" id="menub" aria-labelledby="dropdownMenu1" style="width:210%; top:265px; bottom:-420px; left:0; right:0; overflow-y: auto;">
                                                    <input type="text" id="myInput" class="form-control" placeholder="Search Data" onkeyup="myFunctionb()" title="Type in a name" style="width:95%; margin-left:6px; padding: 12px 20px 12px 40px; background-repeat:no-repeat; background-size: 35px; ">
                                                    <p style="margin-top:14px; margin-left:15px;">
                                                    <b><input type="checkbox" name="select-allb" id="select-allb"> Select All</b>
                                                    <hr>
                                                    <div id="type">
                                                    @foreach ($prod as $type)
                                                            <li>
                                                                <label>
                                                                    <input type="checkbox" name="products[]" style="margin-left: 15px;" class="region" value="{{$type->bni_account_type}}-{{$type->bni_sub_category}}"> {{$type->bni_account_type}} - {{$type->bni_sub_category}} {{$type->product_name}}
                                                                </label>
                                                            </li>
                                                            @endforeach
                                                        </div>
                                            </ul>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-3">
                                        <label for="">Status</label>
                                        <br>
                                        <select name="types" id="types" class="form-control">
                                            <option value="">Pilih Type</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Dormant</option>
                                        </select>
                                    </div> --}}
                            </div>
                            <br>
                            <div class="row">
                                
                                
                                
                                <div class="col-md-3">
                                    <label for="">Filter</label>
                                    <br>
                                    <select name="filter" id="filter" class="form-control">
                                        <option value="">Pilih Filter</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                {{-- <div class="col-md-3">
                                    <label for="">Category</label>
                                    <br>
                                    <select name="cats" id="cats" class="form-control">
                                        <option value="">Pilih Category</option>
                                        <option value="dtd">DTD</option>
                                        <option value="mtd">MTD</option>
                                        <option value="ytd">YTD</option>
                                    </select>
                                </div> --}}
                            </div>
                            <br>
                            <div class="row">
                                

                                {{-- <div class="col-md-3">
                                    <label for="">&nbsp;</label>
                                    <br>
                                    <select name="date" id="date" class="form-control">
                                        <option value="">====</option>
                                        @foreach ($a as $item)
                                                <option value="{{ substr($item, 13,4).'-'.substr($item,17,2).'-'.substr($item,19,2) }}">{{ substr($item, 13,4) . '-' .substr($item, 19, 2) }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
{{-- 
                                <div class="col-md-3">
                                    <label for="">Order By</label>
                                    <br>
                                    <select name="order" id="order" class="form-control">
                                        <option value="">Pilih Order By</option>
                                        <option value="asc">Asc</option>
                                        <option value="desc">Desc</option>
                                    </select>
                                </div> --}}

                               
                            </div>
    
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">&nbsp;</label>
                                        <br>
                                        <button type="submit" id="buttonsa" class="btn btn-primary" style="margin-left: 404%;">Execute</button>
                                    </div>
                                </div>
                    </form>

                    @if ($null)

                    @else

                    @if ($sa == null)
                        
                    @else
                        

                    <br>
                    <table class="table border" id="myTable">
                        <thead >
                            <tr style="background-color: #5f3423; color:white;">
                                <td>Produk</td>
                                <td>Saldo Sesudah</td>
                                <td>Saldo Sebelum</td>
                                <td>Total</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $int1 = 0;
                                $int2 = 0;
                                $int3 = 0;
                            @endphp

                                @foreach ($sa as $val )
                                    <tr>
                                        <td>{{$val->product_name}}</td>
                                        <td>{{number_format($val->saldo1,2)}}</td>
                                        <td>{{number_format($val->saldo2,2)}}</td>
                                        <td>{{number_format($val->saldo1-$val->saldo2,2)}}</td>
                                        
                                    </tr>
                                        @php
                                            $int1 += $val->saldo1;
                                            $int2 += $val->saldo2;
                                            $int3 += ($val->saldo1-$val->saldo2);
                                        @endphp
                                @endforeach
                                
                                <tr style="background-color: #5f3423; color:white;">
                                    <td></td>
                                    <td>{{number_format($int1,2)}}</td>
                                    <td>{{number_format($int2,2)}}</td>
                                    <td>{{number_format($int3,2)}}</td>
                                    
                                </tr>
                            
                        </tbody>

                        
                    </table>
                    <div class="container" id="container" style="min-widh: 310px; height:400px; margin: 0 auto;">
                    </div>
                    @endif

                    @endif

                 
                </div>
            </div>
        </div>
</div>
@endsection

@section('scripts')
    
<script src="{{ asset('js/js/highcharts.js') }}"></script>
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
                    "order": [],
                    bSort: false,
                    "paging": false,
                    buttons: ['excel']
                });
        });
    </script>

    <script>
    $('.region').click(function(e){
            if($(this).is(':checked') == true){
                var count =  document.querySelectorAll('input[type="checkbox"]:checked');
                var str = '';
                for (let i = 0; i < count.length; i++) {
                    str += 'regDigit[]='+count[i].value+'&';
                }
                console.log(str);
                $.get('http://192.168.7.32:8080/bni/public/api/json-branches?' + str , function(data){
                    console.log(data);
                    $('#branchess').empty();

                    $.each(data, function(index, productsObj) {
                        console.log(productsObj);
                        $('#branchess').append('<li><label><input name="groups[]" style="margin-left: 15px;" type="checkbox" class="groupes" value="'+ productsObj.branch_name +'">' +  productsObj.branch_name +  '</label></li>');
                    });
                });

            } else {

                var count =  document.querySelectorAll('input[type="checkbox"]:checked');
                var str = '';
                for (let i = 0; i < count.length; i++) {
                    str += 'regDigit[]='+count[i].value+'&';
                }
                console.log(str);
                $.get('http://192.168.7.32:8080/bni/public/api/json-branches?' + str , function(data){
                    console.log(data);
                    $('#branchess').empty();

                    $.each(data, function(index, productsObj) {
                        console.log(productsObj);
                        $('#branchess').append('<li><label><input name="groups[]" style="margin-left: 15px;" type="checkbox" class="groupes" value="'+ productsObj.branch_name +'">' +  productsObj.branch_name +  '</label></li>');
                    });
                });
                    
            }
        });
        </script>

{{-- <script>
        $(document).ready(function(){
            $('#regions').on('change', function(e){
                console.log(e.target.value);
                var region_id = e.target.value;
                if (region_id=="all_region") {
                    $.get('http://192.168.7.32:8080/bni/public/api/json-branches' , function(data){
    
                    $('#branchess').empty();
                
                    $.each(data, function(index, branchesObj) {
                        $('#branchess').append('<li style="margin-left:15px;"><label><input name="branches[]" type="checkbox" class="bran" value="'+ branchesObj.branch_name +'">' +  branchesObj.branch_name +  '</label></li>');
                    });
                }); 
                } else {
                    $.get('http://192.168.7.32:8080/bni/public/api/json-branches?regDigit=' + region_id , function(data){
                    console.log(data);
                    $('#branchess').empty();
    
                    $.each(data, function(index, branchesObj) {
                        console.log(branchesObj);
                        $('#branchess').append('<li style="margin-left:15px;"><label><input name="branches[]" type="checkbox" class="bran" value="'+ branchesObj.branch_name +'">' + branchesObj.branch_name +  '</label></li>');
                    });
                });    
                }
            });
        });
    </script> --}}

    <script>
        $('#select-all').click(function(event) {   
            if(this.checked) {
                $.get('http://192.168.7.32:8080/bni/public/api/json-branches'  , function(data){
                    console.log(data);
                    $('#branchess').empty();

                    $.each(data, function(index, productsObj) {
                        console.log(productsObj);
                        $('#branchess').append('<li><label><input name="groups[]" style="margin-left: 15px;" type="checkbox" class="groupes" value="'+ productsObj.branch_name +'">' +  productsObj.branch_name +  '</label></li>');
                    });
                });
                // Iterate each checkbox
                $('.region').each(function() {
                    this.checked = true;                        
                });
            } else {

                $.get('http://192.168.7.32:8080/bni/public/api/json-branches'  , function(data){
                    console.log(data);
                    $('#branchess').empty();
                    
                });

                $('.region').each(function() {
                    this.checked = false;                       
                });
            }
        });
    </script>

    <script>
        $('#select-alls').click(function(event) {   
            if(this.checked) {
                
                // Iterate each checkbox
                $('.groupes').each(function() {
                    this.checked = true;                        
                });
            } else {


                $('.groupes').each(function() {
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

    <script>
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Performance Tabungan Perwilayah'
        },
        subtitle: {
            text: 'Source: DMA'
        },
        xAxis: {
            categories: {!! json_encode($reg) !!} ,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Saldo Dalam Juta'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Saldo1',
            data: {!! json_encode($balance) !!}

        }, {
            name: 'Saldo2',
            data: {!! json_encode($balance2) !!}

        }]
    });
    
    </script>

    <script>
        $(document).ready(function(){
            $('#cats').on('change', function(e){
                console.log(e.target.value);
                var date = e.target.value;
                if (date == "dtd") {
                    $.get('/api/json-branches', function(data){
                        console.log(data);
                        $('#date').empty();
                        $('#date').append('<option value="0" selected="true">All Branch</option>');

                        $.each(data, function(index, monthsObj) {
                            console.log(monthsObj.name);
                            $('#date').append('<option value="' + monthsObj.id + '" >' + monthsObj.name + '</option>');
                        });
                    });
                } else if (date == "mtd") {
                    $.get('/api/json-branches', function(data){
                        console.log(data);
                        $('#date').empty();
                        $('#date').append('<option value="0" selected="true">All Branch</option>');

                        $.each(data, function(index, monthsObj) {
                            console.log(monthsObj.name);
                            $('#date').append('<option value="' + monthsObj.id + '" >' + monthsObj.name + '</option>');
                        });
                    });
                } else {
                    $.get('/api/json-branches', function(data){
                        console.log(data);
                        $('#date').empty();
                        $('#date').append('<option value="0" selected="true">All Branch</option>');

                        $.each(data, function(index, monthsObj) {
                            console.log(monthsObj.name);
                            $('#date').append('<option value="' + monthsObj.id + '" >' + monthsObj.name + '</option>');
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
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            $('#months').on('change', function(e){
                var month = e.target.value;
                var sub = month.substr(0,25);
                    $.get('http://192.168.7.32:8080/bni/public/api/json-day-balance?TABLE_NAME=' + month , function(data){

                        var cont = parseInt(month.substr(17,2)) + '_' + month.substr(13,4);
                        var par = @json($a);
                        var ex = par.indexOf(cont);

                        if (ex != -1) {
                            var merge = data.yearss;

                            var as = merge.map(item => item.TABLE_NAME.slice(0,21))
                            .filter((value, index, self) => self.indexOf(value) === index)

                            var final = as.push('deposit_prod_' + parseInt(month.substr(17,2)) + '_' + month.substr(13,4))

                            console.log(as);

                            $('#days').empty();
                            $('#days').append('<option value="0" selected="true">Pilih Tanggal</option>');

                            $.each(as, function(index, daysObj) {

                                if (daysObj.substr(19,2).length < 2) {
                                    $('#days').append('<option value="' + daysObj + '" >' + 'lastdate' + '</option>');
                                } else {
                                    $('#days').append('<option value="' + daysObj + '" >' + daysObj.substr(19,2) + '</option>');
                                }

                            });

                        } else {

                            var merge = data.yearss;
                            var asa = merge.map(item => item.TABLE_NAME.slice(0,21))
                            .filter((value, index, self) => self.indexOf(value) === index)
                            console.log(asa);
                            
                            $('#days').empty();
                            $('#days').append('<option value="0" selected="true">Pilih Tanggal</option>');

                            $.each(asa, function(index, daysObj) {

                                $('#days').append('<option value="' + daysObj + '" >' + daysObj.substr(19,2) + '</option>');

                            });
                        }

                    });
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            $('#types').on('change', function(e){
                console.log(e.target.value);
                var type_product_id = e.target.value;
                $.get('/api/json-groups?type_product_id=' + type_product_id , function(data){
                    console.log(data);
                    $('#products').empty();
                    $('#products').append('<option value="0" selected="true">=======</option>');

                    $.each(data, function(index, productsObj) {
                        console.log(productsObj);
                         $('#products').append('<option value="' + productsObj.id + '" >' + productsObj.name.substring( 0, 1 ).toUpperCase() + productsObj.name.substring( 1 ) + '</option>');
                    });
                });
            });
        });
    </script> 
     
     <script>
        $(document).ready(function(){
            $('#groups').on('change', function(e){
                console.log(e.target.value);
                var group_product_id = e.target.value;
                $.get('/api/json-prods?group_product_id=' + group_product_id , function(data){
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
    
@endsection