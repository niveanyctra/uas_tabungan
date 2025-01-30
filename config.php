<?php
$conn = mysqli_connect('localhost', 'root', '', "tabungan");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function syncAccountAmount($conn, $user_id)
{
    $sql_total = "SELECT SUM(amount) AS total_amount FROM categories WHERE user_id = $user_id";
    $result = $conn->query($sql_total);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total_amount = $row['total_amount'];
    } else {
        $total_amount = 0;
    }

    $sql_update = "UPDATE accounts SET amount = $total_amount WHERE user_id = $user_id";
    $conn->query($sql_update);
}
