<?php

namespace App\Http\Controllers;

class IndexController extends ControllerBase
{

    public function index()
    {
        return view('index');
    }

    public function table()
    {
        return view('table', [
            'breadcrumb' => ['test'],
            'title'      => 'test',
        ]);
    }
}
