<!DOCTYPE html>
<html>

<head>
    <title>Relación Nota Crédito Caja Rápida</title>

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
                
               
                <th><font size="2">No.NC</font></th>
                <th><font size="2">No.Fact</font></th>
                <th><font size="2">Fecha_fact</font></th>
                <th><font size="2">Identificación</font></th>
                <th><font size="2">Cliente</font></th>
                <th><font size="2">Subtotal</font></th>
                <th><font size="2">Iva</font></th>
                <th><font size="2">Total</font></th>
                <th><font size="2">Facturador</font></th>
            </tr>
        </thead>
        <tbody id="datos">

             {{-- Inicializar una variable para alternar colores --}}
            @php
                $colorAlternado = true;
            @endphp
          @for ($i = 0; $i < $contcajadiario; $i++)
            @if (array_key_exists($i, $cajadiario))
             {{-- Alternar colores de fondo --}}
            @php
            $colorFondo = $colorAlternado ? '#ffffff' : '#f2f2f2';
            @endphp
              <tr style="background-color: {{ $colorFondo }}">
                 <td align="center">
                  <font size="2">{{ $cajadiario[$i]['id_ncf'] }}</font>
                </td>
                
                <td>
                  <font size="2">{{ $cajadiario[$i]['prefijo'] }} {{ $cajadiario[$i]['id_fact'] }}</font>
                </td>

                <td align="center">
                  <font size="2">{{ Carbon\Carbon::parse($cajadiario[$i]['fecha_fact'])->format('d/m/Y')}}</font>
                </td>
                <td>
                  <font size="2">{{ $cajadiario[$i]['a_nombre_de'] }}</font>
                </td>
                 <td>
                  <font size="1">{{ $cajadiario[$i]['cliente'] }}</font>
                </td>
               
                <td align="right">
                  <font size="2">{{ number_format($cajadiario[$i]['subtotal'], 2) }}</font>
                </td>
                <td align="right">
                  <font size="2">{{ number_format($cajadiario[$i]['total_iva'], 2) }}</font>
                </td>
                <td align="right">
                  <font size="2">{{ number_format($cajadiario[$i]['total_fact'], 2) }}</font>
                </td>
                
                 <td align="center">
                  <font size="2">{{ $cajadiario[$i]['name'] }}</font>
                </td>
                </tr>
                 {{-- Alternar el valor de la variable para el próximo ciclo --}}
                @php
                $colorAlternado = !$colorAlternado;
                @endphp
                  @endif
                @endfor

                <tr>
                    <td>  <font size="2"><b>-------</b></font></td>
                    <td></td>
                     <td></td>
                      <td></td>
                      <td></td>
                    <td  align="right">
                        <font size="2"><b>------------</b></font>
                    </td>
                    <td  align="right">
                      <font size="2"><b>------------</b></font>
                    </td>
                    <td align="right">
                      <font size="2"><b>------------</b></font>
                    </td>
                   <td>                      
                    </td>
                    <td>                      
                    </td>
                </tr>

                 <tr>
                    <td>  <font size="2"><b>Total</b></font></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right">
                      <font size="2"><b>{{ number_format($subtotal, 2) }}</b></font>
                    </td>
                    <td align="right">
                      <font size="2"><b>{{ number_format($total_iva, 2) }}</b></font>
                    </td>
                    <td align="right">
                      <font size="2"><b>{{ number_format($total_fact, 2) }}</b></font>
                    </td>
                    <td>                      
                    </td>
                    <td>                      
                    </td>
                </tr>
            </tbody>
            </table>

</body>

</html>
