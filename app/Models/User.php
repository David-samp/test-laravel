<?php

namespace App\Models;

use App\Scopes\UserScope;
use App\Traits\CreateUpdateBy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'settings' => 'array',
    ];

    protected $appends = [
        'rolesList',
        'home'
    ];

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------*/

    /**
     * Retrieve a setting with a given name or fall back to the default.
     *
     */
    public function setting(string $name, $default = null)
    {
        if (array_key_exists($name, $this->settings)) {
            return $this->settings[$name];
        }
        return $default;
    }

    /**
     * Update one or more settings and then optionally save the model.
     *
     */
    public function settings(array $revisions, bool $save = true): self
    {
        $this->settings = array_merge($this->settings, $revisions);
        if ($save) {
            $this->save();
        }
        return $this;
    }

}
