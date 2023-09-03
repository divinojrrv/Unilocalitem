@extends('layouts.main')

@section('title', 'UnilocalItem')

@section('CorpoPagina')

@section('TituloPagina')

<div class="container pt-4 " style="margin-left: 280px;">
    <div class="mb-3 mt-5">
        <h3>Visualizar Resgate</h3>
    </div>
    <br>
    @endsection
    
    <div class="card">
        <div class="card-body">
            <form id="meuForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="NOME">Título:</label>
                            <input class="form-control" id="NOME" name="NOME" value="{{isset($item) ? $item->NOME : old('NOME')}}" type="text" disabled>

                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label class="form-label" for="DESCRICAO">Descrição:</label>
                        <textarea class="form-control" id="DESCRICAO" name="DESCRICAO" rows="4" disabled>{{ old('DESCRICAO', $item->DESCRICAO ?? '') }} </textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="IDCATEGORIA" class="form-label">Categoria:</label>
                        <select class="form-select" id="IDCATEGORIA" name="IDCATEGORIA" disabled>
                            <option value="">Selecione uma opção</option>
                            @foreach($categorias_combobox as $ID => $NOME)
                                <option value="{{ $ID }}" {{ old('IDCATEGORIA', $item->IDCATEGORIA ?? '') == $ID ? 'selected' : '' }}>{{ $NOME }}</option>
                            @endforeach
                        </select>

                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="IDBLOCO" class="form-label">Bloco:</label>
                        <select class="form-select" id="IDBLOCO" name="IDBLOCO" disabled>
                            <option value="">Selecione uma opção</option>
                            @foreach($blocos_combobox as $ID => $NOME)
                                <option value="{{ $ID }}" {{ old('IDBLOCO', $item->IDBLOCO ?? '') == $ID ? 'selected' : '' }}>{{ $NOME }}</option>
                            @endforeach
                        </select>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="nome">Nome:</label>
                        <input class="form-control" id="nome" name="nome" value="{{ $nomeUser }}" type="text" disabled/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="cpf">CPF:</label>
                        <input class="form-control" id="cpf" name="cpf" value="{{ $CPFUser }}" type="text" disabled/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <p><b>Documentos com foto frente e verso:</b>
                        @if ($item->imageNames)
                            @foreach ($item->imageNames as $imageName)
                                <a href="{{ asset('img/events/'.$imageName) }}" target="_blank">
                                    <img src="{{ asset('img/events/'.$imageName) }}" height="150" width="150" alt="Imagem da Publicação">
                                </a>
                            @endforeach
                        @endif
                        </p>
                    </div>
                </div>
                <br><br>
                <br><br>

                <div class="row d-flex justify-content-between align-items-end">
                    <div class="form-group col-sm-12 col-md-6 mb-3 text-end"> 
                        <a class="btn btn-primary" href="/Publicacao/VisualizarSolicitacao" >Voltar</a>
                        &nbsp
                        <button class="btn btn-primary" style="background: rgba(8, 192, 26, 1); outline: none;" type="button" onclick="confirmVizualizarSolResgt({{ $item->ID }})" >Concluir</button>
                    </div>
                </div>
            </form>
            <script>
                function confirmVizualizarSolResgt(id) {

                    if (!confirm('Deseja realmente CONCLUIR essa solicitação de resgate??')) {
                        return false; // Retorna false para cancelar o envio do formulário
                    }

                    // Obtém o formulário
                    var form = document.getElementById('meuForm');

                    form.action = `{{ route('publicacoes.resgateConcluir', ['id' => '/']) }}/${id}`;

                    form.submit();

                    return true; // Retorna true para continuar o envio do formulário
                }
            </script>
</div>
@endsection