@extends('layouts.container.main')
@section('container')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-heading">
        <h3>Result</h3>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="col-12 col-md-12">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Table Alternatif</h4>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped  mb-0" id="example1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NAME</th>
                                        <th>NISN</th>
                                        @foreach ($dataKeys as $item)
                                            <th>{{ $item }}</th>
                                        @endforeach

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($dataAlternatif))
                                        @foreach ($dataAlternatif as $item)
                                            <tr>
                                                <td class="text-bold-500">{{ $loop->iteration }}</td>
                                                <td class="text-bold-500">{{ $item['name'] }}</td>
                                                <td class="text-bold-500">{{ $item['nim'] }}</td>
                                                @foreach ($dataKeys as $value)
                                                    <td class="text-bold-500">{{ $item[$value] }}</td>
                                                @endforeach

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

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Table Normalisasi</h4>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped  mb-0" id="example1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NAME</th>
                                        <th>NISN</th>
                                        @foreach ($dataKeys as $item)
                                            <th>{{ $item }}</th>
                                        @endforeach

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($normalisasi))
                                        @foreach ($normalisasi as $item)
                                            <tr>
                                                <td class="text-bold-500">{{ $loop->iteration }}</td>
                                                <td class="text-bold-500">{{ $item['name'] }}</td>
                                                <td class="text-bold-500">{{ $item['nim'] }}</td>
                                                @foreach ($dataKeys as $value)
                                                    <td class="text-bold-500">{{ $item[$value] }}</td>
                                                @endforeach

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

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Table Hasil Perhitungan</h4>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped  mb-0" id="example1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NAME</th>
                                        <th>NISN</th>
                                        @foreach ($dataKeys as $item)
                                            <th>{{ $item }}</th>
                                        @endforeach
                                        <th>PERHITUNGAN SAW</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($result))
                                        @foreach ($result as $item)
                                            <tr>
                                                <td class="text-bold-500">{{ $loop->iteration }}</td>
                                                <td class="text-bold-500">{{ $item['name'] }}</td>
                                                <td class="text-bold-500">{{ $item['nim'] }}</td>
                                                @foreach ($dataKeys as $value)
                                                    <td class="text-bold-500">{{ $item[$value] }}</td>
                                                @endforeach
                                                <td class="text-bold-500">{{ $item['saw'] }}</td>
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
