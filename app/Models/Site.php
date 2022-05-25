<?php

namespace App\Models;

use App\Traits\CreateUpdateBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use HasFactory, CreateUpdateBy, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'active',
        'created_by',
        'updated_by'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------*/

    /**
     * @return App\Models\Users
     */
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class);
    }

    public function creator()
    {
        return $this->hasOne(User::class,'id', 'createdBy');
    }


    public function zones()
    {
        return $this->hasMany(\App\Models\Zone::class, 'site_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------*/

    public function getCodeAndNameAttribute()
    {
        return $this->code . ' - ' . $this->name;
    }
}
