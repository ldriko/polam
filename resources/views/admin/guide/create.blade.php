@extends('admin.layout')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Tambah Berkas Panduan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('admin.guide.index') }}">Panduan</a></div>
      <div class="breadcrumb-item">Tambah Panduan</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h4>Tambah Panduan</h4>
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
            <form action="{{ route('admin.guide.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Jenis Panduan</label>
                    <select name="type" class="form-control" required>
                      <option value="" selected disabled>Pilih Jenis Panduan</option>
                      @foreach ($types as $type)
                        <option value="{{ $type }}">{{ ucwords(Str::replace('-', ' ', $type)) }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group position-relative">
                    <label for="inputPdf">File Panduan</label>
                    <input id="inputPdf" type="file" name="guide" class="custom-file-input" accept="application/pdf" required>
                    <label class="custom-file-label" for="inputPdf">Pilih PDF</label>
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
