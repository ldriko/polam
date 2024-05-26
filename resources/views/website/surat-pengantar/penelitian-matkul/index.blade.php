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

    <div class="d-flex align-items-center gap-2 mb-2">
      <span>Unduh panduan pengajuan Surat Pengantar Penelitian Mata Kuliah</span>
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
                <a href="{{ route('surat-pengantar.penelitian-matkul.preview', $datum->id) }}" target="_blank" class="btn btn-primary">Buka</a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-5">
      <header class="section-header">
        <h2>Surat Pengantar Penelitian Mata Kuliah</h2>
        <p>Form Pengajuan</p>
      </header>
      <form action="{{ route('surat-pengantar.penelitian-matkul.store') }}" method="post" enctype="multipart/form-data">
        @foreach($errors->all() as $message)
          {{ $message }}
        @endforeach
        @csrf
        <div class="row mb-4">
          <h5 class="fw-bold">Mahasiswa 1</h5>
          <div class="col">
            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="name[]" class="form-control" value="{{ Auth::user()->name }}" readonly>
          </div>
          <div class="col">
            <label class="form-label">NPM Mahasiswa <span class="text-danger">*</span></label>
            <input type="text" name="registration_number[]" class="form-control" value="{{ Auth::user()->registration_number }}" readonly>
          </div>
        </div>

        @for($i=2; $i<=5; $i++)
        <div class="row mb-4">
          <h5 class="fw-bold">Mahasiswa {{ $i }}</h5>
          <div class="col">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name[]" class="form-control">
          </div>
          <div class="col">
            <label class="form-label">NPM Mahasiswa</label>
            <input type="text" name="registration_number[]" class="form-control">
          </div>
        </div>
        @endfor

        <div class="row mb-3">
          <h5 class="fw-bold">Informasi Mata Kuliah</h5>
          <div class="col">
            <label class="form-label">Nama Mata Kuliah <span class="text-danger">*</span></label>
            <input type="text" name="subject_name" class="form-control" required>
          </div>
          <div class="col">
            <label class="form-label">Upload Surat Ajuan <span class="text-danger">*</span></label>
            <input type="file" name="application_letter" class="form-control" required>
            <div class="form-text">Upload surat ajuan izin penelitian mata kuliah yang telah diberi TTD oleh dosen pengampu.</div>
            <div class="form-text">Format file berupa PDF, maksimal 2MB.</div>
          </div>
        </div>

        <div class="row mb-3">
          <h5 class="fw-bold">Informasi Penelitian</h5>
          <div class="col">
            <label class="form-label">Keperluan Penelitian <span class="text-danger">*</span></label>
            <input type="text" name="research_purpose" class="form-control" required>
          </div>
          <div class="col">
            <label class="form-label">Judul Penelitian <span class="text-danger">*</span></label>
            <input type="text" name="research_title" class="form-control" required>
          </div>
        </div>

        <div class="row mb-3">
          <h5 class="fw-bold">Informasi Perusahaan</h5>
          <div class="col">
            <label class="form-label">Nama Instansi/Perusahaan <span class="text-danger">*</span></label>
            <input type="text" name="company_name" class="form-control" required>
          </div>
          <div class="col">
            <label class="form-label">Nama Bagian/Divisi <span class="text-danger">*</span></label>
            <input type="text" name="company_division" class="form-control" required>
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
