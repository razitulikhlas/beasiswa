@extends('layouts.container.main')
@section('container')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-heading">
        <h3>Jenis Beasiswa</h3>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="col-12 row">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambahkan data Beasiswa</h4>
                </div>

                <div class="card-content">

                    <div class="card-body">
<<<<<<< HEAD:resources/views/layouts/beasiswa/index.blade.php
                        <form class="form" action="/beasiswa" method="post" enctype="multipart/form-data">
=======
                        <form class="form" action="/kategoribeasiswa" method="post">
>>>>>>> c3b59ed22541c4298a24374448e036469074ed41:resources/views/layouts/kategorybeasiswa/index.blade.php
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="title">Nama Beasiswa*</label>
                                        <input type="text" id="title" class="form-control" placeholder="Nama Beasiswa"
                                            name="title" required
                                            oninvalid="this.setCustomValidity('data nama beasiswa tidak boleh kosong')"
                                            oninput="setCustomValidity('')" value="{{ old('title') }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="desc">Deskripsi</label>
                                        <textarea class="form-control" name="desc" id="desc" rows="3" spellcheck="false">{{ old('desc') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <img class="img-preview img-fluid mb-3 col-sm-5">
                                        <label for="icon">Upload Icon</label>
                                        <input class="form-control  @error('icon') is-invalid @enderror" type="file"
                                            id="icon" name="icon" onchange="previewImage()">
                                        @error('icon')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                    <h4 class="card-title">Table Beasiswa</h4>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  mb-0" id="example1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Beasiswa</th>
                                        <th>Deskripsi</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item['title'] }}</td>
                                            <td>{{ $item['desc'] }}</td>
                                            <td>
                                                <a href="/kategoribeasiswa/{{ $item['id'] }}" class="btn btn-success rounded-pill">Kriteria</a>
                                                <button id="edit" type="button" data-id={{ $item['id'] }}
                                                    data-title="{{ $item['title'] }}" data-desc={{ $item['desc'] }}
                                                    class="btn btn-info rounded-pill" data-bs-toggle="modal"
                                                    data-bs-target="#update">Edit</button>
                                                <button type="button" class="btn btn-danger rounded-pill"
                                                    data-bs-toggle="modal" data-id-beasiswa={{ $item['id'] }}
                                                    data-bs-target="#exampleModalCenter" id="delete">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{-- @foreach ($data as $item)
                                        <tr>
                                            <td class="text-bold-500">{{ $loop->iteration }}</td>
                                            <td class="text-bold-500">{{ $item['title'] }}</td>
                                            <td class="text-bold-500">{{ $item['desc'] }}</td>
                                            <td>
                                                <button id="edit" type="button" data-id={{ $item['id'] }}
                                                    data-title="{{ $item['title'] }}" data-desc={{ $item['desc'] }}
                                                    class="btn btn-info rounded-pill" data-bs-toggle="modal"
                                                    data-bs-target="#update">Edit</button>
                                                <button type="button" class="btn btn-danger rounded-pill"
                                                    data-bs-toggle="modal" data-id-beasiswa={{ $item['id'] }}
                                                    data-bs-target="#exampleModalCenter" id="delete">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach --}}
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
                    <form action="/kategoribeasiswa" method="post" class="d-inline" id="formDelete">
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
                    <form class="form" action="/kategoribeasiswa" method="post" id="formEdit">
                        @method('put')
                        @csrf
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="title">Nama Beasiswa*</label>
                                    <input type="text" id="Utitle" class="form-control" placeholder="Nama Beasiswa"
                                        name="title" required
                                        oninvalid="this.setCustomValidity('data nama beasiswa tidak boleh kosong')"
                                        oninput="setCustomValidity('')" value="{{ old('title') }}">
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="desc">Deskripsi</label>
                                    <textarea class="form-control" name="desc" id="Udesc" rows="3" spellcheck="false">{{ old('desc') }}</textarea>
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
                $('#formDelete').attr('action', '/kategoribeasiswa/' + $(this).data('id-beasiswa'))
            })

            $(document).on('click', '#edit', function() {
                const id = $(this).data('id');
                const title = $(this).data('title');
                const desc = $(this).data('desc');

                $("#Utitle").val(title);
                $("#Udesc").val(desc);
                $('#formEdit').attr('action', '/kategoribeasiswa/' + id);
            })
        });

        function previewImage() {
            const image = document.querySelector('#icon');
            const previewImage = document.querySelector('.img-preview');

            previewImage.style.display = 'block';

            const offReader = new FileReader();
            offReader.readAsDataURL(image.files[0]);

            offReader.onload = function(oFREvent) {
                previewImage.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
