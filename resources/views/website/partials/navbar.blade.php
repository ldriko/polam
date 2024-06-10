<header id="header" class="header fixed-top">
  <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

    <a href="{{ route('index') }}" class="logo d-flex align-items-center">
      <img src="{{ asset('website/img/logo-upn.png') }}" alt="">
      <span>SIPATCA</span>
    </a>

    <nav id="navbar" class="navbar">
      <ul>
        <li class="dropdown"><a href="#"><span>Perkuliahan</span> <i class="bi bi-chevron-down"></i></a>
          <ul>
            <li><a href="#">Informatika</a></li>
            <li><a href="#">Sistem Informasi</a></li>
            <li><a href="#">Sains Data</a></li>
          </ul>
        </li>
        <li class="dropdown"><a href="#"><span>Surat Pengantar</span> <i class="bi bi-chevron-down"></i></a>
          <ul>
            <li><a href="{{ route('surat-pengantar.pkl.index') }}">Praktek Kerja Lapangan</a></li>
            <li><a href="{{ route('surat-pengantar.skripsi.index') }}">Penelitian Skripsi</a></li>
            <li><a href="{{ route('surat-pengantar.penelitian-matkul.index') }}">Penelitian Mata Kuliah</a></li>
          </ul>
        </li>
        <li class="dropdown"><a href="#"><span>Surat Keterangan</span> <i class="bi bi-chevron-down"></i></a>
          <ul>
            <li><a href="{{ route('surat-keterangan.aktif-kuliah.index') }}">Aktif Kuliah</a></li>
            <li><a href="{{ route('surat-keterangan.bebas-sanksi-akademik.index') }}">Bebas Sanksi Akademik</a></li>
          </ul>
        </li>
        <li class="dropdown"><a href="#"><span>Surat Rekomendasi</span> <i class="bi bi-chevron-down"></i></a>
          <ul>
            <li><a href="#">Beasiswa</a></li>
            <li><a href="#">MBKM</a></li>
            <li><a href="#">Non-MBKM (Umum)</a></li>
          </ul>
        </li>
        <li class="dropdown"><a href="#"><span>Surat Lainnya</span> <i class="bi bi-chevron-down"></i></a>
          <ul>
            <li><a href="#">Berkas Transkrip</a></li>
            <li><a href="{{ route('surat-lainnya.cuti.index') }}">Cuti</a></li>
            <li><a href="{{ route('surat-lainnya.transfer.index') }}">Transfer</a></li>
            <li><a href="#">Undur Diri</a></li>
          </ul>
        </li>
        <li><a href="https://uyus.igsindonesia.org" target="_blank"><span>Yudisium</span></a></li>
        @if(auth()->user())
            <li><a class="getstarted scrollto" href="{{ route('dashboard') }}">Profil</a></li>
        @else
            <li><a class="getstarted scrollto" href="{{ route('login') }}">Masuk</a></li>
        @endif
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->

  </div>
</header>
