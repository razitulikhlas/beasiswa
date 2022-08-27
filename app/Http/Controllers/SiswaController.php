<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Siswa;
use App\Models\Prodi;
use Illuminate\Http\Request;

class SiswaController extends Controller
{

    function index()
    {

        // return "hello";
        $data = Siswa::all();

        return view('layouts.siswa.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   //

        $jurusan = Jurusan::all()->toArray();
        return view('layouts.siswa.add', [
            'jurusan' => $jurusan
        ]);
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
            'nama' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'alamat_asal' => 'required:false',
            'alamat_sekarang' => 'required:false',
            'email' => "required|unique:tbl_siswa|email:rfc,dns",
            'status_tmpt_tinggal' => 'required',
            'sumber_biaya_sekolah' => 'required',
            'id_jurusan' => 'required',
            'phone' => '',
            'nomor_kk' => '',
            'image' => 'image|file|max:1024'
        ]);


        if ($request->file('image')) {
            $validateData['image'] = $request->file('image')->store('images');
        } else {
            $validateData['image'] = 'images/avatar.jpg';
        }
        $validateData['nim'] = $this->makeNisn();
        $validateData['tahun_masuk'] = date('Y');

        Siswa::create($validateData);
        return redirect('siswa')->with('success', 'Data siswa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data = Siswa::whereId($id)->first();
        return view('layouts.siswa.detail', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Siswa::whereId($id)->first();
        $jurusan = Jurusan::all()->toArray();
        return view('layouts.siswa.edit', [
            'data' => $data,
            'jurusan' => $jurusan
        ]);
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
        $data = Siswa::whereId($id)->first();
        $rules = [
            'nama' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'id_jurusan' => 'required',
            'agama' => 'required',
            'alamat_asal' => 'required:false',
            'alamat_sekarang' => 'required:false',
            'status_tmpt_tinggal' => 'required',
            'sumber_biaya_sekolah' => 'required',
            'phone' => 'required',
            'nomor_kk' => 'required'
        ];

        $validateData = $request->validate($rules);


        if ($request->email != $data['email']) {
            $rules['email'] = "required|unique:tbl_siswa|email:rfc,dns";
        }

        if ($request->file('image')) {
            $rules['image'] = 'image|file|max:1024';
        }


        if ($request->file('image')) {
            $validateData['image'] = $request->file('image')->store('images');
        }

        Siswa::whereId($id)->update($validateData);

        return redirect('siswa')->with('success', 'Data Siswa berhasil diupdate');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Siswa::destroy($id);
        return redirect('siswa')->with('success', 'Data siswa berhasil dihapus');
    }
}
