<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = Siswa::with('penjemput')->where('status', 'active')->get();

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
      'foto_siswa' => 'image|mimes:jpg,jpeg,png'
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
    if ($siswa->status == 'inactive') return abort(404);
    $data_penjemput = $siswa->penjemput()->where('status', 'active')->get();
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
    if ($siswa->status == 'inactive') return abort(404);
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
    if ($siswa->status == 'inactive') return abort(404);
    $request->validate([
      'nama_siswa' => 'required',
      'foto_siswa' => 'image|mimes:jpg,jpeg,png'
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

  /**
   * Remove the specified resource from storage.
   *
   * @param  Request $request
   * @return \Illuminate\Http\Response
   */
  public function import_excel(Request $request)
  {
    $this->validate($request, [
      'file' => 'required|mimes:csv,xls,xlsx'
    ]);

    $file = $request->file('file');
    $nama_file = rand() . $file->getClientOriginalName();
    $file->move('file_siswa', $nama_file);

    Excel::import(new SiswaImport, public_path('/file_siswa/' . $nama_file));

    return back()->with('success', 'Siswa Imported Successfully.');
  }

  /**
   * Set siswa to inactive.
   *
   * @param  Siswa $siswa
   * @return \Illuminate\Http\Response
   */
  public function setInactive(Siswa $siswa)
  {
    if ($siswa->status == 'inactive') return abort(404);
    $data = $siswa->penjemput()->get();

    DB::beginTransaction();
    try {
      $siswa->status = 'inactive';
      foreach ($data as $key => $penjemput) {
        $penjemput->status = 'inactive';
        $penjemput->tokens()->delete();
        $penjemput->save();
      }

      $siswa->save();

      DB::commit();
    } catch (\Exception $ex) {
      DB::rollback();
      return redirect()->route('siswa.index')
        ->with('error_message', $ex);
    }

    return redirect()->route('siswa.index')->with('success_message', 'Siswa deleted successfully');
  }
}