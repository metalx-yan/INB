<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use App\Models\JobLevel;
use App\Models\Account;
use App\Models\TypeProduct;
use App\Models\GroupProduct;
use App\Models\RegionalSaving;
use App\Models\CurBalance;
use App\Models\ParameterProduct;
use App\Models\AccountMtd;
use App\Models\AccountYtd;
use Carbon\Carbon;
use Request as Req;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Exports\AccountExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use DateTime;
use DataTables;

class QueryController extends Controller
{
    public function home() 
    {
        return view('dashboard');
    }

    public function getBalance(Request $request)
    {   
        $status = $request->status;
        $account = $request->accounts;

        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $categories = $categori->toArray();

        $regi = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as reg"), 'regDigit')->distinct('reg', 'regDigit')->get();
        $regions = $regi->toArray();

        $tables =  DB::connection('sqlsrv158')->select("SELECT * FROM FUNDING.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%deposit_prod_%'");
        $tables2 = DB::connection('sqlsrv158')->select("SELECT * FROM FUNDING.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%pdm_hsl_summary_deposito_%'");

        $list = [];
        $list6 = [];
        foreach ($tables as $table) {
                if ($table->TABLE_NAME != 'term_deposit_prod_20190228') {
                        if (strpos(substr($table->TABLE_NAME, 13,7), '_') == true ) {
                                $list[] = substr($table->TABLE_NAME, 13 ,7);
                        }
                        $list6[] = substr($table->TABLE_NAME, 13,7);
                }
        }


        $list3 = [];
        $list9 = [];
        foreach ($tables2 as $table) {
                if (strpos(substr($table->TABLE_NAME, 25 ,8), '_') == true ) {
                        $list3[] = substr($table->TABLE_NAME, 25 ,7);
                        $list9[] = $table->TABLE_NAME;
                }
        }

        $columns = DB::connection('sqlsrv158')->select("SELECT * FROM FUNDING.INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='deposit_prod_12_2019'");
        $cols = [];
        foreach ($columns as $column) {
                $cols[] = $column->COLUMN_NAME;
        }

        if ($request->categories == "DEPOSITO") {
                if (is_null($request->years) && is_null($request->months) && is_null($request->days)) {
                        $lastDate = "";
                } else {
                        $stringDate = substr($request->years, 25,4).'-'.substr($request->months, 29,2).'-'.substr($request->days, 31,2);        
                        $lastDate = $stringDate == Carbon::parse(substr($request->years, 25,4).'-'.substr($request->months, 29,2).'-'.substr($request->days, 31,2))->endOfMonth()->toDateString();
                }

                if ($lastDate) {
                        foreach ($list9 as $table) {
                                        if (strpos(substr($table, 25,7), '_') == true ) {
                                                if (substr($table, 25,7) ==  substr($request->months, 29,2) .'_'. substr($request->years, 25,4)) {
                                                        if ($request->categories == "DEPOSITO") {
                                                                $last = substr($table, 25,7);
                                                                $records = DB::connection('sqlsrv158')->table('funding.dbo.PDM_HSL_SUMMARY_DEPOSITO_'.$last)
                                                                ->leftJoin('datamart.dbo.list_prd_dpk' , DB::raw("CONCAT(funding.dbo.PDM_HSL_SUMMARY_DEPOSITO_$last.bni_account_type , '-' , funding.dbo.PDM_HSL_SUMMARY_DEPOSITO_$last.bni_sub_category)") , '=' , DB::raw("CONCAT(datamart.dbo.list_prd_dpk.bni_account_type , '-' , datamart.dbo.list_prd_dpk.bni_sub_category)"))                
                                                                ->leftJoin('funding.dbo.tbl_branch_code', 'funding.dbo.PDM_HSL_SUMMARY_DEPOSITO_'.$last . '.branch_code', '=', 'funding.dbo.tbl_branch_code.branch_code')
                                                                ->leftJoin('funding.dbo.cust_icons', 'funding.dbo.PDM_HSL_SUMMARY_DEPOSITO_' .$last. '.BNI_CIF_KEY' ,'=', 'funding.dbo.cust_icons.cif_key')
                                                                // ->where('funding.dbo.PDM_HSL_SUMMARY_DEPOSITO_' .$last. '.GL_ACCOUNT_ID', '!=' , 210011)
                                                                ->where('funding.dbo.PDM_HSL_SUMMARY_DEPOSITO_' .$last. '.BNI_ACCOUNT_STATUS', $request->status)
                                                                ->where('funding.dbo.tbl_branch_code.regDigit', $request->regions)
                                                                ->whereIn('funding.dbo.tbl_branch_code.branch_name', $request->branches)
                                                                ->whereIn(DB::raw("CONCAT(datamart.dbo.list_prd_dpk.bni_account_type , '-' , datamart.dbo.list_prd_dpk.bni_sub_category)"),  $request->products)
                                                                ->get()->toArray();    
                                                                $queq = [];
                                                                foreach ($records as $key) {
                                                                $queq[] = $key;
                                                                }    
                                                        }  
                                                }
                                        }
                                }
                } else {
                        if($request->all() == null) {

                        } else {
                                if ($request->categories == "DEPOSITO") {
                                        $records = DB::connection('sqlsrv158')->table('funding.dbo.'.$request->days)
                                        ->leftJoin('datamart.dbo.list_prd_dpk' , DB::raw("CONCAT(funding.dbo.$request->days.bni_account_type , '-' , funding.dbo.$request->days.bni_sub_category)") , '=' , DB::raw("CONCAT(datamart.dbo.list_prd_dpk.bni_account_type , '-' , datamart.dbo.list_prd_dpk.bni_sub_category)"))                
                                        ->leftJoin('funding.dbo.tbl_branch_code', 'funding.dbo.'.$request->days . '.branch_code', '=', 'funding.dbo.tbl_branch_code.branch_code')
                                        ->leftJoin('funding.dbo.cust_icons', 'funding.dbo.'.$request->days .'.BNI_CIF_KEY' ,'=', 'funding.dbo.cust_icons.cif_key')
                                        // ->where('funding.dbo.'.$request->days .'.GL_ACCOUNT_ID', '!=' , 210011)
                                        ->where('funding.dbo.'.$request->days .'.BNI_ACCOUNT_STATUS', $request->status)
                                        ->where('funding.dbo.tbl_branch_code.regDigit', $request->regions)
                                        ->whereIn('funding.dbo.tbl_branch_code.branch_name', $request->branches)
                                        ->whereIn(DB::raw("CONCAT(datamart.dbo.list_prd_dpk.bni_account_type , '-' , datamart.dbo.list_prd_dpk.bni_sub_category)"),  $request->products)
                                        ->get()->toArray();
                                        $queq = [];
                                        foreach ($records as $key) {
                                               $queq[] = $key;
                                        }
                                } 
                        }
                } 

        } else {

                if (is_null($request->years) && is_null($request->months) && is_null($request->days)) {
                        $lastDate = "";
                } else {
                        $stringDate = substr($request->years,13,4).'-'.substr($request->months,17,2).'-'.substr($request->days, 19,2);        
                        $lastDate = $stringDate == Carbon::parse(substr($request->years,13,4).'-'.substr($request->months,17,2).'-'.substr($request->days, 19,2))->endOfMonth()->toDateString();
                }

                if ($lastDate) {
                        foreach ($tables as $table) {
                                if ($table->TABLE_NAME != 'term_deposit_prod_20190228') {
                                        if (strpos(substr($table->TABLE_NAME, 13,7), '_') == true ) {
                                                        if (substr($table->TABLE_NAME, 13,7) ==  substr($request->months, 17,2) .'_'. substr($request->years, 13,4)) {
                                                                if ($request->categories == "TABUNGAN") {
                                                                        $last = substr($table->TABLE_NAME, 13,7);
                                                                        $records = DB::connection('sqlsrv158')->table('funding.dbo.deposit_prod_'.$last)
                                                                        ->leftJoin('datamart.dbo.list_prd_dpk' , DB::raw("CONCAT(funding.dbo.deposit_prod_$last.bni_account_type , '-' , funding.dbo.deposit_prod_$last.bni_sub_category)") , '=' , DB::raw("CONCAT(datamart.dbo.list_prd_dpk.bni_account_type , '-' , datamart.dbo.list_prd_dpk.bni_sub_category)"))                
                                                                        ->leftJoin('funding.dbo.tbl_branch_code', 'funding.dbo.deposit_prod_'.$last . '.branch_code', '=', 'funding.dbo.tbl_branch_code.branch_code')
                                                                        ->leftJoin('funding.dbo.cust_icons', 'funding.dbo.deposit_prod_' .$last. '.BNI_CIF_KEY' ,'=', 'funding.dbo.cust_icons.cif_key')
                                                                        ->where('funding.dbo.deposit_prod_' .$last. '.GL_ACCOUNT_ID', '=' , 210011)
                                                                        ->where('funding.dbo.deposit_prod_' .$last. '.BNI_ACCOUNT_STATUS', $request->status)
                                                                        ->where('funding.dbo.tbl_branch_code.regDigit', $request->regions)
                                                                        ->whereIn('funding.dbo.tbl_branch_code.branch_name', $request->branches)
                                                                        ->whereIn(DB::raw("CONCAT(datamart.dbo.list_prd_dpk.bni_account_type , '-' , datamart.dbo.list_prd_dpk.bni_sub_category)"),  $request->products)
                                                                        ->get()->toArray();      
                                                                        $queq = [];
                                                                        foreach ($records as $key) {
                                                                        $queq[] = $key;
                                                                        }
                                                                } else {
                                                                        $last = substr($table->TABLE_NAME, 13,7);
                                                                        $records = DB::connection('sqlsrv158')->table('funding.dbo.deposit_prod_'.$last)
                                                                        ->leftJoin('datamart.dbo.list_prd_dpk' , DB::raw("CONCAT(funding.dbo$last.bni_account_type , '-' , funding.dbo$last.bni_sub_category)") , '=' , DB::raw("CONCAT(datamart.dbo.list_prd_dpk.bni_account_type , '-' , datamart.dbo.list_prd_dpk.bni_sub_category)"))                
                                                                        ->leftJoin('funding.dbo.tbl_branch_code', 'funding.dbo.deposit_prod_'.$last . '.branch_code', '=', 'funding.dbo.tbl_branch_code.branch_code')
                                                                        ->leftJoin('funding.dbo.cust_icons', 'funding.dbo.deposit_prod_' .$last. '.BNI_CIF_KEY' ,'=', 'funding.dbo.cust_icons.cif_key')
                                                                        ->where('funding.dbo.deposit_prod_' .$last. '.GL_ACCOUNT_ID', '!=' , 210011)
                                                                        ->where('funding.dbo.deposit_prod_' .$last. '.BNI_ACCOUNT_STATUS', $request->status)
                                                                        ->where('funding.dbo.tbl_branch_code.regDigit', $request->regions)
                                                                        ->whereIn('funding.dbo.tbl_branch_code.branch_name', $request->branches)
                                                                        ->whereIn(DB::raw("CONCAT(datamart.dbo.list_prd_dpk.bni_account_type , '-' , datamart.dbo.list_prd_dpk.bni_sub_category)"),  $request->products)
                                                                        ->get()->toArray(); 
                                                                        $queq = [];
                                                                        foreach ($records as $key) {
                                                                        $queq[] = $key;
                                                                        }  
                                                                }
                                                                
                                                        }
                                                }
                                        }
                                }
                } else {
                        if($request->all() == null) {

                        } else {
                                if ($request->categories == "TABUNGAN") {
                                        $records = DB::connection('sqlsrv158')->table('funding.dbo.'.$request->days)
                                        ->leftJoin('datamart.dbo.list_prd_dpk' , DB::raw("CONCAT(funding.dbo.$request->days.bni_account_type , '-' , funding.dbo.$request->days.bni_sub_category)") , '=' , DB::raw("CONCAT(datamart.dbo.list_prd_dpk.bni_account_type , '-' , datamart.dbo.list_prd_dpk.bni_sub_category)"))                
                                        ->leftJoin('funding.dbo.tbl_branch_code', 'funding.dbo.'.$request->days . '.branch_code', '=', 'funding.dbo.tbl_branch_code.branch_code')
                                        ->leftJoin('funding.dbo.cust_icons', 'funding.dbo.'.$request->days .'.BNI_CIF_KEY' ,'=', 'funding.dbo.cust_icons.cif_key')
                                        ->where('funding.dbo.'.$request->days .'.GL_ACCOUNT_ID', '=' , 210011)
                                        ->where('funding.dbo.'.$request->days .'.BNI_ACCOUNT_STATUS', $request->status)
                                        ->where('funding.dbo.tbl_branch_code.regDigit', $request->regions)
                                        ->whereIn('funding.dbo.tbl_branch_code.branch_name', $request->branches)
                                        ->whereIn(DB::raw("CONCAT(datamart.dbo.list_prd_dpk.bni_account_type , '-' , datamart.dbo.list_prd_dpk.bni_sub_category)"),  $request->products)
                                        ->get()->toArray();
                                        foreach ($records as $key) {
                                               $queq[] = $key;
                                        }
                                } else {
                                        $records = DB::connection('sqlsrv158')->table('funding.dbo.'.$request->days)
                                        ->leftJoin('datamart.dbo.list_prd_dpk' , DB::raw("CONCAT(funding.dbo.$request->days.bni_account_type , '-' , funding.dbo.$request->days.bni_sub_category)") , '=' , DB::raw("CONCAT(datamart.dbo.list_prd_dpk.bni_account_type , '-' , datamart.dbo.list_prd_dpk.bni_sub_category)"))                
                                        ->leftJoin('funding.dbo.tbl_branch_code', 'funding.dbo.'.$request->days . '.branch_code', '=', 'funding.dbo.tbl_branch_code.branch_code')
                                        ->leftJoin('funding.dbo.cust_icons', 'funding.dbo.'.$request->days .'.BNI_CIF_KEY' ,'=', 'funding.dbo.cust_icons.cif_key')
                                        ->where('funding.dbo.'.$request->days .'.GL_ACCOUNT_ID', '!=' , 210011)
                                        ->where('funding.dbo.'.$request->days .'.BNI_ACCOUNT_STATUS', $request->status)
                                        ->where('funding.dbo.tbl_branch_code.regDigit', $request->regions)
                                        ->whereIn('funding.dbo.tbl_branch_code.branch_name', $request->branches)
                                        ->whereIn(DB::raw("CONCAT(datamart.dbo.list_prd_dpk.bni_account_type , '-' , datamart.dbo.list_prd_dpk.bni_sub_category)"),  $request->products)
                                        ->get()->toArray();
                                        $queq = [];
                                        foreach ($records as $key) {
                                               $queq[] = $key;
                                        }
                                }
                                
                        }
                }
        }
        
        return view('query.balance', compact('regions', 'categories', 'ass','queq1','queq','account', 'query', 'status' ,'columns', 'records', 'years', 'tables', 'listyear', 'listyear2', 'cols', 'keys', 'values'));

    }

//     public function serverSide(Request $request)
//     {
//         $status = $request->status;
//         $account = $request->accounts;

//         $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
//         $categories = $categori->toArray();

//         $regi = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as reg"), 'regDigit')->distinct('reg', 'regDigit')->get();
//         $regions = $regi->toArray();

//         $tables = DB::connection('sqlsrv158')->select("SELECT * FROM FUNDING.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%deposit_prod_%'");
//         $tables2 = DB::connection('sqlsrv158')->select("SELECT * FROM FUNDING.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%pdm_hsl_summary_deposito_%'");

//         $list = [];
//         $list6 = [];
//         foreach ($tables as $table) {
//                 if ($table->TABLE_NAME != 'term_deposit_prod_20190228') {
//                         if (strpos(substr($table->TABLE_NAME, 13,7), '_') == true ) {
//                                 $list[] = substr($table->TABLE_NAME, 13 ,7);
//                         }
//                         $list6[] = substr($table->TABLE_NAME, 13,7);
//                 }
//         }

//         $list3 = [];
//         $list9 = [];
//         foreach ($tables2 as $table) {
//                 if (strpos(substr($table->TABLE_NAME, 25 ,8), '_') == true ) {
//                         $list3[] = substr($table->TABLE_NAME, 25 ,7);
//                         $list9[] = $table->TABLE_NAME;
//                 }
//         }

//         $columns = DB::connection('sqlsrv158')->select("SELECT * FROM FUNDING.INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='deposit_prod_9_2019'");

//         $req = ['BRANCH_CODE'];
//         $cols = [];
//         foreach ($columns as $column) {
//                 $cols[] = $column->COLUMN_NAME;
//         }

//         $diff = array_diff($cols, $req);
        
//         $dip = [];
        
//         foreach ($diff as $value) {
//                 $dip[] = $value;
//         }
        

//         $usersQuery =  DB::connection('sqlsrv158')->table('funding.dbo.deposit_prod_9_2019');

//         $as_of_date = (!empty($_GET["as_of_date"])) ? ($_GET["as_of_date"]) : ('');
//         $id_number = (!empty($_GET["id_number"])) ? ($_GET["id_number"]) : ('');

//         if ($as_of_date == true) {
//                 $usersQuery->where('BRANCH_CODE', $as_of_date);
//         }

//         if ($id_number == true) {
//                 $usersQuery->where('ID_NUMBER', $id_number);
//         }

//         $users = $usersQuery->select('*');

//         if ($request->ajax()) {
//                 return datatables()->of($users)->make(true);
//         }
        
//         return view('serverside', compact('cols', 'dip', 'categories', 'regions', 'status'));
// }       

