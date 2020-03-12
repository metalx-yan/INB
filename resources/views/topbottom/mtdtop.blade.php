@extends('main')

@section('link')

<style>
    .dropbtnr {
  background-color: white;
  border-radius: 3px;
  color: #666;
  padding: 8px;
  font-size: 16px;
  border: 1px solid #ced4da;
  cursor: pointer;
  width: 230px;
}

.dropbtnf {
  background-color: white;
  border-radius: 3px;
  color: #666;
  padding: 8px;
  font-size: 16px;
  border: 1px solid #ced4da;
  cursor: pointer;
  width: 230px;
}

.dropbtnz {
  background-color: white;
  border-radius: 3px;
  color: #666;
  padding: 8px;
  font-size: 16px;
  border: 1px solid #ced4da;
  cursor: pointer;
  width: 230px;
}

.dropbtns {
  background-color: white;
  border-radius: 3px;
  color: #666;
  padding: 8px;
  font-size: 16px;
  border: 1px solid #ced4da;
  cursor: pointer;
  width: 230px;
}

.dropbtnp {
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

#myInput {
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

#myInputz {
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

#myInputs {
  box-sizing: border-box;
  background-image: url('searchicon.png');
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 16px;
  border: none;
  border-bottom: 1px solid #ddd;
  position:fixed;
  /* overflow-y: scroll; */
}

#myInputa {
  box-sizing: border-box;
  background-image: url('searchicon.png');
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 15px;
  border: none;
  border-bottom: 1px solid #ddd;
  position:fixed;
}

#myInputi {
  box-sizing: border-box;
  background-image: url('searchicon.png');
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 15px;
  border: none;
  border-bottom: 1px solid #ddd;
  position:fixed;
}

#myInputs:focus {outline: 3px solid #ddd;}

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

</style>

@endsection

@section('title', 'MTD-Top')


