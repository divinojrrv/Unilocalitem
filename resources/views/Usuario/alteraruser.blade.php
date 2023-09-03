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
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="POST" action="{{ route('usuario.update', $usuario->ID) }}"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="nome">Nome:</label>
                        <input class="form-control" id="nome" name="nome" value="{{ auth()->user()->nome }}" type= "text" autocomplete="off"/>
                        @error('nome')
                        <div class="alert alert-danger mt-3">(($message))</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="email">E-mail:</label>
                        <input class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" readonly type= "email" autocomplete="off"/>
                        @error('email')
                        <div class="alert alert-danger mt-3">(($message))</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <script>
                            // Aguarde o documento ser carregado
                            $(document).ready(function () {
                                // Selecione o campo de entrada do CPF pela classe e aplique a máscara
                                $('.cpf-mask').inputmask('999.999.999-99', { placeholder: '___.___.___-__' });
                            });
                        </script>
                        <label for="cpf">CPF:</label>
                        <input class="form-control cpf-mask" id="cpf" name="cpf" value="{{ auth()->user()->cpf }}" readonly placeholder="XXX.XXX.XXX-XX" autocomplete="off"/>
                        @error('cpf')
                        <div class="alert alert-danger mt-3">(($message))</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="senha">Senha:</label>
                        <input class="form-control" id="password" name="password" value="" type= "password" autocomplete="off"/>
                        @error('password')
                            <div class="alert alert-danger mt-3">Senha não corresponte a confirmação!</div>
                        @enderror
                    </div>
                </div>
                <br><br>


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
                        &nbsp;
                        <button class="btn btn-primary" style="background: rgba(8, 192, 26, 1); outline: none;" type="submit" >Salvar</button>
                    </div>
                </div>
            </form>
        </div>
</div>
        

@endsection