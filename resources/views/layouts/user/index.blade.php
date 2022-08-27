@extends('layouts.container.main')
@section('container')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-heading">
        <h3>Data user admin</h3>
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
                    <h4 class="card-title">Tambahkan data user admin</h4>
                </div>

                <div class="card-content">

                    <div class="card-body">
                        <form class="form" action="/user" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="name">Nama*</label>
                                        <input type="text" id="title"
                                            class="form-control @error('name') is-invalid @enderror" placeholder="Nama"
                                            name="name" required
                                            oninvalid="this.setCustomValidity('data nama tidak boleh kosong')"
                                            oninput="setCustomValidity('')" value="{{ old('name') }}">
                                        @error('tile')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="email">Email*</label>
                                        <input type="text" id="email"
                                            class="form-control @error('email') is-invalid @enderror" placeholder="Nama"
                                            name="email" required
                                            oninvalid="this.setCustomValidity('data email tidak boleh kosong')"
                                            oninput="setCustomValidity('')" value="{{ old('email') }}">
                                        @error('tile')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="password">Password*</label>
                                        <input type="password" id="title"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Password" name="password" required
                                            oninvalid="this.setCustomValidity('data password tidak boleh kosong')"
                                            oninput="setCustomValidity('')" value="{{ old('password') }}">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="confirmpassword">Confirm Password*</label>
                                        <input type="password" id="confirmpassword"
                                            class="form-control @error('confirmpassword') is-invalid @enderror"
                                            placeholder="Confirm password" name="confirmpassword" required
                                            oninvalid="this.setCustomValidity('data confirmpassword tidak boleh kosong')"
                                            oninput="setCustomValidity('')" value="{{ old('confirmpassword') }}">
                                        @error('confirmpassword')
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
        <div class="col-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Table admin</h4>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  mb-0" id="example1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Email</th>
                                        <th>Nama</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-bold-500">{{ $loop->iteration }}</td>
                                            <td class="text-bold-500">{{ $item['name'] }}</td>
                                            <td class="text-bold-500">{{ $item['email'] }}</td>
                                            <td>
                                                <button id="edit" type="button" data-id={{ $item['id'] }}
                                                    data-name="{{ $item['name'] }}" data-email="{{ $item['email'] }}"
                                                    class="btn btn-info rounded-pill" data-bs-toggle="modal"
                                                    data-bs-target="#update">Edit</button>
                                                <button type="button" class="btn btn-danger rounded-pill"
                                                    data-bs-toggle="modal" data-id={{ $item['id'] }}
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
                                    <label for="name">Nama*</label>
                                    <input type="text" id="Uname"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Nama"
                                        name="Uname" required
                                        oninvalid="this.setCustomValidity('data nama tidak boleh kosong')"
                                        oninput="setCustomValidity('')" value="{{ old('name') }}">
                                    @error('tile')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="email">Email*</label>
                                    <input type="text" id="Uemail"
                                        class="form-control @error('email') is-invalid @enderror" placeholder="Nama"
                                        name="email" required
                                        oninvalid="this.setCustomValidity('data email tidak boleh kosong')"
                                        oninput="setCustomValidity('')" value="{{ old('email') }}">
                                    @error('tile')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="password">Password*</label>
                                    <input type="text" id="title"
                                        class="form-control @error('password') is-invalid @enderror" placeholder="Nama"
                                        name="password" required
                                        oninvalid="this.setCustomValidity('data password tidak boleh kosong')"
                                        oninput="setCustomValidity('')" value="{{ old('password') }}">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="confirmpassword">Confirm Password*</label>
                                    <input type="text" id="confirmpassword"
                                        class="form-control @error('confirmpassword') is-invalid @enderror"
                                        placeholder="Nama" name="confirmpassword" required
                                        oninvalid="this.setCustomValidity('data confirmpassword tidak boleh kosong')"
                                        oninput="setCustomValidity('')" value="{{ old('confirmpassword') }}">
                                    @error('confirmpassword')
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

    <script>
        $(function() {
            $(document).on('click', '#delete', function() {
                $('#formDelete').attr('action', '/user/' + $(this).data('id'))
            })
            $(document).on('click', '#edit', function() {
                const id = $(this).data('id');
                const email = $(this).data('email');
                const name = $(this).data('name');


                $("#Uemail").val(email);
                $("#Uname").val(name);
                $('#formEdit').attr('action', '/auth/' + id);
            })
        });
    </script>
@endsection
