<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name' , 'guard_name'];

    public function roles(){
        $this->belongsToMany(Role::class , 'role_has_permissions' , 'role_id' , 'permission_id');
    }

    
}
