@extends('layouts.main')

@section('title', 'UnilocalItem')

@section('CorpoPagina')

@section('TituloPagina')

<div class="container pt-4" style="margin-left: 280px;">
    <div class="mb-3 mt-5">
        <h3>Usuários</h3>
    </div>
    <br>
@endsection

<div class="card">
    <div class="card-body">
        <form method="POST" enctype="multipart/from-data">
            <div class="container">
                <div class="row rounded p-2" style="background-color:#f2f2f2">
                    <div class="col-1 text-center"></div>    
                    <div class="col-md-2 col-sm-3 text-center text-truncate"><b>ID</b></div>
                    <div class="col-md-2 col-sm-3 text-center text-truncate"><b>NOME</b></div>
                    <div class="col-md-2 col-sm-3 text-center text-truncate"><b>EMAIL</b></div>
                    <div class="col-md-2 col-sm-3 text-center text-truncate"><b>ADMIM</b></div>
                    <div class="col-md-2 col-sm-3 text-center text-truncate"><b>STATUS</b></div>
                    <div class="col text-center"></div>
                </div>
                @foreach ($usuarios as $usuario)
                <div class="row rounded p-3">
                    <div class="col-1 text-center"></div>  
                    <div class="col-md-2 col-sm-3 text-center text-truncate"><b style="color:#0EA5E9">{{ $usuario->ID }}</b></div>
                    <div class="col-md-2 col-sm-3 text-center text-truncate">{{ $usuario->nome }}</div>
                    <div class="col-md-2 col-sm-3 text-center text-truncate">{{ $usuario->email }}</div>
                    <div class="col-md-2 col-sm-3 text-center text-truncate">

                        @if ($usuario->tipousuario == 0)
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16" style="color:red">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16" style="color:green">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                            </svg>
                        @endif
                    </div>

                    <div class="col-md-2 col-sm-3 text-center text-truncate">

                        @if ($usuario->status == 0)
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16" style="color:red">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16" style="color:green">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="col text-center">
                        <a href="{{ route('usuario.editADM', $usuario->ID) }}" class="link-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
                
            </div>
        </form>
    </div>
</div>
@endsection
