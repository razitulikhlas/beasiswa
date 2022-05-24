@extends('layouts.container.main')
@section('container')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-heading">
        <h3>Prodi </h3>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="col-12 row">
        <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambahkan data prodi</h4>
                </div>

                <div class="card-content">

                    <div class="card-body">
                        <form class="form" action="/prodi" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="prodi">Nama Prodi*</label>
                                        <input type="text" id="prodi"
                                            class="form-control @error('prodi') is-invalid @enderror"
                                            placeholder="Nama prodi" name="prodi" required
                                            oninvalid="this.setCustomValidity('data prodi tidak boleh kosong')"
                                            oninput="setCustomValidity('')" value="{{ old('prodi') }}">
                                        @error('prodi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="prodi">Tingkatan</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="tingkatan" name="tingkat">
                                                <option value="D3">D3</option>
                                                <option value="D4">D4</option>
                                                <option value="S2">S2</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="prodi">Jurusan*</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="id_jurusan" name="id_jurusan">
                                                @foreach ($jurusan as $item)
                                                    @if (old('id_jurusan') == $item['id'])
                                                        <option value="{{ $item['id'] }}" selected>
                                                            {{ $item['jurusan'] }}</option>
                                                    @else
                                                        <option value="{{ $item['id'] }}">{{ $item['jurusan'] }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="kode_prodi">Kode Prodi</label>
                                        <input type="text" id="kode_prodi" class="form-control" readonly
                                            placeholder="Kode prodi" name="kode_prodi" required
                                            oninvalid="this.setCustomValidity('data tempat lahir tidak boleh kosong')"
                                            oninput="setCustomValidity('')" value="{{ old('kode_prodi', $kode_prodi) }}">
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
        <div class="col-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Table Prodi</h4>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  mb-0" id="example1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jurusan</th>
                                        <th>Prodi</th>
                                        <th>Tingkat</th>
                                        <th>Kode Prodi</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-bold-500">{{ $loop->iteration }}</td>
                                            <td class="text-bold-500">{{ $item->jurusan->jurusan }}</td>
                                            <td class="text-bold-500">{{ $item['prodi'] }}</td>
                                            <td class="text-bold-500">{{ $item['tingkat'] }}</td>
                                            <td class="text-bold-500">{{ $item['kode_prodi'] }}</td>
                                            <td>
                                                <button id="edit" type="button" data-id={{ $item['id'] }}
                                                    data-prodi="{{ $item['prodi'] }}"
                                                    data-kd_prodi={{ $item['kode_prodi'] }}
                                                    data-id_jurusan={{ $item['id_jurusan'] }}
                                                    data-tingkat={{ $item['tingkat'] }} class="btn btn-info rounded-pill"
                                                    data-bs-toggle="modal" data-bs-target="#update">Edit</button>
                                                <button type="button" class="btn btn-danger rounded-pill"
                                                    data-bs-toggle="modal" data-id-prodi={{ $item['id'] }}
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
                    <form action="/prodi" method="post" class="d-inline" id="formDelete">
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
                    <form class="form" method="post" id="formEdit">
                        @method('put')
                        @csrf
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="prodi">Nama Prodi*</label>
                                    <input type="text" id="Uprodi" class="form-control @error('prodi') is-invalid @enderror"
                                        placeholder="Nama prodi" name="prodi" required
                                        oninvalid="this.setCustomValidity('data prodi tidak boleh kosong')"
                                        oninput="setCustomValidity('')" value="{{ old('prodi') }}">
                                    @error('prodi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="prodi">Tingkatan</label>
                                    <fieldset class="form-group">
                                        <select class="form-select" id="Utingkat" name="tingkat">
                                            <option value="D3">D3</option>
                                            <option value="D4">D4</option>
                                            <option value="S2">S2</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="prodi">Jurusan*</label>
                                    <fieldset class="form-group">
                                        <select class="form-select" id="Uid_jurusan" name="id_jurusan">
                                            @foreach ($jurusan as $item)
                                                @if (old('id_jurusan') == $item['id'])
                                                    <option value="{{ $item['id'] }}" selected>
                                                        {{ $item['jurusan'] }}</option>
                                                @else
                                                    <option value="{{ $item['id'] }}">{{ $item['jurusan'] }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="kode_prodi">Kode Prodi</label>
                                    <input type="text" id="Ukode_prodi" class="form-control" readonly
                                        placeholder="Kode prodi" name="kode_prodi" required
                                        oninvalid="this.setCustomValidity('data tempat lahir tidak boleh kosong')"
                                        oninput="setCustomValidity('')" value="{{ old('kode_prodi', $kode_prodi) }}">
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

    <script>
        $(function() {
            $(document).on('click', '#delete', function() {
                $('#formDelete').attr('action', '/prodi/' + $(this).data('id-prodi'))
            })

            $(document).on('click', '#edit', function() {
                const id = $(this).data('id');
                const id_jurusan = $(this).data('id_jurusan');
                const prodi = $(this).data('prodi');
                const kd_prodi = $(this).data('kd_prodi');
                const tingkat = $(this).data('tingkat');

                $("#Uprodi").val(prodi);
                $("#Ukode_prodi").val(kd_prodi);
                $('#Uid_jurusan').val(id_jurusan);
                $('#Utingkat').val(tingkat);
                $('#formEdit').attr('action', '/prodi/' + id);
            })
        });
    </script>
@endsection
