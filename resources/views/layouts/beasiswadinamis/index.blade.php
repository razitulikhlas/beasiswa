@extends('layouts.container.main')
@section('container')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-heading">
        <h3>Data Beasiswa</h3>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="col col-lg-1 offset-lg-11">
        <a href="/databeasiswa" class="">Back</a>
    </div>
    <div class="col-12 row">
        <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambahkan data mahasiswa</h4>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <form class="form" action="/databeasiswa" method="post">
                            @csrf
                            <div class="row">
                                <input type="text" name="id_beasiswa" value="{{ $id_beasiswa }}" hidden readonly>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="prodi">Nama mahasiswa</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="name" name="id_siswa">
                                                @foreach ($siswa as $item)
                                                    @if (old('id') == $item['id'])
                                                        <option value="{{ $item['id'] }}" selected>
                                                            {{ $item['nama'] }}</option>
                                                    @else
                                                        <option value="{{ $item['id'] }}">{{ $item['nama'] }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>

                                @foreach ($datakey as $item)
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="prodi">{{ $item }}</label>
                                            <input type="text" id="{{ str_replace(' ', '_', $item) }}"
                                                class="form-control @error('prodi') is-invalid @enderror"
                                                placeholder="{{ $item }}"
                                                name="{{ str_replace(' ', '_', $item) }}" required
                                                oninvalid="this.setCustomValidity('data prodi tidak boleh kosong')"
                                                oninput="setCustomValidity('')"
                                                value="{{ old(str_replace(' ', '_', $item)) }}">
                                            @error('prodi')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
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
                    <h4 class="card-title">Table data</h4>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  mb-0" id="example1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        @foreach ($datakey as $value)
                                            <th>{{ $value }}</th>
                                        @endforeach
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- {{ var_dump($datasiswa) }} --}}
                                    @foreach ($datasiswa as $key => $item)
                                        <tr>
                                            <td class="text-bold-500">{{ $loop->iteration }}</td>
                                            <td class="text-bold-500">{{ $item['name'] }}</td>
                                            {{-- {{ var_dump($datakey) }} --}}
                                            @foreach ($datakey as $value)
                                                <td class="text-bold-500">
                                                    {{ $item[$value] }}
                                                </td>
                                            @endforeach
                                            <td>
                                                <button id="edit" type="button" class="btn btn-info rounded-pill"
                                                    data-id="{{ $item['id'] }}" data-id_siswa={{ $item['id_siswa'] }}
                                                    @foreach ($datakey as $value) data-{{ $value }}="{{ $item[$value] }}" @endforeach
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
                            <input type="text" name="id_beasiswa" value="{{ $id_beasiswa }}" hidden readonly>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="prodi">Nama mahasiswa</label>
                                    <fieldset class="form-group">
                                        <select class="form-select" id="uid_siswa" name="uid_siswa">
                                            @foreach ($siswa as $item)
                                                @if (old('id') == $item['id'])
                                                    <option value="{{ $item['id'] }}" selected>
                                                        {{ $item['nama'] }}</option>
                                                @else
                                                    <option value="{{ $item['id'] }}">{{ $item['nama'] }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            @foreach ($datakey as $item)
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="prodi">{{ $item }}</label>
                                        <input type="text" id="u{{ str_replace(' ', '_', $item) }}"
                                            class="form-control @error('prodi') is-invalid @enderror"
                                            placeholder="{{ $item }}" name="u{{ str_replace(' ', '_', $item) }}"
                                            required oninvalid="this.setCustomValidity('data prodi tidak boleh kosong')"
                                            oninput="setCustomValidity('')"
                                            value="{{ old(str_replace(' ', '_', $item)) }}">
                                        @error('prodi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
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
                $('#formDelete').attr('action', '/databeasiswa/' + $(this).data('id-prodi'))
            })

            $(document).on('click', '#edit', function() {
                const id = $(this).data('id');
                const id_siswa = $(this).data('id_siswa');
                $('#uid_siswa').val(id_siswa);
                @foreach ($datakey as $item)
                    const {{ $item }} = $(this).data('{{ $item }}');
                    $("#u{{ $item }}").val({{ $item }});
                @endforeach

                $('#formEdit').attr('action', '/databeasiswa/' + id);
            })
        });
    </script>
@endsection
