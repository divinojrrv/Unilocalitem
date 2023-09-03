@extends('layouts.main')

@section('title', 'UnilocalItem')

@section('CorpoPagina')

@section('TituloPagina')

<div class="container pt-4" style="margin-left: 280px;">
    <div class="mb-3 mt-5">
        <h3>Alterar Usuário</h3>
    </div>
    <br>
@endsection
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('usuario.updateADM', $usuario->ID) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row d-flex justify-content-between align-items-end">
                    <div class="form-group col-sm-12 col-md-6 mb-3 text-end">
                        <input class="form-check-input" id="tipousuario" name="tipousuario" type="checkbox" {{ $usuario->tipousuario == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="tipo">ADMIN</label>
                        &nbsp;
                        &nbsp;
                        <input class="form-check-input" id="status" name="status" type="checkbox" {{ $usuario->status == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="tipo">Desativar</label>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="nome">Nome:</label>
                        <input class="form-control" id="nome" name="nome" value="{{ $usuario->nome }}" type= "text" autocomplete="off"/>
                        @error('nome')
                        <div class="alert alert-danger mt-3">(($message))</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="email">E-mail:</label>
                        <input class="form-control" id="email" name="email" readonly value="{{ $usuario->email }}" type= "email" autocomplete="off"/>
                        @error('email')
                        <div class="alert alert-danger mt-3">(($message))</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="cpf">CPF:</label>
                        <input class="form-control" id="cpf" name="cpf" readonly value="{{ $usuario->cpf }}" type= "text" autocomplete="off"/>
                        @error('cpf')
                        <div class="alert alert-danger mt-3">(($message))</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="confirmation">Senha:</label>
                        <input class="form-control" id="password" name="password" value="" type= "password" autocomplete="off"/>
                        @error('password')
                        <div class="alert alert-danger mt-3">Senha não corresponde a sua confirmação!</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="password_confirmation">Confirme a senha:</label>
                        <input class="form-control" id="password_confirmation" name="password_confirmation" value="" type= "password" autocomplete="off"/>
                        @error('password_confirmation')
                        <div class="alert alert-danger mt-3">(($message))</div>
                        @enderror
                    </div>
                </div>
                <br><br>

    <!-- MOSTRAR OS BOTÕES NO FIM DO FORMULARIO
                <div class="row justify-content-end">
                    <div class="form-group col-sm-12 col-md-6 mb-3 text-end"> -->   
                        
                    
  <!-- MOSTRAR OS BOTÕES NO FIM DOS INPUTS TEXTS DO FORMULARIO  -->  
                <div class="row d-flex justify-content-between align-items-end">
                    <div class="form-group col-sm-12 col-md-6 mb-3 text-end">

                        <script>
                            function cancelar() {
                                // Exibe o modal de confirmação usando Bootstrap
                                var confirmation = confirm("Deseja realmente cancelar?");
                                if (confirmation) {
                                    // Se o usuário confirmar, redireciona para a página de logout
                                    window.location.href = "/Home"; // Altere o caminho conforme necessário
                                }
                                // Se o usuário cancelar, não faz nada e permanece na mesma página
                            }
                        </script>

                        <button onclick="cancelar()" class="btn btn-primary" style="background-color: rgba(244, 7, 7, 1); outline: none;" type="button" >Cancelar</button>
                        &nbsp
                        <button class="btn btn-primary" style="background: rgba(8, 192, 26, 1); outline: none;" type="submit" >Salvar</button>
                    </div>
                </div>
            </form>
</div>
@endsection