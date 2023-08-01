<?php

namespace App\Models;

use App\Interfaces\ModelColumns;
use App\Traits\DBFetch;
use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model implements ModelColumns
{
    use HasFactory, ModelHelper, DBFetch;

    private $main_table = 'roles';
    private static $current_class = __CLASS__;
    private $menu = 'App\Models\RolePermission';

    protected $fillable = ['title'];

    public function permissions(){
        return $this->hasMany(RolePermission::class, 'role_id', 'id');
    }
}
