@foreach($items as $item)
    <li style="position: relative;">
        @if($item->childrenRecursive->count())
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="ace-icon fa fa-angle-down bigger-110 blue"></i>
                {{ $item->nombre }}
            </a>

            <ul class="dropdown-menu" style="position: absolute; left: 100%; top: 0;">
                @include('layouts.partials.menu-items', ['items' => $item->childrenRecursive])
            </ul>
        @else
            <a href="{{ $item->ruta ?? 'javascript://' }}" id="{{ $item->html_id }}">
                <i class="ace-icon {{ $item->icono }}"></i>
                {{ $item->nombre }}
            </a>
        @endif
    </li>
@endforeach