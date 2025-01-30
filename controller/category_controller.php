<?php
require_once("../config.php");
session_start();

if (isset($_POST['create_category'])) {
    $name = $_POST['name'];
    $user_id = (int) $_POST['user_id'];

    $sql = "INSERT INTO categories (user_id, name, amount) VALUES ($user_id, '$name', 0)";

    if ($conn->query($sql) === TRUE) {
        syncAccountAmount($conn, $user_id);
        header("Location: ../pages/setor.php?success=category_created");
        exit();
    } else {
        header("Location: ../pages/setor.php?error=category_creation_failed");
        exit();
    }
}

if (isset($_POST['update_category'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];

    $sql = "UPDATE categories SET name = '$name' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $sql_user_id = "SELECT user_id from categories WHERE id = $id";
        $result = mysqli_query($conn, $sql_user_id);
        if ($result && mysqli_num_rows($result) > 0) {
            $category = mysqli_fetch_assoc($result);
            $user_id = $category['user_id'];
            syncAccountAmount($conn, $user_id);
        }
        header("Location: ../pages/setor.php?success=category_updated");
        exit();
    } else {
        header("Location: ../pages/setor.php?error=category_update_failed");
        exit();
    }
}

if (isset($_GET['delete_category_id'])) {
    $id = $_GET['delete_category_id'];
    $sql_user_id = "SELECT user_id from categories WHERE id = $id";
    $result = mysqli_query($conn, $sql_user_id);
    if ($result && mysqli_num_rows($result) > 0) {
        $category = mysqli_fetch_assoc($result);
        $user_id = $category['user_id'];
    }
    $sql = "DELETE FROM categories WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        syncAccountAmount($conn, $user_id);
        header("Location: ../pages/setor.php?success=category_deleted");
        exit();
    } else {
        header("Location: ../pages/setor.php?error=category_delete_failed");
        exit();
    }
}
