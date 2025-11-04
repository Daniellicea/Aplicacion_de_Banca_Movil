<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class layoutsController extends Controller
{
    public function app()
    {
        return view('layoutsController.app');
    }

    public function card()
    {
        return view('layoutsController.cards');
    }
}