    public function getFilePost(Request $request)
    {
        $content = File::get($request->upload->getRealPath());

        $array = explode(PHP_EOL, $content);

        // if ($request->ajax()) {
        //         return Datatables::of(DB::connection('sqlsrv158')->table('funding.dbo.'.$request->days)->whereIn( $request->choose , $array)->get())->make(true);
        // }

        $queries = DB::connection('sqlsrv158')->table('funding.dbo.'.$request->days)->whereIn( $request->choose , $array)->get();
        $columns = DB::connection('sqlsrv158')->select("SELECT * FROM FUNDING.INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='deposit_prod_11_2019'");

        $cols = [];
        $cals = [];

        foreach ($columns as $column ) {
                $cols[] = $column->COLUMN_NAME;
        }
        
        if ($request->accounts == null) {
        
        }     
        else {
                foreach ($cols as $key) {
                        foreach ($request->accounts as $value) {
                                if ($value == $key) {
                                        continue 2;
                                }
                        }
                        $cals[] = $key;
                }
        }
                       
        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $categories = $categori->toArray();
        
        $account = $request->accounts;

        $query = null;

        return view('query.upload', ["query" => $query, "categories" => $categories, 'account' => $account ,  'cols' => $cols, 'cals' => $cals, 'queries' => $queries]);
    }

