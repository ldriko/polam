@extends('admin.layout')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Akun Admin</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Akun Admin</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <div class="col">
              <h4>Akun Admin</h4>
            </div>
            <div class="col-3 text-right">
              <a class="btn btn-primary btn-icon icon-left note-btn" href="{{ route('admin.account.create') }}"><i class="fas fa-plus"></i> Tambah</a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th>#</th>
                  <th>Identitas</th>
                  <th>Jurusan</th>
                  <th>Email</th>
                  <th>Action</th>
                </tr>
                @foreach($accounts as $key => $account)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>
                    {{ $account->name }} ({{ strtoupper($account->position->name) }}) <br>
                    {{ $account->registration_type }} {{ $account->registration_number }}
                  </td>
                  <td>{{ ucwords($account->department->name) }}</td>
                  <td>{{ $account->email }}</td>
                  <td>
                    <a href="{{ route('admin.account.edit', $account->id) }}" class="btn btn-primary mr-2">Edit</a>
                    <a href="{{ route('admin.account.destroy', $account->id) }}" class="btn btn-danger" id="deleteConfirmation">Hapus</a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
          </div>
          <div class="card-footer text-right">
            {{ $accounts->onEachSide(1)->links('vendor.pagination.admin') }}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
