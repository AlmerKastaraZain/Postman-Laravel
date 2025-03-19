<?php

namespace App\Http\Controllers;

use App\Models\DataAbsensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiDataAbsensiController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = "";
        
        try {
            $data_collections = DataAbsensi::all('*')->toJson();
        } catch (\Throwable $th) {
            return response()->json($th, 404);
        }


        $result = $data_collections;

        return response()->json($result, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status_kehadiran' => 'required|min:1|max:32',
            'id_admin' => 'required|integer|exists:admins,id',
            'id_data_karyawan' => 'required|integer|exists:data_karyawan,id'
        ]);
        
        if ($validator->fails()) {
            return response()->json('Incorrect format', 400);
        }

        $data = new DataAbsensi();
        $data->status_kehadiran = $request->get('status_kehadiran');
        $data->id_admin = $request->get('id_admin');
        $data->id_data_karyawan = $request->get('id_data_karyawan');

        try {
            $data->saveOrFail();
        } catch (\Throwable $th) {
            return response()->json($th, 404);
        }

        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(DataAbsensi $id)
    {
        $result = "";
        
        try {
            $data = DataAbsensi::find($id)->toJson();
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }

        $result = $data;

        return response()->json($result, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataAbsensi $id)
    {
        try {
            $data = DataAbsensi::find($id)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json($th, 404);
        }

        if ($request->has('status_kehadiran')) {
            $validator = Validator::make($request->all(), [
                'status_kehadiran' => 'required|min:1|max:128',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', 400);
            }

            $data->username = $request->get('status_kehadiran');
        }

        if ($request->has('id_admin')) {
            $validator = Validator::make($request->all(), [
                'id_admin' => 'required|integer|exists:admins,id',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', 400);
            }

            $data->password = $request->get('id_admin');
        }

        if ($request->has('id_data_karyawan')) {
            $validator = Validator::make($request->all(), [
                'id_data_karyawan' => 'required|integer|exists:data_karyawan,id'
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', 400);
            }

            $data->password = $request->get('id_data_karyawan');
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
    public function destroy(DataAbsensi $id)
    {
        try {
            $data = DataAbsensi::find($id)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json($th, 404);
        }
        
        try {
            $data->deleteOrFail();
        } catch (\Throwable $th) {
            return response()->json($th, 404);
        }

        return response()->json("Data has been destroyed / Deleted", 200);
    }
}
