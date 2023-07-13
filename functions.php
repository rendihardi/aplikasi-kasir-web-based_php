<?php
session_start();

//var
settype($_SESSION['arrayTrs'], "array");
settype($_SESSION['totalsementara'], "float");
settype($_SESSION['totalakhir'], "float");
settype($_SESSION['idMemberTemp'], "string");
settype($_SESSION['diskon'], "int");
settype($_SESSION['userRole'], "string");
settype($_SESSION['userID'], "string");
settype($_SESSION['idTransaksi'], "string");
settype($_SESSION['nominaldiskon'], "int");

// Menghubungkan ke database
$conn = mysqli_connect("localhost", "root", "", "sakinah");

// Memeriksa koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit;
}

// FUNCTION LOGINOUT
function login($data)
{
    global $conn;
    $cekPegawai = "SELECT * FROM pegawai p WHERE p.USERNAME = '$data[username]' and p.PASSWORD = '$data[password]'";
    $hasil = mysqli_query($conn, $cekPegawai);

    if (mysqli_num_rows($hasil) > 0) {

        $row = mysqli_fetch_assoc($hasil);
        $_SESSION['userID'] = $row['ID_PEGAWAI'];

        if ($row['ID_JABATAN'] == "JB001") {
            $_SESSION['userRole'] = "Admin";
        } else if ($row['ID_JABATAN'] == "JB002") {
            $_SESSION['userRole'] = "Kasir";
        } else {
            $_SESSION['userRole'] = "Manager";
        }

    }

    return mysqli_affected_rows($conn);
}

function logout()
{
    session_destroy();
    header('location:login.php');
}

// FUNCTION READ
function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_array($result)) {
        $rows[] = $row;

    }
    return $rows;
}

// FUNCTION BARANG

function tambahProduk($data)
{
    //ambil data
    global $conn;
    $kodebrg = $data["kodebrg"];
    $kodektg = $data["kodektg"];
    $namabrg = $data["namabrg"];
    $harga = $data["hargabrg"];
    $stok = $data["jumlahbrg"];
    //  query insert data
    $query = "INSERT INTO BARANG VALUES ('$kodebrg','$kodektg','$namabrg','$harga','$stok')";
    mysqli_query($conn, $query);

    //cek apakah data berhasil ditambahkan atau tidak
    return mysqli_affected_rows($conn);
}

function generateKodeBarang()
{
    global $conn;

    // Mendapatkan kode barang terakhir dari database
    $query = "SELECT ID_BARANG FROM BARANG ORDER BY ID_BARANG DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $lastKodeBarang = $row['ID_BARANG'];

        // Mengambil angka urutan dari kode barang terakhir
        $urutan = (int) substr($lastKodeBarang, 3);
        $urutan++;

        // Menghasilkan kode barang baru dengan format BRGXXX
        $kodeBarang = 'BRG' . str_pad($urutan, 3, '0', STR_PAD_LEFT);
    } else {
        // Jika belum ada kode barang, menghasilkan kode barang pertama BRG001
        $kodeBarang = 'BRG001';
    }

    return $kodeBarang;
}

function hapusBarang($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM BARANG WHERE ID_BARANG ='$id'");
    return mysqli_affected_rows($conn);
}

function ubahBarang($data)
{
    //ambil data
    global $conn;
    $kodebrg = $data["kodebrg"];
    $kodektg = $data["kodektg"];
    $namabrg = $data["namabrg"];
    $harga = $data["hargabrg"];
    $stok = $data["jumlahbrg"];
    //  query ubah data
    $query = "UPDATE BARANG SET 
        ID_BARANG='$kodebrg',
        ID_KATEGORI='$kodektg',
        NAMA_BARANG='$namabrg',
        HARGA='$harga',
        STOK='$stok'
        WHERE ID_BARANG ='$kodebrg'";
    mysqli_query($conn, $query);

    //cek apakah data berhasil diuabh atau tidak
    return mysqli_affected_rows($conn);

}


// FUNCTION UNTUK MEMBER

function tambahMember($data)
{
    //ambil data
    global $conn;
    $kodembr = $data["kodembr"];
    $namambr = $data["namambr"];
    $nombr = $data["nombr"];
    $alamatmbr = $data["alamatmbr"];
    //  query insert data
    $query = "INSERT INTO PELANGGAN VALUES ('$kodembr','$namambr','$nombr','$alamatmbr')";
    mysqli_query($conn, $query);

    //cek apakah data berhasil ditambahkan atau tidak
    return mysqli_affected_rows($conn);
}


