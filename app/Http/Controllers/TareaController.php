<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;
use App\Models\User;

class TareaController extends Controller
{

    public function index()
    {
        $tareas = Tarea::with('users')->get();

        return response()->json($tareas);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|string',
            'prioridad' => 'required|string',
            'usuarios' => 'array',
            'usuarios.*' => 'exists:users,id',
        ]);

        $tarea = Tarea::create([
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'],
            'estado' => $validated['estado'],
            'prioridad' => $validated['prioridad'],
        ]);

        $tarea->users()->sync($validated['usuarios']);

        $tarea->load('users');

        return response()->json($tarea, 201);
    }

    public function show($id)
    {
        $tarea = Tarea::with('users')->find($id);

        if ($tarea) {
            return response()->json($tarea);
        } else {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'string|max:255',
            'descripcion' => 'string|max:500',
            'estado' => 'string',
            'prioridad' => 'string',
        ]);

        $tarea = Tarea::findOrFail($id);
        $tarea->update($request->all());

        return response()->json($tarea);
    }

    public function destroy($id)
    {
        $tarea = Tarea::findOrFail($id);
        $tarea->delete();

        return response()->json(null, 204);
    }
    public function getUsersByRole()
    {
        $usuarios = User::role('usuario')->get();
        return response()->json($usuarios);
    }
}
