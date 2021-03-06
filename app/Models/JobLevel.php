<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobLevel extends Model
{
    protected $fillable = ['name'];

    public function users()
    {
    	return $this->hasMany(User::class);
    }

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
