<?php

namespace App\Models;

use Cache;
use Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username','password', 'region_id', 'level_id', 'job_level_id', 'management_unit_id', 'last_sign_in_at', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'last_sign_in_at'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function job_level()
    {
    	return $this->belongsTo(JobLevel::class);
    }

    public function level()
    {
    	return $this->belongsTo(Level::class);
    }

    public function hasLevel($level)
    {
        if ($this->level()->where('name', $level)->first()) 
            {
                return true;
            }        
                return false;
    }

    public function management_unit()
    {
    	return $this->belongsTo(ManagementUnit::class);
    }

    public function region()
    {
    	return $this->belongsTo(Region::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, "permission_user")->withPivot([]);
    }
    
    public function logactivities()
    {
    	return $this->hasMany(LogActivity::class);
    }

    public function hasApplication(string $slug)
    {
        return $this->permissions()->where('slug', $slug)->first();
    }

    public function menus()
    {
        return $this->permissions->where('permission_id', '!=', null);
    }

    public function hasPermission(string $slug): bool
    {
        return is_object($this->permissions()->where('slug', $slug)->first());
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    
}
