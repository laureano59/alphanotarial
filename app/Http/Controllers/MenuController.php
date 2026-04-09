<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;


class MenuController extends Controller
{
    public function index(Request $request)
    {

        $request->user()->authorizeRoles(['administrador']);
        
        $menus = Menu::whereNull('parent_id')
            ->with('childrenRecursive')
            ->orderBy('orden')
            ->get();

        return view('menus.index', compact('menus'));
    }



    public function create()
    {
        $menus = \App\Menu::whereNull('parent_id')
            ->with('childrenRecursive')
            ->orderBy('orden')
            ->get();           

        $parent_id = request('parent_id'); 

        return view('menus.create', compact('menus', 'parent_id'));
    }




    public function store(Request $request)
    {
            $request->validate([
            'nombre' => 'required',
            'orden' => 'required|integer'
            ]);

            \App\Menu::create([
                'nombre'    => $request->nombre,
                'icono'     => $request->icono,
                'ruta'      => $request->ruta ?? 'javascript://',
                'html_id'   => $request->html_id,
                'parent_id' => $request->parent_id ?: null,
                'orden'     => $request->orden,
                'activo'    => 1
            ]);

            return redirect()->route('panelmenus.index')
            ->with('success', 'Menú creado correctamente');


    }



    public function edit($id)
    {
        $menu = Menu::findOrFail($id);

        $menus = Menu::whereNull('parent_id')
        ->with('childrenRecursive')
        ->orderBy('orden')
        ->get();

        return view('menus.edit', compact('menu', 'menus'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'orden' => 'required|integer'
        ]);

        $menu = Menu::findOrFail($id);

       
        // No puede ser su propio padre
        if ($request->parent_id == $id) {
            return back()->with('error', 'No puedes asignarte a ti mismo como padre');
        }

        // No puede ser hijo de un descendiente
        if ($this->esDescendiente($menu, $request->parent_id)) {
            return back()->with('error', 'No puedes asignar como padre a un submenú hijo');
        }

        $menu->update([
            'nombre'    => $request->nombre,
            'icono'     => $request->icono,
            'ruta'      => $request->ruta ?? 'javascript://',
            'html_id'   => $request->html_id,
            'parent_id' => $request->parent_id ?: null,
            'orden'     => $request->orden,
            'activo'    => $request->activo ?? 1
        ]);

        return redirect()->route('panelmenus.index')
        ->with('success', 'Menú actualizado correctamente');
    }


    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        $menu->delete();

        return redirect()->route('panelmenus.index')
        ->with('success', 'Menú eliminado correctamente');
    }



    private function esDescendiente($menu, $parent_id)
    {
        if (!$parent_id) return false;

            foreach ($menu->childrenRecursive as $child) {
                if ($child->id == $parent_id) {
                return true;
            }

                if ($this->esDescendiente($child, $parent_id)) {
                    return true;
                }
            }

        return false;
    }


}
