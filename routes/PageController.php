<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Menampilkan halaman welcome/splash screen.
     */
    public function welcome(): View
    {
        return view('welcome');
    }
}
