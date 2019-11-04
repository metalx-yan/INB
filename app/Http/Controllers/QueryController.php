<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use App\Models\JobLevel;
use App\Models\Account;
use Carbon\Carbon;
use Request as Req;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Exports\AccountExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Storage;
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
        
        $acc = Account::all()->groupBy(function ($val) {
            return $val->created_at->format('Y');
        });
        
        $accn = Account::all()->groupBy(function ($val) {
            return $val->created_at->format("m");
        });

        $columns = Schema::getColumnListing('accounts');
        
        $dataBranch = is_array($branch) ? $branch : array($branch);

        $dataProduct = is_array($product) ? $product : array($product);

        $records = DB::table('accounts')->whereIn('product_id', $dataProduct)->whereIn('branch_id', $dataBranch)->where('status', $status)->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
        
        return view('query.balance', compact('regions', 'categories', 'account', 'acc', 'query', 'columns', 'records', 'accn'));
    }

    public function getFile()
    {   
        $month = Req::input('months');
        
        $year = Req::input('years');
 
        $columns = Schema::getColumnListing('accounts');

        $categories = Category::all();

        $acc = Account::all()->groupBy(function ($val) {
            return $val->created_at->format('Y');
        });
        
        $accn = Account::all()->groupBy(function ($val) {
            return $val->created_at->format("m");
        });

        return view('query.upload', compact('acc', 'accn', 'columns', 'categories'));
    }
    public function branches()
    {
        $region_id = Req::input('region_id');

        if(isset($region_id)){
            $branches = Branch::where('region_id', '=' , $region_id)->get();
        } else {
            $branches = Branch::all();
        }
        
        return response()->json($branches);
    }

    public function products()
    {
        $category_id = Req::input('category_id');

        if(isset($category_id)){
            $products = Product::where('category_id', '=', $category_id)->get();
        } else {
            $products = Product::all();
        }

        return response()->json($products);
    }

    public function months()
    {
        $created = Req::input('years');
        
        $months = Account::whereMonth('created_at', '=', '12')->get();
        dd($created);

        return response()->json($months);
    }

}
