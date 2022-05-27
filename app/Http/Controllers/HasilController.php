<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\DataBeasiswa;
use App\Models\Kriteria;
use App\Models\Siswa;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoryBeasiswa = Beasiswa::all();
        return view('layouts.hasil.index', [
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beasiswa  $beasiswa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->saw($id);
        $data = $this->getListSiswa($id);

        return view('layouts.hasil.result', [
            'dataKeys' => $data['datakey'],
            'result'=>$result['result'],
            'normalisasi'=>$result['normalisasi'],
            'dataAlternatif'=>$data['datasiswa']
        ]);



    }

  public function saw($id)
    {
        $data = $this->getListSiswa($id);
        $max = array();
        foreach ($data['datakey'] as  $datakey) {
            $column = array_column($data['datasiswa'], $datakey);
            foreach ($data['kriteria'] as $datakriteria) {
                if ($datakey == $datakriteria['nama_kriteria']) {
                    if (strtolower($datakriteria['type']) == $this->BENEFIT) {
                        $dataColumn['div' . $datakey] = max($column);
                    } else {
                        $dataColumn['div' . $datakey] = min($column);
                    }
                }
            }
        }


        foreach ($data['datasiswa'] as $key => $datasiswa) {
             $data['normalisasi'][$key]['name'] = $datasiswa['name'];
            $data['normalisasi'][$key]['nim'] = $datasiswa['nim'];
            foreach ($data['datakey'] as $datakey) {
               foreach($data['kriteria'] as $datakriteria){
                   if($datakey == $datakriteria['nama_kriteria']){
                       if (strtolower($datakriteria['type']) == $this->BENEFIT) {
                        $data['datasiswa'][$key][$datakey] = $datasiswa[$datakey] / $dataColumn['div' . $datakey];
                         $data['normalisasi'][$key][$datakey] = $datasiswa[$datakey] / $dataColumn['div' . $datakey];
                    } else {
                       $data['datasiswa'][$key][$datakey] = $dataColumn['div' . $datakey] / $datasiswa[$datakey];
                        $data['normalisasi'][$key][$datakey] = $dataColumn['div' . $datakey] / $datasiswa[$datakey];
                    }
                   }
               }
            }
        }

        foreach ($data['datasiswa'] as $key => $datasiswa) {
            foreach ($data['datakey'] as $datakey) {
               foreach($data['kriteria'] as $datakriteria){
                   if($datakey == $datakriteria['nama_kriteria']){
                      $data['datasiswa'][$key][$datakey] =$data['datasiswa'][$key][$datakey] * ($datakriteria['bobot']/100);
                   }
               }
            }
        }

           foreach ($data['datasiswa'] as $key => $datasiswa) {
            $data['datasiswa'][$key]['saw'] = 0;
            foreach ($data['datakey'] as $datakey) {
                $data['datasiswa'][$key]['saw'] += $data['datasiswa'][$key][$datakey];
            }
        }

       usort($data['datasiswa'], function ($a, $b) {
                if ($a['saw'] == $b['saw']) {
                    return 0;
                }
                return ($a['saw'] > $b['saw']) ? -1 : 1;
            });
          return [
            'result'=>$data['datasiswa'],
            'normalisasi'=>$data['normalisasi'],
        ];
    }
    public function getListSiswa($id)
    {
        $kriteriaBeasiswa = Kriteria::whereIdBeasiswa($id)->get();
        $listData = DataBeasiswa::whereIdBeasiswa($id)->get();
        $keyData = array();
        $listValue = array();
        $dataValueBeasiswa = array();
        foreach ($kriteriaBeasiswa  as $key => $item) {
            $item->nama_kriteria = strtolower(str_replace(' ', '_', $item['nama_kriteria']));
            $keyData[$key] = $item->nama_kriteria;
        }
        foreach ($listData as $key => $item) {
            $dataValueBeasiswa[$key]['name'] = $item->mahasiswa->nama;
            $dataValueBeasiswa[$key]['id_siswa'] = $item->id_siswa;
            $dataValueBeasiswa[$key]['id'] = $item->id;
            $dataValueBeasiswa[$key]['nim'] = $item->mahasiswa->nim;
            $listValue = json_decode($item->data, true);
            foreach ($keyData as $keys) {
                $dataValueBeasiswa[$key][$keys] = $listValue[$keys];
            }
        }
        return [
            "datasiswa" => $dataValueBeasiswa,
            "datakey" => $keyData,
            "kriteria" => $kriteriaBeasiswa
        ];
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Beasiswa  $beasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
