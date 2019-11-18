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
// use Illuminate\Support\Facades\Input;

class QueryController extends Controller
{
    public function getBalance(Request $request)
    {   
        // dd();
        $regions = Region::all();

        $categories = Category::all();
        
        $account = Req::input('accounts');

        $branch = Req::input('branches');

        $product = Req::input('products');

        $status = Req::input('status');
        // dd($status);
        $month = Req::input('months');

        $year = Req::input('years');

        $years = Account::select(DB::raw('YEAR(created_at) as year'))->distinct()->orderBy('year')->get();

        $columns = Schema::getColumnListing('accounts');
        
        $dataBranch = is_array($branch) ? $branch : array($branch);

        $dataProduct = is_array($product) ? $product : array($product);

        $records = DB::table('accounts')->whereIn('product_id', $dataProduct)->whereIn('branch_id', $dataBranch)->where('status', $status)->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
        
        return view('query.balance', compact('regions', 'categories', 'account', 'query', 'status' ,'columns', 'records', 'years'));
    }

    public function getFilePost(Request $request)
    {
        $content = File::get($request->upload->getRealPath());

        $array = explode(PHP_EOL, $content);

        $query = Category::find($request->categories)->accounts()->whereIn($request->number ,$array)->whereYear('accounts.created_at', $request->years)->whereMonth('accounts.created_at', $request->months)->get();

        $columns = Schema::getColumnListing('accounts');

        $years = Account::select(DB::raw('YEAR(created_at) as year'))->distinct()->orderBy('year')->get();
        
        $categories = Category::all();
        
        $account = Req::input('accounts');

        return view('query.upload', ["query" => $query, "categories" => $categories, "columns" => $columns, 'account' => $account , 'years' => $years ]);
    }

    public function getFile(Request $request)
    {   
        $columns = Schema::getColumnListing('accounts');

        $account = Req::input('accounts');

        $categories = Category::all();

        $years = Account::select(DB::raw('YEAR(created_at) as year'))->distinct()->orderBy('year')->get();

        $query = null;

        return view('query.upload', compact('years', 'columns', 'categories', 'account', 'query'));
    }

    public function getPosition(Request $request)
    {
        $types = TypeProduct::all();

        $result1 = RegionalSaving::select('type_product_id', 'group_product_id', DB::raw('sum(balance) as balance, sum(number_account) as number_account'))
                ->where('type_product_id', 1)->whereYear('date', $request->year)->whereMonth('date', $request->month)->whereDay('date', $request->day)->where('region_id', 1)
                ->groupBy('type_product_id', 'group_product_id')->get();

        $result2 = RegionalSaving::select('type_product_id', 'group_product_id', DB::raw('sum(balance) as balance, sum(number_account) as number_account'))
                ->where('type_product_id', 2)->whereYear('date', $request->year)->whereMonth('date', $request->month)->whereDay('date', $request->day)->where('region_id', 1)
                ->groupBy('type_product_id', 'group_product_id')->get();

        $result3 = RegionalSaving::select('type_product_id', 'group_product_id', DB::raw('sum(balance) as balance, sum(number_account) as number_account'))
                ->where('type_product_id', 3)->whereYear('date', $request->year)->whereMonth('date', $request->month)->whereDay('date', $request->day)->where('region_id', 1)
                ->groupBy('type_product_id', 'group_product_id')->get();

        $result4 = RegionalSaving::select('type_product_id', 'group_product_id', DB::raw('sum(balance) as balance, sum(number_account) as number_account'))
                ->whereYear('date', $request->year)->whereMonth('date', $request->month)->whereDay('date', $request->day)->where('region_id', 1)
                ->groupBy('type_product_id', 'group_product_id')->get();
        
        // ->where('region_id', 1)->where('type_product_id')->where('group_product_id')->where('product_id')
                
        $charts = RegionalSaving::select('region_id', DB::raw('sum(balance) as balance, sum(number_account) as number_account'))
        ->whereYear('date', '2019')->whereMonth('date', '11')->whereDay('date', '08');
        
        if (is_null($request->regions[0])) {
               $c = $charts->groupBy('region_id')->orderBy('region_id', 'asc')->get();
        } else {
               $c = $charts->where('region_id', $request->regions)->groupBy('region_id')->orderBy('region_id', 'asc')->get();
        }

        $null = is_null($request->year);
        
        $regions = Region::all();
        
        $reg = [];
        $balance = [];
        $number_account = [];
                
        foreach ($c as $chart) {
            $reg[] = $chart->region->code;
            $balance[] = $chart->balance;
            $number_account[] = (int)$chart->number_account;
        }
     
        $years = RegionalSaving::select(DB::raw('YEAR(date) as year'))->distinct()->orderBy('year')->get();
        
        return view('balance.position', compact('regions', 'years', 'types', 'result1', 'result2', 'result3', 'result4', 'charts', 'reg', 'balance', 'number_account', 'null'));
    }

