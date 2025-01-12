@extends('admin.layout')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Tambah Akun Admin</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('admin.account.index') }}">Akun Admin</a></div>
      <div class="breadcrumb-item">Tambah Akun Admin</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h4>Tambah Akun Admin</h4>
          </div>
          <div class="card-body">
            @if($errors->any())
              <div class="row">
                <div class="col">
                  @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                      {{ $error }}
                    </div>
                  @endforeach
                </div>
              </div>
            @endif
            <form action="{{ route('admin.account.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required value="{{ old('name') }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Email Aktif" required value="{{ old('email') }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="selectPosition">Jabatan</label>
                    <select name="employee_position_id" id="selectPosition" class="form-control">
                      <option value="" disabled selected>Pilih Jabatan Pegawai</option>
                      @foreach ($positions as $position)
                        <option value="{{ $position->id }}" {{ $position->id == old('employee_position_id') ? 'selected':'' }}>{{ strtoupper($position->name) }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="selectDepartment">Jurusan</label>
                    <select name="department_id" id="selectDepartment" class="form-control">
                      <option value="" disabled selected>Pilih Jurusan Pegawai</option>
                      @foreach ($departments as $department)
                        <option value="{{ $department->id }}" {{ $department->id == old('department_id') ? 'selected':'' }}>{{ $department->name }} ({{ $department->short_name }})</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Jenis Nomor Induk</label>
                    <input type="text" name="registration_type" class="form-control" placeholder="Contoh: NIP, NRP, dll" required value="{{ old('registration_type') }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Nomor Induk</label>
                    <input type="text" name="registration_number" class="form-control" placeholder="3578*****" required value="{{ old('registration_number') }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Pangkat</label>
                    <input type="text" name="rank" class="form-control" placeholder="Contoh: Penata, Pembina, dll" required value="{{ old('rank') }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Golongan</label>
                    <input type="text" name="class" class="form-control" placeholder="Contoh: III C, IV C, dll" required value="{{ old('class') }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group position-relative">
                    <label for="inputSignature">Tanda Tangan</label>
                    <input id="inputSignature" type="file" name="signature" class="custom-file-input" accept="image/png">
                    <label class="custom-file-label" for="inputSignature">Pilih Tanda Tangan (PNG)</label>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="********" required>
                  </div>
                </div>
              </div>
  
              <div class="row justify-content-end">
                <div class="col-4">
                  <button type="submit" class="btn btn-lg btn-primary form-control">Simpan</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
