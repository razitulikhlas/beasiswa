@extends('layouts.container.main')
@section('container')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-heading">
        <h3>Detail Mahasiswa</h3>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="row">
                <div class="col-9">
                    <div class="card-header">
                        <h5 class="card-title">Profile Siswa</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <th class="text-bold-500">Nama</th>
                                        <td>{{ $data['nama'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-bold-500">Tempat/Tanggal Lahir</th>
                                        <td>{{ $data['tempat_lahir'] }}/ {{ $data['tanggal_lahir'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-bold-500">Jenis Kelamin</th>
                                        <td>{{ $data['jenis_kelamin'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-bold-500">Agama</th>
                                        <td>{{ $data['agama'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-bold-500">Alamat Asal</th>
                                        <td>{{ $data['alamat_asal'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-bold-500">Alamat Sekarang</th>
                                        <td>{{ $data['alamat_sekarang'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-bold-500">Email</th>
                                        <td>{{ $data['email'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-bold-500">Status Tempat Tinggal</th>
                                        <td>{{ $data['status_tmpt_tinggal'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-bold-500">Sumber Biaya Sekolah</th>
                                        <td>{{ $data['sumber_biaya_sekolah'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-bold-500">Nomor KK</th>
                                        <td>{{ $data['nomor_kk'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-bold-500">Phone</th>
                                        <td>{{ $data['phone'] }}</td>
                                    </tr>
                                </tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-3  text-end">

                    <img class="myprofile " src="http://127.0.0.1:8000/storage/{{ $data['image'] }}"
                        data-bs-target="#Gallerycarousel" data-bs-slide-to="1">

                </div>
            </div>

        </div>
    </div>
@endsection
