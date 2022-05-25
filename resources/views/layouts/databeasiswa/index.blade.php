@extends('layouts.container.main')
@section('container')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-heading">
        <h3>Daftar Beasiswa</h3>
    </div>

    @if($data != null)
    <div class="page-content">
        <div class="col-12 col-lg-9">
            <div class="row">
                @foreach ($data as $item)
                <div class="col-6 col-lg-3 col-md-6">
                    <a href="/databeasiswa/{{$item->id}}">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">{{ $item->title }}</h6>
                                        <h6 class="font-extrabold mb-0">80</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    
                </div>
    
                @endforeach
            </div>
        </div>
    </div>
    @else
    <div>
        Silahkan isi kategori beasiswa terlebih dahulu
    </div>
    @endif
    
@endsection
