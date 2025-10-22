<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            font-family: sans-serif;
            font-weight: 100
        }

        body {
            background-color: rgba(239, 247, 248, 1);
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .container form {
            border: 1px solid rgba(231, 231, 231, 1);
            display: flex;
            flex-direction: column;
            height: 320px;
            width: 400px;
            gap: 8px;
            background-color: white;
            justify-content: center;
            align-items: center;
        }

        .container form input {
            border-collapse: collapse;
            border: 1px solid rgba(231, 231, 231, 1);
            width: 100%;
        }

        .container form input:focus {
            outline: none;
        }

        .container form button {
            border-collapse: collapse;
            border: 1px solid #7c69ef;
            border-radius: 4px;
            height: 30px;
            background-color: #7c69ef;
            color: white;
            width: 65%;
        }

        .email,
        .password {
            display: flex;
            flex-direction: column;
            gap: 8px;
            width: 65%;

        }

        .email input,
        .password input {
            height: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <form action="query_login.php" method="post">
            <div class="email">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="password">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit" name="submit" id="submit">Login</button>
        </form>
    </div>
</body>

</html>

