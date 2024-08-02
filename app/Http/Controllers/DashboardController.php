<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function bph()
    {
        return view('dashboard.bph');
    }

    public function kepalaDepartemen()
    {
        return view('dashboard.kepala-departemen');
    }

    public function anggotaDepartemen()
    {
        return view('dashboard.anggota-departemen');
    }
}
