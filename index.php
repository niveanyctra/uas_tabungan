<?php
include "config.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Tabungan</title>
        <link rel="stylesheet" href="./assets/css/style.css" />
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div class="navbar">
                    <a href="#" class="nav-logo">Tabungan</a>
                    <nav class="nav">
                        <ul>
                            <li class="nav-list">
                                <a href="./index.php" class="nav-item">Home</a>
                            </li>
                            <li class="nav-list">
                                <a href="./pages/setor.php" class="nav-item"
                                    >Setor</a
                                >
                            </li>
                            <li class="nav-list">
                                <a href="./pages/tarik.php" class="nav-item"
                                    >Tarik</a
                                >
                            </li>
                            <li class="nav-list">
                                <a href="./pages/history.php" class="nav-item"
                                    >History</a
                                >
                            </li>
                            <?php 
                            if (!isset($_SESSION['username'])) {
                                echo '<li class="nav-list">
                                    <a href="./pages/auth/login.php" class="nav-item"
                                        >Login</a
                                    >
                                </li>';
                            } else {
                                echo '<li class="nav-list">
                                    <a href="./controller/logout.php" class="nav-item" style="color:red;"
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
                <div class="landing">
                    <div class="greetings">
                        <h1>
                            Selamat Datang di, <br />
                            Website Tabungan
                        </h1>
                        <p>
                            Kelola tabungan Anda dengan mudah dan efisien.
                            Pantau saldo, catat pemasukan dan pengeluaran, serta
                            capai tujuan finansial Anda bersama kami.
                        </p>
                    </div>
                    <img
                        src="./assets/img/money-in-a-jar.png"
                        alt="Tabungan"
                        class="landing-image"
                    />
                </div>

                <div class="tabungan">
                    <h2>Fitur-fitur</h2>
                    <div class="fitur">
                        <a href="./pages/setor.php">
                            <div class="card">
                                <h5 class="card-title">Setor</h5>
                                <div class="card-body">
                                    <p>
                                        Tambahkan uang ke tabungan Anda dengan
                                        mudah. Catat setiap penyetoran untuk
                                        memastikan semua tercatat rapi.
                                    </p>
                                </div>
                            </div>
                        </a>
                        <a href="./pages/tarik.php">
                            <div class="card">
                                <h5 class="card-title">Tarik</h5>
                                <div class="card-body">
                                    <p>
                                        Rekam setiap penarikan dana dari
                                        tabungan Anda. Pantau pengeluaran untuk
                                        membantu mencapai target finansial.
                                    </p>
                                </div>
                            </div>
                        </a>
                        <a href="./pages/history.php">
                            <div class="card">
                                <h5 class="card-title">History</h5>
                                <div class="card-body">
                                    <p>
                                        Lihat riwayat transaksi Anda, termasuk
                                        penyetoran dan penarikan. Analisis
                                        kebiasaan keuangan Anda untuk
                                        pengelolaan yang lebih baik.
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <div class="left">
                <h3>Tugas</h3>
                <img src="./assets/img/Logo_Universitas_Catur_Insan_Cendekia.png" alt="Universitas Catur Insan Cendekia" height="100px">
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
