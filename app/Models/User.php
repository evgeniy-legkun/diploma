<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    const ROLE_COURIER = 1;
    const ROLE_WAREHOUSE_MANAGER = 2;
    const ROLE_ADMINISTRATOR = 3;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'role'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $appends = ['created'];

    public function getCreatedAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

}
