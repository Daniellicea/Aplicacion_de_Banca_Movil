<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class layouts extends Controller
{
    public function app()
    {
        return view('layouts.app');
    }

    public function card()
    {
        return view('layouts.cards');
    }
}
