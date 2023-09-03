@extends('layouts.main')

@section('title', 'UnilocalItem')

@section('CorpoPagina')

@section('TituloPagina')


<div class="container pt-4 " style="margin-left: 280px;">
    <div class="mb-3 mt-5">
        <h3>Criar/Alterar Publicação</h3>
    </div>
    <br>
@endsection

    <div class="card">
        <div class="card-body">

            @if (session('errorC'))
            <div class='alert alert-danger w-100'>
                {{ session('errorC') }}
            </div>
            @endif
            
            <form method="POST" enctype="multipart/form-data" 

            @if(isset($item))
                action="{{ route('publicacoes.update', $item->ID) }}">
                {!! method_field('PUT') !!}
            @else
                action="{{ route('publicacoes.store') }}">
            @endif
            {!! csrf_field() !!}  

                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="NOME">Título:</label>
                            {{-- <input class="form-control" id="nome" name="nome" value="{{ old('nome', $item->NOME ?? '') }}" type="text" /> --}}
                            <input class="form-control" id="NOME" name="NOME" value="{{isset($item) ? $item->NOME : old('NOME')}}" type="text" autocomplete="off">
                        @error('NOME')
                        <div class="alert alert-danger mt-3">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label class="form-label" for="DESCRICAO">Descrição:</label>
                        <textarea class="form-control" id="DESCRICAO" name="DESCRICAO" rows="4">{{ old('DESCRICAO', $item->DESCRICAO ?? '') }}</textarea>
                        @error('DESCRICAO')
                        <div class="alert alert-danger mt-3">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="IDCATEGORIA" class="form-label">Categoria:</label>
                        <select class="form-select" id="IDCATEGORIA" name="IDCATEGORIA" >
                            <option value="">Selecione uma opção</option>
                            @foreach($categorias_combobox as $ID => $NOME)
                                <option value="{{ $ID }}" {{ old('IDCATEGORIA', $item->IDCATEGORIA ?? '') == $ID ? 'selected' : '' }}>{{ $NOME }}</option>
                            @endforeach
                        </select>
                        @error('IDCATEGORIA')
                        <div class="alert alert-danger mt-3">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="IDBLOCO" class="form-label">Bloco:</label>
                        <select class="form-select" id="IDBLOCO" name="IDBLOCO" >
                            <option value="">Selecione uma opção</option>
                            @foreach($blocos_combobox as $ID => $NOME)
                                <option value="{{ $ID }}" {{ old('IDBLOCO', $item->IDBLOCO ?? '') == $ID ? 'selected' : '' }}>{{ $NOME }}</option>
                            @endforeach
                        </select>
                        @error('IDBLOCO')
                        <div class="alert alert-danger mt-3">{{$message}}</div>
                        @enderror
                    </div>
                
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="DATAHORA" class="form-label">Data:</label>
                        <input class="form-control" id="DATAHORA" name="DATAHORA" type= "datetime-local" value="{{ old('DATAHORA', $item->DATAHORA ?? '') }}" />
                        @error('DATAHORA')
                        <div class="alert alert-danger mt-3">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="imagem" class="form-label">Imagem:</label>
                        <input class="form-control" id="imagem" name="imagem" value="{{isset($item) ? $item->imagem : old('imagem')}}" type="file" accept="image/jpeg, image/png, image/gif">
                        @if(isset($item))
                        <p><b>Se deseja alterar a imagem abaixo, basta selecionar uma nova! Se não prossiga sem selecionar nenhuma!</b></p>
                        @if ($item->imageName)
                        <img src="{{ asset('img/events/'.$item->imageName) }}" height="150" width="150" alt="Imagem da Publicação">
                        @endif
                        @endif
                        @error('imagem')
                        <div class="alert alert-danger mt-3">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <INPUT class="form-control" type="hidden" id="IDUSUARIO" name="IDUSUARIO" VALUE="{{ session('user_id') }}">
                <INPUT class="form-control" type="hidden" id="STATUS" name="STATUS" VALUE="1">
                <br><br>

    <!-- MOSTRAR OS BOTÕES NO FIM DO FORMULARIO--> 
                <div class="row justify-content-end">
                    <div class="form-group col-sm-12 col-md-6 mb-3 text-end"> 
                        
                    
  <!-- MOSTRAR OS BOTÕES NO FIM DOS INPUTS TEXTS DO FORMULARIO  
                <div class="row d-flex justify-content-between align-items-end">
                    <div class="form-group col-sm-12 col-md-6 mb-3 text-end">-->  
                        <button class="btn btn-primary" style="background-color: rgba(244, 7, 7, 1); outline: none;" type="cancel" >Cancelar</button>
                        &nbsp
                        <button class="btn btn-primary" style="background: rgba(8, 192, 26, 1); outline: none;" type="submit" >Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection