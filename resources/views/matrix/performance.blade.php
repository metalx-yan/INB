@extends('main')

@section('title', 'Key Performance Matrix')

@section('link')
    <style>
        /* body {
  padding: 15px;
    } */
    .dropbtn {
  background-color: white;
  border-radius: 3px;
  color: #666;
  padding: 8px;
  font-size: 16px;
  border: 1px solid #ced4da;
  cursor: pointer;
  width: 230px;
}

.dropbtn:hover, .dropbtn:focus {
  background-color: #CED4DA;
}

#myInputa {
  box-sizing: border-box;
  background-image: url('searchicon.png');
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 16px;
  border: none;
  border-bottom: 1px solid #ddd;
  position:fixed;
}

#myInput:focus {outline: 3px solid #ddd;}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f6f6f6;
  min-width: 230px;
  overflow: auto;
  border: 1px solid #ddd;
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}

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
                                <select id="perorangan" class="form-control">
                                    <option value="">All</option>
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="">Tabungan</label>
                                <select  id="tabungan" class="form-control">
                                    <option value="">Tabungan</option>
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="">Region</label>
                                <select name="region" id="region" class="form-control">
                                    <option value="">Pilih Region</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->region }}">{{ $region->region }} - {{ $region->region_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="">Jenis</label>
                                <br>
                                <select name="type" id="type" class="form-control">
                                    <option value="">Pilih Jenis</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->jenis }}">{{ $type->jenis }}</option>
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
                                    <option value="">All Group</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                    <label for="">Acc Type</label>
                                    <div class="dropdown">
                                        <button type="button"  class="dropbtn">Pilih Acc Type</button>
                                        <br>
                                        <div id="myDropdowna" class="dropdown-content" style="overflow-y: auto; top:40px; bottom:-250px;">
                                        <input type="text" placeholder="Search.." id="myInputa" onkeyup="filterFunctiona()" >
                                        
                                        <br><br><br>
                                        <b><input style="margin-left: 30px;" type="checkbox" name="select-all" id="select-all"> Select All</b>
                                        <hr>
                                            <div id="options">
                                            </div>
                                        </div>
                                    </div>
                            </div>

                   
                        </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">&nbsp;</label>
                                    <br>
                                    <button type="submit" id="buttonsa" value="button" name="cari" class="btn btn-primary" style="margin-left: 404%;">Execute</button>
                                </div>
                            </div>

                        </form>
                        <br>

                        <?php 
                            if (!isset($_GET["region"]) || !isset($_GET["type"]) || !isset($_GET["group"])) {
                                $reg = '';
                                $type = '';
                                $group = '';
                            } else {
                                $reg = $_GET["region"];
                                $type = $_GET["type"];
                                $group = $_GET["group"];
                            }

                            if (!isset($_GET["acctypes"])) {
                                $acc = '';
                            } else {
                                $acc = implode(' ',$_GET["acctypes"]);
                            }
                            
                        
                        ?>


                        @if ($cari == "button")
                        <a href="{{ url('user/export-performance') }}?region=<?php echo ($reg) ?>&type=<?php echo ($type) ?>&group=<?php echo ($group) ?>&acctypes=<?php echo ($acc) ?>" class="btn btn-info">Excel</a>
                        
                            @if (count($query1) == 0 || count($query2) == 0)
                                
                            @else
                                
                            <div class="container" id="container" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>
                            <hr>

                            @endif

                            @if (count($query3) == 0 || count($query4) == 0)
                                
                            @else
                            
                            <div class="container" id="container1" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>
                            <hr>

                            @endif  
                            
                            @if (count($query5) == 0 || count($query6) == 0)
                                
                            @else
                            <div class="container" id="container2" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>

                            @endif
                            
                            @if (count($query7) == 0 || count($query8) == 0)
                                
                            @else

                            <div class="container" id="container3" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>
                            <hr>
                            
                            @endif

                            @if (count($query9) == 0 || count($query10) == 0)
                                
                            @else

                            <div class="container" id="container4" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>
                            
                            @endif

                            @if (count($query11) == 0 || count($query12) == 0)
                                
                            @else
                            <div class="container" id="container5" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>
                            <hr>
                            @endif

                            @if (count($query13) == 0 || count($query14) == 0)
                                
                            @else
                            <div class="container" id="container6" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>
                            @endif

                            @if (count($query15) == 0 || count($query16) == 0)
                                
                            @else
                            <div class="container" id="container7" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>
                            <hr>
                            @endif

                            @if (count($query17) == 0 || count($query18) == 0)
                                
                            @else
                            <div class="container" id="container8" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>
                            @endif

                            @if (count($query19) == 0 || count($query20) == 0)
                                
                            @else
                            <div class="container" id="container9" style="min-widh: 310px; height:400px; margin: 0 auto;"></div>
                            @endif

                        @else
                            
                        @endif 
        </div>
    </div>
