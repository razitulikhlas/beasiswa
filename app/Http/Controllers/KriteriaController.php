<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Kriteria;
use App\Models\Subkriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Kriteria::all();
        $bobot_available = Kriteria::sum('bobot');
        $bobot_available = 100 - $bobot_available;
        $categoryBeasiswa =Beasiswa::all();

        return view('layouts.kriteria.index',[
            'data'=>$data,
            'bobot_available'=>$bobot_available,
            'categoryBeasiswa'=>$categoryBeasiswa
        ]);
    }

    public function isactive(Request $request,$id){
        $kriteria =Kriteria::whereId($id)->first();
        $id_beasiswa = $kriteria->id_beasiswa;

        $kriteria->update($request->only(['is_active']));
        return redirect('kategoribeasiswa/'.$id_beasiswa)->with('success','Data kriteria berhasil diupdate');
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
    //    $bobot_available = Kriteria::whereIdBeasiswa($request['id_beasiswa'])->sum('bobot');
    //    $bobot_available = 100 - $bobot_available;
        $data = $request->only([
            'nama_kriteria',
            'type',
            'bobot',
            'id_beasiswa'
        ]);

        Kriteria::create($data);
        return redirect('kategoribeasiswa/'.$data['id_beasiswa'])->with('success','Sukses menambahkan data kriteria');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kriteria  $kriteria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            $kriteria = Kriteria::whereId($id)->first();
            $subKriteria = Subkriteria::whereIdKriteria($id)->get();
            return view('layouts.subkriteria.index',
            [
                "title"=>$kriteria->nama_kriteria,
                "data"=>$subKriteria,
                "id_kriteria"=>$id

            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kriteria  $kriteria
     * @return \Illuminate\Http\Response
     */
    public function edit(Kriteria $kriteria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kriteria  $kriteria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only([
            'nama_kriteria',
            'type',
            'bobot'
        ]);

        Kriteria::whereId($id)->update($data);
        return redirect('kategoribeasiswa/'.$request['id_beasiswa'])->with('success','Sukses update data kriteria');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kriteria  $kriteria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Kriteria::destroy($id);
        return redirect('kategoribeasiswa')->with('success','Data kriteria berhasil dihapus');
    }
}
