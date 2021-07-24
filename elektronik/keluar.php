<?php
require 'function.php';
require 'cek.php';

?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Barang Keluar</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">MyElectronic</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
           
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stock Barang
                            </a>

                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a>

                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Keluar
                            </a>

                            <br>
                            <br>

                            <div class="container">
                                         
                                         <div class="dropdown">
                                           <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                           Privacy
                                           </button>
                                           <div class="dropdown-menu">
                                             <a class="dropdown-item" href="admin.php">Kelola Admin</a>
                                             <a class="dropdown-item" href="logout.php">Logout</a>
                                             
                                           </div>
                                         </div>
                                       </div>
                          
                            
                           
                        </div>
                    </div>
                   
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Barang Keluar</h1>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                 <!-- Button to Open the Modal -->
                                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                          Tambah Barang
                                             </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Pengirim</th>
                                                <th>Aksi</th>
                                                
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                             <?php
                                        $ambilsemuadatastock = mysqli_query($con,"select* from keluar k, stock s where s.idbarang = k.idbarang ");
                                        while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                            $idk = $data['idkeluar'];
                                           $idb = $data['idbarang']; 
                                        $tanggal = $data['tanggal'];
                                        $namabarang = $data['namabarang'];
                                        $qty = $data['qty'];
                                        $pengirim = $data['pengirim'];
                                        

                                        ?>

                                            <tr>
                                            <td><?= date("d-F-Y, H:i:s", strtotime($tanggal)); ?></td>
                                                <td><?= $namabarang; ?></td>
                                                <td><?= $qty; ?></td>
                                                <td><?= $pengirim; ?></td>

                                                <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edite<?= $idk;?>">
                                                 Edite
                                             </button>
                                             
                                             <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idk;?>">
                                                    Delete
                                             </button>
                                                
                                                </td>
                                               
                                            </tr>



                                                  <!-- The Modal edite -->
                                             <div class="modal fade" id="edite<?=$idk; ?>">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                        <h4 class="modal-title">Edite Barang</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        
                                                        <!-- Modal body -->
                                                        <form method="post">
                                                        <div class="modal-body">
                                                    
                                                        <input type="text" name="pengirim" value="<?=$pengirim; ?>" class="form-control" required>
                                                        <br>
                                                        <br>
                                                        <input type="number" name="qty" value="<?=$qty; ?>" class="form-control" required>
                                                        <br>
                                                        <input type="hidden" name="idb" value="<?=$idb;?>">
                                                        <input type="hidden" name="idk" value="<?=$idk;?>">
                                                        
                                                        <button type="submit" class="btn btn-primary" name="updatebarangkeluar">Submit</button>
                                                        </div>
                                                    </form>
                                                    
                                                    </div>
                                                    </div>
                                                </div>

                                                <!-- The Modal delete -->
                                                <div class="modal fade" id="delete<?=$idk; ?>">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Barang ?</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        
                                                        <!-- Modal body -->
                                                        <form method="post">
                                                        <div class="modal-body">

                                                        Apakah Anda yakin ingin menghapus <?= $namabarang; ?> ?
                                                        <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                        <input type="hidden" name="kty" value="<?= $qty; ?>">
                                                        <input type="hidden" name="idk" value="<?=$idk;?>">

                                                    <br>
                                                    <br>
                                                    
                                                        
                                                        <button type="submit" class="btn btn-danger" name="hapusbarangkeluar">Hapus</button>
                                                        </div>
                                                    </form>
                                                    
                                                    </div>
                                                    </div>
                                                </div>






                                             <?php
                                        };

                                        ?>
                                            
                                         
                                         
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>

     <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form method="post">
        <div class="modal-body">
        <select name="barang" class="form-control">
            <?php
                $ambildatanya = mysqli_query($con, "select * from stock");
               while($fetcharray = mysqli_fetch_array($ambildatanya)) {
                   $namabarang = $fetcharray['namabarang'];
                   $idbarang = $fetcharray['idbarang'];

                   ?>
                

               <option value="<?=$idbarang;?>"><?=$namabarang;?></option>

               <?php

               }
            ?>
            </select>
            <br>
            <input type="number" name="qty" placeholder="Quantity" class="form-control" required>
        <br>
        <input type="text" name="pengirim" placeholder="Pengirim" class="form-control" required>
        <br>
        <button type="submit" class="btn btn-primary" name="barangkeluar">Submit</button>
        </div>
       </form>
      
      </div>
    </div>
  </div>

</html>