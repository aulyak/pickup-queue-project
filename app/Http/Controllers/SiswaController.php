<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = Siswa::with('penjemput')->get();

    return view('siswa.index', compact('data'));
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
      'nis' => 'required|unique:siswa|numeric',
      'nama_siswa' => 'required',
      'foto_siswa' => 'mimes:jpg, jpeg, png'
    ]);

    $siswa->nis = $request->input('nis');
    $siswa->nama_siswa = ucwords($request->input('nama_siswa'));

    if ($request->hasFile('foto_siswa')) {
      $file = $request->file('foto_siswa');
      $name = $file->getClientOriginalName();
      $file_name =  $siswa->nis . '_' . $name;
      $path = $file->storeAs(
        'public/foto_siswa',
        $file_name
      );
      // $file->move(public_path('foto_siswa'), $file_name);
      $siswa->path_to_photo = $file_name;
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
    $data_penjemput = $siswa->penjemput()->get();
    return view('siswa.show', compact('siswa', 'data_penjemput'));
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
      'nama_siswa' => 'required',
      'foto_siswa' => 'mimes:jpg, jpeg, png'
    ]);

    $siswa->nama_siswa = ucwords($request->input('nama_siswa'));

    if ($request->hasFile('foto_siswa')) {
      $file = $request->file('foto_siswa');
      $name = $file->getClientOriginalName();
      $file_name =  $siswa->nis . '_' . $name;
      $path = $file->storeAs(
        'public/foto_siswa',
        $file_name
      );
      // $file->move(public_path('foto_siswa'), $file_name);
      Storage::delete('public/foto_siswa/' . $siswa->path_to_photo);
      $siswa->path_to_photo = $file_name;
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

    DB::beginTransaction();
    try {
      $siswa->delete();
      foreach ($data as $key => $penjemput) {
        $penjemput->delete();
      }

      Storage::delete('public/foto_siswa/' . $siswa->path_to_photo);
      DB::commit();
    } catch (\Exception $ex) {
      DB::rollback();
      return redirect()->route('siswa.index')
        ->with('error_message', $ex);
    }

    return redirect()->route('siswa.index')
      ->with('success_message', 'Siswa deleted successfully');
  }
}