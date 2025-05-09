@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">

    <h1>
        Certificado de Retención en la Fuente<span id="radi">

    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-sm-12">
        <form>
            @csrf
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Ingresar documento de identificación y el año gravable</h4>
                    <span class="widget-toolbar">
                        <a href="#" data-action="settings" id="imprimircertificadortf">
                            <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Generar Certificado"></i>
                        </a>
                    </span>
                    <span class="nav-search widget-toolbar">
                        <div class="input-daterange input-group">
                            <input type="text" id="identificacion" class="input-sm form-control" name="identificacion" placeholder="Identificación" />                       

                        
                            <input type="text" maxlength="4" style="width: 50px;" onKeyPress="return soloNumeros(event)" id="aniogravable" class="input-sm form-control" name="aniogravable" placeholder="Año" />
                            
                        </div>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('csslau')
<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datepicker3.min.css')}}" />
@endsection

@section('scripts')
  <script src="{{ asset('js/__AJAX.js')}}"></script>
  <script src="{{asset('assets/js/jquery-ui.custom.min.js')}}"></script>
  <script src="{{asset('assets/js/chosen.jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/spinbox.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{asset('assets/js/autosize.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery.inputlimiter.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery.maskedinput.min.js')}}"></script>
  <script src="{{ asset('js/solonumeros.js')}}"></script>
@endsection
