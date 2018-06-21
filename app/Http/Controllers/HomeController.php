<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $a = ['hello', 'hi', 'go', 'ko' ];

        return view('pages.index', compact('a'));
    }
}
