<?php

namespace App\Traits;

use App\Helper\Text;
use Illuminate\Support\Facades\Hash;

trait ModelHelper
{
    use GetLocales;

    public function getTableColumns($table) {
        $all_columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($table);

        $not_needed_columns = [
            'id',
            'sort',
            'lang',
            'password',
            'endpoint',
            'text',
            'agreed',
            'created_at',
            'updated_at'
        ];

        if($table == 'ideas'){
            $not_needed_columns[] = 'user_id';
        }

        if(str_contains($table, 'translate')){
            $not_needed_columns[] = 'parent_id';
        }

        return array_values(array_diff($all_columns, $not_needed_columns));
    }

    public function getMainColumns() :array
    {
        return $this->getTableColumns($this->main_table);
    }

    public function getTranslateColumns() :array
    {
        return $this->getTableColumns($this->translate_table);
    }

    public function add($request, $item = null, $additional_data = null){
        if(is_null($item)){
            $item = new self::$current_class;
        }

        $item = $this->storeMainColumns($item, $request);

        if(property_exists(self::$current_class, 'pass')){
            if($request->role == 1){
                $item->password = Hash::make($request->password);
            }else{
                $new_pass = Text::generateRandomString(8);
                $item->password = Hash::make($new_pass);
            }
        }

        if($item->save()){
            if(property_exists(self::$current_class, 'translates_class')){
                $translates = $request->translates;
                $translate_columns = $this->getTranslateColumns();

                $storable_data = [];
                foreach($this->getLocales() as $key => $lang){
                    $storable_data[$key] = [
                        'parent_id' => $item->id,
                        'lang' => $lang
                    ];

                    $content = isset($translates[$lang]) ? $translates[$lang] : $translates['ka'];

                    foreach($translate_columns as $column){
                        if(!isset($content[$column])){
                            $content[$column] = isset($translates['ka'][$column]) ? $translates['ka'][$column] : null;
                        }
                        $storable_data[$key][$column] = $content[$column];
                    }
                    if(gettype($additional_data) == 'array'){
                        foreach($additional_data as $column => $items){
                            $storable_data[$key][$column] = isset($items[$lang]) ? $items[$lang] : $items['ka'];
                        }
                    }
                }

                self::$translates_class::insert($storable_data);
            }
            if(property_exists(self::$current_class, 'menu') && $request->menus){
                $this->menuStore($item, $request->menus);
            }
            if(isset($new_pass)){
                //პაროლის გაგზავნის ფუნქცია ადრესატთან
            }
            return true;
        }

        return false;
    }

    public function updateItem($request, $additional_data = null){
        $item = $this->storeMainColumns($this, $request);

        if($item->update()){
            if(property_exists(self::$current_class, 'translates_class')){
                $translates = $request->translates;

                foreach($this->getLocales() as $key => $lang){
                    if($item_content = $this->content()
                        ->where('parent_id', $this->id)
                        ->where('lang', $lang)
                        ->first()
                    )
                    {
                        foreach($translates[$lang] as $column => $content){
                            $updatable[$lang][$column] = is_null($content) ? $translates['ka'][$column] : $content;
                        }

                        if(gettype($additional_data) == 'array'){
                            foreach($additional_data as $column => $items){
                                $updatable[$lang][$column] = isset($items[$lang]) ? $items[$lang] : $items['ka'];
                            }
                        }
                        $item_content->update($updatable[$lang]);
                    }
                    else{
                        $storable_data[$key] = [
                            'parent_id' => $this->id,
                            'lang' => $lang
                        ];
                        foreach($translates[$lang] as $column => $content){
                            $storable_data[$key][$column] = is_null($content) ? $translates['ka'][$column] : $content;
                        }
                        if(gettype($additional_data) == 'array'){
                            foreach($additional_data as $column => $items){
                                $storable_data[$key][$column] = isset($items[$lang]) ? $items[$lang] : $items['ka'];
                            }
                        }
                        self::$translates_class::insert($storable_data);
                    }
                }
            }
            if(property_exists(self::$current_class, 'menu') && $request->menus){
                $this->menuStore($item, $request->menus, $update = true);
            }
            return true;
        }
        return false;
    }

    public function storeMainColumns($item, $request){
        $request_keys = $request->except([
            'translates',
            'image',
            'sort',
            'endpoint'
        ]);

        $table_columns = $this->getMainColumns();

        foreach ($request_keys as $key => $value){
            if(in_array($key, $table_columns))
            {
                $item->$key = $value;
            }
        }

        if(property_exists(self::$current_class, 'date_columns')){
            foreach(self::$date_columns as $column => $format){
                if($request->$column)
                $item->$column = date($format, strtotime($request->$column));
            }
        }

        return $item;
    }

    private function menuStore($item, $permissions, $update = false) :void{
        if($update){
            $item->permissions()->delete();
        }
        $menu_permission = [];
        foreach($permissions as $iterator => $menu){
            $menu_permission[$iterator] = [
                'menu_id' => $menu['id'],
                'role_id' => $item->id
            ];
        }
        if(!empty($menu_permission)){
            $item->permissions()->insert($menu_permission);
        }
    }
}
