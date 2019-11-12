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
use Carbon\Carbon;
use Request as Req;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Exports\AccountExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Input;

class QueryController extends Controller
{
    public function getBalance()
    {   

        $regions = Region::all();

        $categories = Category::all();
        
        $account = Req::input('accounts');

        $branch = Req::input('branches');
        // dd($branch);
        $product = Req::input('products');

        $status = Req::input('status');

        $month = Req::input('months');

        $year = Req::input('years');

        $years = Account::select(DB::raw('YEAR(created_at) as year'))->distinct()->orderBy('year')->get();

        $columns = Schema::getColumnListing('accounts');
        
        $dataBranch = is_array($branch) ? $branch : array($branch);

        $dataProduct = is_array($product) ? $product : array($product);

        $records = DB::table('accounts')->whereIn('product_id', $dataProduct)->whereIn('branch_id', $dataBranch)->where('status', $status)->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
        
        return view('query.balance', compact('regions', 'categories', 'account', 'query', 'columns', 'records', 'years'));
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

        $charts = RegionalSaving::select('region_id', DB::raw('sum(balance) as balance, sum(number_account) as number_account'))
                ->whereYear('date', '2019')->whereMonth('date', '11')->whereDay('date', '08')
                ->groupBy('region_id')->orderBy('region_id', 'asc')->get();
        
                // ->where('region_id', 1)->where('type_product_id')->where('group_product_id')->where('product_id')
                
        $regions = Region::all();
        
        $reg = [];
        $balance = [];
        $number_account = [];
                
        foreach ($charts as $chart) {
            $reg[] = $chart->region->code;
            $balance[] = $chart->balance;
            $number_account[] = (int)$chart->number_account;
        }
     
        $years = RegionalSaving::select(DB::raw('YEAR(date) as year'))->distinct()->orderBy('year')->get();
        
        return view('balance.position', compact('regions', 'years', 'types', 'result1', 'result2', 'result3', 'result4', 'charts', 'reg', 'balance', 'number_account'));
    }

    public function getAverage(Request $request)
    {
        $startDate = new Carbon('2019-11-08');

        $start = $startDate->format('Y-m-d');

        $endDate = new Carbon('2019-11-09');

        $end = $endDate->format('Y-m-d');

        $all_dates = [];

        while ($startDate->lte($endDate)){

            $all_dates[] = $startDate->toDateString();

            $startDate->addDay();
        }

        $count = count($all_dates);

        $result1 = RegionalSaving::select('type_product_id', 'group_product_id', DB::raw("(sum(balance)/$count) as balance"))
                ->where('type_product_id', 1)->where('date', '>=', $start)->where('date', '<=', $end)->where('region_id', 1)
                ->groupBy('type_product_id', 'group_product_id')->get();

        // dd($result1);

        return view('balance.average', compact('result1'));
    }

}
