<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['account_type', 'sub_category' ,'name', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function regional_savings()
    {
        return $this->hasMany(RegionalSaving::class);
    }
    
    public function parameter_products()
    {
        return $this->hasMany(ParameterProduct::class);
    }
}
