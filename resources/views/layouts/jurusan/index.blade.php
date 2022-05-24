@extends('layouts.container.main')
@section('container')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-heading">
        <h3>Jurusan </h3>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="col-12 row">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambahkan data jurusan</h4>
                </div>

                <div class="card-content">

                    <div class="card-body">
                        <form class="form" action="/jurusan" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="jurusan">Nama Jurusan*</label>
                                        <input type="text" id="jurusan" class="form-control" placeholder="Nama Jurusan"
                                            name="jurusan" required
                                            oninvalid="this.setCustomValidity('data nama tidak boleh kosong')"
                                            oninput="setCustomValidity('')" value="{{ old('jurusan') }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="kode_jurusan">Kode Jurusan</label>
                                        <input type="text" id="kode_jurusan" class="form-control" readonly
                                            placeholder="Kode jurusan" name="kode_jurusan" required
                                            oninvalid="this.setCustomValidity('data tempat lahir tidak boleh kosong')"
                                            oninput="setCustomValidity('')"
                                            value="{{ old('kode_jurusan', $kode_jurusan) }}">
                                    </div>
                                </div>


                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Table Jurusan</h4>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  mb-0" id="example1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jurusan</th>
                                        <th>Kode Jurusan</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-bold-500">{{ $loop->iteration }}</td>
                                            <td class="text-bold-500">{{ $item['jurusan'] }}</td>
                                            <td class="text-bold-500">{{ $item['kode_jurusan'] }}</td>
                                            <td>
                                                <button id="edit" type="button" data-id={{ $item['id'] }}
                                                    data-jurusan="{{ $item['jurusan'] }}"
                                                    data-kd_jurusan={{ $item['kode_jurusan'] }}
                                                    class="btn btn-info rounded-pill" data-bs-toggle="modal"
                                                    data-bs-target="#update">Edit</button>
                                                <button type="button" class="btn btn-danger rounded-pill"
                                                    data-bs-toggle="modal" data-id-jurusan={{ $item['id'] }}
                                                    data-bs-target="#exampleModalCenter" id="delete">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
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
                    <form action="/jurusan" method="post" class="d-inline" id="formDelete">
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

    <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Update data</h4>

                </div>
                <div class="modal-body">
                    <form class="form" action="/jurusan" method="post" id="formEdit">
                        @method('put')
                        @csrf
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="jurusan">Nama Jurusan*</label>
                                    <input type="text" id="Ujurusan" class="form-control" placeholder="Nama Jurusan"
                                        name="jurusan" required
                                        oninvalid="this.setCustomValidity('data nama tidak boleh kosong')"
                                        oninput="setCustomValidity('')" value="{{ old('jurusan') }}">
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="kode_jurusan">Kode Jurusan</label>
                                    <input type="text" id="Ukode_jurusan" class="form-control" readonly
                                        placeholder="Kode jurusan" name="kode_jurusan" required
                                        oninvalid="this.setCustomValidity('data tempat lahir tidak boleh kosong')"
                                        oninput="setCustomValidity('')" value="{{ old('kode_jurusan', $kode_jurusan) }}">
                                </div>
                            </div>


                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary ml-1">Submit</button>
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $(document).on('click', '#delete', function() {
                $('#formDelete').attr('action', '/jurusan/' + $(this).data('id-jurusan'))
            })

            $(document).on('click', '#edit', function() {
                const id = $(this).data('id');
                const jurusan = $(this).data('jurusan');
                const kd_jurusan = $(this).data('kd_jurusan');

                $("#Ujurusan").val(jurusan);
                $("#Ukode_jurusan").val(kd_jurusan);
                $('#formEdit').attr('action', '/jurusan/' + id);
            })
        });
    </script>
@endsection
