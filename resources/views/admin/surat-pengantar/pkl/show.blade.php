@php
  $data = json_decode($submission->data);
@endphp
@extends('admin.layout')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Surat Pengantar</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="javascript:void(0)">Surat Pengantar</a></div>
      <div class="breadcrumb-item">Praktek Kerja Lapangan</div>
    </div>
  </div>

  <div class="section-body">
    <h2 class="section-title">Praktek Kerja Lapangan</h2>
    <p class="section-lead">Detail Pengajuan</p>

    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h4>Informasi Pemohon</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label>Nama Pemohon</label>
                  <input type="text" class="form-control" value="{{ $submission->user->name }}" disabled>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>NPM Pemohon</label>
                  <input type="text" class="form-control" value="{{ $submission->user->registration_number }}" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label>Catatan Lain</label>
                  <textarea rows="20" class="form-control" disabled>{{ $data->note }}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h4>Kelompok PKL</h4>
          </div>
          <div class="card-body">
            @foreach($data->name as $key => $name)
              @if($data->name[$key] && $data->registration_number[$key])
                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label>Nama Pemohon</label>
                      <input type="text" class="form-control" value="{{ $data->name[$key] }}" disabled>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label>NPM Pemohon</label>
                      <input type="text" class="form-control" value="{{ $data->registration_number[$key] }}" disabled>
                    </div>
                  </div>
                </div>
              @endif
            @endforeach
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h4>Informasi Instansi/Perusahaan</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label>Nama Perusahaan/Instansi</label>
                  <input type="text" class="form-control" value="{{ $data->company_name }}" disabled>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>Nama Bagian/Divisi</label>
                  <input type="text" class="form-control" value="{{ $data->company_division }}" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label>Nomor Telfon Perusahaan</label>
                  <input type="text" class="form-control" value="{{ $data->company_phone }}" disabled>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>Tanggal Mulai PKL</label>
                  <input type="text" class="form-control" value="{{ Carbon\Carbon::parse($data->starting_date)->locale('id') }}" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label>Alamat Perusahaan</label>
                  <input type="text" class="form-control" value="{{ $data->company_address }}" disabled>
                </div>
              </div>
            </div>
            <div class="row justify-content-end">
              @if(Auth::guard('employee')->user()->position->AllowedToVerify)
                <div class="col-6 text-right">
                  <a href="{{ route('admin.surat-pengantar.pkl.verify', $submission->id) }}" class="btn btn-lg btn-primary form-control {{ ($submission->verified_at != null) ? 'disabled':'' }}">Verifikasi</a>
                </div>
              @endif

              @if($submission->verified_at && Auth::guard('employee')->user()->position->AllowedToApprove)
                <div class="col-6 text-right">
                  <a href="{{ route('admin.surat-pengantar.pkl.approve', $submission->id) }}" class="btn btn-lg btn-primary form-control {{ ($submission->approved_at != null) ? 'disabled':'' }}">Setujui</a>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
