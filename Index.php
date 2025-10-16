<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: url("https://static.promediateknologi.id/crop/0x0:0x0/0x0/webp/photo/p2/231/2024/07/16/Gedung-Sate-Bandung-Abah-Shutterstock-2609867939.png") no-repeat center center;
      background-size: cover;
      height: 100vh;
    }

    .parent {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      grid-template-rows: repeat(5, 1fr);
      gap: 8px;
      height: 100vh;
      background-color: rgba(0, 0, 0, 0.7);
    }

    /* Header */
    .div1 {
      grid-column: span 5 / span 5;
      background-color: black;
      opacity: 1;

      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 50px;
      height: 80px;
    }

    .containerImg img {
      height: 50px;
    }

    .div1 ul {
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: row;
      gap: 36px;
      align-items: center;
      list-style: none;
    }

    .div1 ul li {
      color: white;
      font-size: 18px;
      cursor: pointer;
    }

    .div1 ul li a {
        color: white;
        text-decoration: none;
    }

    li button {
        border-collapse: collapse;
        border: 2px solid white;
        height: 30px;
        width: 80px;
        border-radius: 8px;
        font-weight: bold;
    }

    li button:hover {
        cursor: pointer;
    }

    /* Main content */
    .div2 {
      grid-column: span 5 / span 5;
      grid-row: span 4 / span 4;
      grid-row-start: 2;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      flex-direction: column;
      text-align: center;
      padding: 20px;
    }

    .div2 h1 {
      font-size: 50px;
      margin-bottom: 20px;
    }

    .div2 p {
      font-size: 16px;
      line-height: 24px;
      max-width: 800px;
    }
  </style>
</head>

<body>
  <div class="parent">
    <header class="div1">
      <span class="containerImg">
        <img src="./assets/logo kesbangpol BARU.png" alt="logo">
      </span>

      <ul>
        <li>About</li>
        <li>Struktur Organisasi</li>
        <li><a href="./Dashboard/index.php">Dashboard</a></li>
        <li><a href="/admin_SW1Qb3NzaWJsZU1jNzY3_/index.php"><button>Login</button></a></li>
      </ul>
    </header>

    <main class="div2">
      <h1>Lorem Ipsum</h1>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br>
        Quos ex exercitationem libero distinctio cum explicabo, hic corrupti dolore commodi nemo, sed dolor, quibusdam
        inventore.<br>
        Odit consectetur rem corrupti non rerum.</p>
    </main>
  </div>
</body>

</html>
