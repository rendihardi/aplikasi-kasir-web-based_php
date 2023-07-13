<?php 
require'functions.php';
$id= $_GET['id'];

if(hapusBarang($id)>0){
    echo " <script>
    alert ('Berhasil Dihapus');
    document.location.href= 'produk.php';
    </script>";

}   else{
    echo "<script>
    alert ('Gagal Dihapus');
    document.location.href= 'produk.php';
    </script>";
}
?>