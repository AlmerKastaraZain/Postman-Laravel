<?php

namespace App\Http\Controllers;

use App\Models\SetPotonganGaji;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;


class ApiSetPotonganGaji extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = "";
        
        try {
            $data_collections = SetPotonganGaji::all('*');
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
            'status_kehadiran' => 'required|min:1|max:32',
            'jumlah_potongan' =>'required',
            'id_admin' => 'required|integer|exists:admins,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json('Incorrect format', status: 400);
        }

        $data = new SetPotonganGaji();
        $data->status_kehadiran = $request->get('status_kehadiran');
        $data->jumlah_potongan = $request->get('jumlah_potongan');
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
    public function show(SetPotonganGaji $id)
    {
        $result = "";
        
        try {
            $data = SetPotonganGaji::find($id);
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }


        $result = $data;

        return response()->json($result, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SetPotonganGaji $id)
    {
        try {
            $data = SetPotonganGaji::find($id)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json($th, status: 404);
        }

        if ($request->has('status_kehadiran')) {
            $validator = Validator::make($request->all(), [
                'status_kehadiran' => 'required|min:1|max:32',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', status: 400);
            }

            $data->status_kehadiran = $request->get('status_kehadiran');
        }

        if ($request->has('jumlah_potongan')) {
            $validator = Validator::make($request->all(), [
                'jumlah_potongan' =>'required',
            ]);

            if ($validator->fails()) {
                return response()->json('Incorrect format', status: 400);
            }

            $data->jumlah_potongan = $request->get('jumlah_potongan');
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
    public function destroy(SetPotonganGaji $id)
    {
        try {
            $data = SetPotonganGaji::find($id)->firstOrFail();
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