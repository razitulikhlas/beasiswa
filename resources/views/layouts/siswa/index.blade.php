@extends('layouts.container.main')
@section('container')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-heading">
        <h3>Mahasiswa</h3>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="col-12 col-md-12">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Table Siswa</h4>
                </div>

                <div class="card-content">
                    <div style="margin-left: 20px">
                        <a href="/siswa/create" class="btn btn-primary">Tambah data</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table  mb-0" id="example1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NAME</th>
                                        <th>NISN</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Agama</th>
                                        <th>Phone Orang Tua</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($data))
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="text-bold-500">{{ $loop->iteration }}</td>
                                                <td class="text-bold-500">{{ $item['nama'] }}</td>
                                                <td class="text-bold-500">{{ $item['nim'] }}</td>
                                                <td>{{ $item['jenis_kelamin'] }}</td>
                                                <td class="text-bold-500">{{ $item['agama'] }}</td>
                                                <td>{{ $item['phone'] }}</td>
                                                <td>
                                                    <a href="/siswa/{{ $item['id'] }}"
                                                        class="btn btn-primary rounded-pill">Detail</a>
                                                    <a href="/siswa/{{ $item['id'] }}/edit"
                                                        class="btn btn-info rounded-pill">Edit</a>
                                                    <button type="button" class="btn btn-danger rounded-pill"
                                                        data-bs-toggle="modal" data-id-siswa={{ $item['id'] }}
                                                        data-bs-target="#exampleModalCenter" id="delete">Delete</button>
                                                    <a href="/semester/{{ $item['id'] }}/edit"
                                                        class="btn btn-info rounded-pill">Nilai Semester</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Peringatan!!
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Apakah anda yakin ingin menghapus data ini?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <form action="/siswa" method="post" class="d-inline" id="formDelete">
                        @method('delete')
                        @csrf
                        <button class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Accept</span>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <script>
        $(function() {
            $(document).on('click', '#delete', function() {
                $('#formDelete').attr('action', '/siswa/' + $(this).data('id-siswa'))
            })
        });
    </script>
@endsection
