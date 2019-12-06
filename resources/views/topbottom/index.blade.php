@extends('main')

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
                    <form action="" method="get">
                        <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Tahun</label>
                                    <select name="year" id="year" class="form-control">
                                        <option value="">=====</option>
                                        @foreach (array_unique($tahun) as $year)
                                            <option value="deposit_prod_{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="">Bulan</label>
                                    <select name="month" id="month" class="form-control">
                                        <option value="">=====</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="">Tanggal</label>
                                        <select name="day" id="day" class="form-control" >
                                        <option value="">=====</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="">Region</label>
                                    <br>
                                    <select name="region" id="region" class="form-control">
                                        <option value="">All Region</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Branch</label>
                                    <br>
                                    <select name="branch" id="branch" class="form-control">
                                        <option value="">All Branch</option>
                                    </select>
                                </div>
    
                                <div class="col-md-3">
                                    <label for="">Status</label>
                                    <br>
                                    <select name="types" id="types" class="form-control">
                                        <option value="">=====</option>
                                                <option value="1">Active</option>
                                                <option value="0">Dormant</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="">Product</label>
                                    <br>
                                    <select name="products" id="products" class="form-control">
                                        <option value="">=====</option>
                                        @foreach ($prod as $type)
                                            <option value="{{$type->name}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Cats</label>
                                    <br>
                                    <select name="cats" id="cats" class="form-control">
                                        <option value="">====</option>
                                        <option value="dtd">DTD</option>
                                        <option value="mtd">MTD</option>
                                        <option value="ytd">YTD</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="">&nbsp;</label>
                                    <br>
                                    <select name="date" id="date" class="form-control">
                                        <option value="">====</option>
                                        @foreach ($a as $item)
                                                <option value="{{ substr($item, 13,4).'-'.substr($item,17,2).'-'.substr($item,19,2) }}">{{ substr($item, 13,4) . '-' .substr($item, 19, 2) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="">Order By</label>
                                    <br>
                                    <select name="order" id="order" class="form-control">
                                        <option value="">====</option>
                                        <option value="asc">Asc</option>
                                        <option value="desc">Desc</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="">Filter</label>
                                    <br>
                                    <select name="filter" id="filter" class="form-control">
                                        <option value="">====</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
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

                    <br>
                    <table class="table border" id="myTable">
                        <thead>
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
                                        {{-- <td>{{$val->saldo1}}</td>
                                        <td>{{$val->saldo2}}</td>
                                        <td>{{$val->saldo1-$val->saldo2}}</td> --}}
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
                                    {{-- <td>{{$int1}}</td>
                                    <td>{{$int2}}</td>
                                    <td>{{$int3}}</td> --}}
                                </tr>
                            
                        </tbody>
                    </table>
                    <div class="container" id="container" style="min-widh: 310px; height:400px; margin: 0 auto;">

                    </div>
                    @endif

                 
                </div>
            </div>
        </div>
</div>
@endsection

@section('scripts')
    
    <script src="https://code.highcharts.com/highcharts.js"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
   
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

    {{-- <script>
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
    </script> --}}
        
    <script>
        $(document).ready(function(){
            $('#region').on('change', function(e){
                console.log(e.target.value);
                var region_id = e.target.value;
                if (region_id == "") {
                    $.get('/api/json-branches', function(data){
                        console.log(data);
                        $('#branch').empty();
                        $('#branch').append('<option value="0" selected="true">All Branch</option>');

                        $.each(data, function(index, monthsObj) {
                            console.log(monthsObj.name);
                            $('#branch').append('<option value="' + monthsObj.id + '" >' + monthsObj.name + '</option>');
                        });
                    });
                } else {
                    $.get('/api/json-branches?region_id=' + region_id , function(data){
                        console.log(data);
                        $('#branch').empty();
                        $('#branch').append('<option value="0" selected="true">=====</option>');

                        $.each(data, function(index, monthsObj) {
                            console.log(monthsObj.name);
                            $('#branch').append('<option value="' + monthsObj.branch_code + '" >' + monthsObj.name + '</option>');
                        });
                    });
                }
            });
        });
    </script>
    
    <script>
        $(document).ready(function(){
            $('#year').on('change', function(e){
                // console.log(e.target.value);
                var date = e.target.value;
                $.get('/api/json-month-topbot?tables_in_bni=' + date , function(data){
                    console.log(data);
                     var as = data.map(item => item.Tables_in_bni.slice(0,19))
                    .filter((value, index, self) => self.indexOf(value) === index)
                    $('#month').empty();
                    $('#month').append('<option value="0" selected="true">=====</option>');

                    $.each(as, function(index, monthsObj) {
                        $('#month').append('<option value="' + monthsObj.slice(0,19) + '" >' +  monthsObj.slice(17,19) + '</option>');
                    });
                });
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            $('#month').on('change', function(e){
                console.log(e.target.value);
                var dates = e.target.value;
                $.get('/api/json-day-topbot?tables_in_bni=' + dates , function(data){
                    console.log(data);
                    $('#day').empty();
                    $('#day').append('<option value="0" selected="true">=====</option>');

                    $.each(data, function(index, monthsObj) {
                        var str = monthsObj.Tables_in_bni;
                        console.log(monthsObj);
                        $('#day').append('<option value="' + monthsObj.Tables_in_bni.substring(19) + '" >' +  monthsObj.Tables_in_bni.substring(19) + '</option>');
                    });
                });
            });
        });
    </script>
{{-- 
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
                        // $('#products').append('<option value="' + productsObj.id + '" >' + productsObj.name.substring( 0, 1 ).toUpperCase() + productsObj.name.substring( 1 ) + '</option>');
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
    </script> --}}
    
@endsection