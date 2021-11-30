<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Penjemput;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = Siswa::with('penjemput')->paginate(5);
        $data = Siswa::with('penjemput')->get();

        // dd($data);
        
        return view('siswa.index', compact('data'));
            // ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('siswa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $siswa = new Siswa;

        $request->validate([
            'nik' => 'required|unique:siswa|numeric',
            'nama_siswa' => 'required',
            'foto_siswa' => 'required|mimes:jpg, jpeg, png'
        ]);
        
        $siswa->nik = $request->input('nik');
        $siswa->nama_siswa = ucwords($request->input('nama_siswa'));

        if ($request->hasFile('foto_siswa')) {
            $file = $request->file('foto_siswa');
            $name = $file->getClientOriginalName();
            $file_name =  $siswa->nik.'_'.$name;
            $file_name =  $name;
            // dd($file_name);
            $file->move(public_path('foto_siswa'), $file_name);
            $siswa->path_to_photo = $name;
        }

        $siswa->save();

        return redirect()->route('siswa.index')
            ->with('success_message', 'Siswa created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show(Siswa $siswa)
    {
        // dd($siswa);
        return view('siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Siswa $siswa)
    {
        return view('siswa.edit', compact('siswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Siswa $siswa)
    {

        $request->validate([
            'nama_siswa' => 'required'
        ]);
        
        $siswa->nama_siswa = ucwords($request->input('nama_siswa'));

        if ($request->hasFile('foto_siswa')) {
            $file = $request->file('foto_siswa');
            $name = $file->getClientOriginalName();
            $file_name =  $siswa->nik.'_'.$name;
            $file_name =  $name;
            // dd($file_name);
            $file->move(public_path('foto_siswa'), $file_name);
            $siswa->path_to_photo = $name;
        }

        $siswa->save();

        return redirect()->route('siswa.show', ['siswa' => $siswa])
            ->with('success_message', 'Siswa updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Siswa $siswa)
    {
        $data = $siswa->penjemput()->get();
        // dd($data);

        DB::beginTransaction();
        try {
            $siswa->delete();
            foreach ($data as $key => $penjemput) {
                $penjemput->delete();
            }
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            dump('gagal euy');
            dump($ex);
            return redirect()->route('siswa.index')
            ->with('error_message', $ex);
        }

        return redirect()->route('siswa.index')
            ->with('success_message', 'Siswa deleted successfully');
    }
}