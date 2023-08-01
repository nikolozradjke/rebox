<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    private $model;
    private $main_columns;
    private $translate_columns;

    public function __construct()
    {
        $this->model = new Institution();
        $this->main_columns = $this->model->getMainColumns();
        $this->translate_columns = $this->model->getTranslateColumns();
        $this->data['message'] = 'Success';
    }

    public function index(Request $request)
    {
        $this->data['items'] = $this->model->getAll(
            $lang = 'ka',
            false,
            $request->count
        );

        return $this->getResponse();
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
            'translates.ka.title' => 'required',
            'ip' => 'required'
        ], [
            'translates.ka.title.required' => 'დასახელება აუცილებელია',
            'ip' => 'აიპი აუცილებელია'
        ]);

        $insert = $this->model->add($request);

        if(!$insert)
        {
            $this->error();
        }

        return $this->getResponse();
    }

    public function show(Institution $institution)
    {
        $this->data['item'] = $institution->getItem($institution->id, $lang = false);

        return $this->getResponse();
    }

    public function update(Request $request, Institution $institution)
    {
        $this->validate($request,[
            'translates.ka.title' => 'required',
            'ip' => 'required'
        ], [
            'translates.ka.title.required' => 'დასახელება აუცილებელია',
            'ip' => 'აიპი აუცილებელია'
        ]);

        $update = $institution->updateItem($request);

        if(!$update)
        {
            $this->error();
        }

        return $this->getResponse();
    }

    public function delete(Institution $institution)
    {
        if(!$institution->delete()){
            $this->error();
        }

        return $this->getResponse();
    }
}
