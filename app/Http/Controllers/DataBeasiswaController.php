<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\DataBeasiswa;
use App\Models\Kriteria;
use App\Models\Siswa;
use App\Models\Subkriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $kriteria = Kriteria::whereIdBeasiswa($request['id_beasiswa'])->get()->toArray();
        $kriteriaData = array();
        foreach ($kriteria as $item) {
            $kriteriaData[strtolower(str_replace(' ', '_', $item['nama_kriteria']))] = $request[strtolower(str_replace(' ', '_', $item['nama_kriteria']))];
        }

        $data = [
            'id_siswa' => $request['id_siswa'],
            'id_beasiswa' => $request['id_beasiswa'],
            'data' => json_encode($kriteriaData)
        ];
        DataBeasiswa::create($data);
        return redirect('databeasiswa/' . $request['id_beasiswa'])->with('success', 'Data beasiswa berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beasiswa  $beasiswa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $siswa = Siswa::all();
        $datasiswa = $this->getListSiswa($id);
        // return $datasiswa['subkriteria']['memiliki_ksp'];
        return view('layouts.beasiswadinamis.index', [
            'datakey' => $datasiswa['datakey'],
            'subkriteria' => $datasiswa['subkriteria'],
            'siswa' => $siswa,
            'datasiswa' => $datasiswa['datasiswa'],
            'id_beasiswa' => $id
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
        // return $data['kriteria'];
        // return $dataColumn;

        foreach ($data['datasiswa'] as $key => $datasiswa) {
            foreach ($data['datakey'] as $datakey) {
                foreach ($data['kriteria'] as $datakriteria) {
                    if ($datakey == $datakriteria['nama_kriteria']) {
                        if (strtolower($datakriteria['type']) == $this->BENEFIT) {
                            $data['datasiswa'][$key][$datakey] = $datasiswa[$datakey] / $dataColumn['div' . $datakey];
                        } else {
                            $data['datasiswa'][$key][$datakey] = $dataColumn['div' . $datakey] / $datasiswa[$datakey];
                        }
                    }
                }
            }
        }

        foreach ($data['datasiswa'] as $key => $datasiswa) {
            foreach ($data['datakey'] as $datakey) {
                foreach ($data['kriteria'] as $datakriteria) {
                    if ($datakey == $datakriteria['nama_kriteria']) {
                        $data['datasiswa'][$key][$datakey] = $data['datasiswa'][$key][$datakey] * ($datakriteria['bobot'] / 100);
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
        return $data['datasiswa'];
    }

    public function getListSiswa($id)
    {
        //  $kriteriaBeasiswa = DB::table('tbl_kriteria')
        //     ->leftJoin('tbl_subkriteria', 'tbl_kriteria.id', '=', 'tbl_subkriteria.id_kriteria')
        //     ->select('tbl_kriteria.*', 'tbl_subkriteria.*')
        //     ->where('tbl_kriteria.id_beasiswa','=',$id)
        //     ->get()->toArray();
        $kriteriaBeasiswa = Kriteria::whereIdBeasiswa($id)->whereIsActive(1)->get();
        $listData = DataBeasiswa::whereIdBeasiswa($id)->get();
        $keyData = array();
        $subkriterias = array();
        $listValue = array();
        $dataValueBeasiswa = array();
        // return var_dump($kriteriaBeasiswa);
        foreach ($kriteriaBeasiswa  as $key => $item) {
            $item->nama_kriteria = strtolower(str_replace(' ', '_', $item->nama_kriteria));
            $subkriteria = Subkriteria::whereIdKriteria($item->id)->get();
            $keyData[$key] = $item->nama_kriteria;
            $subkriterias[$item->nama_kriteria] = $subkriteria;
        }


        foreach ($listData as $key => $item) {
            if (isset($item->mahasiswa) != null) {
                $dataValueBeasiswa[$key]['name'] = $item->mahasiswa->nama;
                $dataValueBeasiswa[$key]['id_siswa'] = $item->id_siswa;
                $dataValueBeasiswa[$key]['id'] = $item->id;
                $listValue = json_decode($item->data, true);
                foreach ($keyData as $keys) {
                    $dataValueBeasiswa[$key][$keys] = $listValue[$keys];
                }
            }
        }
        return [
            "datasiswa" => $dataValueBeasiswa,
            "datakey" => $keyData,
            "kriteria" => $kriteriaBeasiswa,
            "subkriteria" => $subkriterias
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
        $kriteria = Kriteria::whereIdBeasiswa($request['id_beasiswa'])->get()->toArray();
        $kriteriaData = array();
        foreach ($kriteria as $item) {
            $kriteriaData[strtolower(str_replace(' ', '_', $item['nama_kriteria']))] = $request[strtolower(str_replace(' ', '_', 'u' . $item['nama_kriteria']))];
        }

        $data = [
            'id_siswa' => $request['uid_siswa'],
            'id_beasiswa' => $request['id_beasiswa'],
            'data' => json_encode($kriteriaData)
        ];
        DataBeasiswa::whereId($id)->update($data);
        return redirect('databeasiswa/' . $request['id_beasiswa'])->with('success', 'Data beasiswa berhasil di tambahkan');

        return $request;
        // $data = $request->only([
        //     'title',
        //     'desc'
        // ]);
        // Beasiswa::whereId($beasiswa->id)->update($data);
        // return redirect('beasiswa')->with('success', 'Data beasiswa berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Beasiswa  $beasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $databeasiswa = DataBeasiswa::whereId($id)->first();
        DataBeasiswa::destroy($id);
        return redirect('databeasiswa/' . $databeasiswa->id_beasiswa)->with('success', 'Data beasiswa berhasil di hapus');
    }
}
