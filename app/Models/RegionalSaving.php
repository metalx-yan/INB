<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegionalSaving extends Model
{
    protected $fillable = ['date', 'number_account', 'balance', 'product_id', 'region_id', 'type_product_id', 'group_product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function type_product()
    {
        return $this->belongsTo(TypeProduct::class);
    }

    public function group_product()
    {
        return $this->belongsTo(GroupProduct::class);
    }
}
