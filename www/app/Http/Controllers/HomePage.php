<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class HomePage extends Controller
{
    public function index()
    {
        return view('pages.home', [
            'pageName' => 'home',
            'title' => 'Главная',
            'buttonTakePhoto' => 'Вход по фото',
            'buttonStartCamera' => 'Авторизация'
        ]);
    }
}
