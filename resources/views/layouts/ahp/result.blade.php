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

    <div class="col-12 col-md-12">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Pembobotan kriteria dan alternatif</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                                aria-controls="home" aria-selected="true">Nilai Bobot Kriteria</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                                aria-controls="profile" aria-selected="false" tabindex="-1">Nilai Bobot alternatif</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab"
                                aria-controls="contact" aria-selected="false" tabindex="-1">Contact</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="table-responsive">
                                <table class="table table-striped  mb-0" id="example12">
                                    <thead>
                                        <tr>
                                            <th>Kriteria</th>
                                            @foreach ($kriteria as $value)
                                                <th>{{ $value['nama_kriteria'] }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kriteria as $n => $value)
                                            <tr>
                                                <th>{{ $value['nama_kriteria'] }}</th>
                                                @foreach ($matrik as $x => $v)
                                                    <td class="text-bold-500">{{ $matrik[$n][$x] }}</td>
                                                @endforeach


                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th>Jumlah</th>
                                            @foreach ($jumlahcolum as $value)
                                                <td class="text-bold-500">{{ $value }}</td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <h1>Matriks Nilai Kriteria</h1>
                            <div class="table-responsive">
                                <table class="table table-striped  mb-0" id="example12">
                                    <thead>
                                        <tr>
                                            <th>Kriteria</th>
                                            @foreach ($kriteria as $value)
                                                <th>{{ $value['nama_kriteria'] }}</th>
                                            @endforeach
                                            <th>Jumlah</th>
                                            <th>Rata-Rata</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kriteria as $n => $value)
                                            <tr>
                                                <th>{{ $value['nama_kriteria'] }}</th>
                                                @foreach ($matriksnilaikriteria as $x => $v)
                                                    <td class="text-bold-500">{{ $matriksnilaikriteria[$n][$x] }}</td>
                                                @endforeach
                                                <td class="text-bold-500">{{ $matriksnilaikriteria[$n][$i] }}</td>
                                                <td class="text-bold-500">{{ $matriksnilaikriteria[$n][$i + 1] }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="{{ $i + 2 }}">Principe Eigen Vector (λ maks)</th>
                                            <td>{{ $lamda }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="{{ $i + 2 }}">Consistency Ratio)</th>
                                            <td>{{ $cr }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            Integer interdum diam eleifend metus lacinia, quis
                            gravida eros mollis. Fusce non sapien sit amet magna
                            dapibus ultrices. Morbi tincidunt magna ex, eget
                            faucibus sapien bibendum non. Duis a mauris ex. Ut
                            finibus risus sed massa mattis porta. Aliquam sagittis
                            massa et purus efficitur ultricies. Integer pretium
                            dolor at sapien laoreet ultricies. Fusce congue et lorem
                            id convallis. Nulla volutpat tellus nec molestie
                            finibus. In nec odio tincidunt eros finibus ullamcorper.
                            Ut sodales, dui nec posuere finibus, nisl sem aliquam
                            metus, eu accumsan lacus felis at odio. Sed lacus quam,
                            convallis quis condimentum ut, accumsan congue massa.
                            Pellentesque et quam vel massa pretium ullamcorper vitae
                            eu tortor.
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <p class="mt-2">
                                Duis ultrices purus non eros fermentum hendrerit.
                                Aenean ornare interdum viverra. Sed ut odio velit.
                                Aenean eu diam dictum nibh rhoncus mattis quis ac
                                risus. Vivamus eu congue ipsum. Maecenas id
                                sollicitudin ex. Cras in ex vestibulum, posuere orci
                                at, sollicitudin purus. Morbi mollis elementum enim,
                                in cursus sem placerat ut.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>
@endsection
