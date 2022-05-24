<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kd_jurusan=DB::table('tbl_jurusan')->max('kode_jurusan');

        if($kd_jurusan == null){
            $kd_jurusan = '01';
        }else{
            $kd_jurusan = (int)$kd_jurusan+1;
            if($kd_jurusan <= 9){
                $kd_jurusan = '0'.$kd_jurusan;
            }else{
                    $kd_jurusan = ''.$kd_jurusan;
            }
        }
        $data = Jurusan::all();
        return view('layouts.jurusan.index',['data'=>$data,'kode_jurusan'=>$kd_jurusan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        $data =$request->only([
            'jurusan','kode_jurusan'
        ]);
        Jurusan::create($data);
        return redirect('jurusan')->with('success','Sukses menambahkan data jurusan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jurusan  $jurusan
     * @return \Illuminate\Http\Response
     */
    public function show(Jurusan $jurusan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jurusan  $jurusan
     * @return \Illuminate\Http\Response
     */
    public function edit(Jurusan $jurusan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jurusan  $jurusan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $data = $request->only([
            'jurusan','kode_jurusan'
        ]);

        Jurusan::whereId($jurusan->id)->update($data);
        return redirect('jurusan')->with('success','Data jurusan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jurusan  $jurusan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jurusan $jurusan)
    {
        Jurusan::destroy($jurusan->id);
        return redirect('jurusan')->with('success','Data jurusan berhasil dihapus');
    }
}
