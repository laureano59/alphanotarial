<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Tipoidentificacion;
use App\Departamento;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Clientes = new Cliente();
        $tipodocumento = $request->input('id_tipoident');
        $id = $request->input('identificacion_cli');
        if ($tipodocumento == 31){//Si es empresa
          $Clientes->id_tipoident = $request->input('id_tipoident');
          $Clientes->identificacion_cli = $request->input('identificacion_cli');
          $Clientes->digito_verif = $request->input('digito_verif');
          $Clientes->empresa = $request->input('empresa');
          $Clientes->telefono_cli = $request->input('telefono_cli');
          $Clientes->direccion_cli = $request->input('direccion_cli');
          $Clientes->id_ciud = $request->input('ciudad');
          $Clientes->email_cli = $request->input('email_cli');
          $Clientes->autoreteiva = $request->input('autoreteiva');
          $Clientes->autoretertf = $request->input('autoretertf');
          $Clientes->autoreteica = $request->input('autoreteica');
          $Clientes->save();
        }else{
          $Clientes->id_tipoident = $request->input('id_tipoident');
          $Clientes->identificacion_cli = $request->input('identificacion_cli');
          $Clientes->pmer_apellidocli = $request->input('pmer_apellidocli');
          $Clientes->sgndo_apellidocli = $request->input('sgndo_apellidocli');
          $Clientes->pmer_nombrecli = $request->input('pmer_nombrecli');
          $Clientes->sgndo_nombrecli = $request->input('sgndo_nombrecli');
          $Clientes->estadocivil = $request->input('estadocivil');
          $Clientes->telefono_cli = $request->input('telefono_cli');
          $Clientes->direccion_cli = $request->input('direccion_cli');
          $Clientes->id_ciud = $request->input('ciudad');
          $Clientes->email_cli = $request->input('email_cli');
          $Clientes->autoreteiva = $request->input('autoreteiva');
          $Clientes->autoretertf = $request->input('autoretertf');
          $Clientes->autoreteica = $request->input('autoreteica');
          $Clientes->save();
        }
        $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname");
        $nombre = Cliente::where('identificacion_cli', $id)->select($raw)->get();
        foreach ($nombre as $nom) {
          $nom = $nom->fullname;
        }
        return response()->json([
           "nombre"=> $nom
         ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      //$request->user()->authorizeRoles(['radicacion','administrador']);
      $Cliente = Cliente::where('identificacion_cli', $id)->get();
      $Identificacion = $id;

      foreach ($Cliente as $key => $cli) {
        $id_tipoident = $cli['id_tipoident'];
      }

       $Departamentos = Departamento::all();
       $Departamentos = $Departamentos->sortBy('nombre_depa'); //TODO:Ordenar por nombre
       $TipoIdentificaciones = Tipoidentificacion::all();
       return view('cliente.editar_cliente', compact('TipoIdentificaciones', 'Departamentos', 'id_tipoident', 'Cliente', 'Identificacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $opcion = $request->input('opcion');
        if($opcion == 1){
          //$cliente->id_tipoident = $request->input('id_tipoident');
          $cliente->pmer_apellidocli = $request->input('pmer_apellidocli');
          $cliente->sgndo_apellidocli = $request->input('sgndo_apellidocli');
          $cliente->pmer_nombrecli = $request->input('pmer_nombrecli');
          $cliente->sgndo_nombrecli = $request->input('sgndo_nombrecli');
          $cliente->estadocivil = $request->input('estadocivil');
          $cliente->telefono_cli = $request->input('telefono_cli');
          $cliente->direccion_cli = $request->input('direccion_cli');
          if($request->input('ciudad') != ''){ // Solo si hay cambio de ciudad
              $cliente->id_ciud = $request->input('ciudad');
          }
          $cliente->email_cli = $request->input('email_cli');
          $cliente->autoreteiva = $request->input('autoreteiva');
          $cliente->autoretertf = $request->input('autoretertf');
          $cliente->autoreteica = $request->input('autoreteica');
          $cliente->save();

          return response()->json([
             "validar"=>1,
             "mensaje"=>"Actualización Exitosa"
           ]);
        }else if($opcion == 2){
          $cliente->empresa = $request->empresa;
          $cliente->telefono_cli = $request->telefono_cli;
          $cliente->direccion_cli = $request->direccion_cli;
          if($request->input('ciudad') != ''){ // Solo si hay cambio de ciudad
              $cliente->id_ciud = $request->ciudad;
          }
          $cliente->email_cli = $request->input('email_cli');
          $cliente->autoreteiva = $request->input('autoreteiva');
          $cliente->autoretertf = $request->input('autoretertf');
          $cliente->autoreteica = $request->input('autoreteica');
          $cliente->save();

          return response()->json([
             "validar"=>1,
             "mensaje"=>"Actualización Exitosa"
           ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
