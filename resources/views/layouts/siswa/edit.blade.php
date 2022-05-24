@extends('layouts.container.main')
@section('container')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-heading">
        <h3>Masukan Data Mahasiswa</h3>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Update Data</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form" action="/siswa/{{ $data['id'] }}" method="post"
                        enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="nama">Nisn</label>
                                    <input type="text" id="nis" class="form-control" placeholder="nis Lengkap" name="nis"
                                        required oninvalid="this.setCustomValidity('data nama tidak boleh kosong')"
                                        oninput="setCustomValidity('')" value="{{ old('nim', $data['nim']) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap*</label>
                                    <input type="text" id="nama" class="form-control" placeholder="Nama Lengkap"
                                        name="nama" required
                                        oninvalid="this.setCustomValidity('data nama tidak boleh kosong')"
                                        oninput="setCustomValidity('')" value="{{ old('nama', $data['nama']) }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="nama_ayah">Nama Ayah</label>
                                    <input type="text" id="nama_ayah" class="form-control" placeholder="Nama Ayah"
                                        name="nama_ayah" value="{{ old('nama_ayah', $data['nama_ayah']) }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="nama_ibu">Nama Ibu</label>
                                    <input type="text" id="nama_ibu" class="form-control" placeholder="Nama ibu"
                                        name="nama_ibu" value="{{ old('nama_ibu', $data['nama_ibu']) }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir*</label>
                                    <input type="text" id="tempat_lahir" class="form-control" placeholder="Tempat Lahir"
                                        name="tempat_lahir" required
                                        oninvalid="this.setCustomValidity('data tempat lahir tidak boleh kosong')"
                                        oninput="setCustomValidity('')"
                                        value="{{ old('tempat_lahir', $data['tempat_lahir']) }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir*</label>
                                    <input type="date" id="tanggal_lahir" class="form-control" placeholder="Date"
                                        name="tanggal_lahir" required
                                        oninvalid="this.setCustomValidity('data tanggal lahir tidak boleh kosong')"
                                        oninput="setCustomValidity('')"
                                        value="{{ old('tanggal_lahir', $data['tanggal_lahir']) }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin*</label>
                                    <fieldset class="form-group">
                                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                            <option @if (old('jenis_kelamin', $data['jenis_kelamin']) == 'Pria') selected @endif>Pria</option>
                                            <option option @if (old('jenis_kelamin', $data['jenis_kelamin']) == 'Wanita') selected @endif>Wanita</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="id_jurusan">Jurusan*</label>
                                    <fieldset class="form-group">
                                        <select class="form-select" id="id_jurusan" name="id_jurusan">
                                            @foreach ($jurusan as $item)
                                                @if ($data['id_jurusan'] == $item['id'])
                                                    <option selected value="{{ $item['id'] }}">{{ $item['jurusan'] }}
                                                    </option>
                                                @else
                                                    <option value="{{ $item['id'] }}">{{ $item['jurusan'] }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="agama">Agama*</label>
                                    <fieldset class="form-group">
                                        <select class="form-select" id="agama" name="agama">
                                            <option @if (old('agama', $data['agama']) == 'Islam') selected @endif>Islam</option>
                                            <option @if (old('agama', $data['agama']) == 'Kristen') selected @endif>Kristen</option>
                                            <option @if (old('agama', $data['agama']) == 'Protestan') selected @endif>Protestan</option>
                                            <option @if (old('agama', $data['agama']) == 'Hindu') selected @endif>Hindu</option>
                                            <option @if (old('agama', $data['agama']) == 'Budha') selected @endif>Budha</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" id="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Email" name="email" required
                                        oninvalid="this.setCustomValidity('data email tidak boleh kosong')"
                                        oninput="setCustomValidity('')" value="{{ old('email', $data['email']) }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="alamat_asal">Alamat Asal</label>
                                    <textarea class="form-control" id="alamat_asal" name="alamat_asal" rows="3"
                                        spellcheck="false">{{ old('alamat_asal', $data['alamat_asal']) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="alamat_sekarang">Alamat Sekarang</label>
                                    <textarea class="form-control" name="alamat_sekarang" id="alamat_sekarang" rows="3"
                                        spellcheck="false">{{ old('alamat_sekarang', $data['alamat_sekarang']) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="status_tmpt_tinggal">Status Tempat Tinggal</label>
                                    <fieldset class="form-group">
                                        <select class="form-select" id="status_tmpt_tinggal" name="status_tmpt_tinggal">
                                            <option @if (old('status_tmpt_tinggal') == 'Bersama Orang tua') selected @endif>Bersama Orang tua
                                            </option>
                                            <option @if (old('status_tmpt_tinggal', $data['status_tmpt_tinggal']) == 'Kos') selected @endif>Kos</option>
                                            <option @if (old('status_tmpt_tinggal', $data['status_tmpt_tinggal']) == 'Kerabat') selected @endif>Kerabat</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="sumber_biaya_kuliah">Sumber Biaya Sekolah</label>
                                    <fieldset class="form-group">
                                        <select class="form-select" id="sumber_biaya_sekolah"
                                            name="sumber_biaya_sekolah">
                                            <option @if (old('sumber_biaya_sekolah', $data['sumber_biaya_sekolah']) == 'Orang Tua') selected @endif>Orang Tua</option>
                                            <option @if (old('sumber_biaya_sekolah', $data['sumber_biaya_sekolah']) == 'Pribadi') selected @endif>Pribadi</option>
                                            <option @if (old('sumber_biaya_sekolah', $data['sumber_biaya_sekolah']) == 'Kerabat') selected @endif>Kerabat</option>
                                            <option @if (old('sumber_biaya_sekolah', $data['sumber_biaya_sekolah']) == 'Beasiswa') selected @endif>Beasiswa</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="phone">Nomor handphone Orang Tua</label>
                                    <input type="number" id="phone" class="form-control" placeholder="Nomor Handphone"
                                        name="phone" value="{{ old('phone', $data['phone']) }}">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="nomor_kk">Nomor Kartu Keluarga</label>
                                    <input type="number" id="nomor_kk" class="form-control"
                                        placeholder="Nomor Kartu Keluarga" name="nomor_kk"
                                        value="{{ old('nomor_kk', $data['nomor_kk']) }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <img class="img-preview img-fluid mb-3 col-sm-5">
                                    <label for="image">Upload Gambar</label>
                                    <input class="form-control  @error('image') is-invalid @enderror" type="file"
                                        id="image" name="image" onchange="previewImage()">
                                    @error('image')
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
        function previewImage() {
            const image = document.querySelector('#image');
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
