<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'slug', 'permission_id'];

    public function users()
    {
    	return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function hasPermissions()
    {
        return $this->permissions->count() != 0;
    }

    public function sub_menus()
    {
        return $this->hasMany(SubMenu::class);
    }

    // public function hasChilds()
    // {
    //     return $this->permissions
    // }
}
