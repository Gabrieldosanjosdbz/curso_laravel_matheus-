<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            
        </style>
    </head>
    <body>
        <h1>Algum comentario</h1>    

        {{-- Diretiva if, elseif e else --}}
        @if(10 > 5) <!--Abrindo a diretiva-->
            <p>A condição é true</p>
        @endif <!--Fechando a diretiva -->

        <p>{{ $nome }}</p> 

        @if($nome == "kay")
            <p>O nome é kay</p>
        @elseif($nome == "Gabriel")
            <p>Seu nome é {{ $nome }} e você tem {{ $idade }} anos</p>
        @else
            <p>Seu nome é estranho</p>
        @endif


        {{-- Diretiva for --}}
        @for($i = 0; $i < count($array); $i++)

            <p> {{ $i }} - {{ $array[$i] }}</p>
            @if($i == 2)
                <p> o índice {{$i}} é {{$array[$i]}}</p>
            @endif

        @endfor

        {{-- Diretiva foreach --}}
        @foreach($nomes as $nome)

        <p>{{ $nome }}</p>
        <p>{{ $loop->index }}</p>   {{-- O $loop é uma variavel do blade para acessar os index dos arrays --}}

        @endforeach

        {{-- Diretiva php --}}
        @php
            $name2 = "gabriel";
            echo $name2;
        @endphp

        <!-- Comentario do HTML -->
        {{-- Este é um comentario do blade nao renderizavel --}}

    </body>
</html>
