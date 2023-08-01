<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Idea();
        $this->data['message'] = 'Success';
    }

    public function index(Request $request)
    {
        $this->data['items'] = $this->model->getAll(null, $request->count);

        return $this->getResponse();
    }

    public function show(Idea $idea)
    {
        $this->data['item'] = $idea->getItem($idea->id);

        return $this->getResponse();
    }
}
