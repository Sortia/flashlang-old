<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

abstract class AuthController extends Controller
{
    abstract function index();

    abstract function auth();
}
