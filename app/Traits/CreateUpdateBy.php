<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Adding created_by and updated_by to model's boot method
 */
trait CreateUpdateBy
{
    public static function bootCreateUpdateBy()
    {
        static::creating(function (Model $model) {
            if (Auth::check()) {
                $model->created_by = Auth::user()->id;
            }
        });

        static::updating(function (Model $model) {
            if (Auth::check()) {
                $model->updated_by = Auth::user()->id;
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------*/


    public function getCreatedByAttribute($value)
    {

        if (!is_null($value)) {
            $user = User::find($value);
            if ($user) {
                return $user;
            }
        }
        return '';
    }

    public function getUpdatedByAttribute($value)
    {
        if (!is_null($value)) {
            $user = User::find($value);
            if ($user) {
                return $user;
            }
        }
        return '';
    }
}
