<?php

namespace App\Models;

use App\NotifiesAdminsOnDelete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Role extends Model
{
    use HasFactory, Notifiable, NotifiesAdminsOnDelete;
    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_roles');
    }
}
