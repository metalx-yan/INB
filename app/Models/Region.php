<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name', 'code'];

    public function users()
    {
    	return $this->hasMany(User::class);
    }

    public function getNameAttribute($value)
    {
       return $this->attributes['name'] = strtolower($value);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function regional_savings()
    {
        return $this->hasMany(RegionalSaving::class);
    }

}
