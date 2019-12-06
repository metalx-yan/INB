<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Input;
use App\Models\User;
use App\Models\JobLevel;
use App\Models\Level;
use App\Models\Region;
use App\Models\ManagementUnit;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Storage;
use Intervention\Image\ImageManagerStatic as Image;
// use App\Http\Controllers\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        $joblevel = JobLevel::all();
        $level = Level::all();
        $region = Region::all();
        $managementunit = ManagementUnit::all();
        $parent = Permission::where('permission_id', '=', null)->get();
        $permission = Permission::where('permission_id', '!=', null)->get();
        return view('registrationuser.index', compact('user','joblevel', 'level', 'region', 'managementunit', 'permission','parent'));
    }

    public function menus(Request $request)
    {
        $parent = $request->input('id');
        $menus = Permission::where('permission_id', '!=', $parent)->get();
        
        return response()->json($menus);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // 

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
        // dd($request->all());
        // dd(isset($request->name));
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:20|unique:users',
            // 'password' => 'required|string|min:6|confirmed',
            'level_id' => 'required',
            'job_level_id' => 'required',
            'region_id' => 'required',
            'management_unit_id' => 'required',
            // 'permissions' => 'required',
            // 'major_id'  =>  '',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => 'user',
            'level_id' => $request->level_id,
            'job_level_id' => $request->job_level_id,
            'region_id' => $request->region_id,
            'management_unit_id' => $request->management_unit_id,
            // 'permissions' => $request->management_unit_id,
        ]);

        if (isset($request['permissions'])) {
            foreach ($request['permissions'] as $permission) {
                $user->permissions()->attach(Permission::find($permission));
            }
        } else {
            return redirect()->back();
        }

        \LogActivity::addToLog(ucfirst(Auth::user()->name) . " Create a User ");
         
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
        
    }

    public function viewData($name)
    {
        $view = User::where('name', $name)->first();

        $applications = Permission::whereNull('permission_id')->get();

        return view('registrationuser.view', compact('view', 'applications'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::find($id);
        $applications = Permission::whereNull('permission_id')->get();
        // $parent = Permission::where('permission_id', '=', null)->get();
        

        return view('registrationuser.edit', compact('users', 'arr', 'applications'));
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
        $update = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:20',
            // 'password' => 'required|string|min:6|confirmed',
            'level_id' => 'required',
            'job_level_id' => 'required',
            'region_id' => 'required',
            'management_unit_id' => 'required',
            // 'permissions' => 'required',
            // 'major_id'  =>  '',
        ]);

        // $hash = Hash::make($request->password);

        $update = User::findOrFail($id);
        $update->name               = $request->name;
        $update->username           = $request->username;
        // $update->password           = $hash;
        $update->level_id           = $request->level_id;
        $update->job_level_id       = $request->job_level_id;
        $update->region_id          = $request->region_id;
        $update->management_unit_id = $request->management_unit_id;
        $update->save();
        
        $update->permissions()->sync($request->permissions);

        return redirect()->route('user.index');
    }

    public function updatePassword(Request $request, $id)
    {
        // dd($request);
        
        $update = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $update                 = User::findOrFail($id);
        $update->password       = $request->password;
        $update->save();
        
        return redirect()->back();
    }

    public function resetPassword(Request $request, $id)
    {
        // $update = $request->validate([
        //     'password' => 'required|string|min:6|confirmed',
        // ]);

        $update                 = User::findOrFail($id);
        $update->password       = 'user';
        $update->save();
        
        return redirect()->back();
    }

    public function uploadPhoto(Request $request, $id)
    {
        
        $update  = User::findOrFail($id);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time(). '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(200,200)->save(public_path('/images/profile/'. $filename));
            $oldFilename = $update->avatar;

            $update->avatar  = $filename;

            Storage::delete($oldFilename);
        }
        
        $update->save();

        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->back();
    }

    public function logActivity()
    {
        $logs = \LogActivity::logActivityLists();
        return view('registrationuser.log',compact('logs'));
    }

    public function myTestAddToLog()
    {
        \LogActivity::addToLog('My Testing Add To Log.');
        dd('log insert successfully.');
    }

}
