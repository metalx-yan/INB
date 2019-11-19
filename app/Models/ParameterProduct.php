<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParameterProduct extends Model
{
    public function type_product()
    {
        return $this->belongsTo(TypeProduct::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function acc_type()
    {
        return $this->belongsTo(AccType::class);
    }
}
