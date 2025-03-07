@extends('website.layout')

@section('content')
<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">
    <ol>
      <li><a href="{{ route('index') }}">Beranda</a></li>
      <li>Profil</li>
      <li>Ganti Password</li>
    </ol>
    <h2>Ganti Password Mahasiswa</h2>
  </div>
</section><!-- End Breadcrumbs -->

<section class="inner-page">
  <div class="container">
    <form action="{{ route('profile.change-password.update') }}" method="post">
      @csrf
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="row mb-3">
        <h5 class="fw-bold">Form Ganti Password</h5>
        <div class="col">
          <label class="form-label">Password Lama <span class="text-danger">*</span></label>
          <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" placeholder="********" required>
          @error('old_password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col">
          <label class="form-label">Password Baru <span class="text-danger">*</span></label>
          <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="********" required>
          @error('new_password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col">
          <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
          <input type="password" name="new_password_confirmation" class="form-control @error('new_password_confirmation') is-invalid @enderror" placeholder="********" required>
          @error('new_password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="d-grid d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-primary btn-lg">Simpan</button>
      </div>
    </form>
  </div>
</section>
@stop