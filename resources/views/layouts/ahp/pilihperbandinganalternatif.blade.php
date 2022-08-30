@extends('layouts.container.main')
@section('container')
    <div class="col-12 row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">

                    <div class="card-body">
                        <h2 class="ui header">Perbandingan Alternatif &rarr; {{ $namaKriteria }}</h2>
                        <form class="ui form" action="/matrikalternatif" method="post">
                            @csrf
                            <table class="ui celled selectable collapsing table">
                                <thead>
                                    <tr>
                                        <th colspan="2">pilih yang lebih penting</th>
                                        <th>nilai perbandingan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $urut = 0;
                                    @endphp
                                    @for ($x = 0; $x <= $n - 2; $x++)
                                        @for ($y = $x + 1; $y <= $n - 1; $y++)
                                            @php
                                                $urut++;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="field">
                                                        <div class="ui radio checkbox">
                                                            <input name="pilih{{ $urut }}" value="1"
                                                                checked="" class="hidden" type="radio">
                                                            <label>{{ $nama[$x] }}</label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="field">
                                                        <div class="ui radio checkbox">
                                                            <input name="pilih{{ $urut }}" value="2"
                                                                class="hidden" type="radio">
                                                            <label>{{ $nama[$y] }}</label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="field">
                                                        <fieldset class="form-group">
                                                            <select class="form-select" id="bobot{{ $urut }}"
                                                                name="bobot{{ $urut }}">
                                                                @for ($q = 1; $q <= 9; $q++)
                                                                    <option value="{{ $q }}">
                                                                        {{ $q }}
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                        </fieldset>
                                                        {{-- <input type="text" name="bobot{{ $urut }}" value=""
                                                            required> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endfor
                                    @endfor
                                    <input type="text" name="n" value="{{ $n }}" hidden>
                                    <input type="text" name="jumlahkriteria" value="{{ $jumlahkriteria }}" hidden>
                                    <input type="text" name="id" value="{{ $id }}" hidden>

                                </tbody>
                            </table>
                            <input type="text" name="jenis" value="{{ $no }}" hidden>
                            <br><br><input class="btn btn-primary" type="submit" name="submit" value="SUBMIT">
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h2 class="ui header">Analitycal Hierarchy Process (AHP)</h2>
                        <p>Analytic Hierarchy Process (AHP) merupakan suatu model pendukung keputusan yang dikembangkan oleh
                            Thomas L. Saaty. Model pendukung keputusan ini akan menguraikan masalah multi faktor atau multi
                            kriteria yang kompleks menjadi suatu hirarki. Hirarki didefinisikan sebagai suatu representasi
                            dari sebuah permasalahan yang kompleks dalam suatu struktur multi level dimana level pertama
                            adalah tujuan, yang diikuti level faktor, kriteria, sub kriteria, dan seterusnya ke bawah hingga
                            level terakhir dari alternatif.</p>
                        <p>AHP membantu para pengambil keputusan untuk memperoleh solusi terbaik dengan mendekomposisi
                            permasalahan kompleks ke dalam bentuk yang lebih sederhana untuk kemudian melakukan sintesis
                            terhadap berbagai faktor yang terlibat dalam permasalahan pengambilan keputusan tersebut. AHP
                            mempertimbangkan aspek kualitatif dan kuantitatif dari suatu keputusan dan mengurangi
                            kompleksitas suatu keputusan dengan membuat perbandingan satu-satu dari berbagai kriteria yang
                            dipilih untuk kemudian mengolah dan memperoleh hasilnya.</p>
                        <p>AHP sering digunakan sebagai metode pemecahan masalah dibanding dengan metode yang lain karena
                            alasan-alasan sebagai berikut :</p>

                        <ol class="ui list">
                            <li>Struktur yang berhirarki, sebagai konsekuesi dari kriteria yang dipilih, sampai pada
                                subkriteria yang paling dalam.</li>
                            <li>Memperhitungkan validitas sampai dengan batas toleransi inkonsistensi berbagai kriteria dan
                                alternatif yang dipilih oleh pengambil keputusan.</li>
                            <li>Memperhitungkan daya tahan output analisis sensitivitas pengambilan keputusan.</li>
                        </ol>
                        <br>
                        <h3 class="ui header">Tabel Tingkat Kepentingan menurut Saaty (1980)</h3>
                        <table class="ui collapsing striped blue table">
                            <thead>
                                <tr>
                                    <th>Nilai Numerik</th>
                                    <th>Tingkat Kepentingan <em>(Preference)</em></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="center aligned">1</td>
                                    <td>Sama pentingnya <em>(Equal Importance)</em></td>
                                </tr>
                                <tr>
                                    <td class="center aligned">2</td>
                                    <td>Sama hingga sedikit lebih penting</td>
                                </tr>
                                <tr>
                                    <td class="center aligned">3</td>
                                    <td>Sedikit lebih penting <em>(Slightly more importance)</em></td>
                                </tr>
                                <tr>
                                    <td class="center aligned">4</td>
                                    <td>Sedikit lebih hingga jelas lebih penting</td>
                                </tr>
                                <tr>
                                    <td class="center aligned">5</td>
                                    <td>Jelas lebih penting <em>(Materially more importance)</em></td>
                                </tr>
                                <tr>
                                    <td class="center aligned">6</td>
                                    <td>Jelas hingga sangat jelas lebih penting</td>
                                </tr>
                                <tr>
                                    <td class="center aligned">7</td>
                                    <td>Sangat jelas lebih penting <em>(Significantly more importance)</em></td>
                                </tr>
                                <tr>
                                    <td class="center aligned">8</td>
                                    <td>Sangat jelas hingga mutlak lebih penting</td>
                                </tr>
                                <tr>
                                    <td class="center aligned">9</td>
                                    <td>Mutlak lebih penting <em>(Absolutely more importance)</em></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>


            </div>

        </div>
    </div>
@endsection
