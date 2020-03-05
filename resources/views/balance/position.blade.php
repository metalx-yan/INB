@extends('main')

@section('title', 'Position')

@section('content')
<div class="container-fluid">
       
    <div class="row page-titles">
        <div class="col-md-6 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Saldo Posisi</li>
            </ol>
        </div>
    </div>
    
    <div class="card">
        <div class="card-title">
            <br>
            <div class="container">
                <form action="{{ route('saldo-posisi') }}" method="POST">
                    @csrf
                        <div class="row">
                            <input type="hidden" name="id">
                            <div class="col-md-3">
                                <label for="">Tahun</label>
                                <select name="year" id="year" class="form-control" required>
                                    <option value="">Pilih Tahun</option>
                                    @foreach ($years as $column)
                                        <option value="{{ $column->tahun}}">{{ $column->tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="">Bulan</label>
                                <select name="month" id="month" class="form-control" required>
                                    <option value="">Pilih Bulan</option>
                                    
                                </select>

                            </div>
                            
                            <div class="col-md-3">
                                <label for="">Tanggal</label>
                                <select name="day" id="day" class="form-control" required>
                                    <option value="">Pilih Tanggal</option>
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="">Region</label>
                                <br>
                                <select name="region" id="region" class="form-control">
                                    <option value="">Pilih Region</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->region.'-'.$region->regDigit }}">{{ $region->regDigit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                           
                            <div class="col-md-3">
                                <label for="">Jenis</label>
                                <br>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" 
                                            id="dropdownMenu1" data-toggle="dropdown" 
                                            aria-haspopup="true" aria-expanded="true" style="border-color:#ced4da; width:100%;">
                                            
                                        <span class="caret" style="margin-left:-59%;">Pilih Jenis</span>
                                    </button>
                                    <ul class="dropdown-menu checkbox-menu allow-focus" id="menus" aria-labelledby="dropdownMenu1" style="width:100%;">
                                            <input type="text" id="myInputs" class="form-control" placeholder="Search Data" onkeyup="myFunctions()" title="Type in a name" style="width:95%; margin-left:6px; padding: 12px 20px 12px 40px; background-repeat:no-repeat; background-size: 35px; ">
                                            <p style="margin-top:14px; margin-left:15px;">
                                            <b><input type="checkbox" name="select-alls" id="select-alls"> Select All</b>
                                            <hr>
                                            <div id="type">
                                            @foreach ($types as $type)
                                                    <li>
                                                        <label>
                                                            <input type="checkbox" name="types[]" style="margin-left: 15px;" class="brans" value="{{ $type->jenis }}"> {{ $type->jenis }}
                                                        </label>
                                                    </li>
                                                    @endforeach
                                                </div>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="">Group</label>
                                <br>
                                <div class="dropdown gonta">
                                    <button class="btn btn-default dropdown-toggle ganti" type="button" 
                                            id="dropdownMenu" data-toggle="dropdown" 
                                            aria-haspopup="true" aria-expanded="true" style="border-color:#ced4da; width:100%;">
                                        
                                        <span class="caret" style="margin-left:-59%;">Pilih Group</span>
                                    </button>
                                    <ul class="dropdown-menu checkbox-menu allow-focus" id="menu" aria-labelledby="dropdownMenu" style="width:100%;">
                                            <input type="text" id="myInput" class="form-control" placeholder="Search Data" onkeyup="myFunction()" title="Type in a name" style="width:95%; margin-left:6px; padding: 12px 20px 12px 40px; background-repeat:no-repeat; background-size: 35px; ">
                                            <p style="margin-top:14px; margin-left:15px;">
                                            <b><input type="checkbox" name="select-all" id="select-all"> Select All</b>
                                            <hr>
                                                <div id="groupe">

                                                </div>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="">Product</label>
                                <br>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" 
                                            id="dropdownMenua" data-toggle="dropdown" 
                                            aria-haspopup="true" aria-expanded="true" style="border-color:#ced4da; width:100%;">
                                        
                                        <span class="caret" style="margin-left:-51%;">Pilih Product</span>
                                    </button>
                                    <ul class="dropdown-menu checkbox-menu allow-focus" id="menua" aria-labelledby="dropdownMenu" style="width:100%;">
                                            <input type="text" id="myInputa" class="form-control" placeholder="Search Data" onkeyup="myFunctiona()" title="Type in a name" style="width:95%; margin-left:6px; padding: 12px 20px 12px 40px; background-repeat:no-repeat; background-size: 35px; ">
                                            <p style="margin-top:14px; margin-left:15px;">
                                            <b><input type="checkbox" name="select-alla" id="select-alla"> Select All</b>
                                            <hr>
                                                <div id="product">
                                                    
                                                </div>
                                    </ul>
                                </div>
                            </div>

                            {{-- <div class="col-md-3">
                                <label for="">Product</label>
                                <br>
                                <select name="products" id="products" class="form-control">
                                    <option value="">All Product</option>
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
                        <hr>

                        <br>
                        @if ($null)
                            
                        @else
                            
                        {{-- <a href="{{ route('export.file') }}" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a> --}}
                        <table class="table border" id="myTable">
                            <thead>
                                <tr style="background-color: #5f3423; color:white;">
                                    <td>Keterangan</td>
                                    <td>Group Produk</td>
                                    <td>Saldo Posisi</td>
                                    <td>NOA</td>
                                    <td>WS</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($result1) == 0)
                                    
                                @else
                                    
                                @php
                                    $int1 = 0;
                                    $int2 = 0;
                                @endphp

                                @foreach ($result1 as $tidak_berbayar)
                                    @isset($tidak_berbayar)
                                        <tr>
                                            <td>{{ $tidak_berbayar->jenis }}</td>
                                            <td>{{ $tidak_berbayar->group_prod_3 }}</td>
                                            <td>{{ number_format($tidak_berbayar->balance) }}</td>
                                            <td>{{ number_format($tidak_berbayar->number_account) }}</td>
                                            <td>{{ number_format($tidak_berbayar->total) }}</td>
                                        </tr>
                                        @php
                                            $int1 += $tidak_berbayar->balance;
                                            $int2 += $tidak_berbayar->number_account;
                                        @endphp
                                    @endisset
                                @endforeach

                                <tr style="background-color: #5f3423; color:white;">
                                    <td style="text-align:right">Total Reguler Berbayar</td>
                                    <td></td>
                                    <td>{{ number_format($int1) }}</td>
                                    <td>{{ number_format($int2) }}</td>
                                    <td>{{ number_format($int1/$int2) }}</td>
                                </tr>
                                @endif

                                @if (count($result2) == 0)
                                    
                                @else
                                    
                                @php
                                    $int4 = 0;
                                    $int5 = 0;
                                @endphp

                                @foreach ($result2 as $berbayar)
                                    @isset($berbayar)
                                        <tr>
                                            <td>{{ $berbayar->jenis }}</td>
                                            <td>{{ $berbayar->group_prod_3 }}</td>
                                            <td>{{ number_format($berbayar->balance) }}</td>
                                            <td>{{ number_format($berbayar->number_account) }}</td>
                                            <td>{{ number_format($berbayar->total) }}</td>
                                        </tr>
                                        @php
                                            $int4 += $berbayar->balance;
                                            $int5 += $berbayar->number_account;
                                        @endphp
                                    @endisset
                                @endforeach

                                <tr style="background-color: #5f3423; color:white;">
                                    <td style="text-align:right">Total Reguler Tidak Berbayar</td>
                                    <td> </td>
                                    <td>{{ number_format($int4) }}</td>
                                    <td>{{ number_format($int5) }}</td>
                                    <td>{{ number_format($int4/$int5) }}</td>
                                </tr>

                                @endif

                                @if (count($result3) == 0)
                                    
                                @else
                                    
                                @php
                                    $int7 = 0;
                                    $int8 = 0;
                                @endphp

                                @foreach ($result3 as $mandatory)
                                    @isset($mandatory)
                                        <tr>
                                            <td>{{ $mandatory->jenis }}</td>
                                            <td>{{ $mandatory->group_prod_3 }}</td>
                                            <td>{{ number_format($mandatory->balance) }}</td>
                                            <td>{{ number_format($mandatory->number_account) }}</td>
                                            <td>{{ number_format($mandatory->total) }}</td>
                                        </tr>
                                        @php
                                            $int7 += $mandatory->balance;
                                            $int8 += $mandatory->number_account;
                                        @endphp
                                    @endisset
                                @endforeach

                                <tr style="background-color: #5f3423; color:white;">
                                    <td style="text-align:right">Total Mandatory</td>
                                    <td> </td>
                                    <td>{{ number_format($int7) }}</td>
                                    <td>{{ number_format($int8) }}</td>
                                    <td>{{ number_format($int7/$int8) }}</td>
                                </tr>
                                @endif

                                @if (count($result4) == 0)
                                    
                                @else
                                    
                                @php
                                    $int10 = 0;
                                    $int11 = 0;
                                @endphp

                                @foreach ($result4 as $result)
                                    @isset($result)
                                        @php
                                            $int10 += $result->balance;
                                            $int11 += $result->number_account;
                                        @endphp
                                    @endisset
                                @endforeach

                                <tr style="background-color: #5f3423; color:white;">
                                    <td style="text-align:right">Total Tabungan</td>
                                    <td> </td>
                                    <td>{{ number_format($int10) }}</td>
                                    <td>{{ number_format($int11) }}</td>
                                    <td>{{ number_format($int10/$int11) }}</td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                        
                        <br>
                        <div class="container" id="container" style="min-widh: 310px; height:400px; margin: 0 auto;">

                        </div>
                        @endif

                    </div>
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
   
    <script>
        $(document).ready(function(){
            $(".gonta").change(function(e){
                    console.log(e);
                    if($('.groupes').is(':checked') == true){
                        console.log(e.target.value);
                        var count =  document.querySelectorAll('input[type="checkbox"]:checked');
                        var str = '';
                        for (let i = 0; i < count.length; i++) {
                            str += 'group_prod_3[]='+count[i].value+'&';
                        }
                        console.log(str);
                        $.get('http://192.168.7.32:8080/bni/public/api/json-prods?' + str , function(data){
                            console.log(data);
                            $('#product').empty();

                            $.each(data, function(index, productsObj) {
                                console.log(productsObj);
                                $('#product').append('<li><label><input name="products[]" style="margin-left: 15px;" type="checkbox" class="products" value="'+ productsObj.prd_name +'">' +  productsObj.prd_name +  '</label></li>');
                            });
                        });
                    } else {
                        console.log(e.target.value);
                        var count =  document.querySelectorAll('input[type="checkbox"]:checked');
                        var str = '';
                        for (let i = 0; i < count.length; i++) {
                            str += 'group_prod_3[]='+count[i].value+'&';
                        }
                        console.log(str);
                        $.get('http://192.168.7.32:8080/bni/public/api/json-prods?' + str , function(data){
                            console.log(data);
                            $('#product').empty();

                            $.each(data, function(index, productsObj) {
                                console.log(productsObj);
                                $('#product').append('<li><label><input name="products[]" style="margin-left: 15px;" type="checkbox" class="products" value="'+ productsObj.prd_name +'">' +  productsObj.prd_name +  '</label></li>');
                            });
                        });
                    }
            });
        });
    </script>

    <script>
        $('.brans').click(function(e){
            if($(this).is(':checked') == true){
                var count =  document.querySelectorAll('input[type="checkbox"]:checked');
                var str = '';
                for (let i = 0; i < count.length; i++) {
                    str += 'jenis[]='+count[i].value+'&';
                }
                console.log(str);
                $.get('http://192.168.7.32:8080/bni/public/api/json-groups?' + str , function(data){
                    console.log(data);
                    $('#groupe').empty();

                    $.each(data, function(index, productsObj) {
                        console.log(productsObj);
                        $('#groupe').append('<li><label><input name="groups[]" style="margin-left: 15px;" type="checkbox" class="groupes" value="'+ productsObj.group_prod_3 +'">' +  productsObj.group_prod_3 +  '</label></li>');
                    });
                });

            } else {

                        var count =  document.querySelectorAll('input[type="checkbox"]:checked');
                        var str = '';
                        for (let i = 0; i < count.length; i++) {
                            str += 'jenis[]='+count[i].value+'&';
                        }
                        console.log(str);
                        $.get('http://192.168.7.32:8080/bni/public/api/json-groups?' + str , function(data){
                            console.log(data);
                            $('#groupe').empty();

                            $.each(data, function(index, productsObj) {
                                console.log(productsObj);
                                $('#groupe').append('<li><label><input name="groups[]" style="margin-left: 15px;" type="checkbox" class="groupes" value="'+ productsObj.group_prod_3 +'">' +  productsObj.group_prod_3 +  '</label></li>');
                            });
                        });
                    
            }
        });
    </script>

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
        $('#select-alls').click(function(event) {   
            if(this.checked) {
                $.get('http://192.168.7.32:8080/bni/public/api/json-groups'  , function(data){
                    console.log(data);
                    $('#groupe').empty();

                    $.each(data, function(index, productsObj) {
                        console.log(productsObj);
                        $('#groupe').append('<li><label><input name="groups[]" style="margin-left: 15px;" type="checkbox" class="groupes" value="'+ productsObj.group_prod_3 +'">' +  productsObj.group_prod_3 +  '</label></li>');
                    });
                });
                // Iterate each checkbox
                $('.brans').each(function() {
                    this.checked = true;                        
                });
            } else {
                $.get('http://192.168.7.32:8080/bni/public/api/json-groups'  , function(data){
                    console.log(data);
                    $('#groupe').empty();
                });

                $('.brans').each(function() {
                    this.checked = false;                       
                });
            }
        });
    </script>

    <script>
        $('#select-all').click(function(event) {   
            if(this.checked) {
                $.get('http://192.168.7.32:8080/bni/public/api/json-prods'  , function(data){
                    console.log(data);

                    $('#product').empty();
                    
                    $.each(data, function(index, productsObj) {
                        console.log(productsObj);
                        $('#product').append('<li><label><input name="products[]" style="margin-left: 15px;" type="checkbox" class="products" value="'+ productsObj.prd_name +'">' +  productsObj.prd_name +  '</label></li>');
                    });
                });
                // Iterate each checkbox
                $('.groupes').each(function() {
                    this.checked = true;                        
                });
            } else {
                $.get('http://192.168.7.32:8080/bni/public/api/json-prods'  , function(data){
                    console.log(data);
                    $('#product').empty();
                });

                $('.groupes').each(function() {
                    this.checked = false;                       
                });
            }
        });
    </script>

<script>
        $('#select-alla').click(function(event) {   
            if(this.checked) {
               
                // Iterate each checkbox
                $('.products').each(function() {
                    this.checked = true;                        
                });
            } else {
                
                $('.products').each(function() {
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
        function myFunctiona() {
            var FilterValue, input, ul, li, i;
                input = document.getElementById('myInputa');
                FilterValue = input.value;
                ul = document.getElementById('menua');
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
            name: 'Saldo',
            data: {!! json_encode($balance) !!}

        }, {
            name: 'Noa',
            data: {!! json_encode($number_account) !!}

        }]
    });
    
    </script>

    {{-- <script>
        $(document).ready(function(){
            $('#region').on('change', function(e){
                console.log(e.target.value);
                var region_id = e.target.value;
                if (region_id == "") {
                    $.get('/api/json-branches', function(data){
                        console.log(data);
                        $('#branch').empty();
                        $('#branch').append('<option value="0" selected="true">All Region</option>');

                        $.each(data, function(index, monthsObj) {
                            console.log(monthsObj.name);
                            $('#branch').append('<option value="' + monthsObj.id + '" >' + monthsObj.name + '</option>');
                        });
                    });
                } else {
                    $.get('/api/json-branches?region_id=' + region_id , function(data){
                        console.log(data);
                        $('#branch').empty();
                        $('#branch').append('<option value="0" selected="true">Pilih Bran</option>');

                        $.each(data, function(index, monthsObj) {
                            console.log(monthsObj.name);
                            $('#branch').append('<option value="' + monthsObj.id + '" >' + monthsObj.name + '</option>');
                        });
                    });
                }
            });
        });
    </script> --}}
    
    <script>
        $(document).ready(function(){
            $('#year').on('change', function(e){
                console.log(e.target.value);
                var year = e.target.value;
                $.get('http://192.168.7.32:8080/bni/public/api/json-months?tahun=' + year , function(data){
                    console.log(data);
                    $('#month').empty();
                    $('#month').append('<option value="0" selected="true">Pilih Bulan</option>');

                    $.each(data, function(index, monthsObj) {
                        console.log(String("00" + monthsObj.bulan).slice(-2));
                       
                        $('#month').append('<option value="' + monthsObj.bulan + '" >' + String("00" + monthsObj.bulan).slice(-2) + '</option>');
                    });
                });
          
            });
        });
    </script>

    <script> 
            $('#month').on('change', function(e){
                console.log(e.target.value);
                var date = e.target.value;
                $.get('http://192.168.7.32:8080/bni/public/api/json-days?bulan=' + date , function(data){
                    console.log(data);
                    $('#day').empty();
                    $('#day').append('<option value="0" selected="true">Pilih Tanggal</option>');

                    $.each(data, function(index, monthsObj) {
                        console.log(String("00" + monthsObj.tgl).slice(-2));
                        $('#day').append('<option value="' + monthsObj.tgl + '" >' + String("00" + monthsObj.tgl).slice(-2) + '</option>');
                    });
                });
            });
    </script>

    {{-- <script>
        $(document).ready(function(){
            $('#types').on('change', function(e){
                console.log(e.target.value);
                var type_product_id = e.target.value;
                $.get('http://192.168.7.32:8080/bni/public/api/json-groups?jenis=' + type_product_id , function(data){
                    console.log(data);
                    $('#groups').empty();
                    $('#groups').append('<option value="0" selected="true">=======</option>');

                    $.each(data, function(index, productsObj) {
                        console.log(productsObj);
                        $('#groups').append('<option value="' + productsObj.group_prod_3 + '" >' + productsObj.group_prod_3 + '</option>');
                    });
                });
            });
        });
    </script> --}}

    {{-- <script>
        $(document).ready(function(){
            $('#regions').on('change', function(e){
                console.log(e.target.value);
                var id = e.target.value;
                if (id == "all_region") {
                    $.get('/api/json-regions' , function(data){
                    console.log(data);
                    // $('#groups').empty();
                    // $('#groups').append('<option value="0" selected="true">=======</option>');

                        $.each(data, function(index, regionsObj) {
                            console.log(regionsObj.id + '-' + regionsObj.name);
                            $('#regions').append('<option value="' + regionsObj.id + '" ></option>');
                        });
                    });    
                } else {
                    
                $.get('/api/json-regions?id=' + id , function(data){
                    console.log(data);
                    // $('#groups').empty();
                    // $('#groups').append('<option value="0" selected="true">=======</option>');

                    $.each(data, function(index, regionsObj) {
                        console.log(regionsObj.id + '-' + regionsObj.name);
                        // $('#groups').append('<option value="' + productsObj.id + '" >' + productsObj.name.substring( 0, 1 ).toUpperCase() + productsObj.name.substring( 1 ) + '</option>');
                    });
                });
                }
            });
        });
    </script> --}}

    {{-- <script>
        $(document).ready(function(){
            $('#groups').on('change', function(e){
                console.log(e.target.value);
                var group_product_id = e.target.value;
                $.get('http://192.168.7.32:8080/bni/public/api/json-prods?group_product_id=' + group_product_id , function(data){
                    console.log(data);
                    $('#products').empty();
                    $('#products').append('<option value="0" selected="true">=======</option>');

                    $.each(data, function(index, productsObj) {
                        console.log(productsObj.prd_name);
                        $('#products').append('<option value="' + productsObj.prd_name + '" >' + productsObj.prd_name + '</option>');
                    });
                });
            });
        });
    </script> --}}

    
    
@endsection