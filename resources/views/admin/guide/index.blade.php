@extends('admin.layout')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Berkas Panduan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Panduan</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <div class="col">
              <h4>Berkas Panduan</h4>
            </div>
            <div class="col-3 text-right">
              <a class="btn btn-primary btn-icon icon-left note-btn" href="{{ route('admin.guide.create') }}"><i class="fas fa-plus"></i> Tambah</a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-md">
                <tr>
                  <th>#</th>
                  <th>Tipe</th>
                  <th>File</th>
                  <th>Action</th>
                </tr>
                @foreach($guides as $key => $guide)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ ucwords(Str::replace('-', ' ', $guide->type)) }}</td>
                  <td><a href="{{ $guide->fileUrl }}" class="btn btn-info" target="_blank">Buka</a></td>
                  <td>
                    <a href="{{ route('admin.guide.edit', $guide->id) }}" class="btn btn-primary mr-2">Edit</a>
                    <a href="{{ route('admin.guide.destroy', $guide->id) }}" class="btn btn-danger" id="deleteConfirmation">Hapus</a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
          </div>
          <div class="card-footer text-right">
            {{ $guides->onEachSide(1)->links('vendor.pagination.admin') }}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