function generateKodeMember()
{
    global $conn;

    // Mendapatkan kode barang terakhir dari database
    $query = "SELECT ID_PELANGGAN FROM PELANGGAN ORDER BY ID_PELANGGAN DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $lastKodePelanggan = $row['ID_PELANGGAN'];

        // Mengambil angka urutan dari kode barang terakhir
        $urutan = (int) substr($lastKodePelanggan, 3);
        $urutan++;

        // Menghasilkan kode barang baru dengan format BRGXXX
        $kodePelanggan = 'MBR' . str_pad($urutan, 3, '0', STR_PAD_LEFT);
    } else {
        // Jika belum ada kode barang, menghasilkan kode barang pertama BRG001
        $kodePelanggan = 'MBR001';
    }

    return $kodePelanggan;
}

function hapusMember($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM PELANGGAN WHERE ID_PELANGGAN ='$id'");
    return mysqli_affected_rows($conn);
}

function ubahMember($data)
{
    //ambil data
    global $conn;
    $kodembr = $data["kodembr"];
    $namambr = $data["namambr"];
    $nombr = $data["nombr"];
    $alamatmbr = $data["alamatmbr"];
    //  query ubah data
    $query = "UPDATE PELANGGAN SET 
        ID_PELANGGAN='$kodembr',
        NAMA_PELANGGAN='$namambr',
        NOTELP_PELANGGAN='$nombr',
        ALAMAT='$alamatmbr'
        WHERE ID_PELANGGAN ='$kodembr'";
    mysqli_query($conn, $query);

    //cek apakah data berhasil diuabh atau tidak
    return mysqli_affected_rows($conn);

}

function cekMember($data)
{
    global $conn;
    $cek = "SELECT * FROM pelanggan p WHERE p.ID_PELANGGAN = '$data[idmember]'";
    mysqli_query($conn, $cek);
    return mysqli_affected_rows($conn);
}

// FUNCTION PEGAWAI
function tambahPegawai($data)
{
    //ambil data
    global $conn;
    $kodepgw = $data["kodepgw"];
    $kodejbt = $data["kodejbt"];
    $namapgw = $data["namapgw"];
    $alamatpgw = $data["alamatpgw"];
    $nopgw = $data["notelppgw"];
    $user = $data["ussernamepgw"];
    $pw = $data["passwordpgw"];
    //  query insert data
    $query = "INSERT INTO PEGAWAI VALUES ('$kodepgw','$kodejbt','$namapgw','$alamatpgw','$nopgw','$user','$pw')";
    mysqli_query($conn, $query);

    //cek apakah data berhasil ditambahkan atau tidak
    return mysqli_affected_rows($conn);
}


function generateKodePegawai()
{
    global $conn;

    // Mendapatkan kode barang terakhir dari database
    $query = "SELECT ID_PEGAWAI FROM PEGAWAI ORDER BY ID_PEGAWAI DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $lastKodePegawai = $row['ID_PEGAWAI'];

        // Mengambil angka urutan dari kode barang terakhir
        $urutan = (int) substr($lastKodePegawai, 3);
        $urutan++;

        // Menghasilkan kode barang baru dengan format BRGXXX
        $kodePegawai = 'PG' . str_pad($urutan, 3, '0', STR_PAD_LEFT);
    } else {
        // Jika belum ada kode barang, menghasilkan kode s pertama BRG001
        $kodePegawai = 'PG001';
    }

    return $kodePegawai;
}

function hapusPegawai($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM PEGAWAI WHERE ID_PEGAWAI ='$id'");
    return mysqli_affected_rows($conn);
}


function ubahPegawai($data)
{
    //ambil data
    global $conn;
    $kodepgw = $data["kodepgw"];
    $kodejbt = $data["kodejbt"];
    $namapgw = $data["namapgw"];
    $alamatpgw = $data["alamatpgw"];
    $nopgw = $data["notelppgw"];
    $user = $data["ussernamepgw"];
    $pw = $data["passwordpgw"];
    //  query ubah data
    $query = "UPDATE PEGAWAI SET 
        ID_PEGAWAI='$kodepgw',
        ID_JABATAN='$kodejbt',
        NAMA_PEGAWAI='$namapgw',
        ALAMAT_PEGAWAI='$alamatpgw',
        NOTELP_PEGAWAI='$nopgw',
        USERNAME ='$user',
        `PASSWORD` ='$pw'
        WHERE ID_PEGAWAI ='$kodepgw'";
    mysqli_query($conn, $query);

    //cek apakah data berhasil diuabh atau tidak
    return mysqli_affected_rows($conn);

}