    public function getAverage(Request $request)
    {
        // dd($request->all());
        $getYear = Carbon::now()->format('Y');
        
        $startDate = new Carbon($getYear .'-01-01');
        
        $start = $startDate->format('Y-m-d');

        $end = new DateTime();

        $end = $request->year .'-'. $request->month . '-' . $request->day;

        $all_dates = [];

        while ($startDate->lte($end)){

            $all_dates[] = $startDate->toDateString();

            $startDate->addDay();
        }

        $count = count($all_dates);

        $result1 = RegionalSaving::select('type_product_id', 'group_product_id', DB::raw("(sum(balance)/$count) as balance"))
                ->where('type_product_id', 1)->where('date', '>=', $start)->where('date', '<=', $end)->where('region_id', 1)
                ->groupBy('type_product_id', 'group_product_id')->get();

        $result2 = RegionalSaving::select('type_product_id', 'group_product_id', DB::raw("(sum(balance)/$count) as balance"))
                ->where('type_product_id', 2)->where('date', '>=', $start)->where('date', '<=', $end)->where('region_id', 1)
                ->groupBy('type_product_id', 'group_product_id')->get();

        $result3 = RegionalSaving::select('type_product_id', 'group_product_id', DB::raw("(sum(balance)/$count) as balance"))
                ->where('type_product_id', 3)->where('date', '>=', $start)->where('date', '<=', $end)->where('region_id', 1)
                ->groupBy('type_product_id', 'group_product_id')->get();

        $result4 = RegionalSaving::select('type_product_id', 'group_product_id', DB::raw("(sum(balance)/$count) as balance"))
                ->where('date', '>=', $start)->where('date', '<=', $end)->where('region_id', 1)
                ->groupBy('type_product_id', 'group_product_id')->get();
        // dd(is_null($request->year));
        $regions = Region::all();

        $charts = RegionalSaving::select('region_id', DB::raw("(sum(balance)/$count) as balance"))
                ->where('date', '>=', $start)->where('date', '<=', $end);

        if (is_null($request->regions[0])) {
                $c = $charts->groupBy('region_id')->get();
        } else {
                $c = $charts->where('region_id', $request->regions)->groupBy('region_id')->get();
        }

        $years = RegionalSaving::select(DB::raw('YEAR(date) as year'))->distinct()->orderBy('year')->get();

        $reg = [];
        $balance = [];
                
        foreach ($c as $chart) {
            $reg[] = $chart->region->code;
            $balance[] = $chart->balance;
        }

        $date = RegionalSaving::select('date')->distinct()->get();

        $null = is_null($request->year);
        // dd(is_null($null));
        return view('balance.average', compact('result1', 'result2', 'result3', 'result4','regions', 'reg', 'balance', 'years', 'ar', 'date', 'null'));
    }

