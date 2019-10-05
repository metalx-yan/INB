<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    protected $fillable = ['name', 'slug', 'permission_id'];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
