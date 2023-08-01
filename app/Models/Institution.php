<?php

namespace App\Models;

use App\Interfaces\ModelColumns;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institution extends Model implements ModelColumns
{
    use HasFactory, ModelHelper;

    protected $fillable = [
        'ip',
        'status'
    ];

    private $main_table = 'institutions';
    private $translate_table = 'institution_translates';
    private static $translates_class = 'App\Models\InstitutionTranslate';
    private static $current_class = __CLASS__;

    public function content() :HasMany
    {
        return $this->hasMany(InstitutionTranslate::class, 'parent_id', 'id');
    }

    public function getItem($id, $lang)
    {
        return $this->where('id', $id)
            ->select('id', 'status', 'ip', 'created_at')
            ->with(
                [
                    'content' => function($query) use($lang){
                        $query->when($lang, function ($q) use($lang){
                            $q->where('lang', $lang);
                        });
                    }
                ])
            ->first();
    }

    public function getAll($lang = 'ka', $status = false, $count = 50)
    {
        return $this->when($status, function ($query){
                    return $query->where('status', 'აქტიური');
                })
                ->with(['content' => function($query) use($lang){
                    $query->select('parent_id', 'title', 'lang')
                        ->where('lang', $lang);
                }])
                ->latest()
                ->paginate($count);
    }
}
