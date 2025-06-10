<?php
session_start();
if (!isset($_SESSION['username'])) {
  echo "Akses ditolak. Silakan login.";
  exit;
}
?>

		<!-- Modal Tambah Data -->
			<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
			  <div class="modal-dialog" role="document">
			 
				<form id="addForm" class="modal-content" enctype="multipart/form-data">
				  <div class="modal-header">
					<h5 class="modal-title">Tambah Data</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				  </div>
				  <div class="modal-body row" id="addFields"></div>
				  <div class="modal-footer">
					<button type="submit" class="btn btn-primary">Simpan</button>
				  </div>
				</form>
			  </div>
			</div>

        <div class="container-fluid content mt-3">
			<div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12 content mt-3">
                        <div class="card">
                            <div class="card-header" >
                                <strong class="card-title">Data Pembeli</strong>
								
                            </div>
                            <div class="card-body table-responsive">
								<div class="table-responsive">
                                <table id="dataTable" class="table table-striped container-fluid">
								
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Nama</th>
                                            <th style="width: 40px;">L / P</th>
											<th>No Identitas</th>
											<th style="width: 110px;">Alamat</th>
											<th>Desa</th>
											<th>Kecamatan</th>
											<th>Kabupaten</th>
											<th>No HP</th>
											<th>No HP2</th>
											<th>Email</th>
											<th>Aksi</th>
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
			<!-- Modal Edit -->
			  <div class="modal fade" id="editModal" tabindex="-1">
				<div class="modal-dialog">
				  <form id="editForm" class="modal-content">
					<div class="modal-header">
					  <h5 class="modal-title">Edit Data</h5>
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body" id="editFields"></div>
					<div class="modal-footer">
					  <button type="submit" class="btn btn-primary">Update</button>
					</div>
				  </form>
				</div>
			  </div>

			  <!-- Modal Hapus -->
			  <div class="modal fade" id="deleteModal" tabindex="-1">
				<div class="modal-dialog">
				  <div class="modal-content">
					<div class="modal-header">
					  <h5 class="modal-title">Hapus Data</h5>
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">Yakin ingin menghapus data ini?</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
					</div>
				  </div>
				</div>
			  </div>
			<button class="btn btn-success mb-3" data-toggle="modal" data-target="#addModal">Tambah Data</button>
			
<script>
  localStorage.setItem("username", "<?php echo $_SESSION['username']; ?>");
</script>