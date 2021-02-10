@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">

    <h1>
        Consutas Alpha Notarial<span id="radi">

    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <div class="center">

            <table class="table table-striped table-bordered table-hover head">
                <tr>
                    <td>
                        <a href="/rastrearradicacion">
                            Rastrear Radicación
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        Otros
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<br>

@endsection

@section('scripts')
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
@endsection
