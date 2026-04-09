@extends('layouts.principal')

@section('content')

<div class="page-header">
    <h1>Editar Menú</h1>
</div>

<div class="row">
    <div class="col-xs-12">

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('panelmenus.update', $menu->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{ $menu->nombre }}" required>
            </div>

            <div class="form-group">
                <label>Menú padre</label>
                <select name="parent_id" class="form-control">
                    <option value="">-- Menú principal --</option>

                    @include('layouts.partials.menu-options', [
                        'items' => $menus,
                        'nivel' => 0,
                        'selected' => $menu->parent_id
                    ])
                </select>
            </div>

            <div class="form-group">
                <label>HTML ID</label>
                <input type="text" name="html_id" class="form-control" value="{{ $menu->html_id }}">
            </div>

            <div class="form-group">
                <label>Icono</label>
                <input type="text" name="icono" class="form-control" value="{{ $menu->icono }}">
            </div>

            <div class="form-group">
                <label>Ruta</label>
                <input type="text" name="ruta" class="form-control" value="{{ $menu->ruta }}">
            </div>

            <div class="form-group">
                <label>Orden</label>
                <input type="number" name="orden" class="form-control" value="{{ $menu->orden }}">
            </div>

            <div class="form-group">
                <label>Estado</label>
                <select name="activo" class="form-control">
                    <option value="1" {{ $menu->activo ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ !$menu->activo ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <button class="btn btn-primary">
                <i class="ace-icon fa fa-save"></i>
                Actualizar
            </button>

            <a href="{{ route('panelmenus.index') }}" class="btn btn-default">
                Cancelar
            </a>

        </form>

    </div>
</div>

@endsection