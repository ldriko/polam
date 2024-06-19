@php
  $data = json_decode($submission->data);
@endphp
@extends('admin.layout')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Surat Lainnya</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="javascript:void(0)">Surat Lainnya</a></div>
      <div class="breadcrumb-item">Transkrip</div>
    </div>
  </div>

  <div class="section-body">
    <h2 class="section-title">Transkrip</h2>
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
                  <input type="text" class="form-control" value="{{ $data->name }}" disabled>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>NPM Pemohon</label>
                  <input type="text" class="form-control" value="{{ $data->registration_number }}" disabled>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>Program Studi</label>
                  <input type="text" class="form-control" value="{{ $data->department }}" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>

        <form action="{{ route('admin.surat-lainnya.transkrip.update', $submission->id) }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="card">
            <div class="card-header">
              <h4>Informasi Berkas Transkrip</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Upload Berkas Transkrip</label>
                    <input type="file" class="form-control" name="transkrip_file" {{ Auth::guard('employee')->user()->position->AllowedToVerify ? '':'disabled' }}>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Berkas Transkrip</label>
                    <a href="{{ asset($data->transkrip_file_path ?? '') }}" class="btn btn-lg btn-primary form-control {{ $data->transkrip_file_path ?? null ? '':'disabled' }}" target="_blank">Lihat PDF</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h4>Persetujuan & Catatan</h4>
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

              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Catatan Verifikator</label>
                    <textarea
                      name="{{ Auth::guard('employee')->user()->position->AllowedToVerify ? 'note':'' }}"
                      rows="20"
                      class="form-control"
                      {{ $submission->isAvailableToVerified && Auth::guard('employee')->user()->position->AllowedToVerify && !$submission->rejected_at ? '':'disabled' }}
                    >{{ $submission->verified_note }}</textarea>
                    @if($submission->verified_at)
                      <small id="passwordHelpBlock" class="form-text text-muted">
                        Oleh: {{ $submission->verifiedByEmployee->name }}
                      </small>
                    @endif
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Catatan Approval</label>
                    <textarea
                      name="{{ Auth::guard('employee')->user()->position->AllowedToApprove('transkrip') ? 'note':'' }}"
                      rows="20"
                      class="form-control"
                      {{ $submission->isAvailableToApproved && Auth::guard('employee')->user()->position->AllowedToApprove('transkrip') && !$submission->rejected_at ? '':'disabled' }}
                    >{{ $submission->approved_note }}</textarea>
                    @if($submission->approved_at)
                      <small id="passwordHelpBlock" class="form-text text-muted">
                        Oleh: {{ $submission->approvedByEmployee->name }}
                      </small>
                    @endif
                  </div>
                </div>
              </div>

              @if($submission->rejected_at)
                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label>Alasan Ditolak</label>
                      <textarea
                        rows="20"
                        class="form-control"
                        disabled
                      >{{ $submission->rejected_note }}</textarea>
                      <small id="passwordHelpBlock" class="form-text text-muted">
                        Oleh: {{ $submission->rejectedByEmployee->name }}
                      </small>
                    </div>
                  </div>
                </div>
              @endif

              <div class="row justify-content-end">
                @if($submission->isAvailableToRejected(Auth::guard('employee')->user()->position, 'transkrip'))
                  <div class="col-4 text-right">
                    <button type="submit" name="type" value="rejected" class="btn btn-lg btn-danger form-control">Tolak</button>
                  </div>
                @endif

                @if(!$submission->rejected_at)
                  @if($submission->isAvailableToVerified && Auth::guard('employee')->user()->position->AllowedToVerify)
                    <div class="col-4 text-right">
                      <button type="submit" name="type" value="verified" class="btn btn-lg btn-primary form-control {{ ($submission->verified_at != null) ? 'disabled':'' }}">Verifikasi</button>
                    </div>
                  @endif

                  @if($submission->isAvailableToApproved && Auth::guard('employee')->user()->position->AllowedToApprove('transkrip'))
                    <div class="col-4 text-right">
                      <button type="submit" name="type" value="approved" class="btn btn-lg btn-primary form-control {{ ($submission->approved_at != null) ? 'disabled':'' }}">Setujui</button>
                    </div>
                  @endif
                @endif
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@stop
