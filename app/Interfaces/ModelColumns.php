<?php

namespace App\Interfaces;

interface ModelColumns
{
    public function getMainColumns() :array;
    public function getTranslateColumns() :array;
}
