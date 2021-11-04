<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BarangResource;
use App\Models\Barang;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Barang::latest()->get();
        return response()->json([BarangResource::collection($data),'Barang fetched']);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[ 
            'nama_brg' => 'required|string|max:255', 
            'kode_brg' => 'required', 
            'harga' => 'required',
            'stock' => 'required' 
        ]); 

        if($validator->fails())
        { 
            return response()->json($validator->errors()); 
        }

        $barang = Barang::create([ 
            'kode_brg' => $request->kode_brg, 
            'nama_brg' => $request->nama_brg, 
            'harga' => $request->harga, 
            'stock' => $request->stock
        ]); 
        
        return response()->json([
            'Program created successfully.', new BarangResource($barang)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $barang = Barang::find($id);
        if (is_null($barang)) 
        { 
            return response()->json('Data not found', 404); 
        } 
        return response()->json([new BarangResource($barang)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barang $barang)
    {
        //
        $validator = Validator::make($request->all(),[ 
            'nama_brg' => 'required|string|max:255', 
            'kode_brg' => 'required', 
            'harga' => 'required',
            'stock' => 'required' 
        ]); 

        if($validator->fails())
        { 
            return response()->json($validator->errors()); 
        }

        $barang->nama_brg = $request->nama_brg;
        $barang->nama_brg = $request->nama_brg;
        $barang->harga = $request->harga;
        $barang->stock = $request->stock;
        $barang->save();

        return response()->json(['Barang updated successfully.', new BarangResource($barang)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        //
        $barang->delete(); 
        return response()->json('Barang deleted successfully');
    }
}
