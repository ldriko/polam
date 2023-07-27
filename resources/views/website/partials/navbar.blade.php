<header id="header" class="header fixed-top">
  <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

    <a href="{{ route('index') }}" class="logo d-flex align-items-center">
      <img src="{{ asset('website/img/logo.png') }}" alt="">
      <span>Polam</span>
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
            <li><a href="{{ route('surat-pengantar.pkl') }}">Praktek Kerja Lapangan</a></li>
            <li><a href="#">Penelitian Skripsi</a></li>
            <li><a href="#">Penelitian Mata Kuliah</a></li>
          </ul>
        </li>
        <li class="dropdown"><a href="#"><span>Surat Keterangan</span> <i class="bi bi-chevron-down"></i></a>
          <ul>
            <li><a href="#">Aktif Kuliah</a></li>
            <li><a href="#">Bebas Sanksi Akademik</a></li>
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
            <li><a href="#">Cuti/Transfer/Undur Diri</a></li>
          </ul>
        </li>
        <li class="dropdown"><a href="#"><span>Yudisium</span> <i class="bi bi-chevron-down"></i></a>
          <ul>
            <li><a href="#">Lembar Pengesahan</a></li>
            <li><a href="#">Registrasi Yudisium</a></li>
            <li><a href="#">Album Yudisium</a></li>
            <li><a href="#">Kuisioner Pelayanan</a></li>
          </ul>
        </li>
        <li><a class="getstarted scrollto" href="{{ route('login') }}">Masuk</a></li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->

  </div>
</header>
