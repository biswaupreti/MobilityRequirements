<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'role', 'is_active'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];


    /**
     * Get user by role id and return in [id] => [name] format
     *
     * @param array $roles
     * @return array
     */
    public static function getUsersByRoles($roles = array())
    {
        if(!is_array($roles) && empty($roles)){
            return false;
        }

        $users = array();
        $users_array = User::select('id', 'name')
            ->whereIn('role', $roles)
            ->orderBy('name', 'asc')
            ->get()
            ->toArray();

        if($users_array){
            foreach($users_array as $user){
                $users[$user['id']] = $user['name'];
            }
        }

        return $users;

    }

}
