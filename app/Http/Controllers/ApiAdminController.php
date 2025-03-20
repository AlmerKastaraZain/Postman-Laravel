<?php

namespace App\Http\Controllers;


use App\Models\Admin;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:1|max:128',
            'password' => 'required|min:8|max:128'
        ]);
        
        if ($validator->fails()) {
            return response()->json('Incorrect format', status: 400);
        }

        $new_admin = new Admin();
        $new_admin->username = $request->get('username');
        $new_admin->password = $request->get('password');

        try {
            $new_admin->saveOrFail();
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }

        return response()->json($new_admin, 200);
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
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', status: 400);
            }

            $data->username = $request->get('username');
        }

        if ($request->has('password')) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8|max:128'
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', status: 400);
            }

            $data->password = $request->get('password');
        }

        try {
            $data->save();
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }

        return response()->json($data, 200);
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

        return response()->json("Data has been destroyed / Deleted", 200);
    }
}
