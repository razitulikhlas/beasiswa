@extends('layouts.container.main')
@section('container')
    <div class="col-12 row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">

                    <div class="card-body">
                        <section class="content">
                            <h2 class="ui header">Perangkingan</h2>
                            <table class="ui celled collapsing table">
                                <thead>
                                    <tr>
                                        <th>Peringkat</th>
                                        <th>Alternatif</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rangking as $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $value->nama }}</td>
                                            <td>{{ $value->nilai }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </section>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
