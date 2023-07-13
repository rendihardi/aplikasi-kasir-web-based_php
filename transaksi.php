<?php
require 'functions.php';
$produk = query("SELECT * FROM barang");
$member = query("SELECT * FROM pelanggan");

//var
$arrayTransaksi = $_SESSION['arrayTrs'];
$totalsementara = $_SESSION['totalsementara'];
$totalakhir = $_SESSION['totalakhir'];
$idMember = $_SESSION['idMemberTemp'];
$diskon = $_SESSION['diskon'];
$userRole = $_SESSION['userRole'];
$userID = $_SESSION['userID'];

function showID(){
    if($_SESSION['idMemberTemp'] != null){
        return  $_SESSION['idMemberTemp'];
    }else{
        return "";
    }
}

//usercek
if ($userID == null) {
    logout();
}
;

//logout
if (isset($_GET["logout"])) {
    logout();
}
;

//AutoFill
if (isset($_GET["nama"])) {
    $namabrg = $_GET["nama"];
    $dataproduk = query("SELECT ID_BARANG, HARGA, STOK FROM barang b WHERE b.NAMA_BARANG = '$namabrg'");
    foreach ($dataproduk as $row) {
        $idBarangAF = $row['ID_BARANG'];
        $hargaBarangAF = $row['HARGA'];
        $stok = $row['STOK'];
        foreach ($arrayTransaksi as $row => $value) {
            if ($value['namabarang'] == $namabrg) {
                $stok -= $value['jumlahbarang'];
            }
        }
    };
} else {
    $namabrg = " ";
}

// Tambah transaksi ke array
if (isset($_POST["transaksi"])) {
    tambahTransaksiTemp($_POST);
}
;

//Reset Temp Transaksi
if (isset($_GET["reset"])) {
    resetTransaksiTemp();
}
;

//Diskon Apply
if (isset($_GET["idmember"])) {
    if (cekMember($_GET) > 0) {
        $_SESSION['idMemberTemp'] = $_GET['idmember'];
        $_SESSION['diskon'] = 5;
        $_SESSION['totalakhir'] = $totalsementara - $totalsementara * 0.05;
        $_SESSION['nominaldiskon'] = $totalsementara * 0.05;

        echo "<script>
        alert ('Berhasil tambah member');
        document.location.href= 'transaksi.php';
        </script>";
    } else {
        echo "<script>
        alert ('Member tidak ada');
        document.location.href= 'transaksi.php';
        </script>";
    }
}
;

