
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
									  <input type="text" class="form-control" id="TypeRuko" name="Type" readonly>
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
  // Variabel global untuk menyimpan data stok dan transaksi
  let rowTrxPemesanan = [];
  let dataStok = [];
  const baseURL = 'https://script.google.com/macros/s/AKfycbwwxUOqdYEiy8tBMHWQCP05u3ZnFCKdVV9iGw3SFQ2BXjxmLR2kszaMhoNe3S44fyO0xw/exec';

  // --- Fungsi-fungsi Utilitas ---
  function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
    }).format(angka);
  }

  function tanggalSaja(datetime) {
    if (!datetime) return "";
    const d = new Date(datetime);
    return d.toISOString().split('T')[0];
  }

  function autoGenerateNomor(length) {
    const no = (rowTrxPemesanan.length + 1).toString();
    return no.padStart(length, '0');
  }

  function showLoader(show) {
    const loader = document.getElementById("loader");
    if (loader) loader.style.display = show ? "block" : "none";
  }

  function getStatusBadge(Status) {
    const lower = Status?.toLowerCase() || "";
    if (lower === "booking") return `<span class="badge bg-primary text-white">Booking</span>`;
    if (lower === "terjual") return `<span class="badge bg-danger text-white">Terjual</span>`;
    if (lower === "cancel") return `<span class="badge bg-secondary text-white">Cancel</span>`;
    return `<span class="badge bg-success text-white">Tersedia</span>`;
  }

  // --- Fungsi Pengisi Dropdown ---
  function isiDropdownNama() {
    const formData = new FormData();
    formData.append("sheet", "DataPembeli");
    formData.append("action", "read");

    fetch(baseURL, {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        const select = document.getElementById("Nama");
        if (!select) return;
        select.innerHTML = `<option value="">-- Pilih Nama Pembeli --</option>`;
        data.forEach(row => {
          select.innerHTML += `<option value="${row.Nama}">${row.Nama}</option>`;
        });
        // Inisialisasi Select2 jika digunakan setelah data terisi
        // if (typeof $('#Nama').select2 === 'function') {
        //     $('#Nama').select2();
        // }
      })
      .catch(err => console.error('Error mengisi dropdown Nama:', err));
  }

  function isiDropdownBlokNomor() {
    const formData = new FormData();
    formData.append("sheet", "DataStok");
    formData.append("action", "read");

    fetch(baseURL, {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        dataStok = data; // Simpan data stok
        const select = document.getElementById("BlokNomor");
        if (!select) return;
        select.innerHTML = `<option value="">-- Pilih Blok --</option>`;
        data.forEach(row => {
          if (row.Status?.toLowerCase() === 'tersedia' || !row.Status) {
            select.innerHTML += `<option value="${row.BlokNomor}">${row.BlokNomor}</option>`;
          }
        });
        // Inisialisasi Select2 jika digunakan setelah data terisi
        // if (typeof $('#BlokNomor').select2 === 'function') {
        //     $('#BlokNomor').select2();
        // }
      })
      .catch(err => console.error('Error mengisi dropdown Blok Nomor:', err));
  }

  // --- Fungsi Reset Form ---
  function resetFormTanpaReload(form) {
    form.reset();
    document.getElementById("No").value = autoGenerateNomor(3);
    document.getElementById("No_CL").value = `${autoGenerateNomor(3)}/CL-PSG/V/2025`;
    document.getElementById("InputBy").value = localStorage.getItem("username") || "admin@email.com";
    document.getElementById("Tanggal").value = new Date().toISOString().split('T')[0];
    document.getElementById("Tanggal").readOnly = true;

    // Kosongkan juga input TypeRuko, Ukuran, Harga
    document.getElementById("TypeRuko").value = "";
    document.getElementById("Ukuran").value = "";
    document.getElementById("Harga").value = "";
    document.getElementById("HargaAsli").value = ""; // Pastikan hidden input HargaAsli ada
    
    // Pastikan dropdown di-reset juga secara visual jika menggunakan Select2
    // if (typeof $('#Nama').select2 === 'function') {
    //     $('#Nama').val('').trigger('change');
    // }
    // if (typeof $('#BlokNomor').select2 === 'function') {
    //     $('#BlokNomor').val('').trigger('change');
    // }

    isiDropdownNama(); // Isi ulang dropdown nama
    isiDropdownBlokNomor(); // Isi ulang dropdown blok nomor
    document.getElementById("Nama")?.focus();
  }

  // --- Event Listener untuk Form Submit ---
  function setupFormSubmitHandler() {
    const form = document.getElementById("formPemesanan");
    if (!form) return; // Keluar jika form tidak ditemukan

    form.addEventListener("submit", function (e) {
      e.preventDefault();

      const requiredFields = ["Nama", "BlokNomor"];
      for (const field of requiredFields) {
        if (!form[field].value) {
          alert(`⚠️ Field '${field}' wajib diisi`);
          return;
        }
      }

      const submitBtn = form.querySelector("button[type='submit']");
      submitBtn.disabled = true;
      showLoader(true);

      const sudahDipesan = rowTrxPemesanan.some(r =>
        r.BlokNomor === form.BlokNomor.value &&
        r.Status.toLowerCase() !== 'cancel'
      );

      if (sudahDipesan) {
        alert("⚠️ Blok ini sudah pernah dipesan. Harap pilih blok lain.");
        submitBtn.disabled = false;
        showLoader(false);
        return;
      }

      const formData = new FormData(form);
      formData.append("action", "save_pemesanan");
      formData.append("sheet", "TrxPemesanan");

      fetch(baseURL, {
          method: "POST",
          body: formData
        })
        .then(res => {
          if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
          }
          return res.json();
        })
        .then(res => {
          if (res.status === 'success') {
            const updateForm = new FormData();
            updateForm.append("action", "update_stok");
            updateForm.append("BlokNomor", form.BlokNomor.value);
            updateForm.append("NamaPembeli", form.Nama.value);
            updateForm.append("Status", "Booking");

            return fetch(baseURL, {
              method: "POST",
              body: updateForm
            });
          } else {
            throw new Error(res.message || "Gagal menyimpan data pemesanan");
          }
        })
        .then(updateRes => {
          if (!updateRes.ok) {
            throw new Error(`HTTP error! status: ${updateRes.status}`);
          }
          return updateRes.json();
        })
        .then(updateRes => {
          if (updateRes.status === 'success') {
            alert("✅ Data berhasil disimpan ke TrxPemesanan dan DataStok.");
            resetFormTanpaReload(form);
            window.initTrxPemesananPage(); // Memuat ulang tabel dan data setelah sukses
          } else {
            alert("⚠️ Pemesanan tersimpan, tapi update DataStok gagal: " + updateRes.message);
          }
        })
        .catch(err => {
          console.error("❌ Error:", err);
          alert("❌ Gagal simpan data: " + err.message);
        })
        .finally(() => {
          showLoader(false);
          submitBtn.disabled = false;
        });
    });
  }

  // --- Event Listener untuk Perubahan BlokNomor (Dijalankan Sekali) ---
  function setupBlokNomorChangeListener() {
    const selectBlokNomor = document.getElementById("BlokNomor");
    if (!selectBlokNomor) {
      console.error("Elemen dengan ID 'BlokNomor' tidak ditemukan saat setup change listener.");
      return;
    }

    selectBlokNomor.addEventListener("change", function () {
      const blok = this.value;
      const data = dataStok.find(d => d.BlokNomor === blok);

      const typeRukoInput = document.getElementById("TypeRuko");
      const ukuranInput = document.getElementById("Ukuran");
      const hargaInput = document.getElementById("Harga");
      const hargaAsliInput = document.getElementById("HargaAsli"); // Hidden input untuk harga asli

      if (data) {
        if (typeRukoInput) typeRukoInput.value = data.Type || ""; // Sesuaikan dengan nama properti yang benar (Type atau TypeRuko)
        if (ukuranInput) ukuranInput.value = data.Ukuran || "";

        const rawHarga = data.Harga || 0;
        let hargaAngka;
        if (typeof rawHarga === 'string') {
            const cleanHargaString = rawHarga.toString().replace(/[^\d-]/g, '');
            hargaAngka = parseInt(cleanHargaString);
        } else {
            hargaAngka = rawHarga;
        }

        if (hargaInput) hargaInput.value = formatRupiah(hargaAngka);
        if (hargaAsliInput) hargaAsliInput.value = hargaAngka;
      } else {
        // Jika blok tidak ditemukan (misal: pilih "-- Pilih Blok --"), kosongkan input terkait
        if (typeRukoInput) typeRukoInput.value = "";
        if (ukuranInput) ukuranInput.value = "";
        if (hargaInput) hargaInput.value = "";
        if (hargaAsliInput) hargaAsliInput.value = "";
      }
    });
  }


  // --- Fungsi Utama Inisialisasi Halaman ---
  window.initTrxPemesananPage = function () {
    console.log("🔥 initTrxPemesananPage dipanggil");
    const tbody = document.querySelector("#TabelPemesanan tbody");
    if (!tbody) {
        console.error("Elemen tbody untuk TabelPemesanan tidak ditemukan.");
        return;
    }

    const formData = new FormData();
    formData.append("action", "read_pemesanan");

    fetch(baseURL, {
        method: 'POST',
        body: formData
      })
      .then(res => res.text()) // Ambil sebagai teks dulu
      .then(text => {
        try {
          const data = JSON.parse(text); // Kemudian parse JSON
          if (!Array.isArray(data)) {
            console.error("Data yang diterima bukan array:", data);
            throw new Error("Data yang diterima bukan array");
          }

          rowTrxPemesanan = data;
          tbody.innerHTML = ""; // Bersihkan tabel sebelum mengisi

          data.forEach((row, index) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
              <td>${row.No || ""}</td>
              <td>${row.No_CL || ""}</td>
              <td>${row.No_Pemesanan || ""}</td>
              <td>${row.Nama || ""}</td>
              <td>${row.Klasifikasi || ""}</td>
              <td>${row.BlokNomor || ""}</td>
              <td>${row.Type || ""}</td>
              <td>${row.Ukuran || ""}</td>
              <td>${row.Harga ? formatRupiah(row.Harga) : ""}</td>
              <td>${getStatusBadge(row.Status)}</td>
              <td>${tanggalSaja(row.Tanggal)}</td>
              <td>
                <button class="btn btn-sm btn-warning editBtn" data-index="${index}" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa fa-edit"></i> Edit</button>
              </td>
            `;
            tbody.appendChild(tr);
          });
        } catch (err) {
          console.error("❌ Gagal memuat data pemesanan atau parsing JSON:", err);
          console.warn("Response text was:", text);
        }

        // Inisialisasi atau Hancurkan/Inisialisasi ulang DataTable
        if ($.fn.DataTable.isDataTable('#TabelPemesanan')) {
          $('#TabelPemesanan').DataTable().clear().destroy();
        }
        $('#TabelPemesanan').DataTable({
          pageLength: 10,
          dom: 'Bflrtip',
          buttons: ['excelHtml5'],
          language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            zeroRecords: "Tidak ada data ditemukan",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data"
          }
        });

        // Isi form pemesanan awal
        document.getElementById("No").value = autoGenerateNomor(3);
        document.getElementById("No_CL").value = `${autoGenerateNomor(3)}/CL-PSG/V/2025`;
        document.getElementById("InputBy").value = localStorage.getItem("username") || "admin@email.com";
        document.getElementById("Tanggal").value = new Date().toISOString().split('T')[0];
        document.getElementById("Tanggal").readOnly = true;

        isiDropdownNama(); // Panggil fungsi untuk mengisi dropdown Nama
        isiDropdownBlokNomor(); // Panggil fungsi untuk mengisi dropdown Blok Nomor
      })
      .catch(err => console.error('❌ Gagal memuat data tabel pemesanan:', err));
  };


  // --- Event Listener untuk Modal Edit Status (Dijalankan Sekali) ---
  function setupEditModalListeners() {
    document.addEventListener("click", function (e) {
      if (e.target.closest(".editBtn")) {
        const index = e.target.closest(".editBtn").dataset.index;
        const data = rowTrxPemesanan[index];
        document.getElementById("editNo").value = data.No;
        document.getElementById("editStatus").value = "Tersedia"; // Default ke Tersedia
        document.getElementById("editAlasanContainer").style.display = 'none';
        document.getElementById("editAlasan").value = '';
      }
    });

    const formEditStatus = document.getElementById("formEditStatus");
    if (formEditStatus) {
        formEditStatus.addEventListener("submit", function (e) {
            e.preventDefault();
            if (!confirm("Yakin ingin memperbarui status?")) return;

            const formData = new FormData(this);
            formData.append("action", "edit_status");

            fetch(baseURL, {
                    method: "POST",
                    body: formData
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(res => {
                    if (res.status === 'success') {
                        alert("✅ Status berhasil diperbarui");
                        // Pastikan modal ditutup dengan benar
                        const editModalElement = document.getElementById("editModal");
                        const modalInstance = bootstrap.Modal.getInstance(editModalElement);
                        if (modalInstance) {
                            modalInstance.hide();
                        } else {
                            // Jika instance belum ada, mungkin perlu dibuat atau dicari lagi
                            new bootstrap.Modal(editModalElement).hide();
                        }
                        window.initTrxPemesananPage(); // Memuat ulang tabel setelah update
                    } else {
                        alert("❌ Gagal update status: " + res.message);
                    }
                })
                .catch(err => console.error("❌ Gagal kirim edit:", err));
        });
    } else {
        console.warn("Form dengan ID 'formEditStatus' tidak ditemukan.");
    }
  }


  // --- Inisialisasi Saat Dokumen Siap ---
  document.addEventListener('DOMContentLoaded', function () {
    // Panggil fungsi inisialisasi utama saat DOM siap
    window.initTrxPemesananPage();

    // Setup event listener yang hanya perlu dijalankan sekali
    setupFormSubmitHandler();
    setupBlokNomorChangeListener();
    setupEditModalListeners(); // Setup listener untuk modal edit
  });

  // Bagian ini sepertinya adalah sisa dari cara memuat script secara eksternal.
  // Jika script ini sudah ada di dalam HTML secara langsung, bagian ini tidak diperlukan.
  // Jika ini adalah file TrxPemesanan.js yang dimuat, maka ini harus dihapus dari HTML
  // dan disimpan di dalam file TrxPemesanan.js itu sendiri.
  /*
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
  */
</script>

			
<script>
  localStorage.setItem("username", "<?php echo $_SESSION['username']; ?>");
</script>

</body>

</html>