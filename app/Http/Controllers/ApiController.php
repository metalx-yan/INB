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
    public function months()
    {
        $year = Req::input('date');

        $month =  RegionalSaving::select(DB::raw('MONTH(date) as month'))->whereYear('date', $year)->distinct()->orderBy('month')->get();

        return response()->json($month);

    }

    public function monthBalance()
    {
        $year = Req::input('created_at');

        $month = Account::select(DB::raw('MONTH(created_at) as month'))->whereYear('created_at', $year)->distinct()->orderBy('month')->get();

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
        $month = Req::input('date');

        $day = RegionalSaving::select(DB::raw('DAY(date) as day'))->whereMonth('date', $month)->distinct()->orderBy('day')->get();

        return response()->json($day);

    }

    public function groups()
    {
        $type = Req::input('type_product_id');

        if (isset($type)) {
            $groups = GroupProduct::where('type_product_id', '=', $type)->get();
        }else {
            $groups = GroupProduct::all();
        }

        return response()->json($groups);
    }
    
    public function prods()
    {
        $group = Req::input('group_product_id');

        if (isset($group)) {
            $prods = Product::where('group_product_id', '=', $group)->get();
        }else {
            $prods = Product::all();
        }

        return response()->json($prods);
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
        $type_product = Req::input('type_product_id');
        
        if (isset($type_product)) {
            $parameter =  ParameterProduct::select('group_product_third as group')->where('type_product_id', $type_product)->distinct()->orderBy('group')->get();
        } else {
            $parameter =  ParameterProduct::select('group_product_third as group')->distinct()->orderBy('group')->get();
        }
        
        return response()->json($parameter);
    }

    public function accMatrix()
    {
        $group = Req::input('group_product_third');

        $option = ParameterProduct::select('acc_type_id', 'product_id')->where('group_product_third', $group)->distinct()->orderBy('acc_type_id')->get()->load('product', 'acc_type');

        return response()->json($option);
    }
}
