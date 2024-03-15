<!DOCTYPE html>
<html>

<head>
    <title>Libro Indice</title>

</head>

<body>
    <table width="100%">
        <tr>
            <td>
                <table>
                    <tr>
                        <td>
                            <font size="3"><b>{{$nombre_nota}}</b></font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font size="3">{{$nombre_notario}}</font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font size="3">Nit. {{$nit}}</font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font size="2">{{$direccion_nota}}</font>
                        </td>
                    </tr>
                    <tr>
                        <td>{{$nombre_reporte}}</td>
                    </tr>
                    <tr>
                      <td>
                        Fecha del Reporte : {{$fecha_reporte}}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Fecha de impresión : {{$fecha_impresion}}
                      </td>
                    </tr>
                </table>
            </td>
            <td>
                <img src="{{ asset('images/logon13.png') }}" width="85px" height="85px"></br>
                <center>{{$email}}</center>
            </td>
        </tr>
    </table>
    <hr>
    <table width="100%">
        <thead>
            <tr>
                <th><font size="2">FECHA ESCRITURA</font></th>
                <th><font size="2">ESCRITURA</font></th>
                <th><font size="2">PRIMER OTORGANTE</font></th>
                <th><font size="2">SEGUNDO OTORGANTE</font></th>
                <th><font size="2">ACTO</font></th>
            </tr>
        </thead>
        <tbody id="datos">

             {{-- Inicializar una variable para alternar colores --}}
            @php
                $colorAlternado = true;
            @endphp
            
           @foreach($libroindice as $item)
            {{-- Alternar colores de fondo --}}
            @php
            $colorFondo = $colorAlternado ? '#ffffff' : '#f2f2f2';
            @endphp
           
              <tr style="background-color: {{ $colorFondo }}">
                <td>
                  <font size="2">{{ $item['fecha'] }}</font>
                </td>
                <td  align="center">
                  <font size="2">{{ $item['num_esc'] }}</font>
                </td>
                <td>
                  <font size="2">{{$item['otorgante'] }}</font>
                </td>
                <td>
                  <font size="2">{{ $item['compareciente'] }}</font>
                </td>
                <td>
                  <font size="2">{{ $item['acto'] }}</font>
                </td>
                
                </tr>
                {{-- Alternar el valor de la variable para el próximo ciclo --}}
                @php
                $colorAlternado = !$colorAlternado;
                @endphp
             @endforeach
                    
            </tbody>
            </table>
            <hr>

</body>

</html>
