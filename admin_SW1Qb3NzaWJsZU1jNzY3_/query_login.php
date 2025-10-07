<?php
include "../include/database.php";
session_start();

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

if (!isset($_POST['submit'])) {
    header("Location: index.php");
    exit();
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($email === '' || $password === '') {
    echo "<script>alert('Email dan password wajib diisi.'); window.location='index.php';</script>";
    exit();
}

$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ? LIMIT 1");
if (!$stmt) {
    die("Database error: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if (!($result && $result->num_rows > 0)) {
    echo "<script>alert('Email atau password Anda salah. Silakan coba lagi!'); window.location='index.php';</script>";
    $stmt->close();
    exit();
}

$row = $result->fetch_assoc();
$storedHash = $row['password'];
$userId = (int)$row['id'];
$username = $row['username'];

if (password_verify($password, $storedHash)) {
    if (password_needs_rehash($storedHash, PASSWORD_DEFAULT)) {
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $up = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        if ($up) {
            $up->bind_param("si", $newHash, $userId);
            $up->execute();
            $up->close();
        }
    }

    $_SESSION['username'] = $username;
    $stmt->close();
    header("Location: dashboard.php");
    exit();
}

$sha256 = hash('sha256', $password);
if (hash_equals($storedHash, $sha256)) {
    $newHash = password_hash($password, PASSWORD_DEFAULT);
    $up = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    if ($up) {
        $up->bind_param("si", $newHash, $userId);
        $up->execute();
        $up->close();
    }

    $_SESSION['username'] = $username;
    $stmt->close();
    header("Location: dashboard.php");
    exit();
}

if (hash_equals($storedHash, $password)) {
    $newHash = password_hash($password, PASSWORD_DEFAULT);
    $up = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    if ($up) {
        $up->bind_param("si", $newHash, $userId);
        $up->execute();
        $up->close();
    }

    $_SESSION['username'] = $username;
    $stmt->close();
    header("Location: dashboard.php");
    exit();
}

echo "<script>alert('Email atau password Anda salah. Silakan coba lagi!'); window.location='index.php';</script>";
$stmt->close();
exit();

?>
