<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

<<<<<<< Updated upstream:app/Http/Controllers/layouts.php
class layouts extends Controller
=======
class LayoutsController extends Controller
>>>>>>> Stashed changes:app/Http/Controllers/LayoutsController.php
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
