<?php 
require'functions.php';
$id= $_GET['id'];

if(hapusPegawai($id)>0){
    echo " <script>
    alert ('Berhasil Dihapus');
    document.location.href= 'pegawai.php';
    </script>";

}   else{
    echo "<script>
    alert ('Gagal Dihapus');
    document.location.href= 'pegawai.php';
    </script>";
}
?>