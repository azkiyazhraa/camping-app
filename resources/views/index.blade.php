<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Camping App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            scroll-behavior: smooth;
        }

        .hero {
            background-image: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.6);
        }

        .section-title {
            margin-bottom: 2rem;
        }

        .card img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Camping App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#barang">Barang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimoni">Testimoni</a></li>
                    <li class="nav-item"><a class="nav-link" href="#form">Form</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>

                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>


    <!-- Hero -->
    <header class="hero text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Sewa Alat Camping</h1>
            <p class="lead">Nikmati petualangan tanpa ribet, semua alat camping kami sediakan!</p>
            <a href="#form" class="btn btn-warning btn-lg mt-3">Pinjam Sekarang</a>
        </div>
    </header>

    <!-- Spacer for fixed navbar -->
    <div class="pt-5 mt-4"></div>

    <!-- About -->
    <section id="about" class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="section-title">Tentang Kami</h2>
            <p>Kami menyediakan berbagai alat camping seperti tenda, matras, kompor portable, dan perlengkapan lainnya
                untuk memenuhi kebutuhan petualangan Anda.</p>
        </div>
    </section>

    <!-- Barang -->
    <section id="barang" class="py-5">
  <div class="container">
    <h2 class="text-center section-title mb-4">Barang Tersedia</h2>
    <div class="row g-3">
      @foreach ($tools as $index => $tool)
        @if($index < 15)
        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
          <div class="card h-100 text-center">
            <img src="{{ asset('storage/' . $tool->image) }}" class="card-img-top" alt="{{ $tool->name }}" style="height: 120px; object-fit: cover;">
            <div class="card-body p-2">
              <h6 class="card-title mb-1" style="font-size: 14px;">{{ $tool->name }}</h6>
              <p class="card-text mb-1" style="font-size: 12px;">{{ Str::limit($tool->description, 50) }}</p>
              <small class="text-muted">Stok: {{ $tool->stock }}</small>

              
            </div>
          </div>
        </div>
        @endif
      @endforeach
    </div>
  </div>
</section>


<!-- Testimoni -->
<section id="testimoni" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center section-title">Testimoni</h2>
        <div class="row justify-content-center">
            @forelse ($testimonis as $testimoni)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 text-center p-3">
                        @if($testimoni->photo)
                            <img src="{{ asset('storage/' . $testimoni->photo) }}" alt="{{ $testimoni->name }}" class="rounded-circle mx-auto d-block mb-3" width="200px" height="200px" style="object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <p class="card-text fst-italic">"{{ $testimoni->message }}"</p>
                            <p class="mb-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $testimoni->rating)
                                        ⭐
                                    @else
                                        ☆
                                    @endif
                                @endfor
                            </p>
                            <h6 class="card-subtitle mt-3 text-muted">- {{ $testimoni->name }}</h6>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Belum ada testimoni tersedia.</p>
            @endforelse
        </div>
    </div>
</section>

    <!-- Harga -->
    

    <!-- Form -->
    <section id="form" class="py-5">
        <div class="container">
            <h2 class="text-center section-title">Form Peminjaman</h2>

            @auth
                <form action="{{ route('borrowers.store') }}" method="POST" class="row g-3">
                    @csrf

                    <div id="barang-wrapper">
                        <div class="row align-items-end barang-item mb-3">
                            <div class="col-md-6">
                                <label for="tool_id" class="form-label">Pilih Barang</label>
                                <select class="form-select" name="tool_id[]" required>
                                    @foreach ($tools as $tool)
                                        <option value="{{ $tool->id }}">{{ $tool->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="qty" class="form-label">Jumlah Pinjam</label>
                                <input type="number" name="qty[]" class="form-control" min="1" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-remove d-none">Hapus</button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="button" id="add-barang" class="btn btn-secondary">+ Tambah Barang</button>
                    </div>

                    <div class="col-md-6">
                        <label for="borrow_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" name="borrow_date" id="borrow_date" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="return_date" class="form-label">Tanggal Kembali</label>
                        <input type="date" name="return_date" id="return_date" class="form-control" required>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-success">Kirim Permintaan</button>
                    </div>
                </form>
            @else
                <div class="alert alert-warning text-center" role="alert">
                    Silakan <a href="{{ route('login') }}" class="alert-link">login terlebih dahulu</a> untuk mengisi
                    form peminjaman.
                </div>
            @endauth
        </div>
    </section>

    <!-- Kontak -->
    <section id="kontak" class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-4">Kontak Kami</h2>
    <div class="row">
      <!-- Maps -->
      <div class="col-md-6 mb-4">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.093548338064!2d106.8244006!3d-6.2481276!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e7cc8dcecf%3A0x2040651a25bb11a5!2sJl.%20Raya%20Lenteng%20Agung%20No.20%2C%20RT.5%2FRW.1%2C%20Lenteng%20Agung%2C%20Jagakarsa%2C%20Kota%20Jakarta%20Selatan%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2012640!5e0!3m2!1sid!2sid!4v1718781946274!5m2!1sid!2sid"
            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
        <p class="mt-2"><strong>Lokasi:</strong> STT Terpadu Nurul Fikri, Jakarta Timur</p>
      </div>

      <!-- Form Kontak -->
      <div class="col-md-6">
        <form action="{{ route('kontak.kirim') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="pesan" class="form-label">Pesan</label>
            <textarea class="form-control" id="pesan" name="pesan" rows="4" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Kirim Pesan</button>
        </form>
      </div>
    </div>
  </div>
</section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p class="mb-0">© Made by | Kelompok Imam Besar</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- for add barang --}}
    <script>
        document.getElementById('add-barang').addEventListener('click', function() {
            const wrapper = document.getElementById('barang-wrapper');
            const item = wrapper.querySelector('.barang-item');

            const clone = item.cloneNode(true);
            clone.querySelectorAll('input, select').forEach(el => el.value = '');
            clone.querySelector('.btn-remove').classList.remove('d-none');

            wrapper.appendChild(clone);
        });

        // Event delegation untuk tombol hapus
        document.getElementById('barang-wrapper').addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-remove')) {
                e.target.closest('.barang-item').remove();
            }
        });
    </script>


    {{-- sweetalert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        @if (session('success') || session('error') || session('warning') || session('info'))

            document.addEventListener('DOMContentLoaded', function() {
                @if (session('success'))
                    swal("Success!", "{{ session('success') }}", "success");
                @elseif (session('error'))
                    swal("Error!", "{{ session('error') }}", "error");
                @elseif (session('warning'))
                    swal("Warning!", "{{ session('warning') }}", "warning");
                @elseif (session('info'))
                    swal("Info", "{{ session('info') }}", "info");
                @endif
            });
        @endif
    </script>
</body>

</html>