//Pembayaran
if(isset($_POST['bayar'])){
    if($_POST['nominal'] < $_SESSION['totalakhir']){
        echo "<script>
        alert('Jumlah nominal kurang dari ' + ".$totalakhir.");
        document.location.href= 'transaksi.php';
        </script>";
    }else if($totalakhir == 0){
        echo "<script>
        alert('Belum ada transaksi');
        document.location.href= 'transaksi.php';
        </script>";
    }else{
        pembayaran($_POST);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sakinah - Transaksi</title>

    <!-- Custom fonts for this template -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                    <img id="logoimg" src="./img/sakinahlogo.png" width="35dp" alt="">
                </div>
                <div class="sidebar-brand-text mx-3">Sakinah
                    <!-- <sup>2</sup> -->
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="bi bi-house-fill"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                General
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li id="linkTransaksi" class="nav-item">
                <a class="nav-link" href="transaksi.php">
                    <i class="bi bi-cart-check-fill"></i>
                    <span>Transaksi</span>
                </a>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="produk.php">
                    <i class="bi bi-bag-fill"></i>
                    <span>Produk</span>
                </a>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li id="linkResource" class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="bi bi-file-person-fill"></i>
                    <span>Resource</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Human Resource</h6>
                        <a id="linkPegawai" class="collapse-item" href="pegawai.php">Pegawai</a>
                        <a class="collapse-item" href="member.php">Member</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <div id="linkLaporan">
                <!-- Heading -->
                <div class="sidebar-heading">
                    Manager
                </div>

                <!-- Nav Item - Charts -->
                <li class="nav-item">
                    <a class="nav-link" href="grafikpenjualan.php">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>Laporan</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
            </div>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-success" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo $userRole; ?>
                                </span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
                        <a href="transaksi.php?reset=true" name="reset"
                            class="d-none d-sm-inline btn btn-sm btn-success shadow-sm">
                            <span>Reset Transaksi</span>
                        </a>
                    </div>
                    <form action="" method="POST">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-success">Tambah Transaksi</h6>
                                <div class="transaksion">
                                    <input type="text" class="form-control bg-light border-0" aria-label="Search"
                                        aria-describedby="basic-addon2" name="idtransaksi"
                                        value="<?php echo generateKodeTransaksi(); ?>" readonly required>
                                </div>
                            </div>
                            <div class="card-body">
                                <div>
                                    <div class="mb-4">
                                        <h6 id="hTransaksi" class="font-weight-bold text-success mb-2">Nama Barang</h6>
                                        <input id="namaBarang" list="listNamaBarang" type="text"
                                            class="form-control bg-light border-1 kodebarang" aria-label="Search"
                                            aria-describedby="basic-addon2" value="<?php echo $namabrg ?>"
                                            name="namabarang" required>
                                    </div>

                                    <div class="d-flex flex-row mb-4">
                                        <div>
                                            <h6 id="hTransaksi" class="font-weight-bold text-success mb-2">Kode Barang
                                            </h6>
                                            <input id="kodeBarang" type="text"
                                                class="form-control bg-light border-1 small namabarang"
                                                aria-label="Search" aria-describedby="basic-addon2" name="kodebarang"
                                                onkeydown="return false;" required>
                                        </div>
                                        <div id="hargabarang">
                                            <h6 id="hTransaksi" class="font-weight-bold text-success mb-2">Harga Barang
                                            </h6>
                                            <div id="inputHarga" class="input-group formharga">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="text" class="form-control hargabarang" id="hargaBarang"
                                                    name="hargabarang" aria-label="Amount (to the nearest dollar)"
                                                    onkeydown="return false;" required>
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h6 id="hTransaksi" class="font-weight-bold text-success mb-2">Jumlah Barang
                                        </h6>
                                        <input id="jumlahbarang" type="number"
                                            class="form-control bg-light border-1 small jumlahbarang"
                                            aria-label="Search" aria-describedby="basic-addon2" name="jumlahbarang"
                                            min="1" max="<?php echo $stok; ?>" required>
                                    </div>

                                    <div class="mb-4">
                                        <h6 id="hTransaksi" class="font-weight-bold text-success mb-0">Total Harga</h6>
                                        <br>
                                        <div id="inputTransaksi" class="input-group">
                                            <span class="input-group-text">Rp.</span>
                                            <input id="totalHarga" type="number" class="form-control totalharga"
                                                name="totalhargatemp" aria-label="Amount (to the nearest dollar)"
                                                readonly required>
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>

                                    <a href="">
                                        <button class="btn btn-success mb-5" onclick="cobaKlik()" type="submit" name="transaksi">
                                            <i class="fas fa-plus fa-sm mr-2"></i>
                                            Tambah Transaksi
                                        </button>
                                    </a>

                                    <div class="table-responsive mb-4">
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Nomor</th>
                                                    <th>Nama Barang</th>
                                                    <th>Harga</th>
                                                    <th>Jumlah</th>
                                                    <th>SubTotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $angka = 1 ?>
                                                <?php foreach ($arrayTransaksi as $value): ?>

                                                    <tr>
                                                        <td>
                                                            <?= $angka; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value["namabarang"]; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value["hargabarang"]; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value["jumlahbarang"]; ?>
                                                        </td>
                                                        <td>
                                                            <?= $value["totaltemp"]; ?>
                                                        </td>
                                                    </tr>

                                                    <?php $angka++ ?>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfooter>
                                                <tr>
                                                    <th class="border-0"></th>
                                                    <th class="border-0"></th>
                                                    <th class="border-0"></th>
                                                    <th class="border-0"><b>Total</b></th>
                                                    <th>
                                                        <?php echo "Rp." . $totalsementara . ",00"; ?>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th class="border-0"></th>
                                                    <th class="border-0"></th>
                                                    <th class="border-0"></th>
                                                    <th class="border-0"><b>Diskon</b></th>
                                                    <th>
                                                        <?php echo $diskon . "%"; ?>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th class="border-0"></th>
                                                    <th class="border-0"></th>
                                                    <th class="border-0"></th>
                                                    <th class="border-0"><b>Total Akhir</b></th>
                                                    <th>
                                                        <?php echo "Rp." . $totalakhir . ",00"; ?>
                                                    </th>
                                                </tr>
                                            </tfooter>
                                        </table>
                                    </div>
                    </form>

                    <form action="" method="POST">
                        <div class="d-sm-flex flex-row mb-4">
                            <div>
                                <h6 id="hTransaksi" class="font-weight-bold text-success mb-2">ID Member (Opsional)</h6>
                                <div class="d-sm-flex flex-row">
                                    <input id="idMember" list="listIDMember" type="text"
                                        class="form-control bg-light border-1 small namabarang" aria-label="Search"
                                        aria-describedby="basic-addon2" value="<?php echo showID()?>" name="idmember" required>

                                    <!-- <button class="btn btn-success ml-3" type="submit" name="cekmember">
                                        Tambah
                                    </button> -->
                                </div>
                            </div>
                        </div>
                    </form>

                    <form action="" method="POST">
                        <div class="d-flex flex-row mb-4">
                            <div>
                                <h6 id="hTransaksi" class="font-weight-bold text-success mb-0">Input Nominal</h6><br>
                                <div id="inputTransaksi" class="input-group formharga">
                                    <span class="input-group-text">Rp.</span>
                                    <input id="nominal" type="text" class="form-control inputnominal"
                                        aria-label="Amount (to the nearest dollar)" name="nominal" required>
                                    <span class="input-group-text">.00</span>
                                </div>
                                <br>
                                <button class="btn btn-success" type="submit" name="bayar">
                                    <i class="fas fa-dollar-sign fa-sm mr-2"></i>
                                    Bayar
                                </button>
                            </div>
                    </form>
                    <div id="hargabarang">
                        <h6 id="hTransaksi" class="font-weight-bold text-success mb-0">Kembalian</h6><br>
                        <div id="inputTransaksi" class="input-group formharga">
                            <span class="input-group-text">Rp.</span>
                            <input id="kembalian" type="text" class="form-control inputnominal"
                                aria-label="Amount (to the nearest dollar)" disabled>
                            <span class="input-group-text">.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- DataTales Example -->

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Sakinah 2023</span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-success" href="?logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <!-- DATALIST -->
    <datalist class="" id="listNamaBarang">
        <?php foreach ($produk as $row): ?>
            <option value="<?= $row["NAMA_BARANG"]; ?>">
            <?php endforeach; ?>
    </datalist>
    <datalist class="" id="listIDMember">
        <?php foreach ($member as $row): ?>
            <option value="<?= $row["ID_PELANGGAN"]; ?>">
            <?php endforeach; ?>
    </datalist>
</body>

</html>

<script type="text/javascript">
    var jumlahBarang = document.getElementById("jumlahbarang");
    var hargaBarang = document.getElementById("hargaBarang");
    var totalHarga = document.getElementById("totalHarga");
    var namaBarang = document.getElementById("namaBarang");
    var kodeBarang = document.getElementById("kodeBarang");
    var idMember = document.getElementById("idMember");
    var nominal = document.getElementById("nominal");
    var kembalian = document.getElementById("kembalian");
    namaBarang.value = namaBarang.value;

    namaBarang.addEventListener("change", (event) => {
        //Passing ke php lewat get
        document.location.href = "?nama=" + namaBarang.value;
    })

    idMember.addEventListener("change", (event) => {
        document.location.href = "?idmember=" + idMember.value;
    })

    jumlahBarang.addEventListener("change", (event) => {
        totalHarga.value = jumlahBarang.value * hargaBarang.value;

        if (cekJumlahBarang == 0) {
            jumlahBarang.ariaReadOnly;
            alert("Stok untuk produk " + namaBarang.value + " habis");
            document.location.href = 'transaksi.php';
        }
    })

    nominal.addEventListener("change", (event) => {
        var totalakhir = <?php echo $totalakhir;?>;;
        if(nominal.value - totalakhir > 0){
            kembalian.value = nominal.value - totalakhir;
        }
    })
</script>

<!-- Variabel dari php -->
<script type="text/javascript">
    namaBarang.value = <?php echo json_encode($namabrg); ?>;
    hargaBarang.value = <?php echo json_encode($hargaBarangAF); ?>;
    kodeBarang.value = <?php echo json_encode($idBarangAF); ?>;
    var cekJumlahBarang = <?php echo json_encode($stok); ?>;
</script>

<!-- Show dan hide menu sesuai user role -->
<script type="text/javascript">
    var userRole = "<?php echo $userRole; ?>";
    var linkResource = document.getElementById('linkResource');
    var linkLaporan = document.getElementById('linkLaporan');
    var linkPegawai = document.getElementById('linkPegawai');
    var linkTransaksi = document.getElementById('linkTransaksi');

    if (userRole == "Kasir") {
        linkLaporan.style.display = "none";
        linkPegawai.style.display = "none";
    } else if (userRole == "Admin") {
        linkLaporan.style.display = "none";
        linkResource.style.display = "none";
        linkTransaksi.style.display = "none";
    } else {
        linkTransaksi.style.display = "none";
    };
</script>