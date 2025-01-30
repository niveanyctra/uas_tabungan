<?php
include "../config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("location:auth/login.php");
}

$username = $_SESSION['username'];

$query = "SELECT u.name, a.amount 
        FROM users u
        INNER JOIN accounts a ON u.id = a.user_id
        WHERE u.username = '$username'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $user_name = $user['name']; 
    $user_amount = $user['amount']; 
} else {
    $user_name = "User"; 
    $user_amount = 0;
}

$query_transactions = "SELECT t.type, t.amount, t.created_at, c.name as category_name
                    FROM transactions t
                    INNER JOIN categories c ON t.category_id = c.id
                    INNER JOIN users u ON t.user_id = u.id
                    WHERE u.username = '$username'
                    ORDER BY t.created_at DESC";
$result_transactions = mysqli_query($conn, $query_transactions);

$transactions = [];
if ($result_transactions && mysqli_num_rows($result_transactions) > 0) {
    while ($row = mysqli_fetch_assoc($result_transactions)) {
        $transactions[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tabungan History</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="navbar">
                <a href="#" class="nav-logo">Tabungan</a>
                <nav class="nav">
                    <ul>
                        <li class="nav-list">
                            <a href="../index.php" class="nav-item">Home</a>
                        </li>
                        <li class="nav-list">
                            <a href="../pages/setor.php" class="nav-item">Setor</a>
                        </li>
                        <li class="nav-list">
                            <a href="../pages/tarik.php" class="nav-item">Tarik</a>
                        </li>
                        <li class="nav-list">
                            <a href="../pages/history.php" class="nav-item">History</a>
                        </li>
                        <?php
                        if (!isset($_SESSION['username'])) {
                            echo '<li class="nav-list">
                                    <a href="../pages/auth/login.php" class="nav-item"
                                        >Login</a
                                    >
                                </li>';
                        } else {
                            echo '<li class="nav-list">
                                    <a href="../controller/logout.php" class="nav-item" style="color:red;"
                                        >Logout</a
                                    >
                                </li>';
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="content">
            <div class="history">
                <h1>History</h1>
                <div class="card">
                    <div class="card-body">
                        <div class="header">
                            <h1>Hi, <span><?php echo htmlspecialchars($user_name); ?></span></h1>
                            <div
                                style="
                                        display: flex;
                                        align-items: center;
                                        gap: 20px;
                                    ">
                                <h3>Saldo :</h3>
                                <p class="saldo">Rp. <?php echo htmlspecialchars(number_format($user_amount, 0, ',', '.')); ?></p>
                            </div>
                        </div>

                        <?php
                        if (!empty($transactions)) {
                            $current_date = null;
                            foreach ($transactions as $transaction) {
                                $transaction_date = date('l, d F Y', strtotime($transaction['created_at']));
                                if ($transaction_date != $current_date) {
                                    if ($current_date !== null) {
                                        echo '</div>'; 
                                    }
                                    echo '<div class="riwayat">';
                                    echo '<h3>' . $transaction_date . '</h3>';
                                    echo '<hr>';
                                    $current_date = $transaction_date;
                                }
                                $amount = htmlspecialchars(number_format($transaction['amount'], 0, ',', '.'));
                                $type = htmlspecialchars($transaction['type']);
                                $category_name = htmlspecialchars($transaction['category_name']);
                                $sign = ($type == 'Deposit') ? '+' : '-';
                                $class = ($type == 'Deposit') ? 'income' : 'expense';


                                echo '<div class="jenis ' . $class . '">';
                                echo "<h4>$type ($category_name)</h4>";
                                echo '<p class="jumlah">' . $sign . ' Rp. ' . $amount . '</p>';
                                echo '</div>';
                            }
                            echo '</div>'; 
                        } else {
                            echo "<p>Tidak ada riwayat transaksi.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <footer>
        <div class="left">
            <h3>Tugas</h3>
            <img
                src="../assets/img/Logo_Universitas_Catur_Insan_Cendekia.png"
                alt="Universitas Catur Insan Cendekia"
                height="100px" />
        </div>
        <div class="right">
            <div class="members">
                <h3>Anggota Kelompok</h3>
                <table>
                    <thead>
                        <tr>
                            <th width="300px"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tr>
                        <td>Vilvi Wanda Sandria</td>
                        <td>20241020077</td>
                    </tr>
                    <tr>
                        <td>Yusi Lira Gerhani</td>
                        <td>20241020078</td>
                    </tr>
                    <tr>
                        <td>Bella Imannuel</td>
                        <td>20241020082</td>
                    </tr>
                    <tr>
                        <td>Crishy Prajua</td>
                        <td>20241020079</td>
                    </tr>
                    <tr>
                        <td>Rizki Adha Sulaeman</td>
                        <td>20241020084</td>
                    </tr>
                    <tr>
                        <td>Muhammad Fadli</td>
                        <td>20241020085</td>
                    </tr>
                    <tr>
                        <td>Muhamad Andi Romadhan</td>
                        <td>20191020066</td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
</body>

</html>