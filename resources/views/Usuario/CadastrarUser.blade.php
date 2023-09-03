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
                // Aguarde o documento ser carregado
                $(document).ready(function () {
                    // Selecione o campo de entrada do CPF pela classe e aplique a máscara
                    $('.cpf-mask').inputmask('999.999.999-99', { placeholder: '___.___.___-__' });
                });
            </script>
            

        <style>
            body {
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;

            }
        </style>


    </head>

    <body>

        <div id="cadasdro-user" class="container  col-sm-12 col-md-4 mb-3" style="background-color: aquamarine;">
        <div class="card">
            <div class="card-body">
                <form action="/Usuario" method="POST">
                    @csrf
                    <div class="text-center">
                        <img src="{{ asset('/img/logo.png') }}" class="img-fluid"/>
                    </div>
                    

                        <div class="row">
                            <div class="form-group col-sm-12 col-md-12 mb-3">
                        
                                <label for="nome">Nome:</label>
                                <input class="form-control" id="nome" name="nome" value="mateus" type= "text" autocomplete="off" placeholder="Nome do Usuário"/>
                                @error('nome')
                                <div class="alert alert-danger mt-3">Informe Seu nome!</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-12 mb-3">
                                <label for="email">E-mail:</label>
                                <input class="form-control" id="email" name="email" value="mateus@gmail.com" type= "email" autocomplete="off" placeholder="E-mail"/> 
                                
                                @error('email')
                                <div class="alert alert-danger mt-3">E-mail inválido ou já cadastrado!</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-12 mb-3">
                                <label for="cpf">CPF:</label>
                                <input type="text" class="form-control  cpf-mask"   id="cpf" name="cpf" placeholder="Digite o CPF">
                                @error('cpf')
                                <div class="alert alert-danger mt-3">CPF inválido ou já cadastrado!</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-12 mb-3">
                                <label for="senha">Senha:</label>
                                <input class="form-control" id="password" name="password" type="password" autocomplete="off" placeholder="Senha"/>
                                @error('password')
                                    <div class="alert alert-danger mt-3">Senha não corresponte a confirmação!</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-12 mb-3">
                                <label for="confirmesenha">Confirme a senha:</label>
                                <input class="form-control" id="password_confirmation" name="password_confirmation" value="" type="password" autocomplete="off" placeholder="Conforme sua Senha"/>
                                @error('password_confirmation')
                                    <div class="alert alert-danger mt-3">Informe a senha correta</div>
                                @enderror
                            </div>
                        </div>

                        <br><br>

                        <div class="row d-flex justify-content-between align-items-end">
                            <div class="form-group col-sm-12 col-md-12 mb-3 text-end">

                                <button onclick="cancelar()" class="btn btn-primary" style="background-color: rgba(244, 7, 7, 1); outline: none;" type="button">Cancelar</button>
                                &nbsp
                                <button class="btn btn-primary" style="background: rgba(8, 192, 26, 1); outline: none;" type="submit" >Salvar</button>
                            </div>
                        </div>

                    </form>
            </div>
            </div>
        </div>
        <script>
            function cancelar() {
                // Exibe o modal de confirmação usando Bootstrap
                var confirmation = confirm("Deseja realmente cancelar?");
                if (confirmation) {
                    // Se o usuário confirmar, redireciona para a página de logout
                    window.location.href = "/"; // Altere o caminho conforme necessário
                }
                // Se o usuário cancelar, não faz nada e permanece na mesma página
            }
        </script>
    </body>
</html>
