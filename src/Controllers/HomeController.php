<?php 

namespace Src\Controllers;

class HomeController{
    
    public function index()
    {
        return view('index', [
            'users' => [
                ['name' => 'Chien', 'age' => 21],
                ['name' => 'Dac', 'age' => 21]
            ]
        ]);
    }

    public function show()
    {
        return view('Welcome');
    }
}