    public function getMatrix(Request $request)
    {
        $regions = Region::all();

        $parameter = ParameterProduct::select('type_product_id')->distinct()->get();

        $totalcurl1 = CurBalance::select(DB::raw('MONTH(date) as month, sum(balance) as balance'))
                ->leftJoin('parameter_products', function($join) {
                        $join->on('cur_balances.acc_type_id', '=', 'parameter_products.acc_type_id');
                })
                ->whereYear('date', '2018')->where('region_id', 'LIKE', 1)->where('type_product_id', 'LIKE', 1)->where('group_product_third', 'LIKE', 'prod3')->whereIn('cur_balances.acc_type_id', [1])
                ->groupBy('month')->orderBy('month')->get();
        
        $totalcurl2 = CurBalance::select(DB::raw('MONTH(date) as month, sum(balance) as balance'))
                ->leftJoin('parameter_products', function($join) {
                        $join->on('cur_balances.acc_type_id', '=', 'parameter_products.acc_type_id');
                })
                ->whereYear('date', '2019')->where('region_id', 'LIKE', 1)->where('type_product_id', 'LIKE', 1)->where('group_product_third', 'LIKE', 'prod3')->whereIn('cur_balances.acc_type_id', [1])
                ->groupBy('month')->orderBy('month')->get();

        $totalaccount1 = AccountMtd::select(DB::raw('MONTH(date) as month, sum(total_acc) as total'))
                ->leftJoin('parameter_products', function($join) {
                        $join->on('account_mtds.acc_type_id', '=', 'parameter_products.acc_type_id');
                })
                ->whereYear('date', '2018')->where('region_id', 'LIKE', 1)->where('type_product_id', 'LIKE', 1)->where('group_product_third', 'LIKE', 'prod3')->whereIn('account_mtds.acc_type_id', [1])
                ->groupBy('month')->orderBy('month')->get();

        $totalaccount2 = AccountMtd::select(DB::raw('MONTH(date) as month, sum(total_acc) as total'))
                ->leftJoin('parameter_products', function($join) {
                        $join->on('account_mtds.acc_type_id', '=', 'parameter_products.acc_type_id');
                })
                ->whereYear('date', '2019')->where('region_id', 'LIKE', 1)->where('type_product_id', 'LIKE', 1)->where('group_product_third', 'LIKE', 'prod3')->whereIn('account_mtds.acc_type_id', [1])
                ->groupBy('month')->orderBy('month')->get();

        $totalmtd1 = AccountMtd::select(DB::raw('MONTH(date) as month, sum(total_acc) as total'))
                ->leftJoin('parameter_products', function($join) {
                        $join->on('account_mtds.acc_type_id', '=', 'parameter_products.acc_type_id');
                })
                ->whereYear('date', '2018')->where('region_id', 'LIKE', 1)->where('position_product', 'LIKE', 'out murni')->where('type_product_id', 'LIKE', 1)->where('group_product_third', 'LIKE', 'prod3')->whereIn('account_mtds.acc_type_id', [1])
                ->groupBy('month')->orderBy('month')->get();

        $totalmtd2 = AccountMtd::select(DB::raw('MONTH(date) as month, sum(total_acc) as total'))
                ->leftJoin('parameter_products', function($join) {
                        $join->on('account_mtds.acc_type_id', '=', 'parameter_products.acc_type_id');
                })
                ->whereYear('date', '2019')->where('region_id', 'LIKE', 1)->where('position_product', 'LIKE', 'out murni')->where('type_product_id', 'LIKE', 1)->where('group_product_third', 'LIKE', 'prod3')->whereIn('account_mtds.acc_type_id', [1])
                ->groupBy('month')->orderBy('month')->get();

        $totalytd1 = AccountYtd::select(DB::raw('MONTH(date) as month, sum(total_acc) as total'))
                ->leftJoin('parameter_products', function($join) {
                        $join->on('account_ytds.acc_type_id', '=', 'parameter_products.acc_type_id');
                })
                ->whereYear('date', '2018')->where('region_id', 'LIKE', 1)->where('position_product', 'LIKE', 'out murni')->where('type_product_id', 'LIKE', 1)->where('group_product_third', 'LIKE', 'prod3')->whereIn('account_ytds.acc_type_id', [1])
                ->groupBy('month')->orderBy('month')->get();

        $totalytd2 = AccountYtd::select(DB::raw('MONTH(date) as month, sum(total_acc) as total'))
                ->leftJoin('parameter_products', function($join) {
                        $join->on('account_ytds.acc_type_id', '=', 'parameter_products.acc_type_id');
                })
                ->whereYear('date', '2019')->where('region_id', 'LIKE', 1)->where('position_product', 'LIKE', 'out murni')->where('type_product_id', 'LIKE', 1)->where('group_product_third', 'LIKE', 'prod3')->whereIn('account_ytds.acc_type_id', [1])
                ->groupBy('month')->orderBy('month')->get();
        
        $totalmtdnew1 = AccountMtd::select(DB::raw('MONTH(date) as month, sum(total_acc) as total'))
                ->leftJoin('parameter_products', function($join) {
                        $join->on('account_mtds.acc_type_id', '=', 'parameter_products.acc_type_id');
                })
                ->whereYear('date', '2018')->where('region_id', 'LIKE', 1)->where('position_product', 'LIKE', 'new murni')->where('type_product_id', 'LIKE', 1)->where('group_product_third', 'LIKE', 'prod3')->whereIn('account_mtds.acc_type_id', [1])
                ->groupBy('month')->orderBy('month')->get();

        $totalmtdnew2 = AccountMtd::select(DB::raw('MONTH(date) as month, sum(total_acc) as total'))
                ->leftJoin('parameter_products', function($join) {
                        $join->on('account_mtds.acc_type_id', '=', 'parameter_products.acc_type_id');
                })
                ->whereYear('date', '2019')->where('region_id', 'LIKE', 1)->where('position_product', 'LIKE', 'new murni')->where('type_product_id', 'LIKE', 1)->where('group_product_third', 'LIKE', 'prod3')->whereIn('account_mtds.acc_type_id', [1])
                ->groupBy('month')->orderBy('month')->get();

        $totalytdnew1 = AccountYtd::select(DB::raw('MONTH(date) as month, sum(total_acc) as total'))
                ->leftJoin('parameter_products', function($join) {
                        $join->on('account_ytds.acc_type_id', '=', 'parameter_products.acc_type_id');
                })
                ->whereYear('date', '2018')->where('region_id', 'LIKE', 1)->where('position_product', 'LIKE', 'new murni')->where('type_product_id', 'LIKE', 1)->where('group_product_third', 'LIKE', 'prod3')->whereIn('account_ytds.acc_type_id', [1])
                ->groupBy('month')->orderBy('month')->get();

        $totalytdnew2 = AccountYtd::select(DB::raw('MONTH(date) as month, sum(total_acc) as total'))
                ->leftJoin('parameter_products', function($join) {
                        $join->on('account_ytds.acc_type_id', '=', 'parameter_products.acc_type_id');
                })
                ->whereYear('date', '2019')->where('region_id', 'LIKE', 1)->where('position_product', 'LIKE', 'new murni')->where('type_product_id', 'LIKE', 1)->where('group_product_third', 'LIKE', 'prod3')->whereIn('account_ytds.acc_type_id', [1])
                ->groupBy('month')->orderBy('month')->get();
        
        $closedcurmtd1 = AccountMtd::select(DB::raw('MONTH(date) as month, sum(start) as start'))
                ->leftJoin('parameter_products', function($join) {
                        $join->on('account_mtds.acc_type_id', '=', 'parameter_products.acc_type_id');
                })
                ->whereYear('date', '2018')->where('region_id', 'LIKE', 1)->where('position_product', 'LIKE', 'out murni')->where('type_product_id', 'LIKE', 1)->where('group_product_third', 'LIKE', 'prod3')->whereIn('account_mtds.acc_type_id', [1])
                ->groupBy('month')->orderBy('month')->get();

        $closedcurmtd2 = AccountMtd::select(DB::raw('MONTH(date) as month, sum(start) as start'))
                ->leftJoin('parameter_products', function($join) {
                        $join->on('account_mtds.acc_type_id', '=', 'parameter_products.acc_type_id');
                })
                ->whereYear('date', '2019')->where('region_id', 'LIKE', 1)->where('position_product', 'LIKE', 'out murni')->where('type_product_id', 'LIKE', 1)->where('group_product_third', 'LIKE', 'prod3')->whereIn('account_mtds.acc_type_id', [1])
                ->groupBy('month')->orderBy('month')->get();

        $closedcurytd1 = AccountYtd::select(DB::raw('MONTH(date) as month, sum(start) as start'))
                ->leftJoin('parameter_products', function($join) {
                        $join->on('account_ytds.acc_type_id', '=', 'parameter_products.acc_type_id');
                })
                ->whereYear('date', '2018')->where('region_id', 'LIKE', 1)->where('position_product', 'LIKE', 'out murni')->where('type_product_id', 'LIKE', 1)->where('group_product_third', 'LIKE', 'prod3')->whereIn('account_ytds.acc_type_id', [1])
                ->groupBy('month')->orderBy('month')->get();

        $closedcurytd2 = AccountYtd::select(DB::raw('MONTH(date) as month, sum(start) as start'))
                ->leftJoin('parameter_products', function($join) {
                        $join->on('account_ytds.acc_type_id', '=', 'parameter_products.acc_type_id');
                })
                ->whereYear('date', '2019')->where('region_id', 'LIKE', 1)->where('position_product', 'LIKE', 'out murni')->where('type_product_id', 'LIKE', 1)->where('group_product_third', 'LIKE', 'prod3')->whereIn('account_ytds.acc_type_id', [1])
                ->groupBy('month')->orderBy('month')->get();

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
        $month = [];
        $month2 = [];

        foreach ($totalcurl1 as $chart) {
                $balance[] = $chart->balance;
                $con = DateTime::createFromFormat('!m', $chart->month);
                $vert = $con->format('F');
                $month[] = $vert;
        }

        foreach ($totalcurl2 as $chart) {
                $balance2[] = $chart->balance;
                $con = DateTime::createFromFormat('!m', $chart->month);
                $vert = $con->format('F');
                $month2[] = $vert;
        }

        foreach ($totalaccount1 as $chart) {
                $total1[] = (int)$chart->total;
        }
        
        foreach ($totalaccount2 as $chart) {
                $total2[] = (int)$chart->total;
        }

        foreach ($totalmtd1 as $chart) {
                $total3[] = (int)$chart->total;
        }
        
        foreach ($totalmtd2 as $chart) {
                $total4[] = (int)$chart->total;
        }

        foreach ($totalytd1 as $chart) {
                $total5[] = (int)$chart->total;
        }
        
        foreach ($totalytd2 as $chart) {
                $total6[] = (int)$chart->total;
        }

        foreach ($totalmtdnew1 as $chart) {
                $total7[] = (int)$chart->total;
        }
        
        foreach ($totalmtdnew2 as $chart) {
                $total8[] = (int)$chart->total;
        }

        foreach ($totalytdnew1 as $chart) {
                $total9[] = (int)$chart->total;
        }
        
        foreach ($totalytdnew2 as $chart) {
                $total10[] = (int)$chart->total;
        }

        foreach ($closedcurmtd1 as $chart) {
                $total11[] = (int)$chart->start;
        }
        
        foreach ($closedcurmtd2 as $chart) {
                $total12[] = (int)$chart->start;
        }

        foreach ($closedcurytd1 as $chart) {
                $total13[] = (int)$chart->start;
        }
        
        foreach ($closedcurytd2 as $chart) {
                $total14[] = (int)$chart->start;
        }
        
        return view('matrix.performance', compact('regions', 'parameter', 'balance', 'month' , 'balance2', 'month2', 'total1' , 'total2', 'total3' , 'total4', 'total5' , 'total6', 'total7' , 'total8', 'total9' , 'total10', 'total11' , 'total12', 'total13' , 'total14'));
    }

}
