<?php
require_once __DIR__ . '/koneksi.php';

$keyword = trim($_GET['q'] ?? '');
if ($keyword !== '') {
    $pola = '%' . $keyword . '%';
    $stmt = mysqli_prepare($koneksi, 'SELECT * FROM produk WHERE nama_produk LIKE ? OR deskripsi LIKE ?');
    mysqli_stmt_bind_param($stmt, 'ss', $pola, $pola);
    mysqli_stmt_execute($stmt);
    $produkResult = mysqli_stmt_get_result($stmt);
} else {
    $produkResult = mysqli_query($koneksi, 'SELECT * FROM produk');
}

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?><!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#091b10">
  <title>AgriLokal Nusantara — Pangan Fungsional dari Petani</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root{--forest:#091b10;--forest-2:#0c2115;--card:#122a1b;--card-soft:#0e2418;--lime:#c5f015;--lime-2:#a9df09;--mint:#40d9aa;--text:#f4f7f2;--muted:#a2b5a8;--line:rgba(197,240,21,.16)}
    *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;background:var(--forest);color:var(--text);font-family:'DM Sans',sans-serif;overflow-x:hidden}body:before{content:"";position:fixed;inset:0;pointer-events:none;opacity:.28;background-image:radial-gradient(rgba(147,211,112,.18) .8px,transparent .8px);background-size:27px 27px;mask-image:linear-gradient(to bottom,black,transparent 82%)}a{color:inherit;text-decoration:none}.site-shell{position:relative;z-index:1}.container-wide{width:min(1240px,calc(100% - 48px));margin:auto}
    .site-header{padding:22px 0}.nav-wrap{min-height:72px;display:flex;align-items:center;justify-content:space-between;gap:24px}.brand{display:inline-flex;align-items:center;gap:10px;font-family:Manrope,sans-serif;font-weight:800;font-size:21px;letter-spacing:-.8px;white-space:nowrap}.brand-mark{width:39px;height:39px;border-radius:13px;background:var(--lime);color:#12210d;display:grid;place-items:center;font-size:21px;box-shadow:0 7px 24px #c5f02d30}.brand small{display:block;font:600 9px 'DM Sans',sans-serif;letter-spacing:1.25px;color:#91b633;margin-top:-2px}.nav-links{display:flex;align-items:center;gap:7px;padding:8px;border:1px solid rgba(255,255,255,.09);border-radius:999px;background:rgba(7,23,14,.82);box-shadow:0 10px 35px #0002}.nav-links a{padding:12px 17px;color:#c0cec4;font-weight:600;font-size:14px;border-radius:999px;transition:.2s}.nav-links a:hover{background:#ffffff0b;color:white}.nav-actions{display:flex;align-items:center;gap:12px}.icon-btn{width:46px;height:46px;border-radius:50%;display:grid;place-items:center;border:1px solid rgba(64,217,170,.25);color:var(--mint);background:#0b2418;font-size:18px}.btn-lime{display:inline-flex;align-items:center;justify-content:center;gap:10px;background:var(--lime);color:#10190b;border:0;border-radius:999px;padding:14px 24px;font-weight:800;transition:transform .2s,box-shadow .2s}.btn-lime:hover{background:#d4ff20;color:#10190b;transform:translateY(-2px);box-shadow:0 12px 28px #c5f02d26}.btn-quiet{display:inline-flex;align-items:center;justify-content:center;padding:13px 19px;border:1px solid rgba(255,255,255,.1);border-radius:999px;color:#e4ece6;font-weight:700;background:#ffffff05}.mobile-menu{display:none}
    .hero{padding:72px 0 64px;position:relative}.hero:after{content:"";position:absolute;right:4%;top:3%;width:420px;height:420px;border-radius:50%;background:#2d671b30;filter:blur(95px);z-index:-1}.hero-grid{display:grid;grid-template-columns:1.02fr .98fr;align-items:center;gap:54px}.eyebrow{display:inline-flex;align-items:center;gap:9px;border:1px solid #8ab92070;border-radius:999px;background:#263b122e;color:#c4ee48;padding:8px 14px;font-size:12px;font-weight:800;letter-spacing:.2px}.eyebrow-dot{width:7px;height:7px;border-radius:50%;background:var(--lime);box-shadow:0 0 12px var(--lime)}h1,h2,h3{font-family:Manrope,sans-serif;letter-spacing:-1.4px}h1{font-size:clamp(46px,5.5vw,72px);line-height:1.07;font-weight:800;margin:22px 0}.gradient-text{background:linear-gradient(95deg,#53e0ad 0%,#c5f015 75%);-webkit-background-clip:text;background-clip:text;color:transparent}.hero-copy{max-width:570px;color:#b4c5b9;font-size:17px;line-height:1.8}.hero-actions{display:flex;align-items:center;gap:13px;margin-top:30px}.hero-note{margin-top:28px;display:flex;align-items:center;gap:12px;color:#91a99a;font-size:13px}.avatar-stack{display:flex}.avatar-stack span{width:28px;height:28px;display:grid;place-items:center;border:2px solid var(--forest);border-radius:50%;background:#254630;margin-left:-7px;font-size:12px}.avatar-stack span:first-child{margin-left:0}.hero-visual{position:relative;min-height:450px}.hero-photo{position:absolute;inset:8px 16px 18px 28px;border-radius:30px;overflow:hidden;border:1px solid #d7ff6c38;background:linear-gradient(180deg,#11271a00 48%,#06170ecc 100%),url('https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1100&q=85') center/cover;box-shadow:0 30px 80px #0006}.hero-photo:before{content:"";position:absolute;inset:0;background:linear-gradient(135deg,#c5f01510,transparent 52%)}.photo-caption{position:absolute;left:28px;right:28px;bottom:26px;display:flex;justify-content:space-between;align-items:end}.photo-caption strong{font:800 21px Manrope,sans-serif}.photo-caption span{display:block;color:#ccd9cf;font-size:13px;margin-top:4px}.float-card{position:absolute;z-index:2;border:1px solid #bfff5742;border-radius:18px;background:rgba(12,35,22,.94);backdrop-filter:blur(12px);box-shadow:0 18px 42px #0005;padding:16px 18px}.float-card.top{top:0;right:-6px}.float-card.bottom{bottom:0;left:0}.float-label{color:#94ab9a;font-size:11px}.float-value{font:800 18px Manrope,sans-serif;margin-top:4px}.float-icon{display:inline-grid;place-items:center;width:32px;height:32px;border-radius:10px;background:#c5f01520;color:var(--lime);margin-right:8px}
    .section{padding:65px 0}.section-heading{display:flex;align-items:end;justify-content:space-between;gap:20px;margin-bottom:28px}.section-kicker{color:var(--mint);font-weight:700;font-size:13px;margin-bottom:10px}.section-heading h2{font-weight:800;font-size:clamp(29px,3.4vw,42px);margin:0}.section-heading p{color:var(--muted);margin:10px 0 0}.text-link{color:var(--lime);font-weight:700;white-space:nowrap}.search-panel{padding:16px;border:1px solid rgba(64,217,170,.22);border-radius:22px;background:linear-gradient(110deg,#0c2418,#0b2015);box-shadow:0 18px 50px #0002;margin-bottom:32px}.search-row{display:flex;gap:12px}.search-box{flex:1;display:flex;align-items:center;gap:12px;border:1px solid rgba(64,217,170,.28);border-radius:14px;padding:0 16px;background:#07190f;min-width:0}.search-box .search-icon{color:#58cba3;font-size:19px}.search-box input{width:100%;height:52px;background:transparent;border:0;outline:0;color:white;font:500 15px 'DM Sans',sans-serif}.search-box input::placeholder{color:#738c7d}.btn-reset{border:1px solid #ffffff1b;background:#ffffff08;color:#d8e3dc;border-radius:14px;padding:0 20px;font-weight:700}.btn-search{border-radius:14px;padding:0 25px}
    .product-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px}.product-card{overflow:hidden;border:1px solid rgba(255,255,255,.07);border-radius:22px;background:var(--card);transition:transform .25s,border-color .25s,box-shadow .25s}.product-card:hover{transform:translateY(-5px);border-color:#c5f05566;box-shadow:0 20px 45px #0003}.product-image{height:220px;position:relative;background:#203b27;overflow:hidden}.product-image img{width:100%;height:100%;object-fit:cover;transition:transform .5s}.product-card:hover .product-image img{transform:scale(1.04)}.product-tag{position:absolute;top:15px;left:15px;border:1px solid #ffffff30;background:#07180fd9;color:#e9f4eb;padding:7px 11px;border-radius:999px;font-size:10px;font-weight:800;letter-spacing:.5px}.product-content{padding:19px 20px 18px}.product-name{font:800 18px Manrope,sans-serif;margin:0 0 8px}.product-description{min-height:43px;color:#9fb2a4;font-size:13px;line-height:1.65;margin:0}.product-bottom{display:flex;align-items:end;justify-content:space-between;gap:12px;margin-top:20px;padding-top:16px;border-top:1px solid #ffffff0c}.price{color:var(--lime);font:800 21px Manrope,sans-serif}.price small{font:500 12px 'DM Sans',sans-serif;color:#9fb2a4}.stock{color:#c6d3ca;font-size:12px;margin-top:7px}.stock b{color:#edf4ef}.product-actions{display:flex;align-items:center;gap:8px}.btn-detail{display:inline-flex;padding:9px 13px;border-radius:999px;border:1px solid #ffffff20;color:#dbe7df;font-size:12px;font-weight:700}.btn-cart{display:inline-flex;padding:10px 14px;border-radius:999px;background:var(--lime);color:#111a0c;font-size:12px;font-weight:800}.empty-note{grid-column:1/-1;padding:50px;text-align:center;color:var(--muted);border:1px dashed #ffffff24;border-radius:20px}
    .story-band{padding:0 0 72px}.story-card{display:grid;grid-template-columns:1.2fr .8fr;gap:28px;align-items:center;padding:34px 38px;border:1px solid #9ed82b38;border-radius:26px;background:radial-gradient(ellipse at 90% 10%,#1e4b263b,transparent 40%),linear-gradient(120deg,#102b1b,#081b11)}.story-card h2{font-size:32px;font-weight:800;margin:12px 0}.story-card p{color:#aabdaf;line-height:1.75;margin:0}.story-points{display:grid;grid-template-columns:1fr 1fr;gap:12px}.story-point{padding:16px;border-radius:16px;background:#ffffff08;border:1px solid #ffffff0b}.story-point strong{display:block;color:var(--lime);font:800 17px Manrope,sans-serif}.story-point span{display:block;margin-top:5px;color:#aabdaf;font-size:12px}
    footer{padding:20px 0 0}.footer-main{display:grid;grid-template-columns:1.25fr .8fr 1fr;gap:50px;padding:38px;border:1px solid #ffffff0d;border-radius:24px;background:#0c2117}.footer-brand-copy{max-width:360px;color:#94aa9c;font-size:14px;line-height:1.8;margin:18px 0}.footer-title{font:800 14px Manrope,sans-serif;margin:4px 0 19px}.footer-links{display:grid;grid-template-columns:1fr 1fr;gap:13px;color:#9eb2a3;font-size:14px}.footer-links a:hover,.footer-contact a:hover{color:var(--lime)}.footer-contact{display:grid;gap:14px;color:#9eb2a3;font-size:14px;line-height:1.65}.contact-row{display:flex;gap:12px}.contact-icon{color:var(--mint);width:30px;height:30px;flex:0 0 30px;display:grid;place-items:center;background:#00b68917;border-radius:9px}.footer-bottom{display:flex;justify-content:space-between;gap:20px;padding:20px 0 28px;color:#81988a;font-size:12px}.socials{display:flex;gap:9px}.socials a{width:30px;height:30px;display:grid;place-items:center;border:1px solid #ffffff1a;border-radius:50%;color:#b8c8bc}
    @media(max-width:1000px){.nav-links{gap:0}.nav-links a{padding:11px 12px;font-size:13px}.hero-grid{gap:25px}.hero-visual{min-height:390px}.product-grid{grid-template-columns:repeat(2,1fr)}.footer-main{gap:28px;padding:30px}}
    @media(max-width:760px){.container-wide{width:min(100% - 32px,560px)}.site-header{padding:14px 0}.nav-wrap{min-height:56px}.nav-links,.nav-actions .icon-btn{display:none}.mobile-menu{display:grid;width:42px;height:42px;place-items:center;border:1px solid #ffffff1a;border-radius:50%;color:var(--lime);background:#102619}.nav-actions{margin-left:auto}.nav-actions .btn-lime{padding:11px 17px;font-size:13px}.hero{padding:48px 0 40px}.hero-grid{grid-template-columns:1fr;gap:32px}.hero-copy{font-size:15px}.hero-visual{min-height:390px}.hero-photo{inset:8px 7px 14px 16px}.float-card.top{right:0}.section{padding:45px 0}.section-heading{align-items:start;flex-direction:column}.search-row{flex-wrap:wrap}.search-box{flex-basis:100%}.btn-search,.btn-reset{height:48px;flex:1}.product-grid{gap:14px}.product-image{height:175px}.product-content{padding:16px}.product-name{font-size:16px}.product-description{font-size:12px}.product-bottom{align-items:start;flex-direction:column}.product-actions{width:100%}.product-actions>*{flex:1;justify-content:center}.story-card{grid-template-columns:1fr;padding:25px}.story-card h2{font-size:27px}.footer-main{grid-template-columns:1fr;gap:28px;padding:25px}.footer-bottom{flex-direction:column}.hero-note{font-size:12px}}
    @media(max-width:430px){h1{font-size:43px}.product-grid{grid-template-columns:1fr}.product-image{height:220px}.hero-visual{min-height:340px}.float-card{padding:12px 14px}.float-value{font-size:15px}.story-points{gap:8px}.story-point{padding:13px}}
  </style>
</head>
<body>
<div class="site-shell">
  <header class="site-header">
    <div class="container-wide nav-wrap">
      <a class="brand" href="index.php" aria-label="AgriLokal Nusantara, Beranda"><span class="brand-mark">✳</span><span>AgriLokal<small>NUSANTARA • PANGAN LOKAL</small></span></a>
      <nav class="nav-links" aria-label="Navigasi utama">
        <a href="index.php">Beranda</a><a href="#katalog">Katalog Produk</a><a href="#tentang">Tentang Kami</a>
      </nav>
      <div class="nav-actions"><a class="icon-btn" href="#katalog" aria-label="Cari produk">⌕</a><a class="btn-lime" href="login.php">Login Admin <span aria-hidden="true">↗</span></a><button class="mobile-menu" type="button" aria-label="Buka menu">☰</button></div>
    </div>
  </header>
  <main>
    <section class="hero">
      <div class="container-wide hero-grid">
        <div>
          <span class="eyebrow"><span class="eyebrow-dot"></span> HASIL TANI LOKAL • KUALITAS PILIHAN</span>
          <h1>Pangan Fungsional <span class="gradient-text">Kualitas Terbaik</span></h1>
          <p class="hero-copy">Menghubungkan hasil terbaik kelompok tani dan UMKM pangan lokal langsung dengan keluarga Indonesia. Temukan mocaf, hanjeli, dan produk pangan pilihan yang dibuat dengan kepedulian dari hulu hingga meja Anda.</p>
          <div class="hero-actions"><a class="btn-lime" href="#katalog">Jelajahi Katalog <span>↗</span></a><a class="btn-quiet" href="#tentang">Kenali AgriLokal</a></div>
          <div class="hero-note"><div class="avatar-stack"><span>🌾</span><span>🥬</span><span>🌱</span></div><span>Mendukung petani dan UMKM pangan lokal Indonesia</span></div>
        </div>
        <div class="hero-visual" aria-label="Ilustrasi hasil panen segar">
          <div class="hero-photo"><div class="photo-caption"><div><strong>Dari alam, untuk kehidupan.</strong><span>Produk lokal pilihan, penuh kebaikan.</span></div><span>✦ Panen lokal</span></div></div>
          <div class="float-card top"><span class="float-icon">✦</span><span class="float-label">Pilihan pangan lokal</span><div class="float-value">Tumbuh bersama 🌱</div></div>
          <div class="float-card bottom"><span class="float-label">Dampak nyata</span><div class="float-value">Petani • UMKM • Konsumen</div></div>
        </div>
      </div>
    </section>
    <section class="section" id="katalog">
      <div class="container-wide">
        <div class="section-heading"><div><div class="section-kicker">KATALOG PRODUK</div><h2>Kebaikan lokal, siap dinikmati.</h2><p>Jelajahi komoditas unggulan dari mitra tani dan UMKM.</p></div><a class="text-link" href="#produk">Lihat pilihan produk <span>↗</span></a></div>
        <form class="search-panel" action="index.php#katalog" method="get" role="search"><div class="search-row"><label class="search-box"><span class="search-icon" aria-hidden="true">⌕</span><input type="search" name="q" value="<?= e($keyword) ?>" placeholder="Cari produk, misalnya mocaf atau hanjeli..." aria-label="Cari produk"></label><button class="btn-lime btn-search" type="submit">Cari Produk <span>↗</span></button><a class="btn-reset" href="index.php#katalog">Reset</a></div></form>
        <div class="product-grid" id="produk">
          <?php if ($produkResult && mysqli_num_rows($produkResult) > 0): ?>
            <?php while ($produk = mysqli_fetch_assoc($produkResult)): ?>
              <?php
                $fotoProduk = trim((string) ($produk['foto'] ?? ''));
                $urlFoto = $fotoProduk !== '' ? 'assets/images/' . $fotoProduk : 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=800&q=80';
              ?>
              <article class="product-card">
                <div class="product-image">
                  <img src="<?= e($urlFoto) ?>" alt="Foto <?= e($produk['nama_produk']) ?>" loading="lazy">
                  <span class="product-tag">HASIL TANI LOKAL</span>
                </div>
                <div class="product-content">
                  <h3 class="product-name"><?= e($produk['nama_produk']) ?></h3>
                  <p class="product-description"><?= e($produk['deskripsi']) ?></p>
                  <div class="product-bottom">
                    <div>
                      <div class="price">Rp <?= number_format((int) $produk['harga'], 0, ',', '.') ?></div>
                      <div class="stock">Sisa stok: <b><?= e($produk['stok']) ?></b></div>
                    </div>
                    <div class="product-actions"><a class="btn-detail" href="#tentang">Detail</a><a class="btn-cart" href="#kontak">Hubungi Kami</a></div>
                  </div>
                </div>
              </article>
            <?php endwhile; ?>
          <?php else: ?>
            <div class="empty-note"><?php if ($keyword !== ''): ?>Produk untuk “<?= e($keyword) ?>” belum ditemukan.<?php else: ?>Belum ada produk yang tersedia. Silakan kembali lagi nanti.<?php endif; ?></div>
          <?php endif; ?>
        </div>
      </div>
    </section>
    <section class="story-band" id="tentang"><div class="container-wide"><div class="story-card"><div><div class="section-kicker">AGRI LOKAL NUSANTARA</div><h2>Panen baik tumbuh dari kerja bersama.</h2><p>Kami mendukung kelompok tani dan UMKM pangan lokal melalui pencatatan produk yang lebih tertata, informasi stok yang jelas, serta ruang untuk mengenalkan komoditas unggulan seperti mocaf dan hanjeli kepada lebih banyak orang.</p></div><div class="story-points"><div class="story-point"><strong>Petani</strong><span>Hasil panen tercatat</span></div><div class="story-point"><strong>UMKM</strong><span>Produk lokal dikenal</span></div><div class="story-point"><strong>Transparan</strong><span>Informasi stok tersedia</span></div><div class="story-point"><strong>Berkelanjutan</strong><span>Ekonomi lokal bergerak</span></div></div></div></div></section>
  </main>
  <footer id="kontak"><div class="container-wide"><div class="footer-main"><div><a class="brand" href="index.php"><span class="brand-mark">✳</span><span>AgriLokal<small>NUSANTARA • PANGAN LOKAL</small></span></a><p class="footer-brand-copy">Ruang bersama untuk mengenalkan hasil pertanian, produk pangan lokal, dan cerita baik dari kelompok tani serta UMKM Nusantara.</p><div class="socials"><a href="#kontak" aria-label="Instagram">◎</a><a href="#kontak" aria-label="Facebook">f</a><a href="#kontak" aria-label="WhatsApp">◉</a></div></div><div><h3 class="footer-title">TAUTAN CEPAT</h3><div class="footer-links"><a href="index.php">Beranda</a><a href="#katalog">Katalog Produk</a><a href="#tentang">Tentang Kami</a><a href="login.php">Login Admin</a></div></div><div><h3 class="footer-title">KONTAK & INFORMASI</h3><div class="footer-contact"><div class="contact-row"><span class="contact-icon">⌖</span><span>Kelompok Tani & UMKM Pangan Lokal<br>Indonesia</span></div><div class="contact-row"><span class="contact-icon">✉</span><a href="mailto:halo@agrilokal.id">halo@agrilokal.id</a></div><div class="contact-row"><span class="contact-icon">◷</span><span>Mendukung pangan lokal, setiap hari.</span></div></div></div></div><div class="footer-bottom"><span>© 2026 AgriLokal Nusantara. Tumbuh bersama pangan lokal.</span><span>Dari petani, untuk Indonesia <span style="color:var(--lime)">♥</span></span></div></div></footer>
</div>
</body>
</html>


