<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $nome = 'Gabriel';
    $idade = 18;

    $arr = [10, 2, 3, 4, 5];
    $nomes = ['Gabriel', 'Kay', 'Joao', 'sla quem'];

    return view('welcome', 
        [
            'nome' => $nome,
            'idade' => $idade,
            'array' => $arr,
            'nomes' => $nomes
        ]);
});