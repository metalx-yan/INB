<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupProduct extends Model
{
    protected $fillable = ['name'];

    public function regional_savings()
    {
        return $this->hasMany(RegionalSaving::class);
    }
}
