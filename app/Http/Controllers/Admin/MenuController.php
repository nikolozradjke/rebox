<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $this->data['message'] = 'Success';
        $this->data['items'] = Menu::orderBy('id', 'asc')->get();

        return $this->getResponse();
    }
}