@section('content')
<div class="container-fluid">
       
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Top MTD Nasabah</li>
                </ol>
            </div>
        </div>

        {{-- onfocus='this.size=5;' onblur='this.size=1;' onchange='this.size=1; this.blur();'
onfocus='this.size=5;' onblur='this.size=1;' onchange='this.size=1; this.blur();'
onfocus='this.size=5;' onblur='this.size=1;' onchange='this.size=1; this.blur();' --}}
        <div class="card">
            <div class="card-title">
                <div class="container">
                    <form action="{{ route('funding-top-bottom-nasabah-mtd') }}" method="post">
                        @csrf
                        <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Tahun</label>
                                    <select name="year" id="year" class="form-control" required>
                                        <option value=""> Pilih Tahun</option>
                                        @foreach (array_unique($tahun) as $year)
                                            <option value="top_mtd_{{ $year }}">{{ $year }}</option>
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
                                        <select name="day" id="day" class="form-control changes" required >
                                        <option value="">Pilih Tanggal</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                        <label for="">Regions</label>
                                            <div class="dropdown">
                                                <button type="button" class="dropbtnp">Pilih Region</button>
                                                <br>
                                                <div id="myDropdowns" class="dropdown-content" style="overflow-y: auto; top:40px; bottom:-250px;">
                                                <input type="text" placeholder="Search.." id="myInputs" onkeyup="filterFunctions()">
                                                
                                                <br><br><br>
                                                <b><input style="margin-left: 30px;" type="checkbox" name="select-all" id="select-all"> Select All</b>
                                                <hr>
                                                    @foreach ($regions as $region)
                                                        <div class="cok" style="margin-left: 15px;"> 
                                                            <input type="checkbox" name="region[]"  style="margin-left: 15px;" class="region" value="{{ $region->regDigit }}"> {{ $region->region }} - {{ $region->regDigit }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                {{-- <div class="col-md-3">
                                    <label for="">Jenis Tabungan</label>
                                        <div class="dropdown">
                                                <button type="button" class="dropbtnf">Pilih Jenis Tabungan</button>
                                                <br>
                                                <div id="myDropdowni" class="dropdown-content" style="overflow-y: auto; top:40px; bottom:-250px;">
                                                <input type="text" placeholder="Search.." id="myInputi" onkeyup="filterFunctioo()" >
                                                
                                                <br><br><br>
                                                <b><input style="margin-left: 30px;" type="checkbox" name="select-alli" id="select-alli"> Select All</b>
                                                <hr>
                                                        <div class="cik changes" style="margin-left: 15px;" id="jent"> 
                                                            <input type="checkbox" name="jentab[]" style="margin-left: 15px;" class="jentab" value="Tab Perorangan">Tabungan Perorangan
                                                            <input type="checkbox" name="jentab[]" style="margin-left: 15px;" class="jentab" value="Tab Non Perorangan">Tabungan Non Perorangan
                                                        </div>
                                                </div>
                                              </div>
                                </div> --}}
                                
                                </div>
                                <br>
                                <div class="row">
                                        <div class="col-md-3">
                                                <label for="">Branches</label>
                                                <div class="dropdown">
                                                    <button type="button" class="dropbtns">Pilih Branch</button>
                                                    <br>
                                                    <div id="myDropdowna" class="dropdown-content" style="overflow-y: auto; top:40px; bottom:-250px;">
                                                    <input type="text" placeholder="Search.." id="myInputa" onkeyup="filterFunctiona()" >
                                                    
                                                    <br><br><br>
                                                    <b><input style="margin-left: 30px;" type="checkbox" name="select-alls" id="select-alls"> Select All</b>
                                                    <hr>
                                                    <div id="branchess">
    
                                                    </div>
                                                </div>
                                                </div>
                                        </div>
                                        <div class="col-md-3">
                                                <label for="">Jenis Tabungan</label>
                                                    <div class="dropdown">
                                                            <button type="button" class="dropbtnf">Pilih Jenis Tabungan</button>
                                                            <br>
                                                            <div id="myDropdowni" class="dropdown-content" style="overflow-y: auto; top:40px; bottom:-250px;">
                                                            <input type="text" placeholder="Search.." id="myInputi" onkeyup="filterFunctioo()" >
                                                            
                                                            <br><br><br>
                                                            <b><input style="margin-left: 30px;" type="checkbox" name="select-alli" id="select-alli"> Select All</b>
                                                            <hr>
                                                                    <div class="cik changes" style="margin-left: 15px;" id="jent"> 
                                                                        <input type="checkbox" name="jentab[]" style="margin-left: 15px;" class="jentab" value="Tab Perorangan">Tabungan Perorangan
                                                                        <input type="checkbox" name="jentab[]" style="margin-left: 15px;" class="jentab" value="Tab Non Perorangan">Tabungan Non Perorangan
                                                                    </div>
                                                            </div>
                                                          </div>
                                            </div>
                                        <div class="col-md-3">
                                                <label for="">Products</label>
                                                    <div class="dropdown">
                                                            <button type="button" class="dropbtnr">Pilih Product</button>
                                                            <br>
                                                            <div id="myDropdown" class="dropdown-content" style="overflow-y: auto; top:40px; bottom:-250px;">
                                                            <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()" >
                                                            
                                                            <br><br><br>
                                                            <b><input style="margin-left: 30px;" type="checkbox" name="select-allb" id="select-allb"> Select All</b>
                                                            <hr>
                                                                
                                                                    <div id="produk"> 
                                                                    </div>
                                                          </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <label for="">Jenis Nasabah</label>
                                                <div class="dropdown">
                                                        <button type="button" class="dropbtnz">Pilih Jenis Nasabah</button>
                                                        <br>
                                                        <div id="myDropdownz" class="dropdown-content" style="overflow-y: auto; top:40px; bottom:-250px;">
                                                        <input type="text" placeholder="Search.." id="myInputz" onkeyup="filterFunctioz()" >
                                                        
                                                        <br><br><br>
                                                        <b><input style="margin-left: 30px;" type="checkbox" name="select-allz" id="select-allz"> Select All</b>
                                                        <hr>
                                                                <div class="ckk" style="margin-left: 15px;" id="jenas"> 
                                                                    <input type="checkbox" name="jenas[]" style="margin-left: 15px;" class="jenas" value="perusahaan"> Perusahaan <br>
                                                                    <input type="checkbox" name="jenas[]" style="margin-left: 15px;" class="jenas" value="perorangan"> Perorangan
                                                                </div>
                                                        </div>
                                                      </div>
                                        </div>                                    
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Filter</label>
                                    <br>
                                    <select name="filter" id="filter" class="form-control" required>
                                        <option value="">Pilih Filter</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
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

                    @if (count($sa) == 0)
                        
                    @else

                    <br>
                    <p>
                        <span>Tanggal : <b>{{$getdate}}</b></span>
                    </p>
                    <table class="table border" id="myTable">
                        <thead >
                            <tr style="background-color: #5f3423; color:white;">
                                <td>ID Number</td>
                                <td>CIF Key</td>
                                <td>Customer Name</td>
                                <td>Cabang</td>
                                <td>Wilayah</td>
                                <td>Product</td>
                                <td>Tabungan</td>
                                <td>Nasabah</td>
                                <td>Saldo Sebelum</td>
                                <td>Saldo Sesudah</td>
                                <td>Delta</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $int1 = 0;
                                $int2 = 0;
                                $int3 = 0;
                            @endphp

                            @foreach ($sa as $val)
                                <tr>
                                    <td>{{$val->id_number}}</td>
                                    <td>{{$val->bni_cif_key}}</td>
                                    <td>{{$val->customer_name}}</td>
                                    <td>{{$val->branch_name}}</td>
                                    <td>{{$val->regDigit}}</td>
                                    <td>{{$val->product_name}}</td>
                                    <td>{{$val->flag_tabungan}}</td>
                                    <td>{{ucfirst($val->flag_nasabah)}}</td>
                                    <td>{{number_format($val->saldo_sblm)}}</td>
                                    <td>{{number_format($val->saldoskrng)}}</td>
                                    <td>{{number_format($val->delta)}}</td>
                                </tr>
                        
                                @php
                                    $int2 += $val->saldo_sblm;
                                    $int1 += $val->saldoskrng;
                                    $int3 += $val->delta;
                                @endphp
                        
                            @endforeach
                                
                                <tr style="background-color: #5f3423; color:white;">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{number_format($int1)}}</td>
                                    <td>{{number_format($int2)}}</td>
                                    <td>{{number_format($int3)}}</td>
                                </tr>
                            
                        </tbody>
                        
                    </table>

                    {{-- <div class="container" id="container" style="min-widh: 310px; height:400px; margin: 0 auto;">
                    </div> --}}
                    @endif

                    
                    @endif

                 
                </div>
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

    <script type="text/javascript"> 
        $(document).ready(function () {
                $('#myTable').DataTable({
                    dom: 'Bfrtip',
                    "scrollY": "300px",
                    "scrollCollapse": true,
                    "order": [],
                    bSort: false,
                    "paging": false,
                    buttons: ['excel'],
                    "columnDefs": [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                    },
                    {
                        "targets": [ 1 ],
                        "visible": false
                    }
                ]
                });
        });
    </script>

    <script>

        $(".dropbtnp").click(function(e){
            $("#myDropdowns").show();
            e.stopPropagation();
        });

        $("#myDropdowns").click(function(e){
            e.stopPropagation();
        });

        $(document).click(function(){
            $("#myDropdowns").hide();
        });


        $(".dropbtns").click(function(e){
            $("#myDropdowna").show();
            e.stopPropagation();
        });

        $("#myDropdowna").click(function(e){
            e.stopPropagation();
        });

        $(document).click(function(){
            $("#myDropdowna").hide();
        });


        $(".dropbtnf").click(function(e){
            $("#myDropdowni").show();
            e.stopPropagation();
        });

        $("#myDropdowni").click(function(e){
            e.stopPropagation();
        });

        $(document).click(function(){
            $("#myDropdowni").hide();
        });


        $(".dropbtnr").click(function(e){
            $("#myDropdown").show();
            e.stopPropagation();
        });

        $("#myDropdown").click(function(e){
            e.stopPropagation();
        });

        $(document).click(function(){
            $("#myDropdown").hide();
        });


        $(".dropbtnz").click(function(e){
            $("#myDropdownz").show();
            e.stopPropagation();
        });

        $("#myDropdownz").click(function(e){
            e.stopPropagation();
        });

        $(document).click(function(){
            $("#myDropdownz").hide();
        });

        function filterFunction() {
          var input, filter, ul, li, a, i;
          input = document.getElementById("myInput");
          filter = input.value.toUpperCase();
          div = document.getElementById("myDropdown");
          a = div.getElementsByClassName("cik");
          for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              a[i].style.display = "";
            } else {
              a[i].style.display = "none";
            }
          }
        }

        function filterFunctionz() {
          var input, filter, ul, li, a, i;
          input = document.getElementById("myInputz");
          filter = input.value.toUpperCase();
          div = document.getElementById("myDropdownz");
          a = div.getElementsByClassName("ckk");
          for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              a[i].style.display = "";
            } else {
              a[i].style.display = "none";
            }
          }
        }

        function filterFunctioni() {
          var input, filter, ul, li, a, i;
          input = document.getElementById("myInputi");
          filter = input.value.toUpperCase();
          div = document.getElementById("myDropdowni");
          a = div.getElementsByClassName("cik");
          for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              a[i].style.display = "";
            } else {
              a[i].style.display = "none";
            }
          }
        }

        function filterFunctions() {
          var input, filter, ul, li, a, i;
          input = document.getElementById("myInputs");
          filter = input.value.toUpperCase();
          div = document.getElementById("myDropdowns");
          a = div.getElementsByClassName("cok");
          for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              a[i].style.display = "";
            } else {
              a[i].style.display = "none";
            }
          }
        }

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
        $('#select-all').click(function(event) {   
            if(this.checked) {
    
                $.get('http://192.168.7.32:8080/bni/public/api/json-branches'  , function(data){
                    console.log(data);
                    // $('#branchess').empty();
    
                    $.each(data, function(index, productsObj) {
                        // console.log(productsObj);
                        $('#branchess').append('<div class="ak" style="margin-left: 15px;"><input name="groups[]" style="margin-left: 15px;" type="checkbox" class="groupes" value="'+ productsObj.branch_name +'">' + '&nbsp;' + productsObj.branch_name +  '</div>');
    
                        $('#select-alls').prop('checked', true);
                        $('.groupes').each(function() {
                            this.checked = true;                        
                        });        
    
                    });
                });
    
                // Iterate each checkbox
                $('.region').each(function() {
                    this.checked = true;                        
                });
    
            } else {
    
                $.get('http://192.168.7.32:8080/bni/public/api/json-branches'  , function(data){
                    // console.log(data);
                    $('#branchess').empty();
                    $('#select-alls').prop('checked', false);
                    
                });
    
                $('.region').each(function() {
                    this.checked = false;                       
                });
            }
        });
    </script>
    
    <script>
        $('#select-alls').click(function() {   
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
        $('#select-allz').click(function() {   
            if(this.checked) {
                
                // Iterate each checkbox
                $('.jenas').each(function() {
                    this.checked = true;                        
                });
            } else {

                $('.jenas').each(function() {
                    this.checked = false;                       
                });
            }
        });
    </script>
    
    <script>
            $('#select-alli').click(function(event) {   
                if(this.checked) {
                    
                    // Iterate each checkbox
                    $('.jentab').each(function() {
                        this.checked = true;                        
                    });
                } else {
        
        
                    $('.jentab').each(function() {
                        this.checked = false;                       
                    });
                }
            });
        </script>
    
    
    <script>
        $('#select-allb').click(function(event) {   
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
    
        $('.region').click(function(e){
    
                    var count =  document.querySelectorAll('input[name="region[]"]:checked');
                    var aps = $('.region').val();
                    var str = '';
                    for (let i = 0; i < count.length; i++) {
                        str += 'regDigit[]='+count[i].value+'&';
                    }
                    // console.log(document.querySelectorAll('input[name="region[]"]:checked'));
                    console.log(count.length);
    
                    if (count.length != 0) {
                        
                        $.get('http://192.168.7.32:8080/bni/public/api/json-branches?' + str , function(data){
                            console.log(data);
                            $('#branchess').empty();
    
                            $.each(data, function(index, productsObj) {
                                // console.log(productsObj);
                                $('#branchess').append('<div class="cak" style="margin-left: 15px;"><input name="groups[]" style="margin-left: 15px;" type="checkbox" class="groupes" value="'+ productsObj.branch_name +'">' + '&nbsp;' +  productsObj.branch_name + '</div>' );
                                                        
                            });
                        });
    
                    } else {
                        $('#branchess').empty();
                    }
            });
      
            </script>
    
    
            <script>
                $(document).ready(function(){
                    $('#year').on('change', function(e){
                        var year = e.target.value;
    
                        console.log(year);
                        var sub = year.substr(0,25);
                        
                            $.get('http://192.168.7.32:8080/bni/public/api/json-month-topbot?TABLE_NAME=' + year , function(data){
                                var as = data.map(item => item.TABLE_NAME.slice(0,14))
                                .filter((value, index, self) => self.indexOf(value) === index)
    
                                console.log(as);
                                $('#month').empty();
                                $('#month').append('<option value="0" selected="true">Pilih Bulan</option>');
    
                                $.each(as, function(index, monthsObj) {
                                    console.log(monthsObj);
                                    $('#month').append('<option value="' + monthsObj + '" >' + monthsObj.substr(12,2) + '</option>');
                                });
                            });
                    });
                });
            </script>
    
            <script>
                $(document).ready(function(){
                    $('#month').on('change', function(e){
                        var year = e.target.value;
    
                        var sub = year.substr(0,25);
                        
                            $.get('http://192.168.7.32:8080/bni/public/api/json-day-topbot?TABLE_NAME=' + year , function(data){
                                // console.log(data);
                                var as = data.map(item => item.TABLE_NAME.slice(0,23))
                                .filter((value, index, self) => self.indexOf(value) === index)
                                $('#day').empty();
                                $('#day').append('<option value="0" selected="true">Pilih Tanggal</option>');
    
                                $.each(as, function(index, daysObj) {
                                    console.log(daysObj);
                                    $('#day').append('<option value="' + daysObj + '" >' + daysObj.substr(14,2) + '</option>');
                                });
                            });
                    });
                });
            </script>
    
            <script>
               $(document).ready(function(){
                    $('.changes').on('change' ,function(){
                        var date = $('#day').val();
                        // var jen = $('input[name="jentab[]"]:checked').val();
                        var count =  document.querySelectorAll('input[name="jentab[]"]:checked');
                        var str = '';
                        for (let i = 0; i < count.length; i++) {
                            str += 'flag_tabungan[]='+count[i].value+'&';
                        }
                        console.log(count.length != 0);
                        console.log(count);
                        
                        if (count.length != 0) {
                            $.get('http://192.168.7.32:8080/bni/public/api/json-get-date?' + 'TABLE_NAME=' + date + '&' + str, function(data){
                                console.log(data);
                                $('#produk').empty();
    
                                $.each(data, function(index, daysObj) {
                                    console.log(daysObj);
                                    $('#produk').append('<div class="cik" style="margin-left: 15px;"><input name="products[]" style="margin-left: 15px;" type="checkbox" class="products" value="'+ daysObj.product_name +'">' + '&nbsp;' + daysObj.product_name +  '</div>');
                                    // $('#produk').append('<option value="' + daysObj + '" >' + daysObj.product_name + '</option>');
                                });
                            });
                        } else {
                                $('#produk').empty();
                               
                        }
                    });
                });
            </script>
    
        <script>
            $('#select-alli').click(function(event) {   
            if(this.checked) {
    
                var date = $('#day').val();
                var count =  document.querySelectorAll('input[name="jentab[]"]:checked');
                var str = '';
                for (let i = 0; i < count.length; i++) {
                    str += 'flag_tabungan[]='+count[i].value+'&';
                }
                console.log(count.length != 0);
                console.log('http://192.168.7.32:8080/bni/public/api/json-get-date?' + 'TABLE_NAME=' + date + '&' + str);
                
                if (count.length != 0) {
                    $.get('http://192.168.7.32:8080/bni/public/api/json-get-date?' + 'TABLE_NAME=' + date + '&' + str, function(data){
                        console.log(data);
                        $('#produk').empty();
    
                        $.each(data, function(index, daysObj) {
                            console.log(daysObj);
                            $('#produk').append('<div class="cik" style="margin-left: 15px;"><input name="products[]" style="margin-left: 15px;" type="checkbox" class="products" value="'+ daysObj.product_name +'">' + '&nbsp;' + daysObj.product_name +  '</div>');
                            // $('#produk').append('<option value="' + daysObj + '" >' + daysObj.product_name + '</option>');
                            $('#select-allb').prop('checked', true);

                            $('.products').each(function() {
                                this.checked = true;                        
                            });
                        });
                    });
                } else {
                        $('#produk').empty();
                }
                
                // Iterate each checkbox
                $('.jentab').each(function() {
                    this.checked = true;                        
                });
    
            } else {
                $('#select-allb').prop('checked', false);

                $('.products').each(function() {
                    this.checked = false;                        
                });
                var count =  document.querySelectorAll('input[name="jentab[]"]:checked');
                console.log(count.length);
                $('#produk').empty();
    
                $('.jentab').each(function() {
                    this.checked = false;                       
                });
            }
        });
        </script>

@endsection