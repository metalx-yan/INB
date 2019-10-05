<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Permission::where('permission_id', '!=', null)->get();
        $applications = Permission::where('permission_id', null)->get();

        return view('menus.index', compact('menus', 'applications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'permission_id' => 'required',
            ]);
            
        foreach (Permission::whereNull('permission_id')->get() as $parent) {
            if($request->permission_id == $parent->id)
            {
                Permission::create([
                    'permission_id' => $request->permission_id,
                    'name' => $request->name,
                    'slug' => Str::slug($parent->name . " - " . $request->name)
                ]);
            }
        }

                
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menus = Permission::find($id);
        $application = Permission::where('permission_id', null)->get();

        return view('menus.edit', compact('menus', 'application'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $update = Permission::findOrFail($id);
        $update->permission_id      = $request->permission_id;
        $update->name               = $request->name;
        $update->slug               = Str::slug($request->name);
        $update->save();

        return redirect()->route('menus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menus = Permission::find($id);
        $menus->delete($menus);

        return redirect()->back();
    }
}
