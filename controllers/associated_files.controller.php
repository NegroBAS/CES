<?php

class Associated_filesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if(!isset($_SESSION['user'])){
            header('Location:'.constant('URL'));
        }
    }

    public function index()
    {
    }

    public function store()
    {
    }

    public function show()
    {
    }

    public function edit()
    {
    }

    public function destroy()
    {
    }
}
