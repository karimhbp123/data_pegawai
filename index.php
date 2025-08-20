<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>👨‍💼 Aplikasi Data Pegawai </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
      overflow: hidden;
      position: relative;
    }

    /* Background Gambar Tetap Kelihatan */
    .bg-image {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url('./assets/rs_image.jpg');
      background-size: cover;
      background-position: center;
      z-index: -3;
    }

    .bg-dark-blur {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.30);
      backdrop-filter: blur(2px);
      -webkit-backdrop-filter: blur(3px);
      z-index: -2;
    }

    .login-card {
      position: relative;
      z-index: 1;
      background: rgba(255, 255, 255, 0.95);
      padding: 36px 32px;
      width: 100%;
      max-width: 380px;
      margin: 0 auto;
      top: 50%;
      transform: translateY(-50%);
      box-shadow: 0 8px 28px rgba(0, 0, 0, 0.2);
      border-radius: 16px;
      text-align: center;
      transition: all 0.3s ease-in-out;
      backdrop-filter: blur(2px);
    }

    .login-card h2 {
      font-size: 26px;
      margin-bottom: 8px;
    }

    .login-card p {
      font-size: 14px;
      margin-bottom: 24px;
    }


    .form-group {
      text-align: left;
      margin-bottom: 24px;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      color: #333;
      font-size: 14px;
    }

    .form-group input {
      width: 100%;
      padding: 12px 14px;
      font-size: 14px;
      border: 1px solid #d0d0d0;
      border-radius: 12px;
      background-color: #fdfdfd;
      transition: all 0.2s ease-in-out;
      box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .form-group input:focus {
      outline: none;
      border-color: #007bff;
      box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.15);
      background-color: #fff;
    }

    button[type="submit"] {
      width: 100%;
      padding: 14px;
      font-size: 16px;
      font-weight: 600;
      border: none;
      border-radius: 12px;
      background: linear-gradient(to right, #007bff, #0056b3);
      color: #fff;
      cursor: pointer;
      transition: all 0.3s ease-in-out;
    }

    button[type="submit"]:hover {
      background: linear-gradient(to right, #0056b3, #004a99);
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>

<body>

  <div class="bg-image"></div>

  <!-- Overlay Hitam Transparan -->
  <div class="bg-dark-blur"></div>

  <!-- Form Login -->
  <div class="login-card">
    <h2>Selamat Datang</h2>
    <p>Masuk sebagai Admin atau User</p>
    <form method="POST" action="./proses/login.php">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Masukkan username" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
      </div>

      <button type="submit">🔐 Masuk</button>
    </form>
  </div>

</body>

</html>