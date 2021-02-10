@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">

    <h1>
        Ingresos por Escritura<span id="radi">

    </h1>
</div><!-- /.page-header -->

@endsection

@section('scripts')
  <script src="{{ asset('js/reportes/script.js')}}"></script>
  <script src="{{ asset('js/calendario.js')}}"></script>
  <script src="{{ asset('js/__AJAX.js')}}"></script>
@endsection
