@extends('layouts.principal')

@section('content')


<div class="page-header">
    <h1>
        Crear Menú
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Nueva opción
        </small>
    </h1>
</div>

<div class="row">
    <div class="col-xs-12">

        <form action="/panelmenus" method="POST">
            @csrf

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Menú padre</label>
                <select name="parent_id" class="form-control">
                    <option value="">-- Menú principal --</option>

                   @include('layouts.partials.menu-options', [
                        'items' => $menus,
                        'nivel' => 0,
                        'selected' => $parent_id
                    ])
                </select>
            </div>

            <div class="form-group">
                <label>HTML ID (para JS)</label>
                <input type="text" name="html_id" class="form-control">
            </div>

            <div class="form-group">
                <label>Icono (clase)</label>
                <input type="text" name="icono" class="form-control" placeholder="fa fa-file-text-o bigger-110 green">
            </div>

            <div class="form-group">
                <label>Ruta</label>
                <input type="text" name="ruta" class="form-control" value="javascript://">
            </div>

            <div class="form-group">
                <label>Orden</label>
                <input type="number" name="orden" class="form-control" value="1" required>
            </div>

            <div class="form-group">
                <button class="btn btn-success">
                    <i class="ace-icon fa fa-save"></i>
                    Guardar
                </button>

                <a href="/panelmenus" class="btn btn-default">
                    Cancelar
                </a>
            </div>

        </form>

    </div>
</div>

@endsection