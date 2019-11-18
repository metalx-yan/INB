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

@section('content')
<div class="container-fluid">
       
    <div class="row page-titles">
        <div class="col-md-6 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Key Performance Matrix</li>
            </ol>
        </div>
    </div>
    
    <div class="card">
        <div class="card-title">
            <br>
            <div class="container">
                <form action="" method="get">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="">....</label>
                                <select name="perorangan" id="perorangan" class="form-control">
                                    {{-- <option value="*">All</option> --}}
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="">Tabungan</label>
                                <select name="tabungan" id="tabungan" class="form-control">
                                    <option value="tabungan">Tabungan</option>
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="">Region</label>
                                <select name="region" id="region" class="form-control">
                                    {{-- <option value="*">All Region</option> --}}
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="">Jenis</label>
                                <br>
                                <select name="type" id="type" class="form-control">
                                    <option value="all_type">All Jenis</option>
                                    @foreach ($parameter as $type)
                                        <option value="{{ $type->type_product->id }}">{{ $type->type_product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="">Group</label>
                                <br>
                                <select name="group" id="group" class="form-control">
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="">Acc Type</label>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" 
                                            id="dropdownMenu1" data-toggle="dropdown" 
                                            aria-haspopup="true" aria-expanded="true" >
                                        <i class="glyphicon glyphicon-cog"></i>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu checkbox-menu allow-focus" aria-labelledby="dropdownMenu1">
                                        <div id="options">

                                        </div>
                                        
                                    </ul>
                                </div>
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
                        
                        <div class="container" id="container" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>
                        <hr>
                        <div class="container" id="container1" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>
                        <hr>
                        <div class="container" id="container2" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>

                        <div class="container" id="container3" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>
                        <hr>
                        <div class="container" id="container4" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>

                        <div class="container" id="container5" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>
                        <hr>
                        <div class="container" id="container6" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>

                        <div class="container" id="container7" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>
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

    <script>
        Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'CUR Balance'
        },
        subtitle: {
            text: 'Source: X'
        },
        xAxis: {
            categories: {!! json_encode($month) !!},
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
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
            name: '2018',
            data: {!! json_encode($balance) !!}

        },{
            name: '2019',
            data: {!! json_encode($balance2) !!}

        }]
    });
    </script>

    <script>
        Highcharts.chart('container1', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Total Account'
        },
        subtitle: {
            text: 'Source: X'
        },
        xAxis: {
            categories: {!! json_encode($month) !!},
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
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
            name: '2018',
            data: {!! json_encode($total1) !!}

        },{
            name: '2019',
            data: {!! json_encode($total2) !!}

        }]
    });
    </script>
        <script>
        Highcharts.chart('container2', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Total Account'
        },
        subtitle: {
            text: 'Source: X'
        },
        xAxis: {
            categories: {!! json_encode($month) !!},
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
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
            name: '2018',
            data: {!! json_encode($total3) !!}

        },{
            name: '2019',
            data: {!! json_encode($total4) !!}

        }]
    });
    </script>

    <script>
        Highcharts.chart('container3', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Total Closed Account YTD'
        },
        subtitle: {
            text: 'Source: X'
        },
        xAxis: {
            categories: {!! json_encode($month) !!},
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
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
            name: '2018',
            data: {!! json_encode($total5) !!}

        },{
            name: '2019',
            data: {!! json_encode($total6) !!}

        }]
    });
    </script>

    <script>
        Highcharts.chart('container4', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Total New Account MTD'
        },
        subtitle: {
            text: 'Source: X'
        },
        xAxis: {
            categories: {!! json_encode($month) !!},
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
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
            name: '2018',
            data: {!! json_encode($total7) !!}

        },{
            name: '2019',
            data: {!! json_encode($total8) !!}

        }]
    });
    </script>

    <script>
        Highcharts.chart('container5', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Total New Account YTD'
        },
        subtitle: {
            text: 'Source: X'
        },
        xAxis: {
            categories: {!! json_encode($month) !!},
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
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
            name: '2018',
            data: {!! json_encode($total9) !!}

        },{
            name: '2019',
            data: {!! json_encode($total10) !!}

        }]
    });
    </script>

    <script>
        Highcharts.chart('container6', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Closed Account Cur Bal MTD'
        },
        subtitle: {
            text: 'Source: X'
        },
        xAxis: {
            categories: {!! json_encode($month) !!},
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
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
            name: '2018',
            data: {!! json_encode($total11) !!}

        },{
            name: '2019',
            data: {!! json_encode($total12) !!}

        }]
    });
    </script>

    <script>
        Highcharts.chart('container7', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Closed Account Cur Bal YTD'
        },
        subtitle: {
            text: 'Source: X'
        },
        xAxis: {
            categories: {!! json_encode($month) !!},
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
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
            name: '2018',
            data: {!! json_encode($total13) !!}

        },{
            name: '2019',
            data: {!! json_encode($total14) !!}

        }]
    });
    </script>

    <script>
        $(".checkbox-menu").on("change", "input[type='checkbox']", function() {
            $(this).closest("li").toggleClass("active", this.checked);
            });

            $(document).on('click', '.allow-focus', function (e) {
            e.stopPropagation();
        });
    </script>

    <script>
        $(document).ready(function(){
            $('#type').on('change', function(e){
                console.log(e.target.value);
                var groupid = e.target.value;
                if (groupid == "all_type") {
                    $.get('/api/json-group-matrix' , function(data){
                    console.log(data);
                    $('#group').empty();
                    $('#group').append('<option value="0" selected="true">All Group</option>');

                    $.each(data, function(index, groupsObj) {
                        console.log(groupsObj.group);
                        $('#group').append('<option value="' + groupsObj.group + '" >' + groupsObj.group + '</option>');
                    });
                });    
                
                } else {
                    
                $.get('/api/json-group-matrix?type_product_id=' + groupid , function(data){
                    console.log(data);
                    $('#group').empty();
                    $('#group').append('<option value="0" selected="true">=======</option>');

                    $.each(data, function(index, groupsObj) {
                        console.log(groupsObj.group);
                        $('#group').append('<option value="' + groupsObj.group + '" >' + groupsObj.group + '</option>');
                    });
                });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            $('#group').on('change', function(e){
                console.log(e.target.value);
                var group_product_third = e.target.value;
                $.get('/api/json-acc-matrix?group_product_third=' + group_product_third , function(data){
                    console.log(data);
                    $('#options').empty();
                    // $('#option').append('<option value="0" selected="true">=======</option>');

                    $.each(data, function(index, optionObj) {
                        $('#options').append('<li><label><input type="checkbox">' + optionObj.type + '  ' + optionObj.product.name + '</label></li>');
                    });
                });
            });
        });
    </script>

   
@endsection