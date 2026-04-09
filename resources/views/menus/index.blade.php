@extends('layouts.principal')

@section('content')

<div class="page-header">
    <h1>
        Administración de Menú
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Gestión de opciones
        </small>
    </h1>
</div>

<div class="row">
    <div class="col-xs-12">

        <div class="clearfix" style="margin-bottom:10px;">
            <a href="/menucreate" class="btn btn-success">
                <i class="ace-icon fa fa-plus"></i>
                Nuevo menú principal
            </a>
        </div>

        <div class="widget-box">
            <div class="widget-header widget-header-flat">
                <h4 class="widget-title smaller">
                    <i class="ace-icon fa fa-sitemap"></i>
                    Estructura del menú
                </h4>
            </div>

            <div class="widget-body">
                <div class="widget-main no-padding">

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>HTML ID</th>
                                <th>Orden</th>
                                <th>Estado</th>
                                <th width="220">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @include('layouts.partials.menu-items-admin', ['items' => $menus, 'nivel' => 0])
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection