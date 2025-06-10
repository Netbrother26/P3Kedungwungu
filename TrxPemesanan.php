<?php
session_start();
if (!isset($_SESSION['username'])) {
  echo "Akses ditolak. Silakan login.";
  exit;
}
?>
<html>
<body>

		
        <div class="container-fluid content mt-3">
			<div class="animated fadeIn">
                <div class="row">
					<div class="col-md-12 content mt-3">
						<div class="card">
							<div class="card p-3 mb-4">
							  <h5 class="card-title mb-3">Form Pemesanan</h5>
							  <form id="formPemesanan">
								  <div class="form-row">

									<!-- No (auto & hidden) -->
									<input type="hidden" id="No" name="No" />

									<!-- No_CL auto generate -->
									<div class="form-group col-md-6">
									  <label for="No_CL">No CL</label>
									  <input type="text" class="form-control" id="No_CL" name="No_CL" readonly>
									</div>

									<!-- No Pemesanan -->
									<div class="form-group col-md-6">
									  <label for="No_Pemesanan">No Pemesanan</label>
									  <input type="text" class="form-control" id="No_Pemesanan" name="No_Pemesanan" required>
									</div>

									<!-- Nama (dari DataPembeli) -->
									<div class="form-group col-md-6">
									  <label for="Nama">Nama</label>
									  <select class="form-control select2" id="Nama" name="Nama" required>
										<option value="">-- Pilih Nama --</option>
									  </select>
									</div>

									<!-- Klasifikasi -->
									<div class="form-group col-md-6">
									  <label for="Klasifikasi">Klasifikasi</label>
									  <input type="text" class="form-control" id="Klasifikasi" name="Klasifikasi">
									</div>

									<!-- BlokNomor (dari DataStok) -->
									<div class="form-group col-md-6">
									  <label for="BlokNomor">Blok Nomor</label>
									  <select class="form-control select2" id="BlokNomor" name="BlokNomor" required>
										<option value="">-- Pilih Blok --</option>
									  </select>
									</div>

									<!-- Type (otomatis dari DataStok) -->
									<div class="form-group col-md-6">
									  <label for="Type">Type</label>
									  <input type="text" class="form-control" id="Type" name="Type" readonly>
									</div>

									<!-- Ukuran -->
									<div class="form-group col-md-6">
									  <label for="Ukuran">Ukuran</label>
									  <input type="text" class="form-control" id="Ukuran" name="Ukuran" readonly>
									</div>

									<!-- Harga (ubah ke text agar bisa format Rp) -->
									<div class="form-group col-md-6">
									  <label for="Harga">Harga</label>
									  <input type="text" class="form-control" id="Harga" name="Harga" readonly>
									</div>

									<!-- Status -->
									<div class="form-group col-md-6">
									  <label for="Status">Status</label>
									  <input type="text" class="form-control" id="Status" name="Status" value="Booking" readonly>
									</div>

									<!-- Tanggal -->
									<div class="form-group col-md-6">
									  <label for="Tanggal">Tanggal</label>
									  <input type="date" class="form-control" id="Tanggal" name="Tanggal" required>
									</div>

									<!-- InputBy dari session -->
									<div class="form-group col-md-6">
									  <label for="InputBy">Input By</label>
									  <input type="email" class="form-control" id="InputBy" name="InputBy" readonly>
									</div>
								  </div>

								  <button type="submit" class="btn btn-primary mt-3">Simpan</button>
								  <button type="reset" class="btn btn-warning mt-3">Batal</button>
								</form>


							</div>

						</div>
					
					</div>
				
				

                    <div class="col-md-12 content mt-3">
                        <div class="card">
                            <div class="card-header" >
                                <strong class="card-title">Data Pembeli</strong>
								
                            </div>
                            <div class="card-body table-responsive">
								<div class="table-responsive">
                                <table id="TabelPemesanan" class="table table-striped container-fluid">
								
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No_CL</th>
                                            <th>No_Pemesanan</th>
                                            <th style="width: 80px;">Nama</th>
											<th>Klasifikasi</th>
											<th>Blok Nomor</th>
											<th>Type</th>
											<th>Ukuran</th>
											<th>Harga</th>
											<th>Status</th>
											<th>Tanggal</th>
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
			<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
			  <div class="modal-dialog">
				<form id="formEditStatus">
				  <div class="modal-content">
					<div class="modal-header">
					  <h5 class="modal-title">Edit Status Pemesanan</h5>
					  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">
					  <input type="hidden" id="editNoPemesanan" name="No_Pemesanan">
					  <div class="mb-3">
						<label for="editStatus" class="form-label">Status</label>
						<select class="form-select" id="editStatus" name="Status" required>
						  <option value="Booking">Booking</option>
						  <option value="Terjual">Terjual</option>
						  <option value="Cancel">Cancel</option>
						  <option value="Tersedia">Tersedia</option>
						</select>
					  </div>
					</div>
					<div class="modal-footer">
					  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
					</div>
				  </div>
				</form>
			  </div>
			</div>

<!-- Paling bawah sebelum </body> -->
<script>
  const script = document.createElement("script");
  script.src = "js/TrxPemesanan.js";
  script.onload = function () {
    console.log("✅ TrxPemesanan.js loaded manual");
    if (typeof window.initTrxPemesananPage === "function") {
      console.log("🚀 Memanggil initTrxPemesananPage()");
      window.initTrxPemesananPage();
    } else {
      console.error("❌ initTrxPemesananPage tidak ditemukan");
    }
  };
  document.body.appendChild(script);
</script>

			
<script>
  localStorage.setItem("username", "<?php echo $_SESSION['username']; ?>");
</script>

</body>

</html>