@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">

    <h1>
        Tutoriales Alpha-Notarial<span id="radi">

    </h1>
</div><!-- /.page-header -->


<div class="row" style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center;">
    <div style="flex: 1 0 50%; box-sizing: border-box; padding: 10px; text-align: center;">
        <h3>1. Modulo de radicación</h3>
        <iframe src="https://drive.google.com/file/d/1HwnBTs-TW01Xa1DrIT2PoMbqzSXQpKQl/preview" width="300" height="150" allow="autoplay" allowfullscreen></iframe>
    </div>

    <div style="flex: 1 0 50%; box-sizing: border-box; padding: 10px; text-align: center;">
        <h3>2. Modulo de Liquidación</h3>
        <iframe src="https://drive.google.com/file/d/1I1mrBs-PWbkHIoVnPz-ksZFo-v-b2GSL/preview" width="300" height="150" allow="autoplay" allowfullscreen></iframe>
    </div>

    <div style="flex: 1 0 50%; box-sizing: border-box; padding: 10px; text-align: center;">
        <h3>3. Nuevo Modulo de Facturación</h3>
        <iframe src="https://drive.google.com/file/d/1c3kUVlCNafrfgSNiAzVypTPTtI6bbouj/preview" width="300" height="150" allow="autoplay" allowfullscreen></iframe>
    </div>

    

    <div style="flex: 1 0 50%; box-sizing: border-box; padding: 10px; text-align: center;">
        <h3>5. Modulo Cuentas de Cobro</h3>
        <iframe src="https://drive.google.com/file/d/1-fdTX7lm6Rcl4eJWuqabGEUW49s9hgqw/preview" width="300" height="150" allow="autoplay"></iframe>
    </div>
</div>


@endsection


@section('scripts')
 
  <script src="{{asset('assets/js/jquery-ui.custom.min.js')}}"></script>
  <script src="{{asset('assets/js/chosen.jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/spinbox.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{asset('assets/js/autosize.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery.inputlimiter.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery.maskedinput.min.js')}}"></script>
@endsection
