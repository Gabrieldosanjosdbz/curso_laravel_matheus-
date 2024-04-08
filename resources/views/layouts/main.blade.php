<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">

            <title> @yield('title') </title>

            <!-- Fonte do Google -->
            <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">

            <!--CSS Bootstrap-->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            
            <!-- CSS da aplicação -->
            <link rel="stylesheet" href="/css/style.css">
            <script src="/js/script.js"></script>
        </head>
        <body>

            <header>
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="collapse navbar-collapse" id="navbar">

                        <a href="/" class="navbar-brand">
                            <img src="/img/hdcevents_logo.svg" alt="HDC Events">
                        </a>

                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="/" class="nav-link">Eventos</a>
                            </li>

                            <li class="nav-item">
                                <a href="/events/create" class="nav-link">Criar Eventos</a>
                            </li>

                            {{--Quando eu estiver como logado--}}
                            @auth
                                <li>
                                    <a href="/dashboard" class="nav-link">Meus eventos</a>
                                </li>

                                <li>    

                                    {{--Logout (sair) --}}
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <a href="/logout" 
                                            class="nav-link" 
                                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                            Sair
                                        </a>
                                    </form>
                                </li>

                            @endauth
                            
                            {{--Quando eu estiver como convidado--}}
                            @guest
                                <li class="nav-item">
                                    <a href="/login" class="nav-link">Entrar </a>
                                </li>
                                
                                <li class="nav-item">
                                    <a href="/register" class="nav-link">Cadastrar </a>
                                </li>    
                            @endguest
                        </ul>

                    </div>
                </nav>
            </header>

            <main>
                <div class="container-fluid">
                    <div class="row">
                        @if (session('msg'))  {{-- Verificando se uma session "msg" existe--}}
                            <p class="msg">{{ session('msg') }}</p>  {{-- Mostrando a mensagem --}}

                        @endif

                        @yield('content')
                    </div>
                </div>
            </main>

            <footer>    {{--Componente que estará em twwodas as pages--}}
                <p>HDC Events &copy; 2024</p>
            </footer>

            <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        </body>
</html>