    public function getFile(Request $request)
    {   
        // $content = File::get($request->upload->getRealPath());

        // $array = explode(PHP_EOL, $content);
        
        // $queries = DB::connection('sqlsrv158')->table('funding.dbo.'.$request->days)->whereIn( $request->choose , $array)->get();

        $columns = DB::connection('sqlsrv158')->select("SELECT * FROM FUNDING.INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='deposit_prod_11_2019'");

        $cals = [];
        $cols = [];
        foreach ($columns as $column) {
                $cols[] = $column->COLUMN_NAME;
        }

        if ($request->accounts == null) {
        
        }     
        else {
                foreach ($cols as $key) {
                        foreach ($request->accounts as $value) {
                                if ($value == $key) {
                                        continue 2;
                                }
                        }
                        $cals[] = $key;
                }
        }
        $account = $request->accounts;

        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $categories = $categori->toArray();

        $query = null;

        return view('query.upload', compact('years', 'cols' , 'categories', 'account', 'query', 'cals','queries'));
    }

   public function getPosition(Request $request) 
    {
        //     dd();
        $getdate = Carbon::parse($request->day . '-' . $request->month . '-' .$request->year)->format('d-m-Y');
        // $regions = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2.region', 'db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2.regDigit', 'funding.dbo.tbl_branch_code.branch_name')
        // ->leftJoin('funding.dbo.tbl_branch_code', DB::raw("CONCAT(db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2.region , '-' , db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2.regDigit)") , '=' , DB::raw("CONCAT(funding.dbo.tbl_branch_code.region , '-' , funding.dbo.tbl_branch_code.regDigit)"))
        // ->where('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2.regDigit', '!=' , null)->distinct()->orderBy('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2.region', 'asc')->get();
        
        //1
        $section1 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('jenis', 'group_prod_3', DB::raw('sum(saldo) as balance, sum(jml_rek) as number_account, sum(saldo)/sum(jml_rek) as total'));

                if ($request->region != null || $request->types != null || $request->groups != null || $request->products != null) {
                        if ($request->region != null) {
                                $show1 = $section1->where(DB::raw("CONCAT(region, '-' , regDigit)"), $request->region);
                        } else {
                                $show1 = $section1;
                        }
                        
                        if ($request->types != null) {
                                $show1 = $section1->whereIn('jenis', $request->types);
                        } else {
                                $show1 = $section1;
                        }

                        if ($request->groups != null) {
                                $show1 = $section1->whereIn('group_prod_3', $request->groups);
                        } else {
                                $show1 = $section1;
                        }

                        if ($request->products != null) {
                                $show1 = $section1->whereIn('prd_name', $request->products);
                        } else {
                                $show1 = $section1;
                        }

                } else {
                        $show1 = $section1;
                }
        
        $result1 = $show1->where('jenis', 'Reguler Berbayar')->where('tahun', $request->year)->where('bulan', $request->month)->where('tgl', $request->day)->groupBy('jenis', 'group_prod_3')->get();
        //2
        $section2 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('jenis', 'group_prod_3', DB::raw('sum(saldo) as balance, sum(jml_rek) as number_account, sum(saldo)/sum(jml_rek) as total'));

        if ($request->region != null || $request->types != null || $request->groups != null || $request->products != null) {
                if ($request->region != null) {
                        $show2 = $section2->where(DB::raw("CONCAT(region, '-' , regDigit)"), $request->region);
                } else {
                        $show2 = $section2;
                }
                
                if ($request->types != null) {
                        $show2 = $section2->whereIn('jenis', $request->types);
                } else {
                        $show2 = $section2;
                }

                if ($request->groups != null) {
                        $show2 = $section2->whereIn('group_prod_3', $request->groups);
                } else {
                        $show2 = $section2;
                }

                if ($request->products != null) {
                        $show2 = $section2->whereIn('prd_name', $request->products);
                } else {
                        $show2 = $section2;
                }

        } else {
                $show2 = $section2;
        }

        $result2 = $show2->where('jenis', 'Reguler Tidak Berbayar')->where('tahun', $request->year)->where('bulan', $request->month)->where('tgl', $request->day)->groupBy('jenis', 'group_prod_3')->get();

        //3
        $section3 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('jenis', 'group_prod_3', DB::raw('sum(saldo) as balance, sum(jml_rek) as number_account, sum(saldo)/sum(jml_rek) as total'));

        if ($request->region != null || $request->types != null || $request->groups != null || $request->products != null) {
                if ($request->region != null) {
                        $show3 = $section3->where(DB::raw("CONCAT(region, '-' , regDigit)"), $request->region);
                } else {
                        $show3 = $section3;
                }

                if ($request->types != null) {
                        $show3 = $section3->whereIn('jenis', $request->types);
                } else {
                        $show3 = $section3;
                }

                if ($request->groups != null) {
                        $show3 = $section3->whereIn('group_prod_3', $request->groups);
                } else {
                        $show3 = $section3;
                }

                if ($request->products != null) {
                        $show3 = $section3->whereIn('prd_name', $request->products);
                } else {
                        $show3 = $section3;
                }

        } else {
                $show3 = $section3;
        }

        $result3 = $show3->where('jenis', 'Mandatory')->where('tahun', $request->year)->where('bulan', $request->month)->where('tgl', $request->day)->groupBy('jenis', 'group_prod_3')->get();

        //4
        $section4 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('jenis', 'group_prod_3', DB::raw('sum(saldo) as balance, sum(jml_rek) as number_account, sum(saldo)/sum(jml_rek) as total'));

        if ($request->region != null || $request->types != null || $request->groups != null || $request->products != null) {
                if ($request->region != null) {
                        $show4 = $section4->where(DB::raw("CONCAT(region, '-' , regDigit)"), $request->region);
                } else {
                        $show4 = $section4;
                }

                if ($request->types != null) {
                        $show4 = $section4->whereIn('jenis', $request->types);
                } else {
                        $show4 = $section4;
                }

                if ($request->groups != null) {
                        $show4 = $section4->whereIn('group_prod_3', $request->groups);
                } else {
                        $show4 = $section4;
                }

                if ($request->products != null) {
                        $show4 = $section4->whereIn('prd_name', $request->products);
                } else {
                        $show4 = $section4;
                }

        } else {
                $show4 = $section4;
        }

        $result4 = $show4->where('tahun', $request->year)->where('bulan', $request->month)->where('tgl', $request->day)->groupBy('jenis', 'group_prod_3')->get();        
        //5
        $chart = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('region','regDigit', DB::raw('cast(sum(saldo)/1000000 as INT) as balance, sum(jml_rek) as number_account'));

        if ($request->region != null || $request->types != null || $request->groups != null || $request->products != null) {
                if ($request->region != null) {
                        $show5 = $chart->where(DB::raw("CONCAT(region, '-' , regDigit)"), $request->region);
                } else {
                        $show5 = $chart;
                }

                if ($request->groups != null) {
                        $show5 = $chart->whereIn('group_prod_3', $request->groups);
                } else {
                        $show5 = $chart;
                }

                if ($request->products != null) {
                        $show5 = $chart->whereIn('prd_name', $request->products);
                } else {
                        $show5 = $chart;
                }

        } else {
                $show5 = $chart;
        }

        $charts = $show5->where('tahun', $request->year)->where('bulan', $request->month)->where('tgl', $request->day)->groupBy('region','regDigit')->orderBy('regDigit', 'asc')->get();

        $reg = [];
        $balance = [];
        $number_account = [];
                
       foreach ($charts as $chart) {
            $reg[] = $chart->regDigit;
            $balance[] = (int)$chart->balance;
            $number_account[] = (int)$chart->number_account;
       }

       $null = is_null($request->year);

        $years= DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('tahun')->distinct()->get()->toArray();
        
        $regions = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('region', 'regDigit')
                ->where('regDigit', '!=', null)->distinct()->orderBy('region', 'asc')->get();

        $types = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('jenis')
        ->where('jenis', '!=' , null)->distinct()->get();
       
       return view('balance.position', compact('columns','regions', 'years', 'types', 'result1', 'result2', 'result3', 'result4', 'charts', 'reg', 'balance', 'number_account', 'null', 'getdate'));
//        return redirect()->back();
    }

