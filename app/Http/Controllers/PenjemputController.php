<?php

namespace App\Http\Controllers;

use App\Models\Penjemput;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenjemputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $penjemput = new Penjemput;
        $validator = Validator::make($request->all(), [
            'nama_penjemput' => 'required',
            'nik_siswa' => 'required',
            'no_penjemput' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        
        $penjemput->nik_siswa = $request->input('nik_siswa');
        $penjemput->nama_penjemput = ucwords($request->input('nama_penjemput'));
        $penjemput->no_penjemput = $request->input('no_penjemput');

        $penjemput->save();
        return response()->json(['success' => 'Penjemput has been created successfully.']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penjemput  $penjemput
     * @return \Illuminate\Http\Response
     */
    public function show(Penjemput $penjemput)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjemput  $penjemput
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjemput $penjemput)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penjemput  $penjemput
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penjemput $penjemput)
    {
        //
    }

    /**
     * Update by id
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function updateById(Request $request, $id)
    {
        $penjemput = Penjemput::find($id);
        $validator = Validator::make($request->all(), [
            'nama_penjemput' => 'required',
            'nik_siswa' => 'required',
            'no_penjemput' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }
        
        $penjemput->nik_siswa = $request->input('nik_siswa');
        $penjemput->nama_penjemput = ucwords($request->input('nama_penjemput'));
        $penjemput->no_penjemput = $request->input('no_penjemput');

        $penjemput->save();
        return response()->json(['success' => 'Penjemput has been updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjemput  $penjemput
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjemput $penjemput)
    {

    }

    /**
     * Remove the specified resource from storage and redirect to detail siswa.
     *
     * @param  \App\Models\Penjemput  $penjemput
     * @return \Illuminate\Http\Response
     */
    public function destroyRedirect(Penjemput $penjemput, Siswa $siswa)
    {
        $penjemput->delete();
    
        return redirect()->route('siswa.show', ["siswa" => $siswa])
            ->with('success_message', 'Penjemput deleted successfully');
    }
}