<?php

require_once("../config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        die("Password dan Confirm Password tidak cocok.");
    }

    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sql_users = "INSERT INTO users (name, username, email, password) 
                    VALUES ('$name', '$username', '$email', '$password')";
        if ($conn->query($sql_users) === TRUE) {
            $user_id = $conn->insert_id;

            $sql_accounts = "INSERT INTO accounts (user_id, amount) 
                            VALUES ($user_id, 0)";
            if ($conn->query($sql_accounts) !== TRUE) {
                echo "Gagal membuat record di tabel accounts: " . $conn->error;
            }

            $sql_categories = "INSERT INTO categories (user_id, name, amount)
                            VALUES ($user_id, 'Tabungan', 0)";
            if ($conn->query($sql_categories) !== TRUE) {
                echo "Gagal membuat record di tabel categories: " . $conn->error;
            }

            header("Location: ../../../pages/auth/login.php");
            exit();
        } else {
            echo "Registrasi gagal di tabel users: " . $conn->error;
        }
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
    try {
        $sql_users = "INSERT INTO users (name, username, email, password) 
                    VALUES ('$name', '$username', '$email', '$password')";
        if ($conn->query($sql_users) === TRUE) {
            $user_id = $conn->insert_id;

            $sql_accounts = "INSERT INTO accounts (user_id, amount) 
                            VALUES ($user_id, 0)";
            if ($conn->query($sql_accounts) !== TRUE) {
                echo "Gagal membuat record di tabel accounts: " . $conn->error;
            }

            $sql_categories = "INSERT INTO categories (user_id, name, amount)
                            VALUES ($user_id, 'Tabungan', 0)";
            if ($conn->query($sql_categories) !== TRUE) {
                echo "Gagal membuat record di tabel categories: " . $conn->error;
            }

            header("Location: ../../../pages/auth/login.php");
            exit();
        } else {
            echo "Registrasi gagal di tabel users: " . $conn->error;
        }
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
