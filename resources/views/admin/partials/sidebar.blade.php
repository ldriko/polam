<ul class="sidebar-menu">
  <li class="menu-header">Dashboard</li>
  <li><a class="nav-link" href="{{ route('admin.index') }}"><i class="far fa-square"></i> <span>Dashboard</span></a></li>

  <li class="menu-header">Pengajuan</li>
  <li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Surat Pengantar</span></a>
    <ul class="dropdown-menu">
      <li><a class="nav-link" href="{{ route('admin.surat-pengantar.pkl.index') }}">Praktek Kerja Lapangan</a></li>
      <li><a class="nav-link" href="{{ route('admin.surat-pengantar.skripsi.index') }}">Penelitian Skripsi</a></li>
      <li><a class="nav-link" href="{{ route('admin.surat-pengantar.penelitian-matkul.index') }}">Penelitian Mata Kuliah</a></li>
    </ul>
  </li>
</ul>
