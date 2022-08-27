<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Subkriteria;
use Illuminate\Http\Request;

class SubkriteriaController extends Controller
{

    function index()
    {
        //         $categoryBeasiswa = Beasiswa::all();
        // return view('layouts.hasil.index', [
        //     'data' => $categoryBeasiswa
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'value' => 'required',
            'id_kriteria' => 'required'
        ]);
        // $validateData = $request->only([
        //     'id_kriteria',
        //     'title',
        //     'value',

        // ]);

        // return $validateData;
        Subkriteria::create($validateData);
        return redirect('kriteria/' . $request['id_kriteria'])->with('success', 'Data subkriteria berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validateData = $request->validate([
            'usub_kriteria' => 'required',
            'uvalue' => 'required',
            'id_kriteria' => 'required',
        ]);

        $update =  [
            "title"=>$validateData['usub_kriteria'],
            "value"=>$validateData['uvalue'],
            "id_kriteria"=>$validateData['id_kriteria'],
        ];


        Subkriteria::whereId($id)->update($update);

        return redirect('kriteria/' . $request['id_kriteria'])->with('success', 'Data Siswa berhasil diupdate');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $temp = Subkriteria::whereId($id)->first();
        Subkriteria::destroy($id);
        return redirect('kriteria/'.$temp['id_kriteria'])->with('success', 'Data subkriteria berhasil dihapus');
    }
}
