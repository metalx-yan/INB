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

class QueryController extends Controller
{
    public function getData()
    {
        $regions = Region::all();

        $categories = Category::all();
        
        $branch = Req::input('branches');
        // dd($branch);
        $product = Req::input('products');

        $account = Req::input('accounts');
        // dd($account);
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

        $records = DB::table('accounts')->where('product_id', $product)->where('branch_id', $branch)->where('status', $status)->
                    whereMonth('created_at', $month)->whereYear('created_at', $year)->get();

        return view('query.balance', compact('regions', 'categories', 'account', 'acc', 'query', 'columns', 'records', 'accn'));
    }

    public function branches()
    {
        $region_id = Req::input('region_id');
        $branches = Branch::where('region_id', '=' , $region_id)->get();
        
        return response()->json($branches);
    }

    public function products()
    {
        $category_id = Req::input('category_id');
        $products = Product::where('category_id', '=', $category_id)->get();

        return response()->json($products);
    }

    public function months()
    {
        $created = Req::input('years');
        
        $months = Account::whereMonth('created_at', '=', '12')->get();
        dd($created);

        return response()->json($months);
    }

    // public function queries()
    // {
    //     $regions = Req::input('regions');
    //     $branches = Req::input('branches');
    //     // dd($regions, $branches);
    //     $regbra = Region::where('id', $regions)->get();

    //     // dd($regbra);
    //     return view('query.balance', compact('regbra'));
    // }
}
