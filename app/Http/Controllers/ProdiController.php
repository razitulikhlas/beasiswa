<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kd_prodi=DB::table('tbl_prodi')->max('kode_prodi');


        if($kd_prodi == null){
            $kd_prodi = '01';
        }else{
            $kd_prodi = (int)$kd_prodi+1;
            if($kd_prodi <= 9){
                $kd_prodi = '0'.$kd_prodi;
            }else{
                    $kd_prodi = ''.$kd_prodi;
            }
        }
        $data = Prodi::all();
        $jurusan = Jurusan::all();
        return view('layouts.prodi.index',[
            'data'=>$data,
            'kode_prodi'=>$kd_prodi,
            'jurusan'=>$jurusan
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
        $validate =$request->validate([
            'id_jurusan'=>'required',
            'prodi'=>'required|unique:tbl_prodi',
            'kode_prodi'=>'required',
            'tingkatan'=>'required'
        ]);
        Prodi::create($validate);
        return redirect('prodi')->with('success','Data prodi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prodi  $prodi
     * @return \Illuminate\Http\Response
     */
    public function show(Prodi $prodi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prodi  $prodi
     * @return \Illuminate\Http\Response
     */
    public function edit(Prodi $prodi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prodi  $prodi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prodi $prodi)
    {
         $data = $request->only([
            'id_jurusan',
            'prodi',
            'kode_prodi',
            'tingkatan'
        ]);

       Prodi::whereId($prodi->id)->update($data);
       return redirect('prodi')->with('success','Data jurusan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prodi  $prodi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prodi $prodi)
    {
        Prodi::destroy($prodi->id);
        return redirect('prodi')->with('success','Data prodi berhasil dihapus');
    }
}
