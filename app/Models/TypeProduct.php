<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeProduct extends Model
{
    protected $fillable = ['name'];

    public function regional_savings()
    {
        return $this->hasMany(RegionalSaving::class);
    }

    public function parameter_products()
    {
        return $this->hasMany(ParameterProduct::class);
    }
}
