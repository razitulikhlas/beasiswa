@extends('layouts.container.main')
@section('container')
    <div class="col-12 row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">

                    <div class="card-body">
                        <form class="ui form" action="/matrikkriteria" method="post">
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
                                                        <input type="text" name="bobot{{ $urut }}" value=""
                                                            required>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endfor
                                    @endfor
                                    <input type="text" name="n" value="{{ $n }}" hidden>
                                    <input type="text" name="id" value="{{ $id }}" hidden>

                                </tbody>
                            </table>
                            <input type="text" name="jenis" value="" hidden>
                            <br><br><input class="btn btn-primary" type="submit" name="submit" value="SUBMIT">
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
