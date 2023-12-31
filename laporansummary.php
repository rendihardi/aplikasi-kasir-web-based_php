<?php
require 'functions.php';
// Mendapatkan data laporan penjualan
$laporan = query("SELECT t.ID_TRANSAKSI, p.NAMA_PEGAWAI, IFNULL(pl.NAMA_PELANGGAN, 'Bukan Member') AS NAMA_PELANGGAN, t.TANGGAL, t.DISKON, t.TOTAL
                FROM transaksi t
                INNER JOIN pegawai p ON t.ID_PEGAWAI = p.ID_PEGAWAI
                LEFT JOIN pelanggan pl ON t.ID_PELANGGAN = pl.ID_PELANGGAN
                ORDER BY t.TANGGAL");

// Mendapatkan data laporan penjualan berdasarkan tanggal
if (isset($_GET["tanggalawal"])) {
    $laporan = query("SELECT t.ID_TRANSAKSI, p.NAMA_PEGAWAI, IFNULL(pl.NAMA_PELANGGAN, 'Bukan Member') AS NAMA_PELANGGAN, t.TANGGAL, t.DISKON, t.TOTAL
    FROM transaksi t
    INNER JOIN pegawai p ON t.ID_PEGAWAI = p.ID_PEGAWAI
    LEFT JOIN pelanggan pl ON t.ID_PELANGGAN = pl.ID_PELANGGAN
    WHERE (t.TANGGAL BETWEEN '$_GET[tanggalawal]' AND '$_GET[tanggalakhir]')
    ORDER BY t.TANGGAL");
}
;

function getTanggal()
{
    if (isset($_GET["tanggalawal"])) {
        return $_GET["tanggalawal"];
    } else {
        return "";
    }
}

function getTanggalAkhir()
{
    if (isset($_GET["tanggalakhir"])) {
        return $_GET["tanggalakhir"];
    } else {
        return "";
    }
}

//variables
$userRole = $_SESSION['userRole'];
$userID = $_SESSION['userID'];

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
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sakinah - Rekap Transaksi</title>

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
                <!-- Heading -->
                <li id="linkResource" class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan"
                        aria-expanded="true" aria-controls="collapsePages">
                        <i class="bi bi-file-person-fill"></i>
                        <span>Laporan</span>
                    </a>
                    <div id="collapseLaporan" class="collapse" aria-labelledby="headingPages"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Laporan Penjualan</h6>
                            <a id="linkPegawai" class="collapse-item" href="laporansummary.php">Rekap</a>
                            <a class="collapse-item" href="grafikpenjualan.php">Grafik Penjualan</a>
                        </div>
                    </div>
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
                        <h1 class="h3 mb-0 text-gray-800">Rekap Transaksi</h1>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-success">Transaksi</h6>
                            <div class="d-flex flex-row justify-content-between">
                                <input id="tanggalStart" type="date" class="form-control bg-light border-1 small"
                                    aria-describedby="basic-addon2" value="<?php echo getTanggal(); ?>"
                                    name="tanggalStart" required>

                                <h3 class="mr-3 ml-3">-</h3>

                                <input id="tanggalEnd" type="date" class="form-control bg-light border-1 small"
                                    aria-describedby="basic-addon2" name="tanggalEnd"
                                    value="<?php echo getTanggalAkhir(); ?>"  required>

                                <div class="mt-2 ml-3">
                                    <a href="" onclick="reset()" name="reset" data-toggle="collapse"
                                        class="d-none d-sm-inline btn btn-sm btn-success shadow-sm">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Id Transaksi</th>
                                            <th>Pegawai</th>
                                            <th>Member</th>
                                            <th>Tanggal</th>
                                            <th>Diskon</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($laporan as $row): ?>
                                            <tr>
                                                <td>
                                                    <?php echo $no ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['ID_TRANSAKSI']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['NAMA_PEGAWAI']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['NAMA_PELANGGAN']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['TANGGAL']; ?>
                                                </td>
                                                <td>
                                                    Rp.
                                                    <?php echo $row['DISKON']; ?>
                                                </td>
                                                <td>
                                                    Rp.
                                                    <?php echo $row['TOTAL']; ?>
                                                </td>
                                            </tr>
                                            <?php $no++; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

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

</body>

</html>

<script>
    var tanggalStart = document.getElementById('tanggalStart');
    var tanggalAkhir = document.getElementById('tanggalEnd');

    tanggalAkhir.addEventListener("change", (event) => {
        document.location.href = "laporansummary.php?tanggalawal=" + `${tanggalStart.value}&tanggalakhir=${tanggalAkhir.value}`;
    });

    function reset() {
        document.location.href = "laporansummary.php";
    }

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