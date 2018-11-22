<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected  $model_name = '管理员';

    public function index(){
        $this->model = 'index';
        return $this->display('index');
    }
}
