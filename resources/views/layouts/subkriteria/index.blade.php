@extends('layouts.container.main')
@section('container')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-heading">
        <h3>Kriteria {{ $title }}</h3>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session()->has('errorbobot'))
        <div class="alert alert-danger">{{ session('errorbobot') }}</div>
    @endif


    <div class="col-12 row">
        <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambahkan data sub kriteria</h4>
                </div>

                <div class="card-content">

                    <div class="card-body">
                        <form class="form" action="/subkriteria" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="kriteria">Nama Sub Kriteria*</label>
                                        <input type="text" id="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            placeholder="Nama kriteria" name="title" required
                                            oninvalid="this.setCustomValidity('data kriteria tidak boleh kosong')"
                                            oninput="setCustomValidity('')" value="{{ old('title') }}">
                                        @error('tile')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <input type="text" id="id_kriteria" class="form-control" name="id_kriteria"
                                        value="{{ $id_kriteria }}" readonly hidden>

                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="value">Nilai Sub kriteria</label>
                                        <input type="text" id="value"
                                            class="form-control @if (session('errorvalue')) is-invalid @endif"
                                            placeholder="nilai Sub kriteria" name="value" required
                                            oninvalid="this.setCustomValidity('nilai sub kriteria tidak boleh kosong')"
                                            oninput="setCustomValidity('')" value="{{ old('value') }}">
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>
                                <a href="/kategoribeasiswa/{{ $id_beasiswa }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Table Kriteria</h4>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  mb-0" id="example1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sub Kriteria</th>
                                        <th>Nilai Subkriteria</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-bold-500">{{ $loop->iteration }}</td>
                                            <td class="text-bold-500">{{ $item['title'] }}</td>
                                            <td class="text-bold-500">{{ $item['value'] }}</td>
                                            <td>
                                                <button id="edit" type="button" data-id={{ $item['id'] }}
                                                    data-sub-kriteria="{{ $item['title'] }}" data-id="{{ $item['id'] }}"
                                                    data-value={{ $item['value'] }} class="btn btn-info rounded-pill"
                                                    data-bs-toggle="modal" data-bs-target="#update">Edit</button>

                                                <button type="button" class="btn btn-danger rounded-pill"
                                                    data-bs-toggle="modal" data-id-kriteria={{ $item['id'] }}
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
                    <form action="/subkriteria" method="post" class="d-inline" id="formDelete">
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
                                    <label for="usub_kriteria">Nama Sub Kriteria*</label>
                                    <input type="text" id="usub_kriteria"
                                        class="form-control @error('usub_kriteria') is-invalid @enderror"
                                        placeholder="Nama kriteria" name="usub_kriteria" required
                                        oninvalid="this.setCustomValidity('data kriteria tidak boleh kosong')"
                                        oninput="setCustomValidity('')" value="{{ old('usub_kriteria') }}">
                                    @error('kriteria')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <input type="hidden" id="uid_kriteria" class="form-control" name="id_subkriteria">
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="uvalue">Nilai Sub kriteria</label>
                                    <input type="text" id="uvalue"
                                        class="form-control @if (session('errorvalue')) is-invalid @endif"
                                        placeholder="nilai Sub kriteria" name="uvalue" required
                                        oninvalid="this.setCustomValidity('nilai sub kriteria tidak boleh kosong')"
                                        oninput="setCustomValidity('')" value="{{ old('uvalue') }}">
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
                $('#formDelete').attr('action', '/subkriteria/' + $(this).data('id-kriteria'))
            })
            $(document).on('click', '#edit', function() {
                const id = $(this).data('id');
                const sub_kriteria = $(this).data('sub-kriteria');
                const value = $(this).data('value');

                console.log(id);


                $("#usub_kriteria").val(sub_kriteria);
                $("#uvalue").val(value);
                $("#uid_kriteria").val(id);
                $('#formEdit').attr('action', '/kriteria/' + id);
            })
        });
    </script>
@endsection
