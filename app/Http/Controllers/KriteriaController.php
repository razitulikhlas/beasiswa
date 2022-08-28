<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\DataBeasiswa;
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
        $data = $this->getListSiswa($request['id_beasiswa']);

        foreach ($data['datasiswa'] as $key => $value) {
            $id = $data['datasiswa'][$key]['id'];
            $data['datasiswa'][$key]["" . strtolower(str_replace(' ', '_', $request['nama_kriteria']))] = 1;
            unset($data['datasiswa'][$key]["name"]);
            unset($data['datasiswa'][$key]["id_siswa"]);
            unset($data['datasiswa'][$key]["id"]);
            unset($data['datasiswa'][$key]["nim"]);
            DataBeasiswa::whereId($id)->update(['data'=>$data['datasiswa'][$key]]);
        }

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
        // return $id;
            $kriteria = Kriteria::whereId($id)->first();
            $subKriteria = Subkriteria::whereIdKriteria($id)->get();
            return view('layouts.subkriteria.index',
            [
                "title"=>$kriteria->nama_kriteria,
                "data"=>$subKriteria,
                "id_kriteria"=>$id,
                "id_beasiswa"=>$kriteria->id_beasiswa
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


        $kriteria = Kriteria::whereId($id)->first();
        $namakriteria = strtolower(str_replace(' ', '_', $kriteria->nama_kriteria));
        $id_beasiswa = $kriteria->id_beasiswa;
        $data = $this->getListSiswa($id_beasiswa);

        // return $data;


         foreach ($data['datasiswa'] as $key => $value) {
            $id_be = $data['datasiswa'][$key]['id'];
            $temp = $data['datasiswa'][$key]["" . $namakriteria];
            unset($data['datasiswa'][$key]["".$namakriteria]);
            unset($data['datasiswa'][$key]["name"]);
            unset($data['datasiswa'][$key]["id_siswa"]);
            unset($data['datasiswa'][$key]["id"]);
            unset($data['datasiswa'][$key]["nim"]);
            $data['datasiswa'][$key]["" . strtolower(str_replace(' ', '_', $request['kriteria']))] = $temp;
            DataBeasiswa::whereId($id_be)->update(['data'=>$data['datasiswa'][$key]]);
        }

        // return $data['datasiswa'];

        Kriteria::whereId($id)->update([
            'nama_kriteria'=>$request['kriteria'],
            'type'=>$request['type'],
            'bobot'=>$request['bobot'],
        ]);
        return redirect('kategoribeasiswa/'.$id_beasiswa)->with('success','Sukses update data kriteria');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kriteria  $kriteria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kriteria = Kriteria::whereId($id)->first();
        $namakriteria = strtolower(str_replace(' ', '_', $kriteria->nama_kriteria));
        $id_beasiswa = $kriteria->id_beasiswa;
        $data = $this->getListSiswa($id_beasiswa);


         foreach ($data['datasiswa'] as $key => $value) {
            $id_be = $data['datasiswa'][$key]['id'];
            unset($data['datasiswa'][$key]["" . $namakriteria]);
            unset($data['datasiswa'][$key]["name"]);
            unset($data['datasiswa'][$key]["id_siswa"]);
            unset($data['datasiswa'][$key]["id"]);
            unset($data['datasiswa'][$key]["nim"]);
            DataBeasiswa::whereId($id_be)->update(['data'=>$data['datasiswa'][$key]]);
        }



        Kriteria::destroy($id);
        return redirect('kategoribeasiswa')->with('success','Data kriteria berhasil dihapus');
    }

public function getListSiswa($id)
    {
        $totalBoot = Kriteria::whereIdBeasiswa($id)->sum('bobot');
        $kriteriaBeasiswa = Kriteria::whereIdBeasiswa($id)->whereIsActive(1)->get();
        $listData = DataBeasiswa::whereIdBeasiswa($id)->get();
        // return $listData;

        $keyData = array();
        $listValue = array();
        $dataValueBeasiswa = array();
        foreach ($kriteriaBeasiswa  as $key => $item) {
            $item->nama_kriteria = strtolower(str_replace(' ', '_', $item['nama_kriteria']));
            $keyData[$key] = $item->nama_kriteria;
            $kriteriaBeasiswa[$key]['bobot'] = $item->bobot / $totalBoot;
        }
        // return $listData;

        foreach ($listData as $key => $item) {
            if (isset($item->mahasiswa) != null) {
                $dataValueBeasiswa[$key]['name'] = $item->mahasiswa->nama;
                $dataValueBeasiswa[$key]['id_siswa'] = $item->id_siswa;
                $dataValueBeasiswa[$key]['id'] = $item->id;
                $dataValueBeasiswa[$key]['nim'] = $item->mahasiswa->nim;
                $listValue = json_decode($item->data, true);
                foreach ($keyData as $keys) {
                    $dataValueBeasiswa[$key][$keys] = $listValue[$keys];
                }
            }
        }
        return [
            "datasiswa" => $dataValueBeasiswa,
            "datakey" => $keyData,
            "kriteria" => $kriteriaBeasiswa
        ];
    }

}
