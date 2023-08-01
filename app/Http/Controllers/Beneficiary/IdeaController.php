<?php

namespace App\Http\Controllers\Beneficiary;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    private $model;
    private $main_columns;
    private $translate_columns;

    public function __construct()
    {
        $this->model = new Idea();
        $this->main_columns = $this->model->getMainColumns();
        $this->translate_columns = $this->model->getTranslateColumns();
        $this->data['message'] = 'Success';
    }

    public function getColumns()
    {
        $this->data['main_columns'] = $this->main_columns;
        $this->data['translate_columns'] = $this->translate_columns;

        return $this->getResponse();
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'description' => 'required'
        ],[
            'title.required' => 'დასახელება სავალდებულოა',
            'description.required' => 'აღწერა სავალდებულოა'
        ]);

        $insert = $this->model->add($request);

        if(!$insert)
        {
            $this->error();
        }

        return $this->getResponse();
    }

    public function show(Idea $idea)
    {
        $this->data['item'] = $idea->getItem($idea->id);

        return $this->getResponse();
    }

    public function update(Request $request, Idea $idea)
    {
        $this->validate($request,[
            'title' => 'required',
            'description' => 'required'
        ],[
            'title.required' => 'დასახელება სავალდებულოა',
            'description.required' => 'აღწერა სავალდებულოა'
        ]);

        $update = $idea->updateItem($request);

        if(!$update)
        {
            $this->error();
        }

        return $this->getResponse();
    }

    public function delete(Idea $idea)
    {
        if(!$idea->delete()){
            $this->error();
        }

        return $this->getResponse();
    }
}
