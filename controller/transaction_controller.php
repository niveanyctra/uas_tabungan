<?php
require_once("../config.php");
session_start();

if (isset($_POST['deposit'])) {
    $amount = $_POST['amount'];
    $category_id = $_POST['to'];
    $username = $_SESSION['username'];

    $query = "SELECT id FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $user_id = $user['id'];
    } else {
        header("Location: ../pages/setor.php?error=user_not_found");
    }

    $sql = "INSERT INTO transactions (user_id, category_id, type, amount, created_at)
VALUES ($user_id, $category_id, 'Deposit', $amount, NOW())";

    if ($conn->query($sql) === TRUE) {

        $sql_update = "UPDATE categories SET amount = amount + $amount WHERE id = $category_id";

        if ($conn->query($sql_update) === TRUE) {
            syncAccountAmount($conn, $user_id);
            header("Location: ../pages/setor.php?success=deposit_success");
            exit();
        } else {
            header("Location: ../pages/setor.php?error=deposit_update_category_failed");
            exit();
        }
    } else {
        header("Location: ../pages/setor.php?error=deposit_failed");
        exit();
    }
}

if (isset($_POST['withdraw'])) {
    $amount = $_POST['amount'];
    $category_id = $_POST['from'];
    $username = $_SESSION['username'];

    $query = "SELECT id FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $user_id = $user['id'];
    } else {
        header("Location: ../pages/tarik.php?error=user_not_found");
    }

    $sql_check = "SELECT amount FROM categories WHERE id = $category_id";
    $result_check = mysqli_query($conn, $sql_check);

    if ($result_check && mysqli_num_rows($result_check) > 0) {
        $category = mysqli_fetch_assoc($result_check);
        $category_amount = $category['amount'];
        if ($amount > $category_amount) {
            header("Location: ../pages/tarik.php?error=withdraw_amount_exceed");
            exit();
        } else {

            $sql = "INSERT INTO transactions (user_id, category_id, type, amount, created_at)
        VALUES ($user_id, $category_id, 'Tarik Tunai', $amount, NOW())";

            if ($conn->query($sql) === TRUE) {

                $sql_update = "UPDATE categories SET amount = amount - $amount WHERE id = $category_id";

                if ($conn->query($sql_update) === TRUE) {
                    syncAccountAmount($conn, $user_id);
                    header("Location: ../pages/tarik.php?success=withdraw_success");
                    exit();
                } else {
                    header("Location: ../pages/tarik.php?error=withdraw_update_category_failed");
                    exit();
                }
            } else {
                header("Location: ../pages/tarik.php?error=withdraw_failed");
                exit();
            }
        }
    } else {
        header("Location: ../pages/tarik.php?error=category_not_found");
    }
}
