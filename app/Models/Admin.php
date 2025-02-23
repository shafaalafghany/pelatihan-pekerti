<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string $created_at
 * @property string $updated_at
 */
class Admin extends AuthenticableUser
{

    protected $guard = 'admin';
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'admin';

    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'role', 'created_at', 'updated_at'];

    protected $hidden = ['password'];
}