    public function getPositionGet(Request $request)
    {   
        $chart = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('region','regDigit', DB::raw('cast(sum(saldo)/1000000 as INT) as balance, sum(jml_rek) as number_account'));

        if ($request->region != null || $request->types != null || $request->groups != null || $request->products != null) {
                if ($request->region != null) {
                        $show5 = $chart->where(DB::raw("CONCAT(region, '-' , regDigit)"), $request->region);
                } else {
                        $show5 = $chart;
                }

                if ($request->groups != null) {
                        $show5 = $chart->whereIn('group_prod_3', $request->groups);
                } else {
                        $show5 = $chart;
                }

                if ($request->products != null) {
                        $show5 = $chart->whereIn('prd_name', $request->products);
                } else {
                        $show5 = $chart;
                }

        } else {
                $show5 = $chart;
        }

        $charts = $show5->where('tahun', $request->year)->where('bulan', $request->month)->where('tgl', $request->day)->groupBy('region','regDigit')->orderBy('regDigit', 'asc')->get();

        $reg = [];
        $balance = [];
        $number_account = [];
                
       foreach ($charts as $chart) {
            $reg[] = $chart->regDigit;
            $balance[] = (int)$chart->balance;
            $number_account[] = (int)$chart->number_account;
       }

        $null = is_null($request->year);

        $years= DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('tahun')->distinct()->get()->toArray();
        
        $regions = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('region', 'regDigit')
                ->where('regDigit', '!=', null)->distinct()->orderBy('region', 'asc')->get();

        $types = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_tabungan_perwilayah_perproduk_2')->select('jenis')
        ->where('jenis', '!=' , null)->distinct()->get();
        
        return view('balance.position', compact('columns','regions', 'years', 'types', 'result1', 'result2', 'result3', 'result4', 'charts', 'reg', 'balance', 'number_account', 'null'));
    }

//     public function getTopBottom(Request $request)
//     {   
//         $sa = DB::connection('sqlsrv158')->table('datamart.dbo.' .$request->day)
//         ->select('product_name' ,'saldoskrng', 'saldo_sblm', 'delta', 'customer_name')
//         ->whereIn('datamart.dbo.' . $request->day . '.regDigit' , $request->region)
//         ->whereIn('datamart.dbo.' . $request->day . '.branch_name', $request->groups)
//         ->whereIn('datamart.dbo.' . $request->day . '.product_name', $request->products)
//         ->groupBy('product_name' ,'saldoskrng', 'saldo_sblm', 'delta', 'customer_name')
//         ->take($request->filter)->get();
//         // dd($sa);

//         $null = is_null($request->day);
//         $tb = DB::connection('sqlsrv158')->select("SELECT * FROM DATAMART.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%top_bottom_dtd_%'");
        
//         $tahun = [];

//         foreach ($tb as $tbdtd) {
//                 $tahun[] = $tbdtd->TABLE_NAME;
//         }

//         $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
//         $types = $categori->toArray();

//         $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

//         $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
//         $prod = $product->toArray();

//         return view('topbottom.dtd', compact('categori', 'types', 'regions', 'prod', 'null', 'tahun', 'sa'));
//     }

    public function getTopBottomDtd(Request $request)
    {
        $null = is_null($request->days);
        $tb = DB::connection('sqlsrv159')->select("SELECT * FROM DATAMART.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%top_dtd_%'");
        
        $tahun = [];

        foreach ($tb as $tbdtd) {
                $tahun[] = substr($tbdtd->TABLE_NAME, 8,4);
        }

        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();

        return view('topbottom.dtdtop', compact('categori', 'types', 'regions', 'prod', 'null', 'tahun'));
    }

    public function getTopYtd(Request $request)
    {
        $null = is_null($request->days);
        $tb = DB::connection('sqlsrv159')->select("SELECT * FROM DATAMART.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%top_ytd_%'");
        
        $tahun = [];

        foreach ($tb as $tbdtd) {
                $tahun[] = substr($tbdtd->TABLE_NAME, 8,4);
        }
        
        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();

        return view('topbottom.ytdtop', compact('categori', 'types', 'regions', 'prod', 'null', 'tahun'));
    }

    public function getBottomDtd(Request $request)
    {
        $null = is_null($request->days);
        $tb = DB::connection('sqlsrv159')->select("SELECT * FROM DATAMART.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%bottom_dtd_%'");
        
        $tahun = [];

        foreach ($tb as $tbdtd) {
                $tahun[] = substr($tbdtd->TABLE_NAME, 11,4);
        }

        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();

        return view('topbottom.dtdbottom', compact('categori', 'types', 'regions', 'prod', 'null', 'tahun'));
    }

    public function getTopBottomtd(Request $request)
    {
        $null = is_null($request->days);
        $tb = DB::connection('sqlsrv159')->select("SELECT * FROM DATAMART.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%top_mtd_%'");
        
        $tahun = [];

        foreach ($tb as $tbmtd) {
                $tahun[] = substr($tbmtd->TABLE_NAME, 8,4);
        }
        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();

        return view('topbottom.mtdtop', compact('categori', 'types', 'regions', 'prod', 'null', 'tahun'));
    }

    public function getBottomMtd(Request $request)
    {
        $null = is_null($request->days);
        $tb = DB::connection('sqlsrv159')->select("SELECT * FROM DATAMART.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%bottom_mtd_%'");
        
        $tahun = [];

        foreach ($tb as $tbmtd) {
                $tahun[] = substr($tbmtd->TABLE_NAME, 11,4);
        }

        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();

        return view('topbottom.mtdbottom', compact('categori', 'types', 'regions', 'prod', 'null', 'tahun'));
    }

    public function getBottomYtd(Request $request)
    {
        $null = is_null($request->days);
        $tb = DB::connection('sqlsrv159')->select("SELECT * FROM DATAMART.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%bottom_ytd_%'");
        
        $tahun = [];

        foreach ($tb as $tbmtd) {
                $tahun[] = substr($tbmtd->TABLE_NAME, 11,4);
        }
        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();

        return view('topbottom.ytdbottom', compact('categori', 'types', 'regions', 'prod', 'null', 'tahun'));
    }

    public function postBottomYtd(Request $request)
    {
        $getdate = Carbon::parse(substr($request->day,11,8))->format('d-m-Y');
        $br = [];
        $bran = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select('branch_name', 'region')->distinct()->get();
        foreach ($bran as $branch) {
                $br[] = $branch->branch_name;
        }

        if ($request->groups != null && $request->products != null && $request->jenas != null && $request->region != null && $request->jentab != null ) {

        $res = DB::connection('sqlsrv159')->table('datamart.dbo.' .$request->day)
        ->select('product_name', 'bni_cif_key', 'id_number', 'branch_name', 'regDigit' ,'saldoskrng', 'saldo_sblm', 'delta', 'customer_name', 'flag_tabungan', 'flag_nasabah');

        if (Req::input('select-all') == 'on') {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.branch_name', $br);
        } else {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.branch_name', $request->groups);
        }

        if ($request->products != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.product_name', $request->products);
        } else {
                $show5 = $res;
        }
        
        if ($request->region != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.regDigit' , $request->region);
        } else {
                $show5 = $res;
        }
       
        if ($request->jentab != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.flag_tabungan', $request->jentab);
        } else {
                $show5 = $res;
        }

        if ($request->jenas != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.flag_nasabah', $request->jenas);
        } else {
                $show5 = $res;
        }
   
        $sa =  $show5->take($request->filter)->orderBy('delta')->get();

        } else {
                return redirect()->back();
        }        

        $null = is_null($request->day);

        $tb = DB::connection('sqlsrv159')->select("SELECT * FROM DATAMART.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%bottom_ytd_%'");
        
        $tahun = [];

        foreach ($tb as $tbdtd) {
                $tahun[] = substr($tbdtd->TABLE_NAME, 11,4);
        }

        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();

        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();
                   
        return view('topbottom.ytdbottom', compact('years', 'regions', 'types', 'tb', 'f' ,'a', 'prod', 'reg', 'balance', 'balance2', 'bulan', 'tanggal', 'tahun', 'sa', 'null', 'getdate'));
    }

    public function postBottomMtd(Request $request)
    {
        $getdate = Carbon::parse(substr($request->day,11,8))->format('d-m-Y');
        $br = [];
        $bran = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select('branch_name', 'region')->distinct()->get();
        foreach ($bran as $branch) {
                $br[] = $branch->branch_name;
        }

        if ($request->groups != null && $request->products != null && $request->jenas != null && $request->region != null && $request->jentab != null ) {

        $res = DB::connection('sqlsrv159')->table('datamart.dbo.' .$request->day)
        ->select('product_name', 'bni_cif_key', 'id_number', 'branch_name', 'regDigit' ,'saldoskrng', 'saldo_sblm', 'delta', 'customer_name', 'flag_tabungan', 'flag_nasabah');

        if (Req::input('select-all') == 'on') {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.branch_name', $br);
        } else {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.branch_name', $request->groups);
        }

        if ($request->products != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.product_name', $request->products);
        } else {
                $show5 = $res;
        }
        
        if ($request->region != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.regDigit' , $request->region);
        } else {
                $show5 = $res;
        }
       
        if ($request->jentab != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.flag_tabungan', $request->jentab);
        } else {
                $show5 = $res;
        }

        if ($request->jenas != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.flag_nasabah', $request->jenas);
        } else {
                $show5 = $res;
        }
   
        $sa =  $show5->take($request->filter)->orderBy('delta')->get();

        } else {
                return redirect()->back();
        }

        $null = is_null($request->day);

        $tb = DB::connection('sqlsrv159')->select("SELECT * FROM DATAMART.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%bottom_mtd_%'");
        
        $tahun = [];

        foreach ($tb as $tbdtd) {
                $tahun[] = substr($tbdtd->TABLE_NAME, 11,4);
        }

        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();

        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();
                   
        return view('topbottom.mtdbottom', compact('years', 'regions', 'types', 'tb', 'f' ,'a', 'prod', 'reg', 'balance', 'balance2', 'bulan', 'tanggal', 'tahun', 'sa', 'null', 'getdate'));
    }

