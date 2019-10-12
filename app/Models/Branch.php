<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['code', 'code_inc', 'name', 'name_of', 'region_id'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
