<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Listar todos los usuarios. (Solo accesible por Admin)
     * Endpoint: GET /api/v1/users
     */
    public function index()
    {
        // En este punto, el middleware de autorización se encargará de asegurar que solo los 'admin' accedan.
        $users = User::with('role')->paginate(15);

        return response()->json($users);
    }

    /**
     * Obtener los detalles de un usuario específico. (Solo accesible por Admin)
     * Endpoint: GET /api/v1/users/{user}
     */
    public function show(User $user)
    {
        return response()->json($user->load('role'));
    }

    /**
     * Crear un nuevo usuario (Generalmente para ser usado por el Admin para crear otros Admins/Clientes)
     * Endpoint: POST /api/v1/users
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            // Aseguramos que el role_id sea válido y exista en la tabla 'roles'
            'role_id' => 'required|integer|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return response()->json(['message' => 'Usuario creado exitosamente', 'user' => $user->load('role')], 201);
    }

    /**
     * Actualizar los datos de un usuario. (Solo accesible por Admin)
     * Endpoint: PUT/PATCH /api/v1/users/{user}
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            // El email debe ser único, excluyendo el ID del usuario actual
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'role_id' => 'sometimes|required|integer|exists:roles,id',
        ]);

        $user->name = $request->input('name', $user->name);
        $user->email = $request->input('email', $user->email);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->filled('role_id')) {
            $user->role_id = $request->role_id;
        }

        $user->save();

        return response()->json(['message' => 'Usuario actualizado exitosamente', 'user' => $user->load('role')]);
    }

    /**
     * Eliminar un usuario. (Solo accesible por Admin)
     * Endpoint: DELETE /api/v1/users/{user}
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'Usuario eliminado exitosamente']);
    }
}