<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_roles' ,'permission_id', 'role_id');
    }

}
