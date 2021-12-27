<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AccountPage extends Controller
{
    public function index()
    {
        return view('pages.account', [
            'pageName' => 'account',
            'title' => 'Личный кабинет',
            'buttonTakePhoto' => 'Сохранить фото',
            'buttonStartCamera' => 'Включить камеру'
        ]);
    }
}
