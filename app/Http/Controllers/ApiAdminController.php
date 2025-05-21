<?php

namespace App\Http\Controllers;


use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ApiAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = "";
        
        try {
            $admin_collections = Admin::all('*');
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }


        $result = $admin_collections;

        return response()->json($result, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:1|max:128|unique:admins,username',
            'password' => 'required|min:8|max:128'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $new_admin = new Admin();
        $new_admin->username = $request->get('username');
        $new_admin->password = Hash::make($request->get('password')); // Hash the password

        try {
            $new_admin->saveOrFail();
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Registration failed', 'error' => $th->getMessage()], 500);
        }

        return response()->json(['message' => 'Admin registered successfully', 'admin' => $new_admin], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $admin->createToken('admin-api-token')->plainTextToken;

        return response()->json(['admin' => $admin, 'token' => $token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     * This method might be redundant if `register` covers admin creation.
     * If it's for a different purpose (e.g., admin creating other admins), ensure it's secured.
     */
    public function store(Request $request)
    {
        // This is essentially the same as register, consider merging or securing this route
        // For now, let's assume it's a separate admin creation endpoint and hash the password
        // It should ideally be protected by auth:sanctum if only logged-in admins can create other admins
        return $this->register($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $id)
    {
        $result = "";
        
        try {
            $admin_data = Admin::find($id);
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }


        $result = $admin_data;

        return response()->json($result, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $id)
    {
        try {
            $data = Admin::find($id)->firstOrFail();;
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }

        if ($request->has('username')) {
            $validator = Validator::make($request->all(), [
                'username' => 'required|min:1|max:128',
            ], ['username.unique' => 'The username has already been taken.']);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            // Add unique check for username if it's being changed
            // $data->username = $request->get('username');
            $data->username = $request->get('username');
        }

        if ($request->has('password')) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8|max:128'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $data->password = Hash::make($request->get('password')); // Hash the password on update
        }

        try {
            $data->save();
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }

        return response()->json(['message' => 'Admin updated successfully', 'admin' => $data], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $id)
    {
        try {
            $admin_data = Admin::find($id)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }
        
        try {
            $admin_data->deleteOrFail();
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }

        return response()->json("Data has been destroyed / deleted", 200);
    }

}
