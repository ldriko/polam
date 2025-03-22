@extends('website.layout')

@section('content')
<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">
    <ol>
      <li><a href="{{ route('index') }}">Beranda</a></li>
      <li>Surat Rekomendasi</li>
      <li>Non-MBKM (Umum)</li>
    </ol>
    <h2>Surat Rekomendasi Non-MBKM (Umum)</h2>
  </div>
</section><!-- End Breadcrumbs -->

<section class="inner-page">
  <div class="container">
    <header class="section-header">
      <h2>Surat Rekomendasi Non-MBKM (Umum)</h2>
      <p>Riwayat Pengajuan</p>
    </header>

    @if ($guide && $guide->fileUrl)
      <div class="d-flex align-items-center gap-2 mb-2">
        <span>Unduh panduan pengajuan Surat Rekomendasi Non-MBKM (Umum)</span>
        <a href="{{ $guide->fileUrl }}" target="_blank" class="btn btn-secondary">Unduh</a>
      </div>
    @endif

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
                <a href="{{ route('surat-rekomendasi.non-mbkm.preview', $datum->id) }}" target="_blank" class="btn btn-primary">Buka</a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="blog pt-1">
      {{ $data->onEachSide(1)->links('vendor.pagination.website') }}
    </div>

    <div class="mt-5">
      <header class="section-header">
        <h2>Surat Rekomendasi Non-MBKM (Umum)</h2>
        <p>Form Pengajuan</p>
      </header>
      <form action="{{ route('surat-rekomendasi.non-mbkm.store') }}" method="post">
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
          <h5 class="fw-bold">Informasi Mahasiswa</h5>
          <div class="col">
            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ Auth::user()->name }}" readonly>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">NPM Mahasiswa <span class="text-danger">*</span></label>
            <input type="text" name="registration_number" class="form-control @error('registration_number') is-invalid @enderror" value="{{ Auth::user()->registration_number }}" readonly>
            @error('registration_number')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="row mb-4">
          <div class="col">
            <label class="form-label">Program Studi <span class="text-danger">*</span></label>
            <input type="text" name="department" class="form-control @error('department') is-invalid @enderror" value="{{ Auth::user()->department->name }}" readonly>
            @error('department')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">Semester <span class="text-danger">*</span></label>
            <select name="semester" class="form-control @error('semester') is-invalid @enderror" required>
              <option value="" disabled selected>Pilih Semester</option>
              @for ($i = 1; $i <= 14; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>
            @error('semester')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">IPK <span class="text-danger">*</span></label>
            <input type="text" name="ipk" class="form-control @error('ipk') is-invalid @enderror" required>
            @error('ipk')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-4">
          <h5 class="fw-bold">Informasi Program</h5>
          <div class="col">
            <label class="form-label">Nama Program <span class="text-danger">*</span></label>
            <input type="text" name="program_name" class="form-control @error('program_name') is-invalid @enderror" required>
            @error('program_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">Penyelenggara <span class="text-danger">*</span></label>
            <input type="text" name="program_organizer" class="form-control @error('program_organizer') is-invalid @enderror" required>
            @error('program_organizer')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-2">
            <label class="form-label">Tahun <span class="text-danger">*</span></label>
            <input type="number" name="year" class="form-control @error('year') is-invalid @enderror" required>
            @error('year')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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