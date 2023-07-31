<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $model;
    private $main_columns;
    private $translate_columns;

    public function __construct()
    {
        $this->model = new User();
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
            'first_name' => 'required',
            'last_name' => 'required',
            'personal_id' => 'required|unique:users',
            'role' => 'required'
        ],[
            'first_name' => 'მომხმარებლის სახელი სავალდებულოა',
            'last_name' => 'მომხმარებლის გვარი სავალდებულოა',
            'personal_id.unique' => 'მითითებული პირადი ნომრით მომხმარებელი უკვე დამატებულია',
            'role' => 'მომხმარებლის როლი სავალდებულოა',
        ]);

        $insert = $this->model->add($request);

        if(!$insert)
        {
            $this->error();
        }

        return $this->getResponse();
    }

    public function show(User $user)
    {
        $this->data['item'] = $user;

        return $this->getResponse();
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'personal_id' => 'required|unique:users,personal_id,'.$user->id,
            'role' => 'required'
        ],[
            'first_name' => 'მომხმარებლის სახელი სავალდებულოა',
            'last_name' => 'მომხმარებლის გვარი სავალდებულოა',
            'personal_id.unique' => 'მითითებული პირადი ნომრით მომხმარებელი უკვე დამატებულია',
            'role' => 'მომხმარებლის როლი სავალდებულოა',
        ]);

        $update = $user->updateItem($request);

        if(!$update)
        {
            $this->error();
        }

        return $this->getResponse();
    }

    public function delete(User $user)
    {
        if(!$user->delete()){
            $this->error();
        }

        return $this->getResponse();
    }
}
