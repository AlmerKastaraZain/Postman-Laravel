<?php

namespace App\Http\Controllers;

use App\Models\DataGajiKaryawan;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class ApiDataGajiKaryawan extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = "";
        
        try {
            $data_collections = DataGajiKaryawan::all('*');
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
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
            'id_data_karyawan' => 'required|integer|exists:data_karyawan,id',
            'id_pot_gaji' => 'required|exists:set_potongan_gaji,id',
            'id_admin' => 'required|integer|exists:admins,id',

            'total_gaji' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json('Incorrect format', status: 400);
        }

        $data = new DataGajiKaryawan();
        $data->id_data_karyawan = $request->get('id_data_karyawan');
        $data->id_pot_gaji = $request->get('id_pot_gaji');
        $data->id_admin = $request->get('id_admin');

        $data->total_gaji = $request->get('total_gaji');

        try {
            $data->saveOrFail();
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }

        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(DataGajiKaryawan $id)
    {
        $result = "";
        
        try {
            $data = DataGajiKaryawan::find($id);
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }


        $result = $data;

        return response()->json($result, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataGajiKaryawan $id)
    {
        try {
            $data = DataGajiKaryawan::find($id)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }

        if ($request->has('id_data_karyawan')) {
            $validator = Validator::make($request->all(), [
                'id_data_karyawan' => 'required|integer|exists:data_karyawan,id',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', status: 400);
            }

            $data->id_data_karyawan = $request->get('id_data_karyawan');
        }

        if ($request->has('id_pot_gaji')) {
            $validator = Validator::make($request->all(), [
                'id_pot_gaji' => 'required|integer|exists:set_potongan_gaji,id',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', status: 400);
            }

            $data->id_pot_gaji = $request->get('id_pot_gaji');
        }

        if ($request->has('id_admin')) {
            $validator = Validator::make($request->all(), [
                'id_admin' => 'required|integer|exists:admins,id',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', status: 400);
            }

            $data->id_admin = $request->get('id_admin');
        }

        if ($request->has('total_gaji')) {
            $validator = Validator::make($request->all(), [
                'total_gaji' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', status: 400);
            }

            $data->total_gaji = $request->get('total_gaji');
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
    public function destroy(DataGajiKaryawan $id)
    {
        try {
            $data = DataGajiKaryawan::find($id)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }
        
        try {
            $data->deleteOrFail();
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }

        return response()->json("Data has been destroyed / Deleted", 200);
    }
}