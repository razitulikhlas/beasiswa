<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\DataBeasiswa;
use App\Models\Kriteria;
use App\Models\Siswa;
use Illuminate\Http\Request;

class DataBeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoryBeasiswa = Beasiswa::all();
        return view('layouts.databeasiswa.index', [
            'data' => $categoryBeasiswa
        ]);
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
        // return $request['Penghasilan_orang_tua'];
        $kriteria = Kriteria::whereIdBeasiswa($request['id_beasiswa'])->get()->toArray();
        $kriteriaData = array();

        foreach ($kriteria as $item) {
            $kriteriaData[strtolower(str_replace(' ', '_', $item['nama_kriteria']))] = $request[str_replace(' ', '_', $item['nama_kriteria'])];
        }
        $data = [
            'id_mahasiswa' => $request['id_mahasiswa'],
            'id_beasiswa' => $request['id_beasiswa'],
            'data' => json_encode($kriteriaData)
        ];
        DataBeasiswa::create($data);
        return redirect('databeasiswa/'.$request['id_beasiswa'])->with('success', 'Data beasiswa berhasil di tambahkan');
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
        $siswa = Siswa::all();
        $datasiswa = DataBeasiswa::whereIdBeasiswa($id)->get();
         return view('layouts.beasiswadinamis.index', [
            'data' => $data,
            'siswa' => $siswa,
            'datasiswa' => $datasiswa,
            'id_beasiswa'=>$id
        ]);
        return $id;
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
    public function destroy($id)
    {
        //
        DataBeasiswa::destroy($id);
        return redirect('databeasiswa')->with('success', 'Data beasiswa berhasil di hapus');
    }
}
