<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use Request as Req;

class QueryController extends Controller
{
    public function getData()
    {
        $regions = Region::all();
        $categories = Category::all();
        return view('query.balance', compact('regions', 'categories'));
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
}
