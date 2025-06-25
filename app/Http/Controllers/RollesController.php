<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Rolusers;

class RollesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $request->user()->authorizeRoles(['administrador']);
        
        $Usuarios = User::orderBy('name')->get();        
        return view('roles.roles' , compact('Usuarios')); 

         
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $newRoles = $request->roles; // array de role_id


        \DB::beginTransaction();

        try {
            // Paso 1: Obtener todos los roles actuales del usuario
            $existingRoles = Rolusers::where('user_id', $id)->pluck('role_id')->toArray();


            // Paso 2: Determinar roles a eliminar
            $rolesToDelete = array_diff($existingRoles, $newRoles);



            // Paso 3: Determinar roles a insertar
            $rolesToInsert = array_diff($newRoles, $existingRoles);


            // Paso 4: Eliminar los roles que ya no debe tener
            if (!empty($rolesToDelete)) {
                Rolusers::where('user_id', $id)
                ->whereIn('role_id', $rolesToDelete)
                ->delete();
            }


            // Paso 5: Insertar nuevos roles
            foreach ($rolesToInsert as $roleId) {
                Rolusers::create([
                'user_id' => $id,
                'role_id' => $roleId
                ]);
            }

           
            \DB::commit();

            return response()->json([
                "validar"=> 1,
                'mensaje' => 'Roles actualizados correctamente.'
            ]);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                "validar"=> 1,
                'mensaje' => 'Error al actualizar roles.', 'error' => $e->getMessage()], 500);
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

    public function CargarRoles(Request $request)
    {
        $id_user = $request->id_user;
        $RolUsers = Rolusers::
        where("user_id","=",$id_user)
        ->get();

        if(!$RolUsers->isEmpty()){
            return response()->json([
                "validar"=> 1,
                "RolUsers"=> $RolUsers
                ]);
        }
    }
}
