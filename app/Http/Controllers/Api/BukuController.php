<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Buku::orderBy('judul', 'asc')->get();

        // untuk menampilkan data 

        return response()->json([
            // apabila bisa mengeluarkan data
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $data

            // pesan response = [200,400 dllo]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $databuku = new Buku;
        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required|date'
        ];
        // validator
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal Memasukan Data',
                'data' => $validator->errors()
            ]);
        }
        $databuku->judul = $request->judul;
        $databuku->pengarang = $request->pengarang;
        $databuku->tanggal_publikasi = $request->tanggal_publikasi;
        $post = $databuku->save();
        return response()->json([
            'stauts' => true,
            'message' => 'Memasukan data',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Buku::find($id);
        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Data Ditemukan',
                'data' => $data,
            ],);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'data tidak ditemukan'
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $databuku = Buku::find($id);
        if (empty($databuku)) {
            return response()->json([
                'status' => false,
                'message' => 'data tidak ditemukan'
            ], 404);
        }
        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required|date'
        ];
        // validator
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memupdate Data',
                'data' => $validator->errors()
            ]);
        }
        $databuku->judul = $request->judul;
        $databuku->pengarang = $request->pengarang;
        $databuku->tanggal_publikasi = $request->tanggal_publikasi;
        $post = $databuku->save();
        return response()->json([
            'stauts' => true,
            'message' => 'Sukses Melakukan update data',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $databuku = Buku::find($id);
        if (empty($databuku)) {
            return response()->json([
                'status' => false,
                'message' => 'data tidak ditemukan'
            ], 404);
        }
        $post = $databuku->delete();
        return response()->json([
            'stauts' => true,
            'message' => 'Sukses Melakukan Delete data',
        ], 200);
    }
}
