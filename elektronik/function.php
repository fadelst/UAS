<?php
session_start();

//membuat koneksi database
$con = mysqli_connect("localhost","root","","stokbarang");

//menambah barang baru
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi  = $_POST['deskripsi'];
    $stock  = $_POST['stock'];

    $addtotable = mysqli_query($con, "insert into stock (namabarang, deskripsi, stock)
    values('$namabarang', '$deskripsi', '$stock')");
    if($addtotable){
        header('location:index.php');
    }else{
        echo 'Gagal';
        header('location:index.php');
    }
};

//menambah barang masuk

if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barang'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($con, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;
    
    

    $addtomasuk = mysqli_query($con, "insert into masuk (idbarang, keterangan, qty)
     values('$barangnya','$penerima', '$qty')");
    $updatestockmasuk = mysqli_query($con, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");

     if($addtomasuk&&$updatestockmasuk){
        header('location:masuk.php');
    }else{
        echo 'Gagal';
        header('location:masuk.php');
    }
}


//menambah barang keluar

if(isset($_POST['barangkeluar'])){
    $barang = $_POST['barang'];
    $pengirim = $_POST['pengirim'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($con, "select * from stock where idbarang='$barang'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];

    if($stocksekarang >= $qty){
        //kalau barang cukup
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;
    
    $addtokeluar = mysqli_query($con, "insert into keluar (idbarang, pengirim, qty)
     values('$barang','$pengirim', '$qty')");
    $updatestockmasuk = mysqli_query($con, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barang'");

     if($addtokeluar&&$updatestockmasuk){
        header('location:keluar.php');
    }else{
        echo 'Gagal';
        header('location:keluar.php');
    }
    }else{
        //kalau barangnya tidak cukup
        echo '
        <script>
        alert("Stock saat ini tidak mencukupi");
        window.location.href="keluar.php";
        </script>
        ';
    }
}



//update info barang

if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    $update = mysqli_query($con, "update stock set namabarang= '$namabarang', deskripsi= '$deskripsi' where idbarang = '$idb'");
    if($update){
        header('location:index.php');
    }else{
        echo 'Gagal';
        header('location:index.php');
    }
}


//menghapus barang

if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];



    $hapus = mysqli_query($con, "delete from stock where idbarang='$idb'");
    if($hapus){
        header('location:index.php');
    }else{
        echo 'Gagal';
        header('location:index.php');
    }
};


//mengubah data barang masuk

if(isset($_POST['updatebarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['keterangan'];
    $qty     = $_POST['qty'];

    $lihatstock = mysqli_query($con, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($con, "select * from masuk where idmasuk ='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg){
        $selisih = $qty-$qtyskrg;
        $kurangin = $stockskrg + $selisih;
        $kuranginstocknya = mysqli_query($con, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($con, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");

        if($kuranginstocknya&&$updatenya){
            header('location:masuk.php');
        }else{
            echo 'Gagal';
            header('location:masuk.php');
        }
        

    }else{
        $selisih = $qtyskrg - $qty;
        $kurangin = $stockskrg - $selisih;
        $kuranginstocknya = mysqli_query($con, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($con, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");

        if($kuranginstocknya&&$updatenya){
            header('location:masuk.php');
        }else{
            echo 'Gagal';
            header('location:masuk.php');
        }
    }

}


//menghapus barang masuk

if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($con, "select *from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih= $stock-$qty;


    $update = mysqli_query($con,"update stock set stock='$selisih' where idbarang='$idb'" );
    $hapusdata = mysqli_query($con,"delete from masuk where idmasuk='$idm'");


    if($update&&$hapusdata){
        header('location:masuk.php');
    }else{
        echo 'Gagal';
        header('location:masuk.php');
    }



}


//mengubah data barang keluar


if(isset($_POST['updatebarangkeluar'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $pengirim = $_POST['pengirim'];
    $qty     = $_POST['qty'];

    $lihatstock = mysqli_query($con, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($con, "select * from keluar where idkeluar ='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg){
        $selisih = $qty-$qtyskrg;
        $kurangin = $stockskrg - $selisih;
        $kuranginstocknya = mysqli_query($con, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($con, "update keluar set qty='$qty', pengirim='$pengirim' where idkeluar='$idk'");

        if($kuranginstocknya&&$updatenya){
            header('location:keluar.php');
        }else{
            echo 'Gagal';
            header('location:keluar.php');
        }
        

    }else{
        $selisih = $qtyskrg - $qty;
        $kurangin = $stockskrg + $selisih;
        $kuranginstocknya = mysqli_query($con, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($con, "update keluar set qty='$qty', pengirim='$pengirim' where idkeluar='$idk'");

        if($kuranginstocknya&&$updatenya){
            header('location:keluar.php');
        }else{
            echo 'Gagal';
            header('location:keluar.php');
        }
    }

}


//menghapus barang keluar

if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($con, "select *from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih= $stock+$qty;


    $update = mysqli_query($con,"update stock set stock='$selisih' where idbarang='$idb'" );
    $hapusdata = mysqli_query($con,"delete from keluar where idkeluar='$idk'");


    if($update&&$hapusdata){
        header('location:keluar.php');
    }else{
        echo 'Gagal';
        header('location:keluar.php');
    }



}

//menambah admin baru

if (isset($_POST['addadmin'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $queryinsert = mysqli_query($con, "insert into login (email, password)
    values ('$email', '$password')");

    if($queryinsert){
        //berhasil
        header('location:admin.php');
    }else{
        //gagal
        header('location:admin.php');
    }
}


//edite data admin


if (isset($_POST['updateadmin'])){

    $emailbaru = $_POST['emailadmin'];
    $passwordbaru = $_POST['passwordbaru'];
    $idnya= $_POST['id'];

    $queryupdate = mysqli_query($con, "update login set email='$emailbaru', password='$passwordbaru' where iduser='$idnya'");

    if($queryupdate){
        //berhasil
        header('location:admin.php');
    }else{
        //gagal
        header('location:admin.php');
    }
}

//hapus admin
if(isset($_POST['hapusadmin'])){
    $id = $_POST['id'];

    $querydelete = mysqli_query($con, "delete from login where iduser='$id' ");

    if($querydelete){
        //berhasil
        header('location:admin.php');
    }else{
        //gagal
        header('location:admin.php');
    }
}


?>