@extends('website.layout')

@section('content')
<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">
    <ol>
      <li><a href="{{ route('index') }}">Beranda</a></li>
      <li>Surat Pengantar</li>
      <li>Praktek Kerja Lapangan</li>
    </ol>
    <h2>Praktek Kerja Lapangan</h2>

  </div>
</section><!-- End Breadcrumbs -->

<section class="inner-page">
  <div class="container">
    <header class="section-header">
      <h2>Surat Pengantar PKL</h2>
      <p>Riwayat Pengajuan</p>
    </header>

    <div class="d-flex align-items-center gap-2 mb-2">
      <span>Unduh panduan pengajuan Surat Pengantar PKL</span>
      <button class="btn btn-warning">Unduh</button>
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
        <tr>
          <td>1.</td>
          <td>Nama Mahasiswa</td>
          <td>20 Juli 2023</td>
          <td>Verifikasi Staff</td>
          <td>
            <button class="btn btn-primary">Buka</button>
          </td>
        </tr>
        <tr>
          <td>2.</td>
          <td>Nama Mahasiswa 2</td>
          <td>22 Juli 2023</td>
          <td>Verifikasi Wadek 1</td>
          <td>
            <button class="btn btn-primary">Buka</button>
          </td>
        </tr>
        <tr>
          <td>3.</td>
          <td>Nama Mahasiswa 3</td>
          <td>22 Juli 2023</td>
          <td>Ditolak Staff</td>
          <td>
            <button class="btn btn-primary">Buka</button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="mt-5">
      <header class="section-header">
        <h2>Surat Pengantar PKL</h2>
        <p>Form Pengajuan</p>
      </header>
      <form action="#" method="post" class="php-email-form">
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Form 1</label>
          <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Form 2</label>
          <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Form 2</label>
          <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
      </form>
    </div>
  </div>
</section>
@stop
