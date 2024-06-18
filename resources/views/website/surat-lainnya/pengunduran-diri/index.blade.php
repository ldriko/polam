@extends('website.layout')

@section('content')
<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">
    <ol>
      <li><a href="{{ route('index') }}">Beranda</a></li>
      <li>Surat Lainnya</li>
      <li>Pengunduran Diri</li>
    </ol>
    <h2>Pengunduran Diri</h2>

  </div>
</section><!-- End Breadcrumbs -->

<section class="inner-page">
  <div class="container">
    <header class="section-header">
      <h2>Surat Lainnya Pengunduran Diri</h2>
      <p>Riwayat Pengajuan</p>
    </header>

    <div class="d-flex align-items-center gap-2 mb-2">
      <span>Unduh panduan pengajuan Pengunduran Diri</span>
      <button class="btn btn-secondary">Unduh</button>
    </div>

    <table class="table table-striped">
      <thead class="table-dark text-center">
        <tr>
          <th>No.</th>
          <th>Nama</th>
          <th>Tanggal Pengajuan</th>
          <th>Status Pengajuan</th>
          <th>Periksa Dokumen</th>
        </tr>
      </thead>
      <tbody class="text-center align-middle">
        @foreach ($data as $key => $datum)
        <tr>
          <td>{{ $key+1 }}.</td>
          <td>{{ $datum->user->name }}</td>
          <td>{{ $datum->formattedCreatedAt }}</td>
          <td>
            <div class="badge badge-{{ $datum->StatusBadge }}">
              {{ $datum->status }}
            </div>
          </td>
          <td>
            @if($datum->approved_at)
                <a href="{{ route('surat-lainnya.pengunduran-diri.preview', $datum->id) }}" target="_blank" class="btn btn-primary">Buka</a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-5">
      <header class="section-header">
        <h2>Surat Lainnya Pengunduran Diri</h2>
        <p>Form Pengajuan</p>
      </header>
      <form action="{{ route('surat-lainnya.pengunduran-diri.store') }}" method="post">
        @foreach($errors->all() as $message)
          {{ $message }}
        @endforeach
        @csrf
        <div class="row mb-3">
          <h5 class="fw-bold">Informasi Mahasiswa</h5>
          <div class="col">
            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" readonly>
          </div>
          <div class="col">
            <label class="form-label">NPM Mahasiswa <span class="text-danger">*</span></label>
            <input type="text" name="registration_number" class="form-control" value="{{ Auth::user()->registration_number }}" readonly>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col">
            <label class="form-label">Program Studi <span class="text-danger">*</span></label>
            <input type="text" name="department" class="form-control" value="{{ Auth::user()->department->name }}" readonly>
          </div>
          <div class="col">
            <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
            <select name="academic_year" class="form-control" required>
                <option value="">Pilih Tahun Ajaran...</option>
                @php
                    $now = Carbon\Carbon::now()->subYear(1);
                @endphp
                @for ($i = 0; $i < 5; $i++)
                    <option value="{{ $now->year + $i . "/" . $now->year + $i + 1}}">{{ $now->year + $i . "/" . $now->year + $i + 1}}</option>
                @endfor
            </select>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col">
            <label class="form-label">Nama Orang Tua <span class="text-danger">*</span></label>
            <input type="text" name="parent_name" class="form-control" required>
            <div class="form-text">Orang tua yang akan bertanda tangan.</div>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col">
            <label class="form-label">Alasan Pengunduran Diri <span class="text-danger">*</span></label>
            <input type="text" name="excuse" class="form-control" required>
          </div>
        </div>

        <div class="d-grid d-md-flex justify-content-md-end">
          <button type="submit" class="btn btn-primary btn-lg">Ajukan</button>
        </div>

      </form>
    </div>
  </div>
</section>
@stop
