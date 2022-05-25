<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class CategoryBeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Beasiswa::all();
        return view('layouts.kategorybeasiswa.index',['data'=>$data]);
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
        //
        $validateData = $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'icon' => 'image|file|max:1024'
        ]);
        Beasiswa::create($validateData);
        return redirect('kategoribeasiswa')->with('success','Data beasiswa berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beasiswa  $beasiswa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Kriteria::whereIdBeasiswa($id)->get();
        $bobot_available = Kriteria::whereIdBeasiswa($id)->sum('bobot');
        $kategory = Beasiswa::whereId($id)->first();
        $bobot_available = 100 - $bobot_available;

        return view('layouts.kriteria.index',[
            'data'=>$data,
            'bobot_available'=>$bobot_available,
            'id_beasiswa'=>$id,
            'title'=>$kategory->title
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Beasiswa  $beasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Beasiswa $beasiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Beasiswa  $beasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

         $data = $request->only([
            'title',
            'desc'
        ]);
        Beasiswa::whereId($id)->update($data);
        return redirect('kategoribeasiswa')->with('success','Data beasiswa berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Beasiswa  $beasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Beasiswa::destroy($id);
        return redirect('kategoribeasiswa')->with('success','Data beasiswa berhasil di hapus');
    }
}
