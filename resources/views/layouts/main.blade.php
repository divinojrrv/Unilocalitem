<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/Img/iconlogo.ico">
        <!--<link rel="icon" type="image/png" href="https://diretoaoponto-tech.com.br/icon-target.png"/>-->
        <title>@yield('title')</title>

        <!-- fonte google -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">

         <!-- Bootstrap -->
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

        <!--<link rel="stylesheet" href="/css/style.css"> --> 

        <link href="/css/sidebars.css" rel="stylesheet">

        <style>
            body {
                position:absolute;
                width:100%;
                overflow-y:hidden;
                top:0;
                bottom:8px;
            }
            .btn-custom {
                background-color: transparent;
                color: #000; /* Define a cor do texto do botão */
                /* Outros estilos, como borda, tamanho da fonte, etc., podem ser adicionados conforme necessário */
            }
        </style>

    </head>
    <body>

    <header  class="py-3 mb-3 border-bottom fixed-top bg-light">

        <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
            <div class="dropdown">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                </svg>
                &nbsp;
                <a>{{ session('user_name') }}</a>
            </div>

            <div class="d-flex align-items-center">
                <form class="w-100 me-3"></form>

                <div class="flex-shrink-0 dropdown">
                    <a href="{{ route('usuario.edit', session('user_id')) }}" class="link-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                        </svg>
                    </a>
                    &nbsp;
                    <button onclick="confirmarLogout()"  class="btn btn-custom">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    @if (session('user_tipousuario') == 1)
        <main class="d-flex flex-grow mt-5" style="overflow-y: auto">
                <div class="flex-shrink-0 p-3 mt-4" style="width: 250px;  position: fixed; left: 0;"> 
                    <ul class="list-unstyled ps-0">
                        <li class="mb-1">
                            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
                            Publicações
                            </button>
                            <div class="collapse" id="home-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="/Publicacao/PublicacoesPendentes" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Pendentes</a></li>
                                <li><a href="/Publicacao/NaoAceitas" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Não Aceitas</a></li>
                                <li><a href="/Home" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Em aberto</a></li>
                            </ul>
                            </div>
                        </li>

                        <li class="mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg> 
                            <a href="/Publicacao/VisualizarSolicitacao" class="btn btn-tog d-inline-flex">Solicitações de Resgate</a>

                        </li>

                        <li class="mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                            </svg>
                            <a href="/Publicacao/ManifestacoesPublicacoes" class="btn btn-tog d-inline-flex">Devoluções</a>
                        </li>


                        <li class="mb-1">
                            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                                Manifestações
                            </button>
                            <div class="collapse" id="account-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="/Publicacao/Manifestadas" class="link-dark d-inline-flex text-decoration-none rounded">Manifestadas</a></li>
                                </ul>
                            </div>
                        </li>

                    <hr>

                        <li class="mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                            </svg>
                            <a href="/Usuario/VisualizarUser" class="btn btn-tog">Usuários</a>

                        </li>

                        <li class="mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                            <a href="/Publicacao/Consultar" class="btn btn-tog  d-inline-flex">Consultar</a>

                        </li>
                    </ul>
                </div>
                @yield('TituloPagina')
                @yield('CorpoPagina')
        </main>

    @else
        <main class="d-flex flex-grow mt-5" style="overflow-y: auto">
            <div class="flex-shrink-0 p-3 mt-4" style="width: 250px;  position: fixed; left: 0;"> 
                    <ul class="list-unstyled ps-0">
                        <li class="mb-1">
                            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
                            Publicações
                            </button>
                            <div class="collapse" id="home-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="/Publicacao/PubliPendentesUserComum" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Pendentes</a></li>
                                <li><a href="/Publicacao/NaoAceitas" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Não Aceitas</a></li>
                                <li><a href="/Home" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Em aberto</a></li>
                            </ul>
                            </div>
                        </li>
                        



                        <li class="mb-1">
                            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                                Manifestações
                            </button>
                            <div class="collapse" id="account-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="/Publicacao/ManifestacoesPublicacoes" class="link-dark d-inline-flex text-decoration-none rounded">Manifestar</a></li>
                                <li><a href="/Publicacao/Manifestadas" class="link-dark d-inline-flex text-decoration-none rounded">Manifestadas</a></li>
                                </ul>
                            </div>
                        </li>
                    <hr>
                        <li class="mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                            <a href="/Publicacao/Consultar" class="btn btn-tog  d-inline-flex">Consultar</a>

                        </li>
                    </ul>
                </div>
                @yield('TituloPagina')
                @yield('CorpoPagina')
        </main>

    @endif
    
    <script>
        function confirmarLogout() {
            // Exibe o modal de confirmação usando Bootstrap
            var confirmation = confirm("Deseja realmente sair do sistema?");
            if (confirmation) {
                // Se o usuário confirmar, redireciona para a página de logout
                window.location.href = "/"; // Altere o caminho conforme necessário
            }
            // Se o usuário cancelar, não faz nada e permanece na mesma página
        }
    </script>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>