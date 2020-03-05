<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Request as Req;
use App\Models\Region;
use App\Models\Branch;
use App\Models\Account;
use App\Models\Product;
use App\Models\GroupProduct;
use App\Models\RegionalSaving;
use App\Models\ParameterProduct;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{
    public function getYear()
    {
        $categories = Req::input('TABLE_NAME');
       
        $yearss = DB::connection('sqlsrv158')->select("SELECT * FROM FUNDING.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '$categories%'");

        return response()->json($yearss);
    }
    
    public function dayBalance()
    {
        $months = Req::input('TABLE_NAME');

        $yearss = DB::connection('sqlsrv158')->select("SELECT * FROM FUNDING.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '$months%'");

        $arr = [];
        foreach ($yearss as $value) {
            $arr[] = substr($value->TABLE_NAME, 17,2) . '_' . substr($value->TABLE_NAME, 13,4);
        }

        return response()->json(array('yearss' => $yearss, 'arr' => $arr));
    }   

    public function getTopDayDtd()
    {
        $months = Req::input('TABLE_NAME');

        $day = DB::connection('sqlsrv159')->select("SELECT * FROM DATAMART.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '$months%'");

        return response()->json($day);
    }
    
    public function getTopMonthDtd()
    {
        $months = Req::input('TABLE_NAME');

        $month = DB::connection('sqlsrv159')->select("SELECT * FROM DATAMART.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '$months%'");

        return response()->json($month);
    }

    public function getDate()
    {
        $date = Req::input('TABLE_NAME');               

        $tabungan = Req::input('flag_tabungan');

        $month = DB::connection('sqlsrv159')->table('datamart.dbo.'.$date)->whereIn('flag_tabungan', $tabungan)->where('product_name', '!=', null)->select('product_name')->distinct()->get();

        return response()->json($month);
    }

    public function months()
    {
        $year = Req::input('tahun');

        $month = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('bulan')->where('tahun',$year)->distinct()->orderBy('bulan', 'asc')->get();

        return response()->json($month);

    }

    public function monthsAvg()
    {
        $year = Req::input('tahun');

        $month = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_avg_perproduk_perwilayah')->select('bulan')->where('tahun',$year)->distinct()->orderBy('bulan', 'asc')->get();

        return response()->json($month);

    }
 
    public function monthBalance()
    {
        $year = Req::input('TABLE_NAME');

        $month = DB::connection('sqlsrv158')->select("SELECT * FROM FUNDING.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '$year%'");

        return response()->json($month); 
    }

    public function monthUpload()
    {
        $year = Req::input('created_at');

        $month = Account::select(DB::raw('MONTH(created_at) as month'))->whereYear('created_at', $year)->distinct()->orderBy('month')->get();

        return response()->json($month);

    }

    public function days()
    {
        $month = Req::input('bulan');

        $tgl = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('tgl')->where('bulan',$month)->distinct()->orderBy('tgl', 'asc')->get();
        
        return response()->json($tgl);
                       
    }

    public function daysAvg()
    {
        $month = Req::input('bulan');

        $tgl = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_avg_perproduk_perwilayah')->select('tgl')->where('bulan',$month)->distinct()->orderBy('tgl', 'asc')->get();
        
        return response()->json($tgl);
                       
    }
    
    public function groups()
    {
        $type = Req::input('jenis');

        if (isset($type)) {
            $groups = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('group_prod_3')->whereIn('jenis', $type)->distinct()->get();
        }else {
            $groups = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('group_prod_3')->distinct()->get();
        }

        return response()->json($groups);
    }

    public function groupsAvg()
    {
        $type = Req::input('Jenis');

        if (isset($type)) {
            $groups = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_avg_perproduk_perwilayah')->select('group_prod_3')->whereIn('Jenis', $type)->distinct()->get();
            // dd($groups);
        }else {
            $groups = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_avg_perproduk_perwilayah')->select('group_prod_3')->distinct()->get();
        }

        return response()->json($groups);
    }
    
    public function prods()
    {
        $group = Req::input('group_prod_3');

        if (isset($group)) {
            $prods = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('prd_name')->whereIn('group_prod_3', $group)->distinct()->get();
        }else {
            $prods = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('prd_name')->distinct()->get();
        }

        return response()->json($prods);
    }

    public function prodsAvg()
    {
        $group = Req::input('group_prod_3');

        if (isset($group)) {
            $prods = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_avg_perproduk_perwilayah')->select('prd_name')->whereIn('group_prod_3', $group)->distinct()->get();
            // dd($prods);
        }else {
            $prods = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_avg_perproduk_perwilayah')->select('prd_name')->distinct()->get();
        }

        return response()->json($prods);
    }

    public function branches()
    {
        $type_reg = Req::input('regDigit');

        if(isset($type_reg)){
            $branches = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->whereIn('regDigit',$type_reg)->select('branch_name', 'region')->distinct()->get();
        } else {
            $branches = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select('branch_name', 'region')->distinct()->get();
        }
        
        return response()->json($branches);
    }

    public function products()
    {
        $type_prod = Req::input('Jenis');

        if(isset($type_prod)){
            $products = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->where('Jenis', $type_prod)->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        } else {
            $products = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        }
      
        return response()->json($products);
    }

    public function regions()
    {
        $region_id = Req::input('id');

        if(isset($region_id)){
            $regions = Region::where('id', '=', $region_id)->get();
        } else {
            $regions = Region::all();
        }

        return response()->json($regions);
    }

    public function groupMatrix()
    {
        $type_product = Req::input('jenis');
        
        if (isset($type_product)) {
            $parameter =  DB::connection('sqlsrv158')->table('funding.dbo.prm_grouping_produk')->select('group_prod_3')->where('jenis', $type_product)->distinct()->get();
        } else {
            $parameter =  DB::connection('sqlsrv158')->table('funding.dbo.prm_grouping_produk')->select('group_prod_3')->distinct()->get();
        }
        
        return response()->json($parameter);
    }

    public function accMatrix()
    {
        $group = Req::input('group_prod_3');

        $acc =  DB::connection('sqlsrv158')->table('funding.dbo.prm_grouping_produk')->select('acc_type', 'prd_name')->where('group_prod_3', $group)->distinct()->get();

        return response()->json($acc);
    }
}
