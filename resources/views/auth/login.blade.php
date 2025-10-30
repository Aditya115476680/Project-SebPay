<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Kasir | SebPay</title>
  <style>
    body {
      background-color: #3E0703;
      font-family: 'Poppins', sans-serif;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      color: #000;
      overflow: hidden;
    }

    .circle1 {
  position: absolute;
  width: 250px;
  height: 250px;
  background-color: #5A0903; /* warna merah gelap */
  border-radius: 50%;
  top: -100px;
  right: -45px;
  opacity: 0.9; /* sedikit transparan biar lembut */
}


.circle2 {
  position: absolute;
  width: 300px;
  height: 300px;
  background-color: #7A1206; /* merah agak terang */
  border-radius: 50%;
  bottom: -150px;
  left: -100px;
  opacity: 0.9;
}

    .login-container {
      background-color: #fff;
      border-radius: 10px;
      width: 380px;
      padding: 40px 30px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
      text-align: center;
    }

    .logo {
      text-align: center;
      margin-bottom: 20px;
    }

    .logo img {
      width: 120px;
      border-radius: 37%;
    }

    h2 {
      margin-bottom: 25px;
      font-size: 22px;
      color: #000;
      font-weight: 600;
    }

    input {
      width: 100%;
      padding: 12px;
      margin-bottom: 18px;
      border-radius: 8px;
      border: 2px solid #ccc;
      outline: none;
      font-size: 15px;
    }

    input:focus {
      border-color: #660B05;
    }

    button {
      width: 100%;
      background-color: #660B05;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 25px;
      cursor: pointer;
      font-weight: 600;
      font-size: 16px;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #3E0703;
    }

    footer {
      margin-top: 20px;
      font-size: 12px;
      color: #FFF7D5;
    }

    footer span {
      color: #fff;
      font-weight: 500;
    }
  </style>
</head>
<body>
  <div class="logo">
    <img src="{{ asset('logo.png') }}" alt="SebPay Logo">
  </div>

  <div class="circle1"></div>
  <div class="circle2"></div>


  <div class="login-container">
    <h2>Login Kasir</h2>
    <form action="{{ route('login.process') }}" method="POST">
        @csrf
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>
  </div>

  <footer>
    © 2025 Kasir <span>SebPay</span> — Semua hak dilindungi
  </footer>
</body>
</html>
