<?php 

namespace App\Controllers;

class LandingPageController extends BaseController
{
    public function index()
    {
        return view('pages/landingpage');
    }
}