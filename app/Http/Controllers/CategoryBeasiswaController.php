<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
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
        return view('layouts.beasiswa.index', ['data' => $data]);
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
        if ($request->file('icon')) {
            $validateData['icon'] = $request->file('icon')->store('images');
        } else {
            $validateData['icon'] = 'images/avatar.jpg';
        }
        Beasiswa::create($validateData);
        return redirect('beasiswa')->with('success', 'Data beasiswa berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beasiswa  $beasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Beasiswa $beasiswa)
    {
        //
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
    public function update(Request $request, Beasiswa $beasiswa)
    {
        $data = $request->only([
            'title',
            'desc'
        ]);
        Beasiswa::whereId($beasiswa->id)->update($data);
        return redirect('beasiswa')->with('success', 'Data beasiswa berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Beasiswa  $beasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beasiswa $beasiswa)
    {
        //
        Beasiswa::destroy($beasiswa->id);
        return redirect('beasiswa')->with('success', 'Data beasiswa berhasil di hapus');
    }
}
