<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'number', 'cif_key', 'cif_created_at', 'account_open', 'average', 'current_balance', 'birth_date','handphone', 'address',
        'company', 'occupation', 'status', 'monthly_income', 'gender', 'work_phone', 'home_phone', 'workplace_name', 'workplace_address',
        'email', 'indentity', 'place_of_birth', 'product_id', 'branch_id'
    ];
    
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
