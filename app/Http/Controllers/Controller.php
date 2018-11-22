<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected  $breadCrumb = ['首页'];

    function SEO($title){
        if($this->model_name)
            $this->breadCrumb[] = $this->model_name;

        $this->breadCrumb[] = $title;
        $this->title = $title;
    }

    function display($view, $data = []){
        $merge_date = [
            'breadCrumb' => $this->breadCrumb,
            'title' => implode(' - ', array_reverse($this->breadCrumb))
        ];
        $data = array_merge($data,$merge_date);
        return view($view,$data);
    }
}