    public function getTopBottom(Request $request)
    {
        //     dd($request->all());
        $getdate = Carbon::parse(substr($request->day,8,8))->format('d-m-Y');
        $br = [];
        $bran = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select('branch_name', 'region')->distinct()->get();
        foreach ($bran as $branch) {
                $br[] = $branch->branch_name;
        }

        if ($request->groups != null && $request->products != null && $request->jenas != null && $request->region != null && $request->jentab != null ) {
        
        $res = DB::connection('sqlsrv159')->table('datamart.dbo.' .$request->day)
        ->select('product_name', 'bni_cif_key', 'id_number', 'branch_name', 'regDigit' ,'saldoskrng', 'saldo_sblm', 'delta', 'customer_name', 'flag_tabungan', 'flag_nasabah');
        
        if (Req::input('select-all') == 'on') {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.branch_name', $br);
        } else {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.branch_name', $request->groups);
        }

        if ($request->products != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.product_name', $request->products);
        } else {
                $show5 = $res;
        }

        if ($request->jenas != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.flag_nasabah', $request->jenas);
        } else {
                $show5 = $res;
        }
        
        if ($request->region != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.regDigit' , $request->region);
        } else {
                $show5 = $res;
        }
       
        if ($request->jentab != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.flag_tabungan', $request->jentab);
        } else {
                $show5 = $res;
        }
   
        $sa =  $show5->take($request->filter)->orderBy('delta', 'desc')->get();

        } else {
                return redirect()->back();
        }
        $null = is_null($request->day);

        $tb = DB::connection('sqlsrv159')->select("SELECT * FROM DATAMART.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%top_dtd_%'");
        
        $tahun = [];

        foreach ($tb as $tbdtd) {
                $tahun[] = substr($tbdtd->TABLE_NAME, 8,4);
        }

        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();

        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();
                   
        return view('topbottom.dtdtop', compact('years', 'regions', 'types', 'tb', 'f' ,'a', 'prod', 'reg', 'balance', 'balance2', 'bulan', 'tanggal', 'tahun', 'sa', 'null', 'getdate'));
    }

    public function postBottomDtd(Request $request)
    {
        //     dd($request->day);
        $getdate = Carbon::parse(substr($request->day,11,8))->format('d-m-Y');

        $br = [];
        $bran = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select('branch_name', 'region')->distinct()->get();
        foreach ($bran as $branch) {
                $br[] = $branch->branch_name;
        }

        if ($request->groups != null && $request->products != null && $request->jenas != null && $request->region != null && $request->jentab != null ) {
        
        $res = DB::connection('sqlsrv159')->table('datamart.dbo.' .$request->day)
        ->select('product_name', 'bni_cif_key', 'id_number', 'branch_name', 'regDigit' ,'saldoskrng', 'saldo_sblm', 'delta', 'customer_name', 'flag_tabungan', 'flag_nasabah');

        if (Req::input('select-all') == 'on') {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.branch_name', $br);
        } else {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.branch_name', $request->groups);
        }

        if ($request->products != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.product_name', $request->products);
        } else {
                $show5 = $res;
        }
        
        if ($request->region != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.regDigit' , $request->region);
        } else {
                $show5 = $res;
        }
       
        if ($request->jentab != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.flag_tabungan', $request->jentab);
        } else {
                $show5 = $res;
        }

        if ($request->jenas != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.flag_nasabah', $request->jenas);
        } else {
                $show5 = $res;
        }
   
        $sa =  $show5->take($request->filter)->orderBy('delta', 'asc')->get();

        } else {
                return redirect()->back();
        }

        $null = is_null($request->day);

        $tb = DB::connection('sqlsrv159')->select("SELECT * FROM DATAMART.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%bottom_dtd_%'");
        
        $tahun = [];

        foreach ($tb as $tbdtd) {
                $tahun[] = substr($tbdtd->TABLE_NAME, 11,4);
        }

        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();

        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();
                   
        return view('topbottom.dtdbottom', compact('years', 'regions', 'types', 'tb', 'f' ,'a', 'prod', 'reg', 'balance', 'balance2', 'bulan', 'tanggal', 'tahun', 'sa', 'null', 'getdate'));
    }

    public function postTopYtd(Request $request)
    {
        // dd($request->all());
        $getdate = Carbon::parse(substr($request->day,8,8))->format('d-m-Y');

        $br = [];
        $bran = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select('branch_name', 'region')->distinct()->get();
        foreach ($bran as $branch) {
                $br[] = $branch->branch_name;
        }

        if ($request->groups != null && $request->products != null && $request->jenas != null && $request->region != null && $request->jentab != null ) {

        $res = DB::connection('sqlsrv159')->table('datamart.dbo.' .$request->day)
        ->select('product_name', 'bni_cif_key', 'id_number', 'branch_name', 'regDigit' ,'saldoskrng', 'saldo_sblm', 'delta', 'customer_name', 'flag_tabungan', 'flag_nasabah');

        if (Req::input('select-all') == 'on') {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.branch_name', $br);
        } else {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.branch_name', $request->groups);
        }

        if ($request->products != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.product_name', $request->products);
        } else {
                $show5 = $res;
        }
        
        if ($request->region != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.regDigit' , $request->region);
        } else {
                $show5 = $res;
        }
       
        if ($request->jentab != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.flag_tabungan', $request->jentab);
        } else {
                $show5 = $res;
        }

        if ($request->jenas != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.flag_nasabah', $request->jenas);
        } else {
                $show5 = $res;
        }
   
        $sa =  $show5->take($request->filter)->orderBy('delta', 'desc')->get();

        } else {
                return redirect()->back();
        }

        $null = is_null($request->day);

        $tb = DB::connection('sqlsrv159')->select("SELECT * FROM DATAMART.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%top_ytd_%'");
        
        $tahun = [];

        foreach ($tb as $tbdtd) {
                $tahun[] = substr($tbdtd->TABLE_NAME, 11,4);
        }

        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();

        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();
                   
        return view('topbottom.ytdtop', compact('years', 'regions', 'types', 'tb', 'f' ,'a', 'prod', 'reg', 'balance', 'balance2', 'bulan', 'tanggal', 'tahun', 'sa', 'null', 'getdate'));
    }

    public function getTopBottomMtd(Request $request)
    {
        $getdate = Carbon::parse(substr($request->day,8,8))->format('d-m-Y');

        $br = [];
        $bran = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select('branch_name', 'region')->distinct()->get();
        foreach ($bran as $branch) {
                $br[] = $branch->branch_name;
        }

        if ($request->groups != null && $request->products != null && $request->jenas != null && $request->region != null && $request->jentab != null ) {

        $res = DB::connection('sqlsrv159')->table('datamart.dbo.' .$request->day)
        ->select('product_name', 'bni_cif_key', 'id_number', 'branch_name', 'regDigit' ,'saldoskrng', 'saldo_sblm', 'delta', 'customer_name', 'flag_tabungan', 'flag_nasabah');

        if (Req::input('select-all') == 'on') {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.branch_name', $br);
        } else {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.branch_name', $request->groups);
        }

        if ($request->products != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.product_name', $request->products);
        } else {
                $show5 = $res;
        }
        
        if ($request->region != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.regDigit' , $request->region);
        } else {
                $show5 = $res;
        }
       
        if ($request->jentab != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.flag_tabungan', $request->jentab);
        } else {
                $show5 = $res;
        }

        if ($request->jenas != null) {
                $show5 = $res->whereIn('datamart.dbo.' . $request->day . '.flag_nasabah', $request->jenas);
        } else {
                $show5 = $res;
        }
   
        $sa =  $show5->take($request->filter)->orderBy('delta', 'desc')->get();

        } else {
                return redirect()->back();
        }

        $null = is_null($request->day);

        $tb = DB::connection('sqlsrv159')->select("SELECT * FROM DATAMART.INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE '%top_mtd_%'");
        
        $tahun = [];

        foreach ($tb as $tbmtd) {
                $tahun[] = substr($tbmtd->TABLE_NAME, 8,4);
        }

        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();

        $categori = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('jenis')->distinct()->get();
        $types = $categori->toArray();

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'regDigit')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $product = DB::connection('sqlsrv158')->table('datamart.dbo.list_prd_dpk')->select('product_name', 'bni_account_type', 'bni_sub_category')->distinct()->get();
        $prod = $product->toArray();
                   
