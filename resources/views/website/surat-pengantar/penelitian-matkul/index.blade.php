@extends('website.layout')

@section('content')
<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">
    <ol>
      <li><a href="{{ route('index') }}">Beranda</a></li>
      <li>Surat Pengantar</li>
      <li>Penelitian Mata Kuliah</li>
    </ol>
    <h2>Penelitian Mata Kuliah</h2>
  </div>
</section><!-- End Breadcrumbs -->

<section class="inner-page">
  <div class="container">
    <header class="section-header">
      <h2>Surat Pengantar Penelitian Mata Kuliah</h2>
      <p>Riwayat Pengajuan</p>
    </header>

    @if ($guide && $guide->fileUrl)
      <div class="d-flex align-items-center gap-2 mb-2">
        <span>Unduh panduan pengajuan Surat Pengantar Penelitian Mata Kuliah</span>
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
                <a href="{{ route('surat-pengantar.penelitian-matkul.preview', $datum->id) }}" target="_blank" class="btn btn-primary">Buka</a>
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
        <h2>Surat Pengantar Penelitian Mata Kuliah</h2>
        <p>Form Pengajuan</p>
      </header>
      <form action="{{ route('surat-pengantar.penelitian-matkul.store') }}" method="post" enctype="multipart/form-data">
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

        <div class="row mb-4">
          <h5 class="fw-bold">Mahasiswa 1</h5>
          <div class="col">
            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="name[]" class="form-control @error('name.0') is-invalid @enderror" value="{{ old('name.0', Auth::user()->name) }}" readonly>
            @error('name.0')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">NPM Mahasiswa <span class="text-danger">*</span></label>
            <input type="text" name="registration_number[]" class="form-control @error('registration_number.0') is-invalid @enderror" value="{{ old('registration_number.0', Auth::user()->registration_number) }}" readonly>
            @error('registration_number.0')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        @for($i = 2; $i <= 5; $i++)
        <div class="row mb-4">
          <h5 class="fw-bold">Mahasiswa {{ $i }}</h5>
          <div class="col">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name[]" class="form-control @error('name.' . ($i-1)) is-invalid @enderror" value="{{ old('name.' . ($i-1)) }}">
            @error('name.' . ($i-1))
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">NPM Mahasiswa</label>
            <input type="text" name="registration_number[]" class="form-control @error('registration_number.' . ($i-1)) is-invalid @enderror" value="{{ old('registration_number.' . ($i-1)) }}">
            @error('registration_number.' . ($i-1))
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        @endfor

        <div class="row mb-3">
          <h5 class="fw-bold">Informasi Mata Kuliah</h5>
          <div class="col">
            <label class="form-label">Nama Mata Kuliah <span class="text-danger">*</span></label>
            <input type="text" name="subject_name" class="form-control @error('subject_name') is-invalid @enderror" value="{{ old('subject_name') }}" required>
            @error('subject_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">Upload Surat Ajuan <span class="text-danger">*</span></label>
            <input type="file" name="application_letter" class="form-control @error('application_letter') is-invalid @enderror" accept="application/pdf" required>
            <div class="form-text">Upload surat ajuan izin penelitian mata kuliah yang telah diberi TTD oleh dosen pengampu.</div>
            <div class="form-text">Format file berupa PDF, maksimal 2MB.</div>
            @error('application_letter')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <h5 class="fw-bold">Informasi Penelitian</h5>
          <div class="col">
            <label class="form-label">Keperluan Penelitian <span class="text-danger">*</span></label>
            <input type="text" name="research_purpose" class="form-control @error('research_purpose') is-invalid @enderror" value="{{ old('research_purpose') }}" required>
            @error('research_purpose')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">Judul Penelitian <span class="text-danger">*</span></label>
            <input type="text" name="research_title" class="form-control @error('research_title') is-invalid @enderror" value="{{ old('research_title') }}" required>
            @error('research_title')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <h5 class="fw-bold">Informasi Perusahaan</h5>
          <div class="col">
            <label class="form-label">Nama Instansi/Perusahaan <span class="text-danger">*</span></label>
            <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" required>
            <div class="form-text">Contoh: PT. Daily Planet, CV. Alexander Family, dll.</div>
            @error('company_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">Nama Bagian/Divisi <span class="text-danger">*</span></label>
            <input type="text" name="company_division" class="form-control @error('company_division') is-invalid @enderror" value="{{ old('company_division') }}" required>
            <div class="form-text">Contoh: Bagian Penjualan, Divisi Marketing, Bagian Keuangan, Divisi  Umum, dll.</div>
            @error('company_division')
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