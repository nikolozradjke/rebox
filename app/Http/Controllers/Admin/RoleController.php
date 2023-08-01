<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $model;
    private $main_columns;
    private $translate_columns;

    public function __construct()
    {
        $this->model = new Role();
        $this->main_columns = $this->model->getMainColumns();
        $this->translate_columns = $this->model->getTranslateColumns();
        $this->data['message'] = 'Success';
    }

    public function index(Request $request)
    {
        $this->data['items'] = $this->model->getAll($request->count);

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
            'title' => 'required',
        ],[
            'title.required' => 'როლის დასახელება სავალდებულოა',
        ]);

        $insert = $this->model->add($request);

        if(!$insert)
        {
            $this->error();
        }

        return $this->getResponse();
    }

    public function show(Role $role)
    {
        $permissions = $role->permissions;
        $this->data['item'] = $role;

        return $this->getResponse();
    }

    public function update(Request $request, Role $role)
    {
        $this->validate($request,[
            'title' => 'required',
        ],[
            'title.required' => 'როლის დასახელება სავალდებულოა',
        ]);

        $update = $role->updateItem($request);

        if(!$update)
        {
            $this->error();
        }

        return $this->getResponse();
    }

    public function delete(Role $role)
    {
        if(!$role->delete()){
            $this->error();
        }

        return $this->getResponse();
    }
}
