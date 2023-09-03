

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- fonte google -->
            <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
            <!-- Bootstrap -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

            <link href="/css/login.css" rel="stylesheet">

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.6/dist/jquery.inputmask.min.js"></script>

            <script>

                $(document).ready(function () {

                    $('.cpf-mask').inputmask('999.999.999-99', { placeholder: '___.___.___-__' });
                });
            </script>


            <style>
                body {
                    background-image: url(/img/logo.png);
                    background-size: cover;
                    background-position: center;    
                }
            </style>
    </head>


    <body class="d-flex align-items-center py-4 bg-body-tertiary">
    
        <main class="form-signin w-100 m-auto" style="background-color: aliceblue;">
            <form enctype="multipart/form-data" action="/Home" method="POST">
                @csrf

                
                <img src="{{ asset('/img/logo.png') }}" class="img-fluid"/>

                <div class="form-floating">
                <input type="text" class="form-control cpf-mask" id="cpf" name="cpf" placeholder="XXX.XXX.XXX-XX">
                <label for="floatingInput">CPF</label>
                </div>
                <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <label for="floatingPassword">Password</label>
                </div>

                <!--<div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Remember me
                </label>
                </div>-->
                <!--<form method="get">
                    <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
                    <a href="/Usuario/CadastrarUser">Cadastrar-se</a> 
                </form>-->

                <div class="form-group">
                    <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
                </div>
                <a href="/Usuario/CadastrarUser">Cadastrar-se</a>
                &nbsp;
                &nbsp;
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Esqueceu a senha?') }}
                    </a>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif

            </form>
        </main>

        <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>
