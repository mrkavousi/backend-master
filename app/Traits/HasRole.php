<?php
namespace App\Traits;

use App\Models\Type;
use App\Models\User;
use App\Permission;
use App\Role;


use Auth;
use Illuminate\Http\Request;
trait HasRole
{
    /*public function rolesE()
    {
        return $this->belongsToMany('App\Role', 'role_user');
    }*/

    /*public function hasRole($role)
    {
        if(is_string($role)) {
            return $this->roles->contains('name' , $role);
        }
        return !! $role->intersect($this->roles)->count();
    }*/

    public function getAllPermissionsAttribute()
    {
      //  return Permission::with('roles')->get();
    }

    /**
     * Get all user permissions in a flat array.
     *
     * @return array
     */
    public function getCanAttribute()
    {
        $permissions = [];
        foreach (Permission::all() as $permission) {
            if (Auth::user()->can($permission->name)) {
                $permissions[trim($permission->name)] = true;
            } else {
                $permissions[$permission->name] = false;
            }
        }
        return $permissions;
    }
}