</div>
@endsection

@section('scripts')
    
<script src="{{ asset('js/highcharts.js') }}"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> --}}
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('js/jszip.min.js') }}"></script>
<script src="{{ asset('js/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/buttons.print.min.js') }}"></script>
    
    <script>
        $('#select-all').click(function(event) {   
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;                        
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;                       
                });
            }
        });
    </script>

    <script>
    function filterFunctiona() {
          var input, filter, ul, li, a, i;
          input = document.getElementById("myInputa");
          filter = input.value.toUpperCase();
          div = document.getElementById("myDropdowna");
          a = div.getElementsByClassName("cak");
          for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              a[i].style.display = "";
            } else {
              a[i].style.display = "none";
            }
          }
        }
    </script>

    <script>
        $(".dropbtn").click(function(e){
            $("#myDropdowna").show();
            e.stopPropagation();
        });

        $("#myDropdowna").click(function(e){
            e.stopPropagation();
        });

        $(document).click(function(){
            $("#myDropdowna").hide();
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
            categories: {!! json_encode($month2) !!},
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
            categories: {!! json_encode($month4) !!},
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
            text: 'Total Closed Account MTD'
        },
        subtitle: {
            text: 'Source: X'
        },
        xAxis: {
            categories: {!! json_encode($month6) !!},
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
            categories: {!! json_encode($month8) !!},
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
            categories: {!! json_encode($month10) !!},
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
            categories: {!! json_encode($month12) !!},
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
            categories: {!! json_encode($month14) !!},
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
            categories: {!! json_encode($month16) !!},
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
        Highcharts.chart('container8', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'New Account Cur Bal MTD'
        },
        subtitle: {
            text: 'Source: X'
        },
        xAxis: {
            categories: {!! json_encode($month18) !!},
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
            data: {!! json_encode($total15) !!}

        },{
            name: '2019',
            data: {!! json_encode($total16) !!}

        }]
    });
    </script>

    <script>
        Highcharts.chart('container9', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'New Account Cur Bal YTD'
        },
        subtitle: {
            text: 'Source: X'
        },
        xAxis: {
            categories: {!! json_encode($month20) !!},
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
            data: {!! json_encode($total17) !!}

        },{
            name: '2019',
            data: {!! json_encode($total18) !!}

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
                    $.get('http://192.168.7.32:8080/bni/public/api/json-group-matrix' , function(data){
                    console.log(data);
                    $('#group').empty();
                    $('#group').append('<option value="0" selected="true">All Group</option>');

                    $.each(data, function(index, groupsObj) {
                        console.log(groupsObj.prd_name);
                        $('#group').append('<option value="' + groupsObj.group_prod_3 + '" >' + groupsObj.group_prod_3 + '</option>');
                    });
                });    
                
                } else {
                    
                $.get('http://192.168.7.32:8080/bni/public/api/json-group-matrix?jenis=' + groupid , function(data){
                    console.log(data);
                    $('#group').empty();
                    $('#group').append('<option value="0" selected="true">Pilih Group</option>');

                    $.each(data, function(index, groupsObj) {
                        console.log(groupsObj.prd_name);
                        $('#group').append('<option value="' + groupsObj.group_prod_3 + '" >' + groupsObj.group_prod_3 + '</option>');
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
                $.get('http://192.168.7.32:8080/bni/public/api/json-acc-matrix?group_prod_3=' + group_product_third , function(data){
                    console.log(data);
                    // $('#options').append('<li><label><input name="options" type="checkbox" value="">All Group</label></li>');
                    $('#options').empty();

                    $.each(data, function(index, optionObj) {
                        console.log(optionObj.prd_name);
                        $('#options').append('<div class="cik" style="margin-left: 15px;"><input name="products[]" style="margin-left: 15px;" type="checkbox" class="products" value="'+ optionObj.prd_name +'">' + '&nbsp;' + optionObj.acc_type + ' ' + optionObj.prd_name +  '</div>');

                        // $('#options').append('<input name="acctypes[]" type="checkbox" value="'+ optionObj.acc_type +'">' + '&nbsp;' + optionObj.acc_type + ' ' + optionObj.prd_name );
                    });
                });
            });
        });
    </script>

   
@endsection