@extends('layouts.main')

@section('title', 'UnilocalItem')

@section('CorpoPagina')

@section('TituloPagina')

<div class="container pt-4 " style="margin-left: 280px;">
    <div class="mb-3 mt-5">
        <h3>Solicitar Resgate</h3>
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
                        <textarea class="form-control" readonly id="descricao" name="descricao" value="" rows="4">
                        </textarea>

                        <input class="form-check-input" id="tipo" name="tipo" type= "checkbox" style="background-color: rgb(143, 140, 140); outline: none;" checked disabled/>
                        <label class="form-check-label" for="tipo">Li e estou de acordo com os termos</label>

             
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <p><b>Documentos SALVOS:</b>
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

                
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="img" class="form-label">Caso desejar, Escolher novo documento Frente e Verso:</label>
                        <input class="form-control" id="img" name="img[]" type="file" multiple />
                        @error('img')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Selecione pelo menos duas imagens.</small>
                    </div>
                </div>

                <div class="row d-flex justify-content-between align-items-end">
                    <div class="form-group col-sm-12 col-md-6 mb-3 text-end"> 
                        <a class="btn btn-primary" href="/Publicacao/VisualizarSolicitacao" >Voltar</a>
                        &nbsp
                        <button class="btn btn-primary" style="background: rgba(8, 192, 26, 1); outline: none;" type="button" onclick="confirmEditVizualizarSolResgt( {{ $item->ID }}, {{ $item->IdResgate }} )" >Concluir</button>
                    </div>
                        </div>

                <br><br>
            </form>
            <script>
                function confirmEditVizualizarSolResgt(id, IdResgate) {
                    var selectedImages = document.getElementById('img').files;
                    
                if (selectedImages.length == 1) {
                    if (selectedImages.length < 2) {
                        alert('Selecione ao menos duas imagens.');
                        return false; 
                    }
                }

                if (selectedImages.length > 2) {
                        alert('Selecione só duas imagens.');
                        return false;
                }

                    if (!confirm('Deseja realmente Editar essa solicitação de resgate?? ' + IdResgate + '')) {
                        return false;
                    }
            
                    var form = document.getElementById('meuForm');
                    
                    form.action = `{{ route('publicacoes.resgateUpdate', ['ID' => ':id', 'IdResgate' => ':IdResgate']) }}`
                        .replace(':id', id)
                        .replace(':IdResgate', IdResgate);
            
                    form.submit();
            
                    return true; // Retorna true para continuar o envio do formulário
                }
            </script>
        </div>
    </div>
</div>
@endsection