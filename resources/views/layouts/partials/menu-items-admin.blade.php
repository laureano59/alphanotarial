@foreach($items as $item)
    <tr>
        <td>
            {{-- Sangría por nivel --}}
            @for($i = 0; $i < $nivel; $i++)
                &nbsp;&nbsp;&nbsp;&nbsp;
            @endfor

            @if($nivel > 0)
                <i class="fa fa-level-up fa-rotate-90 text-muted"></i>
            @endif

            <strong>{{ $item->nombre }}</strong>
        </td>

        <td>{{ $item->html_id }}</td>

        <td>
            <span class="label label-info">
                {{ $item->orden }}
            </span>
        </td>

        <td>
            @if($item->activo)
                <span class="label label-success">Activo</span>
            @else
                <span class="label label-danger">Inactivo</span>
            @endif
        </td>

        <td>
            <div class="btn-group btn-group-xs">

                <a href="{{ route('panelmenus.edit', $item->id) }}" class="btn btn-primary">
                    <i class="ace-icon fa fa-pencil"></i>
                </a>

                <a href="{{ route('panelmenus.create') }}?parent_id={{ $item->id }}" class="btn btn-success">
                    <i class="ace-icon fa fa-plus"></i>
                </a>

              <form action="{{ route('panelmenus.destroy', $item->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')

    <button class="btn btn-danger btn-xs" onclick="return confirm('¿Eliminar este menú y sus submenús?')">
        <i class="ace-icon fa fa-times"></i>
    </button>
</form>

            </div>
        </td>
    </tr>

    {{-- Hijos --}}
    @if($item->childrenRecursive->count())
        @include('layouts.partials.menu-items-admin', [
            'items' => $item->childrenRecursive,
            'nivel' => $nivel + 1
        ])
    @endif
@endforeach