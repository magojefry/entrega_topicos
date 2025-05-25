<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EmpleadoService;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{
    
    protected $empleadoService;

    public function __construct(EmpleadoService $empleadoService)
    {
        $this->empleadoService = $empleadoService;
    }

    // Listar empleados
    public function index()
    {
        $empleados = DB::select('SELECT * FROM empleados ORDER BY id DESC');
        return response()->json($empleados);
    }

    // Crear nuevo empleado
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'salario' => 'required|numeric|min:0',
        ]);

        $this->empleadoService->insertarEmpleado($request->nombre, $request->salario);

        return response()->json(['message' => 'Empleado creado con éxito'], 201);
    }

    // Mostrar un empleado
    public function show($id)
    {
        $empleado = $this->empleadoService->obtenerEmpleado($id);

        if (empty($empleado)) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        return response()->json($empleado[0]);
    }

    // Actualizar empleado
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'salario' => 'required|numeric|min:0',
        ]);

        $this->empleadoService->actualizarEmpleado($id, $request->nombre, $request->salario);

        return response()->json(['message' => 'Empleado actualizado']);
    }

    // Eliminar empleado
    public function destroy($id)
    {
        $this->empleadoService->eliminarEmpleado($id);

        return response()->json(['message' => 'Empleado eliminado']);
    }

}
