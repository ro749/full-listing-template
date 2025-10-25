<?php

namespace Ro749\FullListingTemplate\Controllers;
use Ro749\SharedUtils\Controllers\Controller;
use Ro749\FullListingTemplate\Forms\AdminLogin;
class AdminLoginController extends Controller
{
    public function index() {
        $form = AdminLogin::instanciate();
        return view('simple-login', ['form'=>$form]);
    }
}
