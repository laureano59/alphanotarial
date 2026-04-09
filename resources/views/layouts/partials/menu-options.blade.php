@foreach($items as $item)
    <option value="{{ $item->id }}"
        {{ isset($selected) && $selected == $item->id ? 'selected' : '' }}>
    
        @for($i = 0; $i < $nivel; $i++)
        ├──
        @endfor

        {{ $item->nombre }}
    </option>

    @if($item->childrenRecursive->count())
        @include('layouts.partials.menu-options', [
            'items' => $item->childrenRecursive,
            'nivel' => $nivel + 1
        ])
    @endif
@endforeach