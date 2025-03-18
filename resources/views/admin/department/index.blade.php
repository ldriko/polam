@extends('admin.layout')

@section('styles')
<style>
  .responsive-logo {
    width: 200px;
    height: 200px;
    object-fit: contain;
  }
</style>
@stop

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Data Prodi</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Prodi</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <div class="col">
              <h4>Data Prodi</h4>
            </div>
            <div class="col-3 text-right">
              <a class="btn btn-primary btn-icon icon-left note-btn" href="{{ route('admin.department.create') }}"><i class="fas fa-plus"></i> Tambah</a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th>#</th>
                  <th class="text-center">Informasi</th>
                  <th class="text-center">Logo</th>
                  <th>Action</th>
                </tr>
                @foreach($departments as $key => $department)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td class="py-2">
                    <span class="d-block">Nama: {{ $department->name }}</span>
                    <span class="d-block">Singkatan: {{ $department->short_name }}</span>
                    <span class="d-block">Deskripsi: {{ $department->description }}</span>
                    <span class="d-block">Url: @if($department->url) <a href="{{ $department->url }}" target="_blank">{{ $department->url }}</a> @else - @endif</span>
                  </td>
                  <td class="py-2"><img class="responsive-logo" src="{{ $department->imageUrl }}" alt="logo {{ $department->name }}"></td>
                  <td>
                    <a href="{{ route('admin.department.edit', $department->id) }}" class="btn btn-primary mr-2">Edit</a>
                    <a href="{{ route('admin.department.destroy', $department->id) }}" class="btn btn-danger" id="deleteConfirmation">Hapus</a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
