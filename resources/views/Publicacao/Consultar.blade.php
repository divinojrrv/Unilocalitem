@extends('layouts.main')

@section('title', 'UnilocalItem')

@section('CorpoPagina')

@section('TituloPagina')

<div class="container pt-4 " style="margin-left: 280px;">
    <div class="mb-3 mt-5">
        <h3>Consultar</h3>
    </div>
    <br>
@endsection
    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" action="{{ route('consultar.publicacoes') }}">
                @csrf


                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="data" class="form-label">Período Inicial:</label>

                            <input class="form-control" id="datainicio" name="datainicio" value="" type= "datetime-local"/>
                            @error('datainicio')
                                <div class="alert alert-danger mt-3">(($message))</div>
                            @enderror
                    </div>
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                    <label for="data" class="form-label">Período Final:</label>
                            <input class="form-control" id="datafinal" name="datafinal" value="" type= "datetime-local"/>
                            @error('datafinal')
                                <div class="alert alert-danger mt-3">(($message))</div>
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
                            <label for="status" class="form-label">Status:</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Selecione uma opção</option>
                                @foreach ($statusOptions as $value => $label)
                                    <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                <br><br>


                <div class="row justify-content-end">
                    <div class="form-group col-sm-12 col-md-6 mb-3 text-end"> 
                        <button class="btn btn-primary" style="background: rgba(8, 192, 26, 1); outline: none;" type="submit">Consultar</button>
                    </div>
                </div>
            </form>
</div>

@endsection