// FUNCTION TRANSAKSI

function generateKodeTransaksi()
{
    global $conn;

    // Mendapatkan kode barang terakhir dari database
    $query = "SELECT ID_TRANSAKSI FROM TRANSAKSI ORDER BY ID_TRANSAKSI DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $lastKodeTransaksi = $row['ID_TRANSAKSI'];

        // Mengambil angka urutan dari kode barang terakhir
        $urutan = (int) substr($lastKodeTransaksi, 3);
        $urutan++;

        // Menghasilkan kode barang baru dengan format TRXXX
        $kodeTransaksi = 'TRS' . str_pad($urutan, 3, '0', STR_PAD_LEFT);
    } else {
        // Jika belum ada kode barang, menghasilkan kode barang pertama BRG001
        $kodeTransaksi = 'TRS001';
    }

    return $kodeTransaksi;
}

function tambahTransaksiTemp($data)
{
    $array = array(
        "idtransaksi" => "$data[idtransaksi]",
        "namabarang" => "$data[namabarang]",
        "hargabarang" => "$data[hargabarang]",
        "kodebarang" => "$data[kodebarang]",
        "jumlahbarang" => "$data[jumlahbarang]",
        "totaltemp" => "$data[totalhargatemp]"
    );
    array_push($_SESSION['arrayTrs'], $array);
    $_SESSION['idTransaksi'] = $data['idtransaksi'];
    $_SESSION['totalsementara'] += $data['totalhargatemp'];
    $_SESSION['totalakhir'] += $data['totalhargatemp'];
    return header('location:transaksi.php');
}

function resetTransaksiTemp()
{
    $_SESSION['totalsementara'] = 0;
    $_SESSION['totalakhir'] = 0;
    $_SESSION['arrayTrs'] = array();
    $_SESSION['idMemberTemp'] = "";
    $_SESSION['nominaldiskon'] = 0;
    $_SESSION['idTransaksi'] = "";
    return header('location:transaksi.php');
}

function pembayaran($data)
{
    global $conn;
    date_default_timezone_set('Asia/Bangkok');
    $tanggalTransaksi = date('Y-m-d H:i:s');
    $arrayTransaksi = $_SESSION['arrayTrs'];
    $idTransaksi = $_SESSION['idTransaksi'];
    $idMember = $_SESSION['idMemberTemp'];
    $idPegawai = $_SESSION['userID'];
    $nominalDiskon = $_SESSION['nominaldiskon'];
    $totalAkhir = $_SESSION['totalakhir'];

    //Input ke db detail_transaksi
    foreach ($arrayTransaksi as $value) {
        $queryDT = "insert into detail_transaksi values('$value[kodebarang]', '$idTransaksi', '$value[hargabarang]', '$value[jumlahbarang]', '$value[totaltemp]')";
        mysqli_query($conn, $queryDT);

        //Update jumlah stok
        if (mysqli_affected_rows($conn) > 0) {
            $dataproduk = query("SELECT * FROM barang b WHERE b.ID_BARANG = '$value[kodebarang]'");
            foreach ($dataproduk as $row) {
                $stok = $row['STOK'] - $value['jumlahbarang'];
            }
            $queryUB = "UPDATE BARANG SET STOK = $stok WHERE ID_BARANG ='$value[kodebarang]'";
            mysqli_query($conn, $queryUB);
        } else {
            $queryG1 = "delete from detail_transaksi where ID_TRANSAKSI = '$idTransaksi'";
            mysqli_query($conn, $queryG1);
            header('location:transaksi.php');
        }
    }
    ;

    //Input ke db Transaksi
    $query = "insert into transaksi values('$idTransaksi', '$idPegawai', '$idMember', '$tanggalTransaksi', '$nominalDiskon', '$totalAkhir')";
    mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>
        alert ('Transaksi Sukses');
        document.location.href= 'transaksi.php?reset';
        </script>";
    } else {
        return mysqli_affected_rows($conn);
    }
}