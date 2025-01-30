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

$query_categories = "SELECT id, name, amount FROM categories WHERE user_id = (SELECT id FROM users WHERE username = '$username')";
$result_categories = mysqli_query($conn, $query_categories);
$categories = [];
if ($result_categories && mysqli_num_rows($result_categories) > 0) {
    while ($row = mysqli_fetch_assoc($result_categories)) {
        $categories[] = $row;
    }
}

$query_user_id = "SELECT id FROM users WHERE username = '$username'";
$result_user_id = mysqli_query($conn, $query_user_id);
if ($result_user_id && mysqli_num_rows($result_user_id) > 0) {
    $user = mysqli_fetch_assoc($result_user_id);
    $user_id = $user['id'];
} else {
    $user_id = null; 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tabungan Setor</title>
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
            <div class="category">
                <?php
                foreach ($categories as $category) {
                ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="info">
                                <h2><?php echo htmlspecialchars($category['name']) ?></h2>
                                <h4>Rp. <?php echo htmlspecialchars(number_format($category['amount'], 0, ',', '.')) ?></h4>
                            </div>
                            <div class="action">
                                <button
                                    type="button"
                                    class="ctg_btn"
                                    id="editCategory" data-id="<?php echo $category['id']; ?>" data-name="<?php echo $category['name']; ?>">
                                    <svg
                                        xmlns="http:
                                        height="32"
                                        width="32"
                                        viewBox="0 0 512 512">
                                        <path
                                            fill="#2eafff"
                                            d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z" />
                                    </svg>
                                </button>
                                <a href="../controller/category_controller.php?delete_category_id=<?php echo $category['id'] ?>">
                                    <svg
                                        xmlns="http:
                                        height="32"
                                        width="28"
                                        viewBox="0 0 448 512">
                                        <path
                                            fill="#ff1d43"
                                            d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="setor">
                <h1>Tabung</h1>
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

                        <form action="../controller/transaction_controller.php" method="post">
                            <input
                                class="form-input"
                                type="number"
                                name="amount"
                                placeholder="Masukkan Jumlah Uang" />
                            <div class="input-group">
                                <select class="form-select" name="to" id="">
                                    <option selected>Pilih Tujuan</option>
                                    <?php
                                    foreach ($categories as $category) {
                                    ?>
                                        <option value="<?php echo $category['id'] ?>"><?php echo htmlspecialchars($category['name']) ?></option>
                                    <?php } ?>
                                </select>
                                <button
                                    class="form-btn"
                                    id="makeCategory"
                                    type="button">
                                    Buat Kategori
                                </button>
                            </div>
                            <button class="form-btn" name="deposit" type="submit">
                                Kirim
                            </button>
                        </form>
                    </div>
                </div>

                <div id="modalCreateCategory" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Buat Kategori</h3>
                            <span id="closeCreate" class="close">×</span>
                        </div>
                        <div class="modal-body">
                            <form action="../controller/category_controller.php" method="post">
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                <input
                                    class="form-input"
                                    type="text"
                                    name="name"
                                    placeholder="Masukkan Nama Kategori" />
                                <button class="form-btn" name="create_category" type="submit">
                                    Tambah
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="modalEditCategory" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Edit Kategori</h3>
                            <span id="closeEdit" class="close">×</span>
                        </div>
                        <div class="modal-body">
                            <form action="../controller/category_controller.php" method="post">
                                <input type="hidden" name="id" id="editCategoryId">
                                <input
                                    class="form-input"
                                    type="text"
                                    name="name"
                                    id="editCategoryName"
                                    placeholder="Masukkan Nama Kategori" />
                                <button class="form-btn" name="update_category" type="submit">
                                    Update
                                </button>
                            </form>
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

    <script>
        const category = document.querySelector(".category");

        
        category.addEventListener("wheel", (event) => {
            event.preventDefault();

            
            let scrollAmount = event.deltaY * 0.5; 
            category.scrollLeft += scrollAmount;
        });
    </script>

    <script>
        var createModal = document.getElementById("modalCreateCategory");
        var editModal = document.getElementById("modalEditCategory");

        var btnCreate = document.getElementById("makeCategory");
        var btnEdit = document.querySelectorAll("#editCategory");


        var spanCreate = document.getElementById("closeCreate"); 
        var spanEdit = document.getElementById("closeEdit"); 

        var editCategoryId = document.getElementById("editCategoryId");
        var editCategoryName = document.getElementById("editCategoryName");

        btnCreate.onclick = function() {
            createModal.style.display = "block";
        };

        btnEdit.forEach(btn => {
            btn.onclick = function() {
                editModal.style.display = "block";
                editCategoryId.value = btn.dataset.id;
                editCategoryName.value = btn.dataset.name;

            };
        });

        spanCreate.onclick = function() {
            createModal.style.display = "none";
        };

        spanEdit.onclick = function() {
            editModal.style.display = "none";
        };

        window.onclick = function(event) {
            if (event.target == createModal) {
                createModal.style.display = "none";
            }
            if (event.target == editModal) {
                editModal.style.display = "none";
            }
        };
    </script>
</body>

</html>