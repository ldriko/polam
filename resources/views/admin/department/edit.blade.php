@extends('admin.layout')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Edit Prodi</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('admin.department.index') }}">Prodi</a></div>
      <div class="breadcrumb-item">Edit Prodi</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h4>Edit Prodi</h4>
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
            <form action="{{ route('admin.department.update', $department->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Nama Prodi</label>
                    <input type="text" name="name" class="form-control" placeholder="" required value="{{ $department->name }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Singkatan</label>
                    <input type="text" name="short_name" class="form-control" placeholder="" required value="{{ $department->short_name }}">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Link Website</label>
                    <input type="text" name="url" class="form-control" placeholder="" value="{{ $department->url }}">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group position-relative">
                    <label for="inputImage">Logo Prodi</label>
                    <input id="inputImage" type="file" name="image" class="custom-file-input" accept="image/png">
                    <label class="custom-file-label" for="inputImage">Pilih logo prodi (PNG)</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Deskripsi</label>
                    <input type="text" name="description" class="form-control" placeholder="" required value="{{ $department->description }}">
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
