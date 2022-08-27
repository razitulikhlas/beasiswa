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
        $kriteria = Kriteria::whereIdBeasiswa($id)->get();
        $nama = array();
        $jumlaKriteria = 0;
        foreach ($kriteria as $key => $value) {
            $nama[$key] = $value->nama_kriteria;
            $jumlaKriteria++;
        }
        return view('layouts.ahp.pilihperbandingan', [
            'n' => $jumlaKriteria,
            'nama' => $nama,
            'id' => $id
        ]);
    }

    public function showAlternatif($no, Request $request)
    {
        // return $request->all();
        $namaKriteria = $this->getKriteriaNama($no, $request['id']);
        $max = $request['max'];
        $siswa = Siswa::all();
        $nama = array();
        $jumlaKriteria = 0;
        foreach ($siswa as $key => $value) {
            $nama[$key] = $value->nama;
            $jumlaKriteria++;
        }


        if($jumlaKriteria <= 2){
            return view('layouts.hasil.erorsatu');
        }
        return view('layouts.ahp.pilihperbandinganalternatif', [
            'n' => $jumlaKriteria,
            'nama' => $nama,
            'namaKriteria' => $namaKriteria,
            'id' => $request['id'],
            'no' => $no
        ]);
    }

    public function matrikkriteria(Request $request)
    {
        $matrik = array();
        $urut     = 0;
        $n = $request['n'];
        $kriteria = Kriteria::whereIdBeasiswa($request['id'])->get();
        $nama = array();
        foreach ($kriteria as $key => $value) {
            $nama[$key] = $value->nama_kriteria;
        }
        $jenis = "kriteria";
        // return $request['pilih1'];
        // return $request->all();

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
            "matrik" => $matrik,
            "matrikb" => $matrikb,
            "jmlmpb" => $jmlmpb,
            "jmlmnk" => $jmlmnk,
            "pv" => $pv,
            "eigenvektor" => $eigenvektor,
            "consIndex" => $consIndex,
            "consRatio" => $consRatio,
            "no" => 0,
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
        $kriteria = Kriteria::whereIdBeasiswa($id)->get();
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
        // return $pv_alternatif;

        // return $checkdata;
        $namaALternatif = Siswa::all();
        // update nilai ranking
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
        // return $namaALternatif;


        $rangking = DB::select('SELECT tbl_siswa.id,tbl_siswa.nama,tbl_rangking.id_alternatif,tbl_rangking.nilai FROM tbl_siswa,tbl_rangking WHERE tbl_siswa.id = tbl_rangking.id_alternatif ORDER BY nilai DESC');

        // return $rangking;

        // return $namaALternatif;


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
        // include('config.php');

        $pv = PvKriteria::whereIdKriteria($id_kriteria)->first();
        // $query = "SELECT nilai FROM pv_kriteria WHERE id_kriteria=$id_kriteria";
        // $result = mysqli_query($koneksi, $query);
        // while ($row = mysqli_fetch_array($result)) {
        // 	$pv = $row['nilai'];
        // }

        return $pv->nilai;
    }
    // mencari priority vector alternatif
    function getAlternatifPV($id_alternatif, $id_kriteria)
    {

        $data = PvAlternatif::whereIdAlternatif($id_alternatif)->whereIdKriteria($id_kriteria)->get();

        // return $data;
        $pv = 0;
        foreach ($data as $value) {
            $pv = $value->nilai;
        }
        // if($pv == 0){
        //     return [
        //         "jika error","alter".$id_alternatif,"krite".$id_kriteria
        //     ];
        // }
        // return[
        //     $pv,"alter".$id_alternatif,"krite".$id_kriteria
        // ];

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
        // return $check;
        // $query  = "SELECT * FROM perbandingan_alternatif WHERE alternatif1 = $id_alternatif1 AND alternatif2 = $id_alternatif2 AND pembanding = $id_pembanding";
        // $result = mysqli_query($koneksi, $query);

        // if (!$result) {
        //     echo "Error !!!";
        //     exit();
        // }

        // jika result kosong maka masukkan data baru
        // jika telah ada maka diupdate
        if (sizeof($check) == 0) {
            PerbandinganAlternatif::create([
                'nilai' => $nilai,
                'alternatif1' => $id_alternatif1,
                'alternatif2' => $id_alternatif2,
                'pembanding' => $id_pembanding,
            ]);
            // $query = "INSERT INTO perbandingan_alternatif (alternatif1,alternatif2,pembanding,nilai) VALUES ($id_alternatif1,$id_alternatif2,$id_pembanding,$nilai)";
        } else {
            PerbandinganAlternatif::whereAlternatif1($id_alternatif1)->whereAlternatif2($id_alternatif2)->wherePembanding($id_pembanding)->update([
                "nilai" => $nilai
            ]);
            // $query = "UPDATE perbandingan_alternatif SET nilai=$nilai WHERE alternatif1=$id_alternatif1 AND alternatif2=$id_alternatif2 AND pembanding=$id_pembanding";
        }
        return [
            'id_alternatif1' => $id_alternatif1,
            'id_alternatif2' => $id_alternatif2,
            'pembanding' => $id_pembanding,
        ];

        // $result = mysqli_query($koneksi, $query);
        // if (!$result) {
        //     echo "Gagal memasukkan data perbandingan";
        //     exit();
        // }
    }

    // memasukkan nilai priority vektor kriteria
    function inputKriteriaPV($id_kriteria, $pv)
    {

        $pvKriteria = PvKriteria::whereIdKriteria($id_kriteria)->get();

        // $query = "SELECT * FROM pv_kriteria WHERE id_kriteria=$id_kriteria";
        // $result = mysqli_query($koneksi, $query);

        // if (!$result) {
        // 	echo "Error !!!";
        // 	exit();
        // }

        // jika result kosong maka masukkan data baru
        // jika telah ada maka diupdate
        if (isset($pvKriteria)) {
            PvKriteria::create(['id_kriteria' => $id_kriteria, 'nilai' => $pv]);
            // $query = "INSERT INTO pv_kriteria (id_kriteria, nilai) VALUES ($id_kriteria, $pv)";
        } else {
            PvKriteria::whereIdKriteria($id_kriteria)->update(['nilai' => $pv]);
            // $query = "UPDATE pv_kriteria SET nilai=$pv WHERE id_kriteria=$id_kriteria";
        }


        // $result = mysqli_query($koneksi, $query);
        // if(!$result) {
        // 	echo "Gagal memasukkan / update nilai priority vector kriteria";
        // 	exit();
        // }

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

        // $query  = "SELECT * FROM perbandingan_kriteria WHERE kriteria1 = $id_kriteria1 AND kriteria2 = $id_kriteria2";
        // $result = mysqli_query($koneksi, $query);

        // if (!$result) {
        // 	echo "Error !!!";
        // 	exit();
        // }

        // jika result kosong maka masukkan data baru
        // jika telah ada maka diupdate
        if (!$check) {
            PerbandinganKriteria::create(['kriteria1' => $id_kriteria1, 'kriteria2' => $id_kriteria2, 'nilai' => $nilai]);
            // $query = "INSERT INTO perbandingan_kriteria (kriteria1,kriteria2,nilai) VALUES ($id_kriteria1,$id_kriteria2,$nilai)";
        } else {
            PerbandinganKriteria::whereKriteria1($id_kriteria1)->whereKriteria2($id_kriteria2)->update(['nilai' => $nilai]);
            // $query = "UPDATE perbandingan_kriteria SET nilai=$nilai WHERE kriteria1=$id_kriteria1 AND kriteria2=$id_kriteria2";
        }

        // $result = mysqli_query($koneksi, $query);
        // if (!$result) {
        // 	echo "Gagal memasukkan data perbandingan";
        // 	exit();
        // }

    }

    // mencari ID kriteria
    // berdasarkan urutan ke berapa (C1, C2, C3)
    function getKriteriaID($no_urut, $id)
    {
        $kriteria  = Kriteria::whereIdBeasiswa($id)->get();
        foreach ($kriteria as $value) {
            $listID[] = $value->id;
        }
        return $listID[($no_urut)];
    }
    function getKriteriaNama($no_urut, $id)
    {
        $kriteria  = Kriteria::whereIdBeasiswa($id)->get();
        foreach ($kriteria as $value) {
            $listID[] = $value->nama_kriteria;
        }
        return $listID[($no_urut - 1)];
    }



    public function bacukp($id)
    {
        $data = $this->getListSiswa($id);
        // return $data;
        $column = array();
        $matrik = array();
        $jumlahColumn = array();
        $matriknilaikriteria = array();
        $totalL = array();
        $a = array();
        $ci = array();
        $ir = array();
        $check = array();
        // return $ir;
        $cr =  array();
        foreach ($data['datakey'] as $key => $datakey) {
            $column[$key] = array_column($data['datasiswa'], $datakey);

            for ($x = 0; $x <= (sizeof($column[$key]) - 2); $x++) {

                for ($y = ($x + 1); $y <= (sizeof($column[$key]) - 1); $y++) {

                    if ($column[$key][$x] > $column[$key][$y]) {
                        $matrik[$key][$x][$y] = (float)round($column[$key][$x] / $column[$key][$y], 2);
                        $matrik[$key][$y][$x] = (float)round($column[$key][$y] / $column[$key][$x], 2);
                    } else {
                        $matrik[$key][$x][$y] = (float)round($column[$key][$x] / $column[$key][$y], 2);
                        $matrik[$key][$y][$x] = (float)round($column[$key][$y] / $column[$key][$x], 2);
                    }
                }

                for ($i = 0; $i <= (sizeof($column[$key]) - 1); $i++) {
                    $matrik[$key][$i][$i] = 1;
                }
            }

            foreach ($matrik[$key] as $keycolumn => $value) {
                // $column[$key] = array_column($matrik,$key);
                $jumlahColumn[$key][$keycolumn] = round(array_sum(array_column($matrik[$key], $keycolumn)), 3);
            }

            foreach ($column[$key] as $n => $value) {
                $i = 0;
                $jumlah = 0;
                foreach ($matrik[$key] as $x => $v) {
                    $matriknilaikriteria[$key][$n][$x] = (float)round($matrik[$key][$n][$x] /  $jumlahColumn[$key][$x], 3);
                    $matriknilaikriteria[$key][$n][$x] = (float)round($matrik[$key][$n][$x] /  $jumlahColumn[$key][$x], 3);
                    $jumlah += $matriknilaikriteria[$key][$n][$x];
                    $i++;
                }
                $a[$key] = $i;
                $matriknilaikriteria[$key][$n][$i] = round($jumlah, 3);
                $matriknilaikriteria[$key][$n][$i + 1] = round($jumlah / $i, 3);
            }

            // return $matriknilaikriteria;
            $totalL[$key] = 0;
            foreach ($jumlahColumn[$key] as $keyc => $value) {
                $totalL[$key] += $value * $matriknilaikriteria[$key][$keyc][$a[$key] + 1];
                $check[$key][$keyc] = "";
                $check[$key][$keyc] = $check[$key][$keyc] . "" . $value . "*" . $matriknilaikriteria[$key][$keyc][$a[$key] + 1];
            }


            $ci[$key] = ($totalL[$key] - $a[$key]) / ($a[$key] - 1);
            $ir[$key] = IR::whereJumlah($a[$key])->first();
            // return $ir;
            $cr[$key] =  $ci[$key] / $ir[$key]->nilai;
        }
        return [
            "matrik" => $matriknilaikriteria,
            "jumlah" => $jumlahColumn,
            "total" => $totalL,
            "check" => $check
            // "cr"=>$cr,
        ];
        // return $check;
        // return $totalL;
        // return $column[0][0];
        return [

            "ci" => $ci,
            "cr" => $cr,
            "ir" => $ir
            // "cr"=>$cr,
        ];



        // return $a;
        return $totalL;

        return $matriknilaikriteria;
        return $jumlahColumn;
        return $matrik;
    }

    public function kriteriafix($id)
    {
        $kriteria = Kriteria::whereIdBeasiswa($id)->whereIsActive(1)->get();
        //   $kriteria = Kriteria::whereIdBeasiswa($id)->get();
        $n = $kriteria->count();
        //   return $n;
        // return $kriteria;

        $matrik = array();

        for ($x = 0; $x <= ($n - 2); $x++) {
            // 1; 1<=2; y++
            for ($y = ($x + 1); $y <= ($n - 1); $y++) {
                // $urut++;
                // $pilih	= "pilih".$urut;
                // $bobot 	= "bobot".$urut;
                if ($kriteria[$x]['bobot'] > $kriteria[$y]['bobot']) {
                    // matrik[0][2] = 5
                    // matriks[2][0] = 1/5
                    // matrik[1][2] = 2
                    // matriks[2][2] = 1/2
                    $matrik[$x][$y] = (float)round($kriteria[$x]['bobot'] / $kriteria[$y]['bobot'], 2);
                    $matrik[$y][$x] = (float)round($kriteria[$y]['bobot'] / $kriteria[$x]['bobot'], 2);
                } else {
                    // matrik[0][1] = 5/10 = 0.5
                    // matriks[1][0] = 10/5 = 2.0
                    // matriks[0][2] = 5/8 = 0.625
                    // matriks[2][0] = 8/5 = 1.6
                    $matrik[$x][$y] = (float)round($kriteria[$x]['bobot'] / $kriteria[$y]['bobot'], 2);
                    $matrik[$y][$x] = (float)round($kriteria[$y]['bobot'] / $kriteria[$x]['bobot'], 2);
                }
            }
        }

        // diagonal --> bernilai 1
        for ($i = 0; $i <= ($n - 1); $i++) {
            $matrik[$i][$i] = 1;
        }

        $jumlahColumn = array();
        foreach ($matrik as $key => $value) {
            // $column[$key] = array_column($matrik,$key);
            $jumlahColumn[$key] = array_sum(array_column($matrik, $key));
        }

        $matriknilaikriteria = array();
        foreach ($kriteria as $n => $value) {
            $i = 0;
            $jumlah = 0;
            foreach ($matrik as $x => $v) {
                $matriknilaikriteria[$n][$x] = (float)round($matrik[$n][$x] /  $jumlahColumn[$x], 3);
                $jumlah += $matriknilaikriteria[$n][$x];
                $i++;
            }
            $matriknilaikriteria[$n][$i] = $jumlah;
            $matriknilaikriteria[$n][$i + 1] = round($jumlah / $i, 3);
        }
        // return $jumlahColumn;

        $totalL = 0;
        foreach ($jumlahColumn as $key => $value) {
            $totalL += $value * $matriknilaikriteria[$key][$i + 1];
        }
        // return $totalL;
        // return $i;
        $ci = ($totalL - $i) / ($i - 1);
        $ir = IR::whereJumlah($i)->first();
        // return $ir;
        $cr =  $ci / $ir->nilai;

        // return [
        //      "kriteria" => $kriteria,
        //     "matrik" => $matrik,
        //     "jumlahcolum" => $jumlahColumn,
        //     "matriksnilaikriteria" => $matriknilaikriteria,
        //     "i" => $i,
        //     "lamda" => $totalL,
        //     "cr" => $cr
        // ];





        return view('layouts.ahp.result', [
            "kriteria" => $kriteria,
            "matrik" => $matrik,
            "jumlahcolum" => $jumlahColumn,
            "matriksnilaikriteria" => $matriknilaikriteria,
            "i" => $i,
            "lamda" => $totalL,
            "cr" => $cr
        ]);
    }

    public function topsis($id)
    {
        $data = $this->getListSiswa($id);
        $column = array();

        // return $data;

        if (sizeof($data['datasiswa']) > 0) {
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
        $kriteriaBeasiswa = Kriteria::whereIdBeasiswa($id)->get();
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
