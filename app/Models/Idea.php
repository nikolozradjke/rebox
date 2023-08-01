<?php

namespace App\Models;

use App\Interfaces\ModelColumns;
use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model implements ModelColumns
{
    use HasFactory;

    use ModelHelper{
        add as protected addHelper;
    }

    private $main_table = 'ideas';
    private static $current_class = __CLASS__;

    protected $fillable = [
        'user_id',
        'title',
        'description'
    ];

    public function beneficiary(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getItem($id){
        return $this->whereId($id)
            ->with([
                'beneficiary' => function($query){
                    $query->select('id', 'first_name', 'last_name', 'personal_id', 'institution_id')
                        ->with('institution');
                }
            ])
            ->first();
    }

    public function getAll($user_id = null, $count = 50){
        return $this->when($user_id, function ($query) use($user_id){
                $query->where('user_id', $user_id);
            })
            ->with([
                'beneficiary' => function($query){
                    $query->select('id', 'first_name', 'last_name', 'personal_id', 'institution_id')
                        ->with('institution');
                }
            ])
            ->latest()
            ->paginate($count);
    }

    public function add($request)
    {
        $item = new self::$current_class;

        $item->user_id = \Auth::user()->id;

        return $this->addHelper(
            $request,
            $item
        );
    }
}
