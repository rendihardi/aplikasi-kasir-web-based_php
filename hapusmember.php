<?php 
require'functions.php';
$id= $_GET['id'];

if(hapusMember($id)>0){
    echo " <script>
    alert ('Berhasil Dihapus');
    document.location.href= 'member.php';
    </script>";

}   else{
    echo "<script>
    alert ('Gagal Dihapus');
    document.location.href= 'member.php';
    </script>";
}
?>