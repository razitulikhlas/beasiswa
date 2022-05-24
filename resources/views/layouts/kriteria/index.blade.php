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

    <div class="col col-lg-1 offset-lg-11">
        <a href="/kategoribeasiswa" class="">Back</a>
    </div>
    <div class="col-12 row">
        <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambahkan data kriteria</h4>
                </div>

                <div class="card-content">

                    <div class="card-body">
                        <form class="form" action="/kriteria" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="kriteria">Nama Kriteria*</label>
                                        <input type="text" id="kriteria"
                                            class="form-control @error('kriteria') is-invalid @enderror"
                                            placeholder="Nama kriteria" name="nama_kriteria" required
                                            oninvalid="this.setCustomValidity('data kriteria tidak boleh kosong')"
                                            oninput="setCustomValidity('')" value="{{ old('nama_kriteria') }}">
                                        @error('kriteria')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <input type="text" id="id_beasiswa"
                                            class="form-control" name="id_beasiswa" value="{{ $id_beasiswa }}" readonly hidden>
                                    
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="type">Type Kriteria*</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="type" name="type">
                                                <option @if (old('type') == 'Benefit') selected @endif>Benefit</option>
                                                <option @if (old('type') == 'Cost') selected @endif>Cost</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="bobot">Bobot</label>
                                        <input type="number" id="bobot"
                                            class="form-control @if (session('errorbobot')) is-invalid @endif"
                                            placeholder="nilai bobot" name="bobot" required
                                            oninvalid="this.setCustomValidity('nilai bobot tidak boleh kosong')"
                                            oninput="setCustomValidity('')" value="{{ old('bobot') }}">

                                        <small class="text-muted">bobot yang tersedia {{ $bobot_available }}</small>
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
                    <h4 class="card-title">Table Kriteria</h4>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  mb-0" id="example1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kriteria</th>
                                        <th>Type</th>
                                        <th>Bobot</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-bold-500">{{ $loop->iteration }}</td>
                                            <td class="text-bold-500">{{ $item['nama_kriteria'] }}</td>
                                            <td class="text-bold-500">{{ $item['type'] }}</td>
                                            <td class="text-bold-500">{{ $item['bobot'] }}</td>
                                            <td>
                                                <button id="edit" type="button" data-id={{ $item['id'] }}
                                                    data-nama-kriteria="{{ $item['nama_kriteria'] }}"
                                                    data-id="{{ $item['id'] }}" data-type={{ $item['type'] }}
                                                    data-bobot={{ $item['bobot'] }} class="btn btn-info rounded-pill"
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
                    <form action="/kriteria" method="post" class="d-inline" id="formDelete">
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
                                    <label for="kriteria">Nama Kriteria*</label>
                                    <input type="text" id="Ukriteria"
                                        class="form-control @error('kriteria') is-invalid @enderror"
                                        placeholder="Nama kriteria" name="kriteria" required
                                        oninvalid="this.setCustomValidity('data kriteria tidak boleh kosong')"
                                        oninput="setCustomValidity('')" value="{{ old('kriteria') }}">
                                    @error('kriteria')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="type">Type Kriteria*</label>
                                    <fieldset class="form-group">
                                        <select class="form-select" id="Utype" name="type">
                                            <option @if (old('type') == 'Benefit') selected @endif>Benefit</option>
                                            <option @if (old('type') == 'Cost') selected @endif>Cost</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="bobot">Bobot</label>
                                    <input type="number" id="Ubobot" class="form-control" placeholder="Kode prodi"
                                        name="bobot" required
                                        oninvalid="this.setCustomValidity('nilai bobot tidak boleh kosong')"
                                        oninput="setCustomValidity('')" value="{{ old('bobot') }}">
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
                $('#formDelete').attr('action', '/kriteria/' + $(this).data('id-kriteria'))
            })
            // $('#useRange').hide();
            // $('#checkRange').click(function(){
                
            //     if($(this).is(':checked')){
            //         $('#useRange').show();
            //     } else {
            //         $('#useRange').hide();
            //     }
            // });

            $(document).on('click', '#edit', function() {
                const id = $(this).data('id');
                const nama_kriteria = $(this).data('nama-kriteria');
                const type = $(this).data('type');
                const bobot = $(this).data('bobot');

                console.log(nama_kriteria);

                $("#Ukriteria").val(nama_kriteria);
                $("#Utype").val(type);
                $('#Ubobot').val(bobot);
                $('#formEdit').attr('action', '/kriteria/' + id);
            })
        });
    </script>
@endsection