        return view('topbottom.mtdtop', compact('years', 'regions', 'types', 'tb', 'f' ,'a', 'prod', 'reg', 'balance', 'balance2', 'bulan', 'tanggal', 'tahun', 'sa', 'null', 'getdate'));
    }
    
    public function getAverage(Request $request)
    {
        // dd($request->all()); 
        $years= DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_avg_perproduk_perwilayah')->select('tahun')->orderBy('tahun')->distinct()->get();
        
        $regions = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_avg_perproduk_perwilayah')->select('region', 'regDigit')
                ->where('regDigit', '!=', null)->distinct()->orderBy('region', 'asc')->get();

        $types = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_avg_perproduk_perwilayah')->select('jenis')
        ->where('jenis', '!=' , null)->distinct()->get();

        $section1 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_avg_perproduk_perwilayah')->select('jenis', 'group_prod_3', DB::raw('sum(saldo_avg) as balance'));

                if ($request->region != null || $request->types != null || $request->groups != null || $request->products != null) {
                        if ($request->region != null) {
                                $show1 = $section1->where(DB::raw("CONCAT(region, '-' , regDigit)"), $request->region);
                        } else {
                                $show1 = $section1;
                        }
                        
                        if ($request->types != null) {
                                $show1 = $section1->whereIn('jenis', $request->types);
                        } else {
                                $show1 = $section1;
                        }

                        if ($request->groups != null) {
                                $show1 = $section1->whereIn('group_prod_3', $request->groups);
                        } else {
                                $show1 = $section1;
                        }

                        if ($request->products != null) {
                                $show1 = $section1->whereIn('prd_name', $request->products);
                        } else {
                                $show1 = $section1;
                        }

                } else {
                        $show1 = $section1;
                }
        
        $result1 = $show1->where('jenis', 'Reguler Berbayar')->where('tahun', $request->year)->where('bulan', $request->month)->where('tgl', $request->day)->groupBy('jenis', 'group_prod_3')->get();
        // dd($result1);
        //2
        $section2 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_avg_perproduk_perwilayah')->select('jenis', 'group_prod_3', DB::raw('sum(saldo_avg) as balance'));

        if ($request->region != null || $request->types != null || $request->groups != null || $request->products != null) {
                if ($request->region != null) {
                        $show2 = $section2->where(DB::raw("CONCAT(region, '-' , regDigit)"), $request->region);
                } else {
                        $show2 = $section2;
                }
                
                if ($request->types != null) {
                        $show2 = $section2->whereIn('jenis', $request->types);
                } else {
                        $show2 = $section2;
                }

                if ($request->groups != null) {
                        $show2 = $section2->whereIn('group_prod_3', $request->groups);
                } else {
                        $show2 = $section2;
                }

                if ($request->products != null) {
                        $show2 = $section2->whereIn('prd_name', $request->products);
                } else {
                        $show2 = $section2;
                }

        } else {
                $show2 = $section2;
        }

        $result2 = $show2->where('jenis', 'Reguler Tidak Berbayar')->where('tahun', $request->year)->where('bulan', $request->month)->where('tgl', $request->day)->groupBy('jenis', 'group_prod_3')->get();
        // dd(count($result2));
        //3
        $section3 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_avg_perproduk_perwilayah')->select('jenis', 'group_prod_3', DB::raw('sum(saldo_avg) as balance'));

        if ($request->region != null || $request->types != null || $request->groups != null || $request->products != null) {
                if ($request->region != null) {
                        $show3 = $section3->where(DB::raw("CONCAT(region, '-' , regDigit)"), $request->region);
                } else {
                        $show3 = $section3;
                }

                if ($request->types != null) {
                        $show3 = $section3->whereIn('jenis', $request->types);
                } else {
                        $show3 = $section3;
                }

                if ($request->groups != null) {
                        $show3 = $section3->whereIn('group_prod_3', $request->groups);
                } else {
                        $show3 = $section3;
                }

                if ($request->products != null) {
                        $show3 = $section3->whereIn('prd_name', $request->products);
                } else {
                        $show3 = $section3;
                }

        } else {
                $show3 = $section3;
        }

        $result3 = $show3->where('jenis', 'Mandatory')->where('tahun', $request->year)->where('bulan', $request->month)->where('tgl', $request->day)->groupBy('jenis', 'group_prod_3')->get();
        // dd($result3);

        //4
        $section4 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_avg_perproduk_perwilayah')->select('jenis', 'group_prod_3', DB::raw('sum(saldo_avg) as balance'));

        if ($request->region != null || $request->types != null || $request->groups != null || $request->products != null) {
                if ($request->region != null) {
                        $show4 = $section4->where(DB::raw("CONCAT(region, '-' , regDigit)"), $request->region);
                } else {
                        $show4 = $section4;
                }

                if ($request->types != null) {
                        $show4 = $section4->whereIn('jenis', $request->types);
                } else {
                        $show4 = $section4;
                }

                if ($request->groups != null) {
                        $show4 = $section4->whereIn('group_prod_3', $request->groups);
                } else {
                        $show4 = $section4;
                }

                if ($request->products != null) {
                        $show4 = $section4->whereIn('prd_name', $request->products);
                } else {
                        $show4 = $section4;
                }

        } else {
                $show4 = $section4;
        }

        $result4 = $show4->where('tahun', $request->year)->where('bulan', $request->month)->where('tgl', $request->day)->groupBy('jenis', 'group_prod_3')->get(); 
        // dd($result4);

        //5
        $chart = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_avg_perproduk_perwilayah')->select(DB::raw("CONVERT(INT, region) as region"),'regDigit', DB::raw('cast(sum(saldo_avg)/1000000 as INT) as balance'));

        if ($request->region != null || $request->types != null || $request->groups != null || $request->products != null) {
                if ($request->region != null) {
                        $show5 = $chart->where(DB::raw("CONCAT(region, '-' , regDigit)"), $request->region);
                } else {
                        $show5 = $chart;
                }

                if ($request->groups != null) {
                        $show5 = $chart->whereIn('group_prod_3', $request->groups);
                } else {
                        $show5 = $chart;
                }

                if ($request->products != null) {
                        $show5 = $chart->whereIn('prd_name', $request->products);
                } else {
                        $show5 = $chart;
                }

        } else {
                $show5 = $chart;
        }

        $charts = $show5->where('tahun', $request->year)->where('bulan', $request->month)->where('tgl', $request->day)->groupBy('region','regDigit')->orderBy('region', 'asc')->get();

        $reg = [];
        $balance = [];
                
        foreach ($charts as $chart) {
            $reg[] = $chart->regDigit;
            $balance[] = (int)$chart->balance;
        }
        
        $null = is_null($request->year);

        return view('balance.average', compact('result1','bulan', 'result2', 'result3', 'result4','regions', 'reg', 'balance', 'years', 'ar', 'date', 'null', 'types'));
    }

    public function getMatrix(Request $request)
    {
        $cari = $request->cari;

        $regions = DB::connection('sqlsrv158')->table('funding.dbo.tbl_branch_code')->select(DB::raw("CONVERT(INT, region) as region"), 'region_name')->where('region', '!=', null)->where('region', '<=', 18)->distinct()->orderBy('region', 'asc')->get();

        $types = DB::connection('sqlsrv158')->table('funding.dbo.prm_grouping_produk')->select('jenis')->distinct()->get();
        //1
        $totalcurl1 = DB::connection('sqlsrv158')->table('db_reza.dbo.grafik_cur_balance')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(saldo as BIGINT)) as balance'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.grafik_cur_balance.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               

        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null ) {
                if ($request->region != null) {
                        $show1 = $totalcurl1->where('db_reza.dbo.grafik_cur_balance.region','LIKE', $request->region);
                } else {
                        $show1 = $totalcurl1;
                }

                if ($request->type != null) {
                        $show1 = $totalcurl1->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show1 = $totalcurl1;
                }
                
                if ($request->group != null ) {
                        $show1 = $totalcurl1->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show1 = $totalcurl1;
                }

                if ($request->acctypes) {
                        $show1 = $totalcurl1->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show1 = $totalcurl1;
                }
                
        } else {
                $show1 = $totalcurl1;
        }
                $query1 = $show1->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
        //2
        $totalcurl2 = DB::connection('sqlsrv158')->table('db_reza.dbo.grafik_cur_balance')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(saldo as BIGINT)) as balance'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.grafik_cur_balance.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show2 = $totalcurl2->where('db_reza.dbo.grafik_cur_balance.region','LIKE' ,$request->region);
                } else {
                        $show2 = $totalcurl2;
                }

                if ($request->type != null) {
                        $show2 = $totalcurl2->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show2 = $totalcurl2;
                }
                
                if ($request->group != null ) {
                        $show2 = $totalcurl2->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show2 = $totalcurl2;
                }

                if ($request->acctypes) {
                        $show2 = $totalcurl2->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show2 = $totalcurl2;
                }
                
        } else {
                $show2 = $totalcurl2;
        }
                $query2 = $show2->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
        
        // dd($query2);
        
        //3
        $totalcurl3 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(jumlah_acc) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show3 = $totalcurl3->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE', $request->region);
                } else {
                        $show3 = $totalcurl3;
                }

                if ($request->type != null) {
                        $show3 = $totalcurl3->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show3 = $totalcurl3;
                }
                
                if ($request->group != null ) {
                        $show3 = $totalcurl3->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show3 = $totalcurl3;
                }

                if ($request->acctypes) {
                        $show3 = $totalcurl3->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show3 = $totalcurl3;
                        
                }
                
        } else {
                $show3 = $totalcurl3;
        }
                $query3 = $show3->where('note_posisi_produk_pekerjaan', '!=', 'OUT MURNI')->where('db_reza.dbo.tbl_chart_acc_mtd.tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        //4
        $totalcurl4 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(jumlah_acc) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show4 = $totalcurl4->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE' ,$request->region);
                } else {
                        $show4 = $totalcurl4;
                }

                if ($request->type != null) {
                        $show4 = $totalcurl4->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show4 = $totalcurl4;
                }
                
                if ($request->group != null ) {
                        $show4 = $totalcurl4->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show4 = $totalcurl4;
                }

                if ($request->acctypes) {
                        $show4 = $totalcurl4->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show4 = $totalcurl4;
                }
                
        } else {
                $show4 = $totalcurl4;
        }
                $query4 = $show4->where('note_posisi_produk_pekerjaan', '!=', 'OUT MURNI')->where('db_reza.dbo.tbl_chart_acc_mtd.tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        //5
        $totalcurl5 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(jumlah_acc as BIGINT)) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show5 = $totalcurl5->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE', $request->region);
                } else {
                        $show5 = $totalcurl5;
                }

                if ($request->type != null) {
                        $show5 = $totalcurl5->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show5 = $totalcurl5;
                }
                
                if ($request->group != null ) {
                        $show5 = $totalcurl5->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show5 = $totalcurl5;
                }

                if ($request->acctypes) {
                        $show5 = $totalcurl5->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show5 = $totalcurl5;
                        
                }
                
        } else {
                $show5 = $totalcurl5;
        }
                $query5 = $show5->where('note_posisi_produk_pekerjaan', '=', 'OUT MURNI')->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        //6
        $totalcurl6 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(jumlah_acc as BIGINT)) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show6 = $totalcurl6->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE' ,$request->region);
                } else {
                        $show6 = $totalcurl6;
                }

                if ($request->type != null) {
                        $show6 = $totalcurl6->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show6 = $totalcurl6;
                }
                
                if ($request->group != null ) {
                        $show6 = $totalcurl6->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show6 = $totalcurl6;
                }

                if ($request->acctypes) {
                        $show6 = $totalcurl6->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show6 = $totalcurl6;
                }
                
        } else {
                $show6 = $totalcurl6;
        }
                $query6 = $show6->where('note_posisi_produk_pekerjaan', '=', 'OUT MURNI')->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        
        //7
        $totalcurl7 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_ytd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(jumlah_acc as BIGINT)) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_ytd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show7 = $totalcurl7->where('db_reza.dbo.tbl_chart_acc_ytd.region','LIKE', $request->region);
                } else {
                        $show7 = $totalcurl7;
                }

                if ($request->type != null) {
                        $show7 = $totalcurl7->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show7 = $totalcurl7;
                }
                
                if ($request->group != null ) {
                        $show7 = $totalcurl7->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show7 = $totalcurl7;
                }

                if ($request->acctypes) {
                        $show7 = $totalcurl7->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show7 = $totalcurl7;
                        
                }
                
        } else {
                $show7 = $totalcurl7;
        }
                $query7 = $show7->where('note_posisi_produk_pekerjaan', '=', 'OUT MURNI')->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        //8
        $totalcurl8 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_ytd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(jumlah_acc as BIGINT)) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_ytd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show8 = $totalcurl8->where('db_reza.dbo.tbl_chart_acc_ytd.region','LIKE' ,$request->region);
                } else {
                        $show8 = $totalcurl8;
                }

                if ($request->type != null) {
                        $show8 = $totalcurl8->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show8 = $totalcurl8;
                }
                
                if ($request->group != null ) {
                        $show8 = $totalcurl8->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show8 = $totalcurl8;
                }

                if ($request->acctypes) {
                        $show8 = $totalcurl8->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show8 = $totalcurl8;
                }
                
        } else {
                $show8 = $totalcurl8;
        }
                $query8 = $show8->where('note_posisi_produk_pekerjaan', '=', 'OUT MURNI')->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
        // dd($query8);
        
        //9
        $totalcurl9 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(jumlah_acc as BIGINT)) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show9 = $totalcurl9->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE', $request->region);
                } else {
                        $show9 = $totalcurl9;
                }

                if ($request->type != null) {
                        $show9 = $totalcurl9->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show9 = $totalcurl9;
                }
                
                if ($request->group != null ) {
                        $show9 = $totalcurl9->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show9 = $totalcurl9;
                }

                if ($request->acctypes) {
                        $show9 = $totalcurl9->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show9 = $totalcurl9;
                        
                }
                
        } else {
                $show9 = $totalcurl9;
        }
                $query9 = $show9->where('note_posisi_produk_pekerjaan', '=', 'NEW MURNI')->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

                //10
        $totalcurl10 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(jumlah_acc as BIGINT)) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show10 = $totalcurl10->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE' ,$request->region);
                } else {
                        $show10 = $totalcurl10;
                }

                if ($request->type != null) {
                        $show10 = $totalcurl10->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show10 = $totalcurl10;
                }
                
                if ($request->group != null ) {
                        $show10 = $totalcurl10->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show10 = $totalcurl10;
                }

                if ($request->acctypes) {
                        $show10 = $totalcurl10->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show10 = $totalcurl10;
                }
                
        } else {
                $show10 = $totalcurl10;
        }
                $query10 = $show10->where('note_posisi_produk_pekerjaan', '=', 'NEW MURNI')->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
        // dd($query10);

        //11
        $totalcurl11 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_ytd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(jumlah_acc as BIGINT)) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_ytd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show11 = $totalcurl11->where('db_reza.dbo.tbl_chart_acc_ytd.region','LIKE', $request->region);
                } else {
                        $show11 = $totalcurl11;
                }

                if ($request->type != null) {
                        $show11 = $totalcurl11->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show11 = $totalcurl11;
                }
                
                if ($request->group != null ) {
                        $show11 = $totalcurl11->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show11 = $totalcurl11;
                }

                if ($request->acctypes) {
                        $show11 = $totalcurl11->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show11 = $totalcurl11;
                        
                }
                
        } else {
                $show11 = $totalcurl11;
        }
                $query11 = $show11->where('note_posisi_produk_pekerjaan', '=', 'NEW MURNI')->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
                // dd($query11);
        //12
        $totalcurl12 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_ytd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(jumlah_acc as BIGINT)) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_ytd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show12 = $totalcurl12->where('db_reza.dbo.tbl_chart_acc_ytd.region','LIKE' ,$request->region);
                } else {
                        $show12 = $totalcurl12;
                }

                if ($request->type != null) {
                        $show12 = $totalcurl12->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show12 = $totalcurl12;
                }
                
                if ($request->group != null ) {
                        $show12 = $totalcurl12->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show12 = $totalcurl12;
                }

                if ($request->acctypes) {
                        $show12 = $totalcurl12->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show12 = $totalcurl12;
                }
                
        } else {
                $show12 = $totalcurl12;
        }
                $query12 = $show12->where('note_posisi_produk_pekerjaan', '=', 'NEW MURNI')->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        
        //13
        $totalcurl13 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(awal as BIGINT)) as start'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show13 = $totalcurl13->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE', $request->region);
                } else {
                        $show13 = $totalcurl13;
                }

                if ($request->type != null) {
                        $show13 = $totalcurl13->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show13 = $totalcurl13;
                }
                
                if ($request->group != null ) {
                        $show13 = $totalcurl13->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show13 = $totalcurl13;
                }

                if ($request->acctypes) {
                        $show13 = $totalcurl13->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show13 = $totalcurl13;
                        
                }
                
        } else {
                $show13 = $totalcurl13;
        }
                $query13 = $show13->where('note_posisi_produk_pekerjaan', '=', 'OUT MURNI')->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
                // dd($query13);
        //14
        $totalcurl14 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(awal as BIGINT)) as start'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show14 = $totalcurl14->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE' ,$request->region);
                } else {
                        $show14 = $totalcurl14;
                }

                if ($request->type != null) {
                        $show14 = $totalcurl14->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show14 = $totalcurl14;
                }
                
                if ($request->group != null ) {
                        $show14 = $totalcurl14->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show14 = $totalcurl14;
                }

                if ($request->acctypes) {
                        $show14 = $totalcurl14->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show14 = $totalcurl14;
                }
                
        } else {
                $show14 = $totalcurl14;
        }
                $query14 = $show14->where('note_posisi_produk_pekerjaan', '=', 'OUT MURNI')->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        
        //15
        $totalcurl15 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_ytd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(awal as BIGINT)) as start'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_ytd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show15 = $totalcurl15->where('db_reza.dbo.tbl_chart_acc_ytd.region','LIKE', $request->region);
                } else {
                        $show15 = $totalcurl15;
                }

                if ($request->type != null) {
                        $show15 = $totalcurl15->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show15 = $totalcurl15;
                }
                
                if ($request->group != null ) {
                        $show15 = $totalcurl15->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show15 = $totalcurl15;
                }

                if ($request->acctypes) {
                        $show15 = $totalcurl15->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show15 = $totalcurl15;
                        
                }
                
        } else {
                $show15 = $totalcurl15;
        }
                $query15 = $show15->where('note_posisi_produk_pekerjaan', '=', 'OUT MURNI')->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
                // dd($query13);
        //16
        $totalcurl16 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_ytd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(awal as BIGINT)) as start'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_ytd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show16 = $totalcurl16->where('db_reza.dbo.tbl_chart_acc_ytd.region','LIKE' ,$request->region);
                } else {
                        $show16 = $totalcurl16;
                }

                if ($request->type != null) {
                        $show16 = $totalcurl16->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show16 = $totalcurl16;
                }
                
                if ($request->group != null ) {
                        $show16 = $totalcurl16->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show16 = $totalcurl16;
                }

                if ($request->acctypes) {
                        $show16 = $totalcurl16->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show16 = $totalcurl16;
                }
                
        } else {
                $show16 = $totalcurl16;
        }
                $query16 = $show16->where('note_posisi_produk_pekerjaan', '=', 'OUT MURNI')->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        //17
        $totalcurl17 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(akhir as BIGINT)) as endd'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show17 = $totalcurl17->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE', $request->region);
                } else {
                        $show17 = $totalcurl17;
                }

                if ($request->type != null) {
                        $show17 = $totalcurl17->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show17 = $totalcurl17;
                }
                
                if ($request->group != null ) {
                        $show17 = $totalcurl17->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show17 = $totalcurl17;
                }

                if ($request->acctypes) {
                        $show17 = $totalcurl17->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show17 = $totalcurl17;
                        
                }
                
        } else {
                $show17 = $totalcurl17;
        }
                $query17 = $show17->where('note_posisi_produk_pekerjaan', '=', 'NEW MURNI')->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
                // dd($query17);
        //18
        $totalcurl18 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(akhir as BIGINT)) as endd'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show18 = $totalcurl18->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE' ,$request->region);
                } else {
                        $show18 = $totalcurl18;
                }

                if ($request->type != null) {
                        $show18 = $totalcurl18->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show18 = $totalcurl18;
                }
                
                if ($request->group != null ) {
                        $show18 = $totalcurl18->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show18 = $totalcurl18;
                }

                if ($request->acctypes) {
                        $show18 = $totalcurl18->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show18 = $totalcurl18;
                }
                
        } else {
                $show18 = $totalcurl18;
        }
                $query18 = $show18->where('note_posisi_produk_pekerjaan', '=', 'NEW MURNI')->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();


        //19
        $totalcurl19 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_ytd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(akhir as BIGINT)) as endd'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_ytd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show19 = $totalcurl19->where('db_reza.dbo.tbl_chart_acc_ytd.region','LIKE', $request->region);
                } else {
                        $show19 = $totalcurl19;
                }

                if ($request->type != null) {
                        $show19 = $totalcurl19->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show19 = $totalcurl19;
                }
                
                if ($request->group != null ) {
                        $show19 = $totalcurl19->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show19 = $totalcurl19;
                }

                if ($request->acctypes) {
                        $show19 = $totalcurl19->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show19 = $totalcurl19;
                        
                }
                
        } else {
                $show19 = $totalcurl19;
        }
                $query19 = $show19->where('note_posisi_produk_pekerjaan', '=', 'NEW MURNI')->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
                // dd($query13);
        //20
        $totalcurl20 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_ytd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(akhir as BIGINT)) as endd'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_ytd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');               
                
        if ($request->perorangan != null || $request->tabungan != null || $request->region != null || $request->type != null || $request->group != null || $request->acctypes != null) {
                if ($request->region != null) {
                        $show20 = $totalcurl20->where('db_reza.dbo.tbl_chart_acc_ytd.region','LIKE' ,$request->region);
                } else {
                        $show20 = $totalcurl20;
                }

                if ($request->type != null) {
                        $show20 = $totalcurl20->where('funding.dbo.prm_grouping_produk.Jenis', $request->type);
                } else {
                        $show20 = $totalcurl20;
                }
                
                if ($request->group != null ) {
                        $show20 = $totalcurl20->where('funding.dbo.prm_grouping_produk.group_prod_3', $request->group);
                } else {
                        $show20 = $totalcurl20;
                }

                if ($request->acctypes) {
                        $show20 = $totalcurl20->whereIn('funding.dbo.prm_grouping_produk.acc_type', $request->acctypes);
                } else {
                        $show20 = $totalcurl20;
                }
                
        } else {
                $show20 = $totalcurl20;
        }
                $query20 = $show20->where('note_posisi_produk_pekerjaan', '=', 'NEW MURNI')->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();



        $balance = [];
        $balance2 = [];
        $total1 = [];
        $total2 = [];
        $total3 = [];
        $total4 = [];
        $total5 = [];
        $total6 = [];
        $total7 = [];
        $total8 = [];
        $total9 = [];
        $total10 = [];
        $total11 = [];
        $total12 = [];
        $total13 = [];
        $total14 = [];
        $total15 = [];
        $total16 = [];
        $total17 = [];
        $total18 = [];
        $month = [];
        $month2 = [];
        $month3 = [];
        $month4 = [];
        $month5 = [];
        $month6 = [];
        $month7 = [];
        $month8 = [];
        $month9 = [];
        $month10 = [];
        $month11 = [];
        $month12 = [];
        $month13 = [];
        $month14 = [];
        $month15 = [];
        $month16 = [];
        $month17 = [];
        $month18 = [];
        $month19 = [];
        $month20 = [];

        foreach ($query1 as $chart) {
                $balance[] = (int)$chart->balance;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month[] = $vert;
        }

        foreach ($query2 as $chart) {
                $balance2[] = (int)$chart->balance;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month2[] = $vert;
        }

        foreach ($query3 as $chart) {
                $total1[] = (int)$chart->total;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month3[] = $vert;
        }

        foreach ($query4 as $chart) {
                $total2[] = (int)$chart->total;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month4[] = $vert;
        }

        foreach ($query5 as $chart) {
                $total3[] = (int)$chart->total;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month5[] = $vert;
        }
        
        foreach ($query6 as $chart) {
                $total4[] = (int)$chart->total;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month6[] = $vert;
        }

        foreach ($query7 as $chart) {
                $total5[] = (int)$chart->total;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month7[] = $vert;
        }
        
        foreach ($query8 as $chart) {
                $total6[] = (int)$chart->total;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month8[] = $vert;
        }

        foreach ($query9 as $chart) {
                $total7[] = (int)$chart->total;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month9[] = $vert;
        }
        
        foreach ($query10 as $chart) {
                $total8[] = (int)$chart->total;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month10[] = $vert;
        }

        foreach ($query11 as $chart) {
                $total9[] = (int)$chart->total;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month11[] = $vert;
        }
        
        foreach ($query12 as $chart) {
                $total10[] = (int)$chart->total;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month12[] = $vert;
        }

        foreach ($query13 as $chart) {
                $total11[] = (int)$chart->start;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month13[] = $vert;
        }
        
        foreach ($query14 as $chart) {
                $total12[] = (int)$chart->start;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month14[] = $vert;
        }

        foreach ($query15 as $chart) {
                $total13[] = (int)$chart->start;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month15[] = $vert;
        }
        
        foreach ($query16 as $chart) {
                $total14[] = (int)$chart->start;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month16[] = $vert;
        }

        foreach ($query17 as $chart) {
                $total15[] = (int)$chart->endd;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month17[] = $vert;
        }
        
        foreach ($query18 as $chart) {
                $total16[] = (int)$chart->endd;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month18[] = $vert;
        }

        foreach ($query19 as $chart) {
                $total17[] = (int)$chart->endd;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month19[] = $vert;
        }
        
        foreach ($query20 as $chart) {
                $total18[] = (int)$chart->endd;
                $con = DateTime::createFromFormat('!m', $chart->bulan);
                $vert = $con->format('F');
                $month20[] = $vert;
        }
        
        return view('matrix.performance', compact('cari', 'regions', 'parameter', 'types' ,'balance', 'month' , 'balance2', 'month2', 'month3', 'month4', 'month5', 'month6', 'month7', 'month8', 'month9', 'month10', 'month11', 'month12', 'month13', 'month14', 'month15', 'month16', 'month17', 'month18', 'month19', 'month20', 'total1' , 'total2', 'total3' , 'total4', 'total5' , 'total6', 'total7' , 'total8', 'total9' , 'total10', 'total11' , 'total12', 'total13' , 'total14', 'total15' , 'total16', 'total17' , 'total18', 'perorangan', 'type', 'group', 'tabungan', 'region', 'obj'
        ,'query1', 'query2', 'query3', 'query4', 'query5', 'query6', 'query7', 'query8', 'query9', 'query10', 'query11', 'query12', 'query13', 'query14', 'query15', 'query16', 'query17', 'query18', 'query19', 'query20'));
    }

    public function exportPerformance()
    {
        // $aut = DB::connection('sqlsrv158')->table('db_reza.dbo.grafik_cur_balance')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(saldo as BIGINT)) as balance'))->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
        return view('matrix.export', compact('aut'));
    }

//     public function halamanutama(){
//         $halamanutama = $request->halamanutama;

//         $saldo_deposito = DB::connection('sqlsrv158')->table('funding.dbo.sum_dpk_daily_2020')->select(DB::raw("CONVERT(INT, tanggal) as tanggal"), 'type_product')->where('tanggal', '!=', null)->where('tanggal', '<=', 18)->distinct()->orderBy('tanggal', 'asc')->get();

                
//         $saldo= select tanggal, sum(ending_bal_tot_idr)saldo

//         from [dbo].[sum_dpk_daily_2020]

//         where TANGGAL in ('2020-01-29') and type_product in ('tabungan') and cus_type not in ('perusahaan-bank')

//         and [BNI_ACCOUNT_TYPE] in ('2302')

//         group by tanggal

//         order by tanggal asc
//     }

}

//umam query
