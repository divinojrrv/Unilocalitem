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
            <form method="POST" enctype="multipart/form-data"
                @if(isset($item))
                    action="{{ route('publicacoes.resgate', $item->ID) }}">
                {!! method_field('PUT') !!}
                @endif
                {!! csrf_field() !!} 
                

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
                        <label for="img" class="form-label">Documento Frente e Verso:</label>
                        <input class="form-control" id="img" name="img[]" type="file" multiple />
                        @error('img')
                        <div class="alert alert-danger mt-3">(($message))</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <textarea class="form-control" readonly id="descricao" name="descricao" value="" rows="4">
                    Entendo que a veracidade e autenticidade dos documentos anexados são de minha responsabilidade, e eu fornecerei informações precisas e completas.
                    Ao aceitar este termo, estou ciente de que a equipe responsável pela publicação pode verificar os documentos anexados para garantir a legitimidade do processo de resgate. 
                    Qualquer tentativa de fornecer informações falsas ou documentos fraudulentos resultará na invalidação do processo de resgate.
                        </textarea>

                        <input class="form-check-input" id="tipo" name="tipo" value="" type= "checkbox" style="background-color: rgb(143, 140, 140); outline: none;"/>
                        <label class="form-check-label" for="tipo">Li e compreendi os termos acima e concordo em anexar os documentos</label>

             
                    </div>
                </div>

                <div class="row d-flex justify-content-between align-items-end">
                            <div class="form-group col-sm-12 col-md-12 mb-3 text-end">
                                <button class="btn btn-primary" style="background-color: rgba(244, 7, 7, 1); outline: none;" >Cancelar</button>
                                &nbsp;
                                <button class="btn btn-primary" style="background: rgba(8, 192, 26, 1); outline: none;" type="submit" >Salvar</button>
                            </div>
                        </div>

                <br><br>
            </form>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
                $(document).ready(function() {
                    $('form').submit(function(event) {
                        var selectedFiles = $('#img')[0].files;
                        var isChecked = $('#tipo').prop('checked');
            
                        if (selectedFiles.length !== 2) {
                            alert('Por favor, selecione exatamente 2 imagens.');
                            event.preventDefault();
                        } else if (!isChecked) {
                            alert('Por favor, leia e concorde com os termos.');
                            event.preventDefault();
                        }
                    });
                });
            </script>
        </div>
    </div>
</div>
@endsection