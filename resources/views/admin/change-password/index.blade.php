@extends('admin.layout')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Profil</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Profil</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h4>Pengaturan Profil</h4>
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
            <form action="{{ route('admin.change-password.update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Password Lama</label>
                    <input type="password" name="old_password" class="form-control" placeholder="********" required>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="new_password" class="form-control" placeholder="********" required>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" class="form-control" placeholder="********" required>
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
