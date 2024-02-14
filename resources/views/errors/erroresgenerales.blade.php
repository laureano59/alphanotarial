@extends('layouts.app')
@section('content')

    <div class="flex-center position-ref full-height">

      <div class="content">
        <h1 class="grey lighter smaller">
          <span class="blue bigger-125">
            <i class="ace-icon fa fa-sitemap"></i>
            Error Excepción:
          </span>
          {{$Mensaje}}
        </h1>

        <hr />
        <div>
          <h4 class="smaller">Es posible que:</h4>

          <ul class="list-unstyled spaced inline bigger-110 margin-15">
            <li>
              <i class="ace-icon fa fa-hand-o-right blue"></i>
              Una variable esté nula o vacía
            </li>

            <li>
              <i class="ace-icon fa fa-hand-o-right blue"></i>
              No se haya guardado antes de imprimir un informe
            </li>
          </ul>
        </div>

        <hr />

        </div>

    </div>
@endsection

@section('csslaure')
  <!-- Styles -->
  <style>
      html, body {
          background-color: #fff;
          color: #636b6f;
          font-family: 'Nunito', sans-serif;
          font-weight: 200;
          height: 100vh;
          margin: 0;
      }

      .full-height {
          height: 70vh;
      }

      .flex-center {
          align-items: center;
          display: flex;
          justify-content: center;
      }

      .position-ref {
          position: relative;
      }

      .top-right {
          position: absolute;
          right: 10px;
          top: 18px;
      }

      .content {
          text-align: left;
      }

      .title {
          font-size: 84px;
      }

      .links > a {
          color: #636b6f;
          padding: 0 25px;
          font-size: 13px;
          font-weight: 600;
          letter-spacing: .1rem;
          text-decoration: none;
          text-transform: uppercase;
      }


  </style>
@endsection
