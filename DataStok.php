<?php
session_start();
if (!isset($_SESSION['username'])) {
  echo "Akses ditolak. Silakan login.";
  exit;
}
?>

        <div class="container-fluid content mt-3">
			<div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12 content mt-3">
                        <div class="card">
                            <div class="card-header" >
                                <strong class="card-title">Data Stok Ruko Kios</strong>
								
                            </div>
                            <div class="card-body table-responsive">
								<div class="table-responsive">
                                <table id="TabelStok" class="table table-striped container-fluid">
								
                                    <thead>
                                        <tr>
                                            <th>No</th>
											<th>Kode Type</th>
                                            <th>Pembeli</th>
                                            <th>Type</th>
											<th>Ukuran</th>
											<th>Blok/Nomor</th>
											<th>Harga</th>
											<th>Status</th>
											
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
									
								</table>
								</div>  
						    </div>
						</div>
                    </div>
				</div>
				
            </div><!-- .animated -->
			
			
<script>
  localStorage.setItem("username", "<?php echo $_SESSION['username']; ?>");
</script>