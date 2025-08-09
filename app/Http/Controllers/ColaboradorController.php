<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;
use Exception;

class ColaboradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $colaboradores = Colaborador::all();

            return response()->json($colaboradores);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al obtener colaboradores: ' . $e->getMessage()], 500);
        }
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
        try {
            $request->validate([
                'nombre_completo' => 'required',
                'empresa' => 'required',
                'area' => 'required',
                'departamento' => 'required',
                'puesto' => 'required',
                'fotografia' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'fecha_de_alta' => 'required|date',
                'estatus' => 'required|boolean',
            ]);

            $colaborador = new Colaborador($request->except('fotografia'));

            if ($request->hasFile('fotografia')) {
                $fotografia = $request->file('fotografia');
                $nombre_archivo = time() . '.' . $fotografia->getClientOriginalExtension();
                $fotografia->move(public_path('fotografias'), $nombre_archivo);
                $colaborador->fotografia = $nombre_archivo;
            }

            $colaborador->save();

            return response()->json($colaborador, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al crear colaborador: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Colaborador  $colaborador
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        try {
            $colaborador = Colaborador::findOrFail($id);

            return response()->json($colaborador);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al obtener colaborador: ' . $e->getMessage()], 500);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Colaborador  $colaborador
     * @return \Illuminate\Http\Response
     */
    public function edit(Colaborador $colaborador)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Colaborador  $colaborador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        try {
            $colaborador = Colaborador::findOrFail($id);


            $colaborador->update($request->all());


            return response()->json($colaborador);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al actualizar colaborador: ' . $e->getMessage()], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Colaborador  $colaborador
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        try {
            $colaborador = Colaborador::findOrFail($id);

            $colaborador->delete();


            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al eliminar colaborador: ' . $e->getMessage()], 500);
        }
    }
}
