@extends('main')

@section('content')
<div class="container-fluid">
       
    <div class="row page-titles">
        <div class="col-md-6 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Saldo Average</li>
            </ol>
        </div>
    </div>
    
    <div class="card">
        <div class="card-title">
            <br>
            <div class="container">
                <form action="{{ route('saldo-posisi') }}" method="get">
                        <div class="row">
                            <input type="hidden" name="id">
                            <div class="col-md-3">
                                <label for="">Tahun</label>
                                <select name="year" id="year" class="form-control">
                                    <option value="">=====</option>
                                    
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
                                <select name="regions[]" id="regions" class="form-control">
                                    <option value="">=====</option>
                                   
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="">Jenis</label>
                                <br>
                                <select name="types[]" id="types" class="form-control">
                                    <option value="">=====</option>
                                    <option value="">All Type</option>
                                    
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="">Group</label>
                                <br>
                                <select name="groups[]" id="groups" class="form-control" >
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="">Product</label>
                                <br>
                                <select name="products[]" id="products" class="form-control">
                                    {{-- <option value="">=====</option> --}}
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
                        <hr>

                        <br>
                        {{-- <a href="{{ route('export.file') }}" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a> --}}
                        <table class="table border" id="myTable">
                            <thead>
                                <tr style="background-color: #2157f1; color:white;">
                                    <td>Keterangan</td>
                                    <td>Group Produk</td>
                                    <td>Saldo Average</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $int1 = 0;
                                @endphp

                                @foreach ($result1 as $tidak_berbayar)
                                    @isset($tidak_berbayar)
                                        <tr>
                                            <td>{{ $tidak_berbayar->type_product->name }}</td>
                                            <td>{{ $tidak_berbayar->group_product->name }}</td>
                                            <td>{{ number_format($tidak_berbayar->balance,2) }}</td>
                                        </tr>
                                        @php
                                            $int1 += $tidak_berbayar->balance;
                                        @endphp
                                    @endisset
                                @endforeach

                                <tr style="background-color: #2157f1; color:white;">
                                    <td style="text-align:right">Total Reguler</td>
                                    @isset($tidak_berbayar)
                                    <td>{{ ucwords($tidak_berbayar->type_product->name) }}</td>
                                    @endisset
                                    <td>{{ number_format($int1) }}</td>
                                </tr>
                            </tbody>
                        </table>

                   
                        <br>
                        <div class="container" id="container" style="min-widh: 310px; height:400px; margin: 0 auto;">

                        </div>
                    </div>
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

    {{-- <script>
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
    
    </script> --}}

    <script>
        $(document).ready(function(){
            $('#year').on('change', function(e){
                console.log(e.target.value);
                var date = e.target.value;
                $.get('/api/json-months?date=' + date , function(data){
                    console.log(data);
                    $('#month').empty();
                    $('#month').append('<option value="0" selected="true">=====</option>');

                    $.each(data, function(index, monthsObj) {
                        console.log(monthsObj.month);
                        $('#month').append('<option value="' + monthsObj.month + '" >' + monthsObj.month + '</option>');
                    });
                });
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            $('#month').on('change', function(e){
                console.log(e.target.value);
                var date = e.target.value;
                $.get('/api/json-days?date=' + date , function(data){
                    console.log(data);
                    $('#day').empty();
                    $('#day').append('<option value="0" selected="true">=====</option>');

                    $.each(data, function(index, monthsObj) {
                        console.log(monthsObj.day);
                        $('#day').append('<option value="' + monthsObj.day + '" >' + monthsObj.day + '</option>');
                    });
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
                    $('#groups').empty();
                    $('#groups').append('<option value="0" selected="true">=======</option>');

                    $.each(data, function(index, productsObj) {
                        console.log(productsObj.id + '-' + productsObj.name);
                        $('#groups').append('<option value="' + productsObj.id + '" >' + productsObj.name.substring( 0, 1 ).toUpperCase() + productsObj.name.substring( 1 ) + '</option>');
                    });
                });
            });
        });
    </script>

    <script>
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