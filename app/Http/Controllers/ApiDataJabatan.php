<?php

namespace App\Http\Controllers;

use App\Models\DataJabatan;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;


class ApiDataJabatan extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = "";
        
        try {
            $data_collections = DataJabatan::all('*')->toJson();
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
            'jabatan' => 'required|min:1|max:128',
            'gaji_pokok' => 'required',
            'tunjangan' => 'required',
            'total' => 'required',
            'id_admin' => 'required|integer|exists:admins,id'
        ]);
        
        if ($validator->fails()) {
            return response()->json('Incorrect format', status: 400);
        }

        $data = new DataJabatan();
        $data->jabatan = $request->get('jabatan');
        $data->gaji_pokok = $request->get('gaji_pokok');
        $data->tunjangan = $request->get('tunjangan');
        $data->total = $request->get('total');
        $data->id_admin = $request->get('id_admin');

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
    public function show(DataJabatan $id)
    {
        $result = "";
        
        try {
            $data = DataJabatan::find($id);
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }

        $result = $data;

        return response()->json($result, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataJabatan $id)
    {
        try {
            $data = DataJabatan::find($id)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }

        if ($request->has('jabatan')) {
            $validator = Validator::make($request->all(), [
                'jabatan' => 'required|min:1|max:128',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', 400);
            }

            $data->jabatan = $request->get('jabatan');
        }
        
        if ($request->has('gaji_pokok')) {
            $validator = Validator::make($request->all(), [
                'gaji_pokok' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', 400);
            }

            $data->gaji_pokok = $request->get('gaji_pokok');
        }

        if ($request->has('tunjangan')) {
            $validator = Validator::make($request->all(), [
                'tunjangan' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', 400);
            }

            $data->tunjangan = $request->get('tunjangan');
        }

        if ($request->has('total')) {
            $validator = Validator::make($request->all(), [
                'total' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', status: 400);
            }

            $data->total = $request->get('total');
        }

        if ($request->has('id_admin')) {
            $validator = Validator::make($request->all(), [
                'id_admin' => 'required|integer|exists:admins,id'
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format',  400);
            }

            $data->id_admin = $request->get('id_admin');
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
    public function destroy(DataJabatan $id)
    {
        try {
            $data = DataJabatan::find($id)->firstOrFail();
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