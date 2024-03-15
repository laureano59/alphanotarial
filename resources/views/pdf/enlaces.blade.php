<!DOCTYPE html>
<html>

<head>
    <title>Enlaces</title>

</head>

<body>
  <table width="100%">
      <tr>
          <td>
              <table>
                  <tr>
                      <td>
                          <font size="4"><b>{{$nombre_nota}}</b></font>
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
                          <font size="2">{{$direccion_nota}} / {{$telefono_nota}}</font>
                      </td>
                  </tr>

                  <tr>
                      <td>
                          <b>{{$nombre_reporte}}</b>
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <b>Fecha : {{$fecha1}} / {{$fecha2}}</b>
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
          <th>ACTO</th>
          <th>CANTIDAD</th>
        </tr>
      </thead>
      <tbody id="datos">
        <tr>
          <td>
            COMPRAVENTA BIEN INMUEBLE
          </td>
          <td  align="center">
            {{$cantventa}}
          </td>
        </tr>

        <tr>
          <td>
            HIPOTECAS 
          </td>
          <td align="center">
            {{$canthipotecas}}
          </td>
        </tr>

        <tr>
          <td>
            CANCELACION HIPOTECA 
          </td>
          <td align="center">
            {{$cantcancelhipo}}
          </td>
        </tr>

        <tr>
          <td>
            ESCRITURAS VIS 
          </td>
          <td align="center">
            {{$cantescriturasvis}}
          </td>
        </tr>

        <tr>
          <td>
            ESCRITURAS VIP 
          </td>
          <td align="center">
            {{$cantescriturasvip}}
          </td>
        </tr>

        <tr>
          <td>
            ESCRITURAS VIPA
          </td>
          <td align="center">
            {{$cantescriturasvipa}}
          </td>
        </tr>

        <tr>
          <td>
            SUCESIONES
          </td>
          <td align="center">
            {{$cantsucesiones}}
          </td>
        </tr>

        <tr>
          <td>
            PERMUTAS INMUEBLES
          </td>
          <td align="center">
            {{$cantpermutas}}
          </td>
        </tr>

        <tr>
          <td>
            OTRAS ESCRITURAS SOBRE INMUEBLES
          </td>
          <td align="center">
            {{$cantotrasescrsobreinmueb}}
          </td>
        </tr>

        <tr>
          <td>
            CONTRATOS DE ARRENDAMIENTOS
          </td>
          <td align="center">
            {{$cantcontratodearrenda}}
          </td>
        </tr>

        <tr>
          <td>
            FIDUCIAS
          </td>
          <td align="center">
            {{$cantfiducias}}
          </td>
        </tr>

        <tr>
          <td>
            LEASING 
          </td>
          <td align="center">
            {{$cantleasing}}
          </td>
        </tr>

        <tr>
          <td>
            CONSTITUCIONES SOCIEDAD
          </td>
          <td align="center">
            {{$cantconstitusocied}}
          </td>
        </tr>

        <tr>
          <td>
            LIQUIDACION SOCIEDAD COMERCIAL
          </td>
          <td align="center">
            {{$cantliqsocied}}
          </td>
        </tr>

        <tr>
          <td>
            REFORMA SOCIAL  COMERCIAL 
          </td>
          <td align="center">
            {{$cantreformsocial}}
          </td>
        </tr>

        <tr>
          <td>
            MATRIMONIO CIVIL  HETEROSEXUALES
          </td>
          <td align="center">
            {{$cantmatrimoniociv}}
          </td>
        </tr>

        <tr>
          <td>
            MATRIMONIOS PERSONAS DEL MISMO SEXO
          </td>
          <td align="center">
            {{$cantmatrimismosexo}}
          </td>
        </tr>

         <tr>
          <td>
            DIVORCIOS
          </td>
          <td align="center">
            {{$cantdivorcios}}
          </td>
        </tr>

         <tr>
          <td>
            DECLARACIÓN UNION MARITAL DE HECHO 
          </td>
          <td align="center">
            {{$cantdeclaunionmaritdhech}}
          </td>
        </tr>

         <tr>
          <td>
            DISOLUCIÓN UNION MARITAL DE HECHO
          </td>
          <td align="center">
            {{$cantdisounimaritdhech}}
          </td>
        </tr>

         <tr>
          <td>
            DISOLUCION / LIQ SOCIEDA CONYUGAL
          </td>
          <td align="center">
            {{$cantdisoluliqsocconyu}}
          </td>
        </tr>

         <tr>
          <td>
            CORRECCION REGISTRO CIVIL
          </td>
          <td align="center">
            {{$cantcorrecregcivil}}
          </td>
        </tr>

         <tr>
          <td>
            CAMBIO DE NOMBRE
          </td>
          <td align="center">
            {{$cantcambionombre}}
          </td>
        </tr>

         <tr>
          <td>
            LEGITIMACIONES HIJOS
          </td>
          <td align="center">
            {{$cantligitimhijos}}
          </td>
        </tr>

         <tr>
          <td>
            CAPITULACIONES MATRIMONIALES
          </td>
          <td align="center">
            {{$cantcapitumatrimo}}
          </td>
        </tr>

         <tr>
          <td>
            INTERDICCIÓN JUDICIAL 
          </td>
          <td align="center">
            {{$cantinterdicjudic}}
          </td>
        </tr>

         <tr>
          <td>
            UNIONES PERSONAS DEL MISMO SEXO
          </td>
          <td align="center">
            {{$cantunipersomismosexo}}
          </td>
        </tr>

         <tr>
          <td>
            ACTAS COMPARECENCIA
          </td>
          <td align="center">
            {{$cantactascomparec}}
          </td>
        </tr>

         <tr>
          <td>
            AUTENTICACIONES
          </td>
          <td align="center">
            {{$cantautenticac}}
          </td>
        </tr>

         <tr>
          <td>
            DECLARACIONES EXTRAJUICIO
          </td>
          <td align="center">
            {{$cantdeclarextrajuic}}
          </td>
        </tr>

         <tr>
          <td>
            DECLARACIONES SUPERVIVENCIA
          </td>
          <td align="center">
            {{$cantdeclarsuperviv}}
          </td>
        </tr>

         <tr>
          <td>
            CONCILIACIONES
          </td>
          <td align="center">
            {{$cantconciliac}}
          </td>
        </tr>

         <tr>
          <td>
            REMATES DE INMUEBLES
          </td>
          <td align="center">
            {{$cantrematinmueb}}
          </td>
        </tr>

         <tr>
          <td>
            COPIAS REGISTRO CIVIL
          </td>
          <td align="center">
            {{$cantcopiregcivil}}
          </td>
        </tr>

         <tr>
          <td>
            REGISTRO CIVIL NACIMIENTO
          </td>
          <td align="center">
            {{$cantregcivnacim}}
          </td>
        </tr>

         <tr>
          <td>
            REGISTRO CIVIL MATRIMONIO
          </td>
          <td align="center">
            {{$cantregcivimatrim}}
          </td>
        </tr>

         <tr>
          <td>
            REGISTRO CIVIL DEFUNCIÓN
          </td>
          <td align="center">
            {{$cantregcivdefunc}}
          </td>
        </tr>

         <tr>
          <td>
            ESCRIT PÚBLICA CORRECIÓN DEL COMPONENTE SEXO MASC A
          </td>
          <td align="center">
            {{$cantescrpublicorreccomposexmasca}}
          </td>
        </tr>

         <tr>
          <td>
            ESCRIT PÚBLICA CORRECIÓN DEL COMPONENTE SEXO FEME A
          </td>
          <td align="center">
            {{$cantescrpublicorreccomposexfema}}
          </td>
        </tr>

         <tr>
          <td>
            MATRIMONIO CIVIL QUE INVOLUCRAN MENOR DE EDAD
          </td>
          <td align="center">
            {{$cantmatrimenoredad}}
          </td>
        </tr>

         <tr>
          <td>
            PROCEDIMIENTOS INSOLV ECONOMICA PERSONA NATURAL
          </td>
          <td align="center">
            {{$cantprocedinsoleconopersonatur}}
          </td>
        </tr>

         <tr>
          <td>
            OTROS
          </td>
          <td align="center">
            {{$cantotros}}
          </td>
        </tr>

        <tr>
          <td>
            <b>--------------------</b>
          </td>
          <td align="center">
            <b>--------------</b>
          </td>
        </tr>

        <tr>
          <td>
            <b>TOTAL</b>
          </td>
          <td align="center">
            <b>{{$totalcantidad}}</b>
          </td>
        </tr>
      </tbody>
    </table>

</body>

</html>
