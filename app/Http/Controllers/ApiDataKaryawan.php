<?php

namespace App\Http\Controllers;

use App\Models\DataKaryawan;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;


class ApiDataKaryawan extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = "";
        
        try {
            $data_collections = DataKaryawan::all('*')->toJson();
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
            'id_admin' => 'required|integer|exists:admins,id',
            'nama' => 'required|min:8|max:128',
            'jenis_kelamin' => 'required|min:1|max:1',
            'id_data_jabatan' => 'required|integer|exists:data_jabatan,id',
            'tanggal_masuk' => 'required',
            'status' => 'required|min:1|max:32',
        ]);
        
        if ($validator->fails()) {
            return response()->json('Incorrect format', status: 400);
        }

        $data = new DataKaryawan();
        $data->id_admin = $request->get(key: 'id_admin');
        $data->nama = $request->get('nama');
        $data->jenis_kelamin = $request->get('jenis_kelamin');
        $data->id_data_jabatan = $request->get('id_data_jabatan');

        $data->tanggal_masuk = Carbon::createFromTimestamp($request->get('tanggal_masuk'));

        $data->status = $request->get('status');

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
    public function show(DataKaryawan $id)
    {
        $result = "";
        
        try {
            $data = DataKaryawan::find($id)->toJson();
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }


        $result = $data;

        return response()->json($result, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataKaryawan $id)
    {
        try {
            $data = DataKaryawan::find($id)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json($th, 404);
        }

        if ($request->has('id_admin')) {
            $validator = Validator::make($request->all(), [
                'id_admin' => 'required|integer|exists:admins,id',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', 400);
            }

            $data->id_admin = $request->get('id_admin');
        }

        if ($request->has('nama')) {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|min:8|max:128',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', 400);
            }

            $data->nama = $request->get('nama');
        }

        if ($request->has('jenis_kelamin')) {
            $validator = Validator::make($request->all(), [
                'jenis_kelamin' => 'required|min:1|max:1',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', 400);
            }

            $data->jenis_kelamin = $request->get('jenis_kelamin');
        }

        if ($request->has('id_data_jabatan')) {
            $validator = Validator::make($request->all(), [
                'id_data_jabatan' => 'required|integer|exists:data_jabatan,id',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', 400);
            }

            $data->id_data_jabatan = $request->get('id_data_jabatan');
        }

        if ($request->has('tanggal_masuk')) {

            $validator = Validator::make($request->all(), [
                'tanggal_masuk' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', 400);
            }

            $data->tanggal_masuk = Carbon::createFromTimestamp($request->get('tanggal_masuk'));
        }

        if ($request->has('status')) {
            $validator = Validator::make($request->all(), [
                'status' => 'required|min:1|max:32',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', 400);
            }

            $data->status = $request->get('status');
        }

        try {
            $data->save();
        } catch (\Throwable $th) {
            return response()->json($th, 404);
        }

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataKaryawan $id)
    {
        try {
            $data = DataKaryawan::find($id)->firstOrFail();
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