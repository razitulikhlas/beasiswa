@extends('layouts.container.main')
@section('container')
    <div class="col-12 row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">

                    <div class="card-body">

                        <section class="content">
                            <h3 class="ui header">Matriks Perbandingan Berpasangan</h3>
                            <table class="ui collapsing celled blue table">
                                <thead>
                                    <tr>
                                        <th>Kriteria</th>
                                        @for ($i = 0; $i <= $n - 1; $i++)
                                            <th>{{ $nama[$i] }}</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($x = 0; $x <= $n - 1; $x++)
                                        <tr>
                                            <td>{{ $nama[$x] }}</td>
                                            @for ($y = 0; $y <= $n - 1; $y++)
                                                <td>{{ round($matrik[$x][$y], 5) }}</td>
                                            @endfor

                                        </tr>
                                    @endfor
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Jumlah</th>
                                        @for ($i = 0; $i <= $n - 1; $i++)
                                            <th>{{ round($jmlmpb[$i], 5) }}</th>
                                        @endfor
                                    </tr>
                                </tfoot>
                            </table>


                            <br>

                            <h3 class="ui header">Matriks Nilai Kriteria</h3>
                            <table class="ui celled red table">
                                <thead>
                                    <tr>
                                        <th>Kriteria</th>
                                        @for ($i = 0; $i <= $n - 1; $i++)
                                            <th>{{ $nama[$i] }}</th>
                                        @endfor
                                        <th>Jumlah</th>
                                        <th>Priority Vector</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($x = 0; $x <= $n - 1; $x++)
                                        <tr>
                                            <td>{{ $nama[$x] }}</td>
                                            @for ($y = 0; $y <= $n - 1; $y++)
                                                <td>{{ round($matrikb[$x][$y], 5) }}</td>
                                            @endfor
                                            <td>{{ round($jmlmnk[$x], 5) }}</td>
                                            <td>{{ round($pv[$x], 5) }}</td>
                                        </tr>
                                    @endfor
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="{{ $n + 2 }}">Principe Eigen Vector (λ maks)</th>
                                        <th>{{ round($eigenvektor, 5) }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="{{ $n + 2 }}">Consistency Index</th>
                                        <th>{{ round($consIndex, 5) }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="{{ $n + 2 }}">Consistency Ratio</th>
                                        <th>{{ round($consRatio * 100, 2) }} %</th>
                                    </tr>
                                </tfoot>
                            </table>

                            @if ($consRatio > 0.1)
                                <div class="ui icon red message">
                                    <i class="close icon"></i>
                                    <i class="warning circle icon"></i>
                                    <div class="content">
                                        <div class="header">
                                            Nilai Consistency Ratio melebihi 10% !!!
                                        </div>
                                        <p>Mohon input kembali tabel perbandingan...</p>
                                    </div>
                                </div>

                                <br>

                                <a href='javascript:history.back()'>
                                    <button class="btn btn-danger">
                                        <i class="left arrow icon"></i>
                                        Kembali
                                    </button>
                                </a>
                            @else
                                <br>

                                <form action="alternatif/{{ $no }}" method="POST">
                                    @csrf
                                    <input type="text" name="id" value="{{ $id }}" hidden>
                                    <input type="text" name="jumlahkriteria" value="{{ $jumlahkriteria }}" hidden>
                                    <button type="submit" class="btn btn-primary" style="float: right;">
                                        <i class="right arrow icon"></i>
                                        Lanjut
                                    </button>
                                </form>
                            @endif


                        </section>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
