<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libra</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f8f9fa; color: #1a1a1a; }

        nav { display: flex; justify-content: space-between; align-items: center; padding: 1rem 2rem; background: #001F5B; border-bottom: 1px solid #001F5B; position: sticky; top: 0; z-index: 10; }
        .nav-brand { font-size: 20px; font-weight: 600; color: #fff; display: flex; align-items: center; gap: 10px; }
        .btn-nav { font-size: 14px; padding: 8px 18px; border-radius: 8px; border: 1px solid #fff; color: #fff; background: none; cursor: pointer; transition: background 0.2s; }
        .btn-nav:hover { background: #ffffff20; }

        .hero { padding: 5rem 2rem; text-align: center; background: linear-gradient(135deg, #1e3a5f 0%, #185FA5 100%); color: #fff; }
        .hero h1 { font-size: 36px; font-weight: 700; margin-bottom: 1rem; }
        .hero p { font-size: 16px; opacity: 0.85; max-width: 500px; margin: 0 auto 2rem; line-height: 1.7; }
        .btn-hero { display: inline-block; padding: 12px 28px; background: #fff; color: #185FA5; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; transition: opacity 0.2s; }
        .btn-hero:hover { opacity: 0.9; }

        .jam-section { padding: 1.5rem 2rem; background: #fff; border-bottom: 1px solid #e5e7eb; }
        .jam-inner { max-width: 640px; margin: 0 auto; background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 12px; padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
        .jam-icon { font-size: 28px; }
        .jam-content { flex: 1; }
        .jam-title { font-size: 13px; color: #6b7280; margin-bottom: 4px; }
        .jam-rows { font-size: 14px; color: #1e3a5f; font-weight: 500; line-height: 1.8; }
        .jam-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 500; padding: 4px 12px; border-radius: 20px; white-space: nowrap; }
        .jam-badge.buka { background: #D1FAE5; color: #065F46; }
        .jam-badge.tutup { background: #FEE2E2; color: #991B1B; }
        .jam-dot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; }
        .jam-dot.buka { background: #10B981; }
        .jam-dot.tutup { background: #EF4444; }

        .section { padding: 3rem 2rem; }
        .section-header { margin-bottom: 1.5rem; }
        .section-header h2 { font-size: 22px; font-weight: 600; color: #1a1a1a; margin-bottom: 4px; }
        .section-header p { font-size: 14px; color: #6b7280; }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px; }
        .stat-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 1.25rem; text-align: center; }
        .stat-emoji { font-size: 28px; margin-bottom: 8px; }
        .stat-num { font-size: 30px; font-weight: 700; color: #185FA5; }
        .stat-label { font-size: 13px; color: #6b7280; margin-top: 4px; }

        .divider { border: none; border-top: 1px solid #e5e7eb; }
        .books-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(155px, 1fr)); gap: 14px; }
        .book-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 1rem; }
        .book-cover { width: 100%; height: 110px; background: #f3f4f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; font-size: 36px; overflow: hidden; }
        .book-cover img { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; }
        .book-badge { display: inline-block; font-size: 11px; padding: 2px 8px; border-radius: 20px; background: #EFF6FF; color: #1D4ED8; margin-bottom: 6px; }
        .book-title { font-size: 13px; font-weight: 600; color: #1a1a1a; margin-bottom: 3px; line-height: 1.4; }
        .book-author { font-size: 12px; color: #9ca3af; }

        .about-section { padding: 3rem 2rem; background: #f8f9fa; border-top: 1px solid #e5e7eb; }
        .about-section h2 { font-size: 22px; font-weight: 600; color: #1a1a1a; margin-bottom: 4px; }
        .about-section .sub { font-size: 14px; color: #6b7280; margin-bottom: 2rem; }
        .about-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; }
        .about-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 1.5rem; }
        .about-card-icon { font-size: 28px; margin-bottom: 12px; }
        .about-card-title { font-size: 15px; font-weight: 600; color: #1e3a5f; margin-bottom: 8px; }
        .about-card-text { font-size: 14px; color: #6b7280; line-height: 1.7; }
        .about-desc { font-size: 15px; color: #374151; line-height: 1.8; margin-bottom: 2rem; }

        .contact-section { padding: 3rem 2rem; background: #1e3a5f; color: #fff; }
        .contact-section h2 { font-size: 22px; font-weight: 600; margin-bottom: 4px; }
        .contact-section .sub { font-size: 14px; color: #93C5FD; margin-bottom: 2rem; }
        .contact-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; }
        .contact-item { display: flex; align-items: flex-start; gap: 12px; }
        .contact-icon { font-size: 22px; margin-top: 2px; flex-shrink: 0; }
        .contact-label { font-size: 12px; color: #93C5FD; margin-bottom: 3px; }
        .contact-val { font-size: 14px; color: #fff; }

        footer { padding: 1.25rem 2rem; text-align: center; font-size: 13px; color: #9ca3af; background: #fff; border-top: 1px solid #e5e7eb; }

        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 100; align-items: center; justify-content: center; }
        .modal-overlay.active { display: flex; }
        .modal { background: #fff; border-radius: 16px; padding: 2rem; width: 100%; max-width: 400px; margin: 1rem; position: relative; }
        .modal-header { text-align: center; margin-bottom: 1.5rem; }
        .modal-logo { width: 48px; height: 48px; background: #EFF6FF; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; }
        .modal-header h2 { font-size: 20px; font-weight: 700; color: #1e3a5f; margin-bottom: 4px; }
        .modal-header p { font-size: 13px; color: #6b7280; }
        .modal-close { position: absolute; top: 1rem; right: 1rem; background: none; border: none; font-size: 20px; cursor: pointer; color: #9ca3af; line-height: 1; }
        .modal-close:hover { color: #1a1a1a; }
        .btn-submit { width: 100%; padding: 11px; background: #185FA5; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; margin-top: 0.5rem; transition: background 0.2s; }
        .btn-submit:hover { background: #1e3a5f; }
    </style>
</head>
<body>

{{-- MODAL LOGIN --}}
<div class="modal-overlay" id="loginModal">
    <div class="modal">
        <button class="modal-close" onclick="closeModal()">✕</button>
        <div class="modal-header">
            <div class="modal-logo">
                <svg width="24" height="24" fill="none" stroke="#185FA5" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <h2>Masuk</h2>
            <p>Klik tombol di bawah untuk melanjutkan ke halaman login</p>
        </div>
        <a href="{{ url('/admin/login') }}" class="btn-submit" style="display:block; text-align:center; text-decoration:none;">Lanjut ke halaman login</a>
        <div style="text-align:center; margin-top: 1rem;">
            <button type="button" onclick="closeModal()" style="background:none; border:none; font-size:13px; color:#6b7280; cursor:pointer; padding: 8px 16px;">Batal</button>
        </div>
    </div>
</div>

<nav>
    <div class="nav-brand">
        <svg width="22" height="22" fill="none" stroke="#ffffff" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        Libra
    </div>
    <button class="btn-nav" onclick="openModal()">Masuk</button>
</nav>

<div class="hero">
    <h1>Selamat datang di Libra</h1>
    <p>Temukan ribuan koleksi buku pilihan. Pinjam, baca, dan perluas wawasanmu bersama kami.</p>
    <a href="#koleksi" class="btn-hero">Lihat koleksi buku</a>
</div>

<div class="jam-section">
    <div class="jam-inner">
        <div class="jam-icon">🕐</div>
        <div class="jam-content">
            <div class="jam-title">Jam operasional</div>
            <div class="jam-rows">
                Senin – Jumat &nbsp;•&nbsp; 09.00 – 21.00 WIB<br>
                Sabtu &nbsp;•&nbsp; 10.00 – 17.00 WIB
            </div>
        </div>
        @php
            $now = \Carbon\Carbon::now('Asia/Jakarta');
            $day = $now->dayOfWeek;
            $hour = $now->hour + $now->minute / 60;
            $isOpen = match(true) {
                $day >= 1 && $day <= 5 => $hour >= 9 && $hour < 21,
                $day === 6             => $hour >= 10 && $hour < 17,
                default                => false,
            };
        @endphp
        <div class="jam-badge {{ $isOpen ? 'buka' : 'tutup' }}">
            <span class="jam-dot {{ $isOpen ? 'buka' : 'tutup' }}"></span>
            {{ $isOpen ? 'Buka' : 'Tutup' }}
        </div>
    </div>
</div>

<div class="section">
    <div class="section-header">
        <h2>Statistik perpustakaan</h2>
        <p>Data terkini dari sistem kami</p>
    </div>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-emoji">📚</div>
            <div class="stat-num">{{ $totalBooks }}</div>
            <div class="stat-label">Total buku</div>
        </div>
        <div class="stat-card">
            <div class="stat-emoji">👥</div>
            <div class="stat-num">{{ $totalMembers }}</div>
            <div class="stat-label">Total anggota</div>
        </div>
        <div class="stat-card">
            <div class="stat-emoji">🏷️</div>
            <div class="stat-num">{{ $totalCategories }}</div>
            <div class="stat-label">Kategori buku</div>
        </div>
        <div class="stat-card">
            <div class="stat-emoji">📋</div>
            <div class="stat-num">{{ $totalLoans }}</div>
            <div class="stat-label">Total peminjaman</div>
        </div>
    </div>
</div>

<hr class="divider">

<div class="section" id="koleksi">
    <div class="section-header">
        <h2>Buku terbaru</h2>
        <p>Koleksi yang baru ditambahkan</p>
    </div>
    <div class="books-grid">
        @forelse($latestBooks as $book)
        <div class="book-card">
            <div class="book-cover">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                @else
                    📖
                @endif
            </div>
            @if($book->category)
                <div class="book-badge">{{ $book->category->name }}</div>
            @endif
            <div class="book-title">{{ $book->title }}</div>
            <div class="book-author">{{ $book->author }}</div>
        </div>
        @empty
        <p style="color: #9ca3af; font-size: 14px;">Belum ada buku.</p>
        @endforelse
    </div>
</div>

<div class="about-section">
    <h2>Tentang Kami</h2>
    <div class="sub">Mengenal Perpustakaan Libra lebih dekat</div>
    <p class="about-desc">
        Perpustakaan Libra adalah perpustakaan umum yang berdiri sejak tahun 2026. Kami hadir untuk melayani masyarakat dengan menyediakan koleksi buku yang beragam, mulai dari ilmu pengetahuan, sastra, teknologi, hingga hiburan. Dengan semangat membangun budaya membaca, Libra terus berkembang menjadi pusat literasi yang inklusif dan modern.
    </p>
    <div class="about-grid">
        <div class="about-card">
            <div class="about-card-icon">🎯</div>
            <div class="about-card-title">Visi</div>
            <div class="about-card-text">Menjadi perpustakaan umum terdepan yang mendorong budaya membaca dan literasi masyarakat demi terwujudnya generasi yang cerdas dan berpengetahuan luas.</div>
        </div>
        <div class="about-card">
            <div class="about-card-icon">📌</div>
            <div class="about-card-title">Misi</div>
            <div class="about-card-text">
                Menyediakan koleksi buku yang lengkap dan beragam untuk semua kalangan.<br><br>
                Memberikan pelayanan peminjaman yang mudah, cepat, dan ramah.<br><br>
                Menciptakan lingkungan belajar yang nyaman dan menyenangkan bagi seluruh masyarakat.
            </div>
        </div>
        <div class="about-card">
            <div class="about-card-icon">📅</div>
            <div class="about-card-title">Sejarah singkat</div>
            <div class="about-card-text">Didirikan pada tahun 2026, Perpustakaan Libra telah melayani ribuan pengunjung setiap tahunnya. Selama pertama kali hadir, kami terus berkomitmen untuk menjadi jembatan antara masyarakat dan ilmu pengetahuan.</div>
        </div>
    </div>
</div>

<div class="contact-section">
    <h2>Kontak kami</h2>
    <div class="sub">Hubungi kami untuk informasi lebih lanjut</div>
    <div class="contact-grid">
        <div class="contact-item">
            <div class="contact-icon">📍</div>
            <div>
                <div class="contact-label">Alamat</div>
                <div class="contact-val">Lenteng Agung, Jakarta</div>
            </div>
        </div>
        <div class="contact-item">
            <div class="contact-icon">📱</div>
            <div>
                <div class="contact-label">WhatsApp</div>
                <div class="contact-val">+62 858-8116-6318</div>
            </div>
        </div>
        <div class="contact-item">
            <div class="contact-icon">✉️</div>
            <div>
                <div class="contact-label">Email</div>
                <div class="contact-val">perpustakaanLibra@email.com</div>
            </div>
        </div>
    </div>
</div>

<footer>
    © {{ date('Y') }} Libra. All rights reserved.
</footer>

<script>
    function openModal() {
        document.getElementById('loginModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeModal() {
        document.getElementById('loginModal').classList.remove('active');
        document.body.style.overflow = '';
    }
    document.getElementById('loginModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });
</script>

</body>
</html>