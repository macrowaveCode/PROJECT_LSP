<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kursus Coding Anak Surabaya - CodeKids</title>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&display=swap" rel="stylesheet">
  <style>
    /* Reset & font */
    body, html { margin:0; padding:0; font-family: 'Baloo 2', cursive; background:#f0f8ff; color:#333; }
    a { text-decoration:none; }

    /* Header */
    header { background:#007BFF; padding:15px 30px; display:flex; justify-content:space-between; align-items:center; }
    .logo { height:60px; color:#FFA500; color: #FFA500;                  /* warna utama */
            -webkit-text-stroke: 2px white;  /* outline putih */
            font-size: 40px;                  /* pastikan ukuran sesuai */
            font-weight: 700;                 /* tebal */
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2); }
    .cta-button { padding:10px 20px; border:none; border-radius:8px; cursor:pointer; font-weight:600; transition:0.3s; }
    .cta-login { background:#FFA500; color:white; }
    .cta-login:hover { background:#ff8c00; }
    
    /* Hero Section */
    .hero { display:flex; flex-wrap:wrap; align-items:center; justify-content:center; padding:60px 20px; background:#e6f0ff; border-bottom:5px solid #FFA500; }
    .hero-text { flex:1; min-width:300px; padding:20px; }
    .hero-text h1 { font-size:2.5rem; margin-bottom:20px; }
    .highlight { color:#FFA500; }
    .hero-text p { font-size:1.2rem; line-height:1.5; }
    .hero-image { flex:1; text-align:center; }
    .hero-image img { max-width:250px; height:auto; }

    /* Footer */
    footer { text-align:center; padding:20px; background:#007BFF; color:white; margin-top:50px; border-top:5px solid #FFA500; }

    /* Modal */
    .modal { display:none; position:fixed; z-index:999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; }
    .modal-content { background:white; padding:30px; border-radius:10px; max-width:400px; width:90%; position:relative; }
    .modal-content h2 { margin-top:0; color:#007BFF; }
    .modal-content input { width:100%; padding:10px; margin:10px 0; border:1px solid #ddd; border-radius:6px; }
    .modal-content button { width:100%; background:#007BFF; color:white; padding:10px; border:none; border-radius:6px; cursor:pointer; }
    .modal-content button:hover { background:#0056b3; }
    .close { position:absolute; top:10px; right:15px; font-size:24px; cursor:pointer; }

    /* Tombol hero */
    .hero-buttons { margin-top:20px; display:flex; gap:15px; flex-wrap:wrap; }
    .hero-buttons .cta-button { font-size:1rem; }
    .hero-buttons .cta-register { background:#007BFF; color:white; }
    .hero-buttons .cta-register:hover { background:#0056b3; }

    /* Responsive */
    @media(max-width:768px){
      .hero { flex-direction:column-reverse; }
      .hero-text h1 { font-size:2rem; }
    }
  </style>
</head>
<body>

<header>
  <h1 class="logo">CodeKids</h1>
  <a href="login.php"><button class="cta-button cta-login">Login</button></a>
</header>

<section class="hero">
  <div class="hero-text">
    <h1>Belajar <span class="highlight">Coding Seru</span> Bersama <span class="highlight">CodeKids</span></h1>
    <p>Program belajar coding interaktif untuk anak usia 5–15 tahun. Belajar sambil bermain, cocok untuk anak dan aman bagi orangtua!</p>
    <div class="hero-buttons">
      <a href="register.php"><button class="cta-button cta-register">Daftar</button></a>
      <a href="login.php"><button class="cta-button cta-login">Login</button></a>
    </div>
  </div>
  <div class="hero-image">
    <img src="assets/logoanak.jpg" alt="Maskot">
  </div>
</section>

<footer>
  <p>© 2025 CodeKids Surabaya</p>
</footer>

<!-- Modal login & register bisa tetap disiapkan, tapi tombol bawah dihapus -->

</body>
</html>