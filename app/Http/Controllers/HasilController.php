<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\DataBeasiswa;
use App\Models\Kriteria;
use App\Models\Siswa;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

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
        $data = $this->getListSiswa($id);
        $result = $this->topsis($id);

        // return $data;

        if (!isset($result['datasiswa'])) {
            return view('layouts.hasil.erorsatu');
        } else {

            return view('layouts.hasil.result', [
                'dataKeys' => $data['datakey'],
                'first' => $result['first'],
                'normalisasi' => $result['normalisasi'],
                'bobot' => $result['bobot'],
                'plusminus' => $result['plusminus'],
                'finish' => $result['finish'],
                'dataAlternatif' => $data['datasiswa']
            ]);
        }
    }

    public function topsis($id)
    {
        $data = $this->getListSiswa($id);
        $column = array();

        // return $data;

        if (sizeof($data['datasiswa']) > 1) {
            foreach ($data['datakey'] as  $datakey) {
                $column = array_column($data['datasiswa'], $datakey);
                $dataColumn['div' . $datakey] = 0;
                foreach ($column as $itemColumn) {
                    $dataColumn['div' . $datakey] += pow($itemColumn, 2);
                }
                $dataColumn['div' . $datakey] = round(sqrt($dataColumn['div' . $datakey]), 7);
            }
            $data['first'] = $data['datasiswa'];

            // normalisasi
            foreach ($data['datasiswa'] as $key => $datasiswa) {
                $data['normalisasi'][$key]['name'] = $datasiswa['name'];
                $data['normalisasi'][$key]['nim'] = $datasiswa['nim'];
                foreach ($data['datakey'] as $datakey) {
                    $data['datasiswa'][$key][$datakey] = round($datasiswa[$datakey] / $dataColumn['div' . $datakey], 9);
                    $data['normalisasi'][$key][$datakey] = round($datasiswa[$datakey] / $dataColumn['div' . $datakey], 9);
                }
            }

            // bobot
            foreach ($data['datasiswa'] as $key => $datasiswa) {
                $data['bobot'][$key]['name'] = $datasiswa['name'];
                $data['bobot'][$key]['nim'] = $datasiswa['nim'];
                foreach ($data['datakey'] as $datakey) {
                    foreach ($data['kriteria'] as $datakriteria) {
                        if ($datakey == $datakriteria['nama_kriteria']) {
                            $data['datasiswa'][$key][$datakey] = $data['datasiswa'][$key][$datakey] * $datakriteria['bobot'];
                            $data['bobot'][$key][$datakey] = $data['normalisasi'][$key][$datakey] * $datakriteria['bobot'];
                        }
                    }
                }
            }

            foreach ($data['kriteria'] as $kriteria) {
                $column = array_column($data['bobot'], $kriteria['nama_kriteria']);
                if (strtolower($kriteria['type']) == $this->BENEFIT) {
                    $data['max'][$kriteria['nama_kriteria']] = max($column);
                    $data['min'][$kriteria['nama_kriteria']] = min($column);
                } else {
                    $data['max'][$kriteria['nama_kriteria']] = min($column);
                    $data['min'][$kriteria['nama_kriteria']] = max($column);
                }
            }

            foreach ($data['bobot'] as $key => $dataBobot) {
                $data['plusminus'][$key]['plus'] = 0;
                $data['plusminus'][$key]['minus'] = 0;
                $data['plusminus'][$key]['name'] = $dataBobot['name'];
                $data['plusminus'][$key]['nim'] = $dataBobot['nim'];
                foreach ($data['datakey'] as $datakey) {
                    $data['plusminus'][$key]['plus'] += pow($dataBobot[$datakey] - $data['max'][$datakey], 2);
                    $data['plusminus'][$key]['minus'] += pow($data['min'][$datakey] - $dataBobot[$datakey], 2);
                }
                $data['plusminus'][$key]['plus'] = sqrt($data['plusminus'][$key]['plus']);
                $data['plusminus'][$key]['minus'] = sqrt($data['plusminus'][$key]['minus']);
            }

            foreach ($data['bobot'] as $key => $databobot) {
                $data['finish'][$key]['name'] = $databobot['name'];
                $data['finish'][$key]['nim'] = $databobot['nim'];
                $data['finish'][$key]['value'] = $data['plusminus'][$key]['minus'] / ($data['plusminus'][$key]['minus'] + $data['plusminus'][$key]['plus']);
            }

            usort($data['finish'], function ($a, $b) {
                if ($a['value'] == $b['value']) {
                    return 0;
                }
                return ($a['value'] > $b['value']) ? -1 : 1;
            });
            return $data;
        } else {
            return [
                'result' => [],
                'normalisasi' => [],
            ];
        }
    }
    public function saw($id)
    {
        $data = $this->getListSiswa($id);
        $column = array();
        // return $data;
        if (sizeof($data['datasiswa']) > 0) {
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
            // return $dataColumn;


            foreach ($data['datasiswa'] as $key => $datasiswa) {
                $data['normalisasi'][$key]['name'] = $datasiswa['name'];
                $data['normalisasi'][$key]['nim'] = $datasiswa['nim'];
                foreach ($data['datakey'] as $datakey) {
                    foreach ($data['kriteria'] as $datakriteria) {
                        if ($datakey == $datakriteria['nama_kriteria']) {
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
            return [
                'result' => $data['datasiswa'],
                'normalisasi' => $data['normalisasi'],
            ];
        } else {
            return [
                'result' => [],
                'normalisasi' => [],
            ];
        }
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
            $item->nama_kriteria = strtolower(str_replace([' ','/','\\','-','&','*','^','%','$'], '_', $item['nama_kriteria']));
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
