<?php

namespace App\Models;

use App\Interfaces\ModelColumns;
use App\Traits\DBFetch;
use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements ModelColumns
{
    use HasApiTokens, HasFactory, Notifiable, ModelHelper, DBFetch;

    private $main_table = 'users';
    private $pass = true;
    private static $current_class = __CLASS__;
    private static $date_columns = [
        'birth_date' => 'Y-m-d'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'personal_id',
        'institution_id',
        'citizenship',
        'birth_date',
        'email',
        'password',
        'role',
        'lang',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isBeneficiary(){
        return $this->role === 1 ? true : false;
    }

    public function menuPermission(){
        return $this->hasMany(RolePermission::class, 'role_id', 'role');
    }

    public function institution(){
        return $this->hasOne(Institution::class, 'id', 'institution_id')
            ->with(['content' => function($query){
                $query->where('lang', 'ka');
            }]);
    }

    public function menuItems(){
        $ids = $this->menuPermission->pluck('menu_id');
        return Menu::select('id', 'title')->whereIn('id', $ids)->get();
    }

    public function hasAaccess($menu_id){
        $ids = $this->menuPermission->pluck('menu_id')->toArray();

        return in_array($menu_id, $ids) ? true : false;
    }
}
