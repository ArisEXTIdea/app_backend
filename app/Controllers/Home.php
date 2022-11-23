<?php

namespace App\Controllers;

use APP\Models\FimonM;

class Home extends BaseController
{

    public function __construct()
    {
        $this->FimonM = new FimonM;
    }

    public function index()
    {
        return view('welcome_message');
    }
}
