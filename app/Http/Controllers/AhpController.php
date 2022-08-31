<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\DataBeasiswa;
use App\Models\IR;
use App\Models\Kriteria;
use App\Models\PerbandinganAlternatif;
use App\Models\PerbandinganKriteria;
use App\Models\PvAlternatif;
use App\Models\PvKriteria;
use App\Models\Rangking;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class AhpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoryBeasiswa = Beasiswa::all();
        return view('layouts.ahp.index', [
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
        $kriteria = Kriteria::whereIdBeasiswa($id)->whereIsActive(1)->get();
        $nama = array();
        $jumlaKriteria = 0;
        foreach ($kriteria as $key => $value) {
            $nama[$key] = $value->nama_kriteria;
            $jumlaKriteria++;
        }
        if($jumlaKriteria <= 2){
            return view('layouts.hasil.erorsatu');
        }
        // return $jumlaKriteria;
        return view('layouts.ahp.pilihperbandingan', [
            'jumlahkriteria' => $jumlaKriteria,
            'nama' => $nama,
            'id' => $id
        ]);
    }

    public function showAlternatif($no, Request $request)
    {
        // return $request->all();
        $namaKriteria = $this->getKriteriaNama($no, $request['id']);
        $jumlahkriteria = $request['jumlahkriteria'];
        $siswa = Siswa::all();
        $nama = array();
        $jumlahalternatif = 0;
        foreach ($siswa as $key => $value) {
            $nama[$key] = $value->nama;
            $jumlahalternatif++;
        }

        // return $jumlahalternatif;

        if($jumlahalternatif <= 2){
            return view('layouts.hasil.erorsatu');
        }
        return view('layouts.ahp.pilihperbandinganalternatif', [
            'n' => $jumlahalternatif,
            'jumlahkriteria' => $jumlahkriteria,
            'nama' => $nama,
            'namaKriteria' => $namaKriteria,
            'id' => $request['id'],
            'no' => $no
        ]);
    }

    public function matrikkriteria(Request $request)
    {
        // return $request;
        $matrik = array();
        $urut     = 0;
        $jumlaKriteria = $request['jumlahkriteria'];
        $kriteria = Kriteria::whereIdBeasiswa($request['id'])->whereIsActive(1)->get();
        $nama = array();
        foreach ($kriteria as $key => $value) {
            $nama[$key] = $value->nama_kriteria;
        }
        $n = $jumlaKriteria;

        for ($x = 0; $x <= ($n - 2); $x++) {
            for ($y = ($x + 1); $y <= ($n - 1); $y++) {
                $urut++;
                $pilih    = "pilih" . $urut;
                $bobot     = "bobot" . $urut;
                if ($request["" . $pilih] == 1) {
                    $matrik[$x][$y] = $request["" . $bobot];
                    $matrik[$y][$x] = 1 / $request["" . $bobot];
                } else {
                    $matrik[$x][$y] = 1 / $request["" . $bobot];
                    $matrik[$y][$x] = $request["" . $bobot];
                }


                if ($request["" . $pilih] == 1) {
                    $this->inputDataPerbandinganKriteria($x, $y, $matrik[$x][$y], $request['id']);
                } else {
                    $this->inputDataPerbandinganKriteria($x, $y, $matrik[$y][$x], $request['id']);
                }
            }
        }



        // diagonal --> bernilai 1
        for ($i = 0; $i <= ($n - 1); $i++) {
            $matrik[$i][$i] = 1;
        }

        // inisialisasi jumlah tiap kolom dan baris kriteria
        $jmlmpb = array();
        $jmlmnk = array();
        for ($i = 0; $i <= ($n - 1); $i++) {
            $jmlmpb[$i] = 0;
            $jmlmnk[$i] = 0;
        }

        // menghitung jumlah pada kolom kriteria tabel perbandingan berpasangan
        for ($x = 0; $x <= ($n - 1); $x++) {
            for ($y = 0; $y <= ($n - 1); $y++) {
                $value        = $matrik[$x][$y];
                $jmlmpb[$y] += $value;
            }
        }




        // menghitung jumlah pada baris kriteria tabel nilai kriteria
        // matrikb merupakan matrik yang telah dinormalisasi
        for ($x = 0; $x <= ($n - 1); $x++) {
            for ($y = 0; $y <= ($n - 1); $y++) {
                $matrikb[$x][$y] = $matrik[$x][$y] / $jmlmpb[$y];
                $value    = $matrikb[$x][$y];
                $jmlmnk[$x] += $value;
            }

            // nilai priority vektor
            $pv[$x]     = $jmlmnk[$x] / $n;

            $id_kriteria = $this->getKriteriaID($x, $request['id']);
            $this->inputKriteriaPV($id_kriteria, $pv[$x]);
            // memasukkan nilai priority vektor ke dalam tabel pv_kriteria dan pv_alternatif

        }

        // return $pv;

        // cek konsistensi
        $eigenvektor = $this->getEigenVector($jmlmpb, $jmlmnk, $n);
        $consIndex   = $this->getConsIndex($jmlmpb, $jmlmnk, $n);
        $consRatio   = $this->getConsRatio($jmlmpb, $jmlmnk, $n);

        // return $nama;

        return view('layouts.ahp.proseskriteria', [
            "nama" => $nama,
            "n" => $n,
            "jumlahkriteria"=>$jumlaKriteria,
            "matrik" => $matrik,
            "matrikb" => $matrikb,
            "jmlmpb" => $jmlmpb,
            "jmlmnk" => $jmlmnk,
            "pv" => $pv,
            "eigenvektor" => $eigenvektor,
            "consIndex" => $consIndex,
            "consRatio" => $consRatio,
            "no" => 1,
            "id" => $request['id']
        ]);
    }

    public function matrikalternatif(Request $request)
    {
        // return $request->all();
        $id = $request['id'];
        $matrik = array();
        $urut     = 0;
        $n = $request['n'];
        $jumlahkriteria = $request['jumlahkriteria'];
        $siswa = Siswa::all();
        $nama = array();
        $jenis = $request['jenis'];
        foreach ($siswa as $key => $value) {
            $nama[$key] = $value->nama;
        }

        for ($x = 0; $x <= ($n - 2); $x++) {
            for ($y = ($x + 1); $y <= ($n - 1); $y++) {
                $urut++;
                $pilih    = "pilih" . $urut;
                $bobot     = "bobot" . $urut;
                if ($request["" . $pilih] == 1) {
                    $matrik[$x][$y] = $request["" . $bobot];
                    $matrik[$y][$x] = 1 / $request["" . $bobot];
                } else {
                    $matrik[$x][$y] = 1 / $request["" . $bobot];
                    $matrik[$y][$x] = $request["" . $bobot];
                }


                if ($request["" . $pilih] == 1) {
                    $this->inputDataPerbandinganAlternatif($x, $y, ($jenis - 1), $matrik[$x][$y], $id);
                } else {
                    $this->inputDataPerbandinganAlternatif($x, $y, ($jenis - 1), $matrik[$y][$x], $id);
                }
            }
        }



        // diagonal --> bernilai 1
        for ($i = 0; $i <= ($n - 1); $i++) {
            $matrik[$i][$i] = 1;
        }

        // inisialisasi jumlah tiap kolom dan baris kriteria
        $jmlmpb = array();
        $jmlmnk = array();
        for ($i = 0; $i <= ($n - 1); $i++) {
            $jmlmpb[$i] = 0;
            $jmlmnk[$i] = 0;
        }

        // menghitung jumlah pada kolom kriteria tabel perbandingan berpasangan
        for ($x = 0; $x <= ($n - 1); $x++) {
            for ($y = 0; $y <= ($n - 1); $y++) {
                $value        = $matrik[$x][$y];
                $jmlmpb[$y] += $value;
            }
        }




        // menghitung jumlah pada baris kriteria tabel nilai kriteria
        // matrikb merupakan matrik yang telah dinormalisasi
        for ($x = 0; $x <= ($n - 1); $x++) {
            for ($y = 0; $y <= ($n - 1); $y++) {
                $matrikb[$x][$y] = $matrik[$x][$y] / $jmlmpb[$y];
                $value    = $matrikb[$x][$y];
                $jmlmnk[$x] += $value;
            }

            // nilai priority vektor
            $pv[$x]     = $jmlmnk[$x] / $n;

            // memasukkan nilai priority vektor ke dalam tabel pv_kriteria dan pv_alternatif
            $id_kriteria    = $this->getKriteriaID($jenis - 1, $request['id']);
            $id_alternatif  = $this->getAlternatifID($x);
            $this->inputAlternatifPV($id_alternatif, $id_kriteria, $pv[$x]);
        }

        // cek konsistensi
        $eigenvektor = $this->getEigenVector($jmlmpb, $jmlmnk, $n);
        $consIndex   = $this->getConsIndex($jmlmpb, $jmlmnk, $n);
        $consRatio   = $this->getConsRatio($jmlmpb, $jmlmnk, $n);

        // return $nama;

        return view('layouts.ahp.prosesalternatif', [
            "nama" => $nama,
            "n" => $n,
            "matrik" => $matrik,
            "matrikb" => $matrikb,
            "jmlmpb" => $jmlmpb,
            "jmlmnk" => $jmlmnk,
            "pv" => $pv,
            "eigenvektor" => $eigenvektor,
            "consIndex" => $consIndex,
            "consRatio" => $consRatio,
            "no" => $jenis,
            "jumlahkriteria" => $jumlahkriteria,
            "id" => $request["id"]
        ]);

        return [
            "matrik" => $matrik,
            "jmlmpb" => $jmlmpb,
            "eigen" => $eigenvektor,
            "consndex" => $consIndex,
            "consratio" => $consRatio,
        ];
    }

    function hasil(Request $request)
    {
        // menghitung perangkingan
        $id = $request['id'];
        $kriteria =  Kriteria::whereIdBeasiswa($id)->whereIsActive(1)->get();
        $siswa = Siswa::all();
        $jmlKriteria     = sizeof($kriteria);
        $jmlAlternatif    = sizeof($siswa);
        $nilai            = array();

        $checkdata = array();

        // mendapatkan nilai tiap alternatif
        for ($x = 0; $x <= ($jmlAlternatif - 1); $x++) {
            // inisialisasi
            $nilai[$x] = 0;

            for ($y = 0; $y <= ($jmlKriteria - 1); $y++) {
                $id_alternatif  = $this->getAlternatifID($x);
                $id_kriteria    = $this->getKriteriaID($y, $id);
                $pv_alternatif = $this->getAlternatifPV($id_alternatif, $id_kriteria);
                $pv_kriteria    = $this->getKriteriaPV($id_kriteria);
                $nilai[$x]      += ($pv_alternatif * $pv_kriteria);
                // $checkdata[] = "".$pv_alternatif."*".$pv_kriteria;
            }
        }

        $namaALternatif = Siswa::all();

        for ($i = 0; $i <= ($jmlAlternatif - 1); $i++) {
            $id_alternatif = $this->getAlternatifID($i);

            $check = Rangking::whereIdBeasiswa($id)->whereIdAlternatif($id_alternatif)->first();

            if (!isset($check)) {
                Rangking::create([
                    "id_beasiswa" => $id,
                    "id_alternatif" => $id_alternatif,
                    "nilai" => $nilai[$i],
                ]);
            } else {
                Rangking::whereIdBeasiswa($id)->whereIdAlternatif($id_alternatif)->update(['nilai' => $nilai[$i]]);
            }


            // $query = "INSERT INTO ranking VALUES ($id_alternatif,$nilai[$i]) ON DUPLICATE KEY UPDATE nilai=$nilai[$i]";
            // $result = mysqli_query($koneksi, $query);
            // if (!$result) {
            //     echo "Gagal mengupdate ranking";
            //     exit();
            // }
        }

        foreach ($kriteria as $keyx => $value) {
            $kriteria[$keyx]['kriteriaPv'] = round($this->getKriteriaPV($this->getKriteriaID($keyx, $id)), 5);

            foreach($namaALternatif as $keyy => $value){
                $namaALternatif[$keyy]['alternatifPv'] = round($this->getAlternatifPV($this->getAlternatifID($keyy),$this->getKriteriaID($keyx,$id)),5);
            }

        }

        $rangking = DB::select('SELECT tbl_siswa.id,tbl_siswa.nama,tbl_rangking.id_alternatif,tbl_rangking.nilai FROM tbl_siswa,tbl_rangking WHERE tbl_siswa.id = tbl_rangking.id_alternatif ORDER BY nilai DESC');

        return view("layouts.ahp.rangking", [
            "namaAlternatif" => $namaALternatif,
            "kriteria" => $kriteria,
            "nilai" => $nilai,
            "rangking" => $rangking
        ]);
    }


    // mencari priority vector kriteria
    function getKriteriaPV($id_kriteria)
    {
        $pv = PvKriteria::whereIdKriteria($id_kriteria)->first();
        return $pv->nilai;
    }
    // mencari priority vector alternatif
    function getAlternatifPV($id_alternatif, $id_kriteria)
    {

        $data = PvAlternatif::whereIdAlternatif($id_alternatif)->whereIdKriteria($id_kriteria)->get();

        $pv = 0;
        foreach ($data as $value) {
            $pv = $value->nilai;
        }
        return $pv;
    }

    // memasukkan nilai priority vektor alternatif
    function inputAlternatifPV($id_alternatif, $id_kriteria, $pv)
    {

        $check = PvAlternatif::whereIdAlternatif($id_alternatif)->whereIdKriteria($id_kriteria)->get();
        // jika result kosong maka masukkan data baru
        // jika telah ada maka diupdate
        if (sizeof($check) == 0) {
            PvAlternatif::create([
                "id_alternatif" => $id_alternatif,
                "id_kriteria" => $id_kriteria,
                "nilai" => $pv,
            ]);
        } else {
            PvAlternatif::whereIdAlternatif($id_alternatif)->whereIdKriteria($id_kriteria)->update(
                ['nilai' => $pv]
            );
        }
    }

    // mencari ID alternatif
    // berdasarkan urutan ke berapa (A1, A2, A3)
    function getAlternatifID($no_urut)
    {
        $siswa = Siswa::all();
        foreach ($siswa as $value) {
            $listID[] = $value->id;
        }

        return $listID[($no_urut)];
    }

    // memasukkan bobot nilai perbandingan alternatif
    function inputDataPerbandinganAlternatif($alternatif1, $alternatif2, $pembanding, $nilai, $id)
    {
        $id_alternatif1 = $this->getAlternatifID($alternatif1);
        $id_alternatif2 = $this->getAlternatifID($alternatif2);
        $id_pembanding  = $this->getKriteriaID($pembanding, $id);


        $check = PerbandinganAlternatif::whereAlternatif1($id_alternatif1)->whereAlternatif2($id_alternatif2)->wherePembanding($id_pembanding)->get();

        // jika result kosong maka masukkan data baru
        // jika telah ada maka diupdate
        if (sizeof($check) == 0) {
            PerbandinganAlternatif::create([
                'nilai' => $nilai,
                'alternatif1' => $id_alternatif1,
                'alternatif2' => $id_alternatif2,
                'pembanding' => $id_pembanding,
            ]);
        } else {
            PerbandinganAlternatif::whereAlternatif1($id_alternatif1)->whereAlternatif2($id_alternatif2)->wherePembanding($id_pembanding)->update([
                "nilai" => $nilai
            ]);
        }
        return [
            'id_alternatif1' => $id_alternatif1,
            'id_alternatif2' => $id_alternatif2,
            'pembanding' => $id_pembanding,
        ];

    }

    // memasukkan nilai priority vektor kriteria
    function inputKriteriaPV($id_kriteria, $pv)
    {

        $pvKriteria = PvKriteria::whereIdKriteria($id_kriteria)->get();
        // jika result kosong maka masukkan data baru
        // jika telah ada maka diupdate
        if (isset($pvKriteria)) {
            PvKriteria::create(['id_kriteria' => $id_kriteria, 'nilai' => $pv]);
        } else {
            PvKriteria::whereIdKriteria($id_kriteria)->update(['nilai' => $pv]);
        }

    }

    // mencari Principe Eigen Vector (λ maks)
    function getEigenVector($matrik_a, $matrik_b, $n)
    {
        $eigenvektor = 0;
        for ($i = 0; $i <= ($n - 1); $i++) {
            $eigenvektor += ($matrik_a[$i] * (($matrik_b[$i]) / $n));
        }

        return $eigenvektor;
    }

    // mencari Cons Index
    function getConsIndex($matrik_a, $matrik_b, $n)
    {
        $eigenvektor = $this->getEigenVector($matrik_a, $matrik_b, $n);
        $consindex = ($eigenvektor - $n) / ($n - 1);

        return $consindex;
    }

    // Mencari Consistency Ratio
    function getConsRatio($matrik_a, $matrik_b, $n)
    {
        $consindex = $this->getConsIndex($matrik_a, $matrik_b, $n);
        $ir = IR::whereJumlah($n)->first();
        $consratio = $consindex / $ir->nilai;

        return $consratio;
    }


    // memasukkan bobot nilai perbandingan kriteria
    function inputDataPerbandinganKriteria($kriteria1, $kriteria2, $nilai, $id)
    {

        $id_kriteria1 = $this->getKriteriaID($kriteria1, $id);
        $id_kriteria2 = $this->getKriteriaID($kriteria2, $id);

        $check = PerbandinganKriteria::whereKriteria1($id_kriteria1)->whereKriteria2($id_kriteria2)->first();


        // jika result kosong maka masukkan data baru
        // jika telah ada maka diupdate
        if (!$check) {
            PerbandinganKriteria::create(['kriteria1' => $id_kriteria1, 'kriteria2' => $id_kriteria2, 'nilai' => $nilai]);
        } else {
            PerbandinganKriteria::whereKriteria1($id_kriteria1)->whereKriteria2($id_kriteria2)->update(['nilai' => $nilai]);
        }

    }

    // mencari ID kriteria
    // berdasarkan urutan ke berapa (C1, C2, C3)
    function getKriteriaID($no_urut, $id)
    {
        $kriteria  =  Kriteria::whereIdBeasiswa($id)->whereIsActive(1)->get();
        foreach ($kriteria as $value) {
            $listID[] = $value->id;
        }
        return $listID[($no_urut)];
    }
    function getKriteriaNama($no_urut, $id)
    {
        $kriteria  = Kriteria::whereIdBeasiswa($id)->whereIsActive(1)->get();
        foreach ($kriteria as $value) {
            $listID[] = $value->nama_kriteria;
        }
        return $listID[($no_urut - 1)];
    }



    public function getListSiswa($id)
    {
        $totalBoot = Kriteria::whereIdBeasiswa($id)->sum('bobot');
        $kriteriaBeasiswa = Kriteria::whereIdBeasiswa($id)->get();
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
