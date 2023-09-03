

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

                <div class="form-group">
                    <button class="btn btn-primary w-100 py-2" type="submit">Enviar</button>
                </div>


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
