@extends('layouts.main')

@section('title', 'UnilocalItem')

@section('CorpoPagina')

    @section('TituloPagina')


<link rel="stylesheet" href="/css/style.css">

<div class="container pt-4 " style="margin-left: 280px;">
    <div class="mb-3 mt-5">
        <h3>Publicações</h3>
    </div>
    <br>
    @endsection

    @if (session('message'))
        <div class='alert alert-success w-100'>
            {{ session('message') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12">
            
            <form id="meuForm"  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @forelse ($items as $item)

                <div class="card">
                    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
                        <div class="dropdown pt-2">
                            &nbsp;
                          <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                            </svg>
                            &nbsp;
                            <a>{{ $item->UserName }}</a>
                            &nbsp;
                            <a>{{ $item->DATAHORA }}</a>
                            <form class="w-100 me-3"></form>  
                        </div>

                        <div class="d-flex align-items-center">
                            <form class="w-100 me-3"></form>
                            <div class="flex-shrink-0 dropdown">
                                {{-- <a href="{{ route('resgate.edit', ['ID' => $item->ID, 'IdResgate' => $item->IdResgate]) }}"> --}}

                                <a href="{{ route('resgate.edit', ['ID' => $item->ID, 'IdResgate' => $item->IdResgate]) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                    </svg>
                                    </a> 

                                &nbsp;
                                <a href="#" onclick="event.preventDefault(); if (confirm('Tem certeza que deseja excluir?')) document.getElementById('delete-form').submit();" style="color: rgba(244, 7, 7, 1); outline: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row g-0">
                       
                        
                        <div class="col-md-4">
                            @if ($item->image)
                                <img src="{{ asset('img/events/'.$item->image) }}" class="img-fluid" style="max-height: 250px; max-width=300px" alt="Imagem do evento">
                            @else
                                <img src="{{ asset('img/no-image-found.png') }}" class="img-fluid" style="max-height: 250px; max-width=300px" alt="Imagem não encontrada">
                            @endif
                        </div>
                        <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title mb-2">{{ $item->NOME }}</h5><br>
                            <p class="card-text text-secondary mb-2">{{ $item->DESCRICAO }}</p><br>
                            <p class="card-text text-secondary mb-2">Categoria:  {{ $item->CategoriaName }}</p>
                            <p class="card-text text-secondary mb-2">Horário Cadastrado: {{ $item->DATAHORA }}</p>
                            <p class="card-text text-secondary mb-2">Localizado:  {{ $item->BlocoName }}</p>

                            <div class="mt-auto d-flex justify-content-end">
                                <a class="btn btn-primary" style="background: rgba(8, 135, 192, 1); outline: none;" href="{{ route('publicacoes.solicitacaoDeResgateVizualizar', $item->ID) }}">Visualizar Solicitação</a>
                            </div>

                        </div>
                        </div>
                    </div>
                </div>

                <form id="delete-form" title="Delete" method="post" action="{{ route('publicacoes.resgateDelete', $item->ID) }}" class="d-none">
                    {!! method_field('DELETE') !!} 
                    {!! csrf_field() !!}
                </form>
                
                @empty
                    <div class="card text-center p-3 d-flex align-items-center">
                        <img src="{{ asset('img/sempubli.jpg')}}" alt="empty-state" width="450"/>

                        <h4> Nenhuma Publicação encontrada!! </h4>
                    </div>
                @endforelse

            </form>
        </div>
    </div>


</div>
@endsection