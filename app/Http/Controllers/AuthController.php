<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Registra un nuevo usuario (Cliente) en el sistema.
     * Endpoint: POST /api/v1/auth/register
     */
    public function register(Request $request)
    {
        // 1. Validar la solicitud
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' busca 'password_confirmation'
        ]);

        // 2. Obtener el ID del rol 'cliente'
        // NOTA: Asumimos que el rol 'cliente' ya existe en la tabla 'roles'.
        // Usamos firstOrFail() para asegurar que el rol exista.
        $role_id = Role::where('name', 'cliente')->firstOrFail()->id; 

        // 3. Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role_id, // <-- MODIFICADO: Usar role_id
        ]);

        // 4. Generar el Token de Acceso Personal de Sanctum
        $token = $user->createToken('client_token')->plainTextToken;

        // 5. Retornar la respuesta (incluyendo el nombre del rol)
        return response()->json([
            'user' => $user->only(['id', 'name', 'email', 'role_id']),
            'role_name' => 'cliente', // Devolvemos el nombre del rol para el frontend
            'token' => $token,
            'message' => 'Registro exitoso. Bienvenido.',
        ], 201);
    }

    /**
     * Autentica un usuario y emite un token.
     * Endpoint: POST /api/v1/auth/login
     */
    public function login(Request $request)
    {
        // 1. Validar credenciales
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Intentar encontrar el usuario por email. Cargar el rol relacionado.
        $user = User::with('role')->where('email', $request->email)->first(); // <-- MODIFICADO: Cargar relación 'role'

        // 3. Verificar si el usuario existe y la contraseña es correcta
        if (! $user || ! Hash::check($request->password, $user->password)) {
            // Lanza una excepción de validación
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        // 4. Eliminar tokens antiguos (opcional)
        $user->tokens()->delete();
        
        // 5. Obtener el nombre del rol para Sanctum abilities (permisos)
        // Usamos el nombre del rol desde la relación, no desde una columna 'role'
        $roleName = $user->role->name; 

        // 6. Generar un nuevo Token
        // Usamos el nombre del rol como 'ability' para el middleware de autorización (Tarea 1.4)
        $token = $user->createToken('auth_token', [$roleName])->plainTextToken; 

        // 7. Retornar la respuesta
        return response()->json([
            'user' => $user->only(['id', 'name', 'email', 'role_id']),
            'token' => $token,
            'role' => $roleName, // <-- MODIFICADO: Devolver el nombre del rol
            'message' => 'Inicio de sesión exitoso.',
        ]);
    }

    /**
     * Invalida el token de sesión del usuario.
     * Endpoint: POST /api/v1/auth/logout
     */
    public function logout(Request $request)
    {
        // El token actual que se utiliza para la solicitud es revocado.
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada exitosamente.'
        ]);
    }
}