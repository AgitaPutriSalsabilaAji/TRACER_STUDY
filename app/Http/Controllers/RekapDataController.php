<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekapDataController extends Controller
{
    public function index()
    {
        return view('data.laporan.laporan');
    }
}
