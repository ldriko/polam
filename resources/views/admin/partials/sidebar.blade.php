<ul class="sidebar-menu">
  <li class="menu-header">Dashboard</li>
  <li>
    <a class="nav-link" href="{{ route('admin.index') }}"><i class="fas fa-box"></i> <span>Dashboard</span></a>
  </li>
  <li>
    <a class="nav-link" href="{{ route('admin.guide.index') }}"><i class="fas fa-sticky-note"></i> <span>Panduan</span></a>
  </li>

  <li class="menu-header">Pengajuan</li>
  <li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-file-powerpoint"></i> <span>Surat Pengantar</span></a>
    <ul class="dropdown-menu">
      <li><a class="nav-link" href="{{ route('admin.surat-pengantar.pkl.index') }}">Praktek Kerja Lapangan</a></li>
      <li><a class="nav-link" href="{{ route('admin.surat-pengantar.skripsi.index') }}">Penelitian Skripsi</a></li>
      <li><a class="nav-link" href="{{ route('admin.surat-pengantar.penelitian-matkul.index') }}">Penelitian Mata Kuliah</a></li>
    </ul>
  </li>

  <li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-file-signature"></i> <span>Surat Keterangan</span></a>
    <ul class="dropdown-menu">
      <li><a class="nav-link" href="{{ route('admin.surat-keterangan.aktif-kuliah.index') }}">Aktif Kuliah</a></li>
      <li><a class="nav-link" href="{{ route('admin.surat-keterangan.bebas-sanksi-akademik.index') }}">Bebas Sanksi Akademik</a></li>
    </ul>
  </li>

  <li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-award"></i> <span>Surat Rekomendasi</span></a>
    <ul class="dropdown-menu">
      <li><a class="nav-link" href="{{ route('admin.surat-rekomendasi.beasiswa.index') }}">Beasiswa</a></li>
      <li><a class="nav-link" href="{{ route('admin.surat-rekomendasi.mbkm.index') }}">MBKM</a></li>
      <li><a class="nav-link" href="{{ route('admin.surat-rekomendasi.non-mbkm.index') }}">Non-MBKM</a></li>
    </ul>
  </li>

  <li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-file-alt"></i> <span>Surat Lainnya</span></a>
    <ul class="dropdown-menu">
      <li><a class="nav-link" href="{{ route('admin.surat-lainnya.transkrip.index') }}">Transkrip</a></li>
      <li><a class="nav-link" href="{{ route('admin.surat-lainnya.cuti.index') }}">Cuti</a></li>
      <li><a class="nav-link" href="{{ route('admin.surat-lainnya.transfer.index') }}">Transfer</a></li>
      <li><a class="nav-link" href="{{ route('admin.surat-lainnya.pengunduran-diri.index') }}">Pengunduran Diri</a></li>
    </ul>
  </li>

  <li class="menu-header">Pengaturan</li>
  @if(Auth::guard('employee')->user()->position->level == 0)
    <li>
      <a class="nav-link" href="{{ route('admin.account.index') }}"><i class="fas fa-users"></i> <span>Akun Admin</span></a>
    </li>
  @endif
  <li>
    <a class="nav-link" href="{{ route('admin.profile.index') }}"><i class="fas fa-user-cog"></i> <span>Profil</span></a>
  </li>
  <li>
    <a class="nav-link" href="{{ route('admin.change-password.index') }}"><i class="fas fa-user-cog"></i> <span>Ubah Password</span></a>
  </li>
</ul>
