<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Kriteria;
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
       $bobot_available = Kriteria::whereIdBeasiswa($request['id_beasiswa'])->sum('bobot');
       $bobot_available = 100 - $bobot_available;
       $data = $request->only([
           'nama_kriteria',
           'type',
           'bobot',
           'id_beasiswa'
       ]);

       if($bobot_available < $request->bobot){
           return redirect('kategoribeasiswa/'.$data['id_beasiswa'])->with('errorbobot','Nilai  bobot yang anda masukan tidak boleh lebih besar dari yang tersedia');
       }else{
           Kriteria::create($data);
           return redirect('kategoribeasiswa/'.$data['id_beasiswa'])->with('success','Sukses menambahkan data kriteria');
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kriteria  $kriteria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        //
       $max =100;
       $kriteria = Kriteria::whereId($id)->first();
       $bobot_available = Kriteria::whereIdBeasiswa($request['id_beasiswa'])->sum('bobot');
       $bobot_available = ($max+$kriteria->bobot) - $bobot_available;

       $data = $request->only([
           'nama_kriteria',
           'type',
           'bobot'
       ]);
       if($bobot_available >= $request->bobot){
            Kriteria::whereId($id)->update($data);
            return redirect('kategoribeasiswa/'.$request['id_beasiswa'])->with('success','Sukses update data kriteria');
       }else{
            if($bobot_available < $request->bobot){
                return redirect('kategoribeasiswa/'.$request['id_beasiswa'])->with('errorbobot','Nilai  bobot yang anda masukan tidak boleh lebih besar dari yang tersedia');
            }else{
                Kriteria::whereId($id)->update($data);
            return redirect('kategoribeasiswa/'.$request['id_beasiswa'])->with('success','Sukses update data kriteria');
            }
       }

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
