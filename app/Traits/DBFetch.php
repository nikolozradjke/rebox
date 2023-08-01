<?php

namespace App\Traits;

trait DBFetch
{

    public function getAll($count = 50){
        return self::$current_class::latest()->paginate($count);
    }

}
