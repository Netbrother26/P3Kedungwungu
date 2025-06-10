(function () {
  const baseURL = 'https://script.google.com/macros/s/AKfycbxMbTidfkhOdMWuToBOFfG5q4QM_kml8m5IAzZ-Xz-Np-4z0DKfbvJ1MoONqtJesPTKQA/exec';
  const TrxPemesananURL  = 'https://script.google.com/macros/s/AKfycbxMbTidfkhOdMWuToBOFfG5q4QM_kml8m5IAzZ-Xz-Np-4z0DKfbvJ1MoONqtJesPTKQA/exec?sheet=TrxPemesanan';
  let rowTrxPemesanan = [];
  let dataStok = [];

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

  function isiDropdownNama() {
    const formData = new FormData();
    formData.append("sheet", "DataPembeli");
    formData.append("action", "read");

    fetch(baseURL, { method: 'POST', body: formData })
      .then(res => res.json())
      .then(data => {
        const select = document.getElementById("Nama");
        if (!select) return;
        select.innerHTML = `<option value="">-- Pilih Nama Pembeli --</option>`;
        data.forEach(row => {
          select.innerHTML += `<option value="${row.Nama}">${row.Nama}</option>`;
        });
      });
  }

  function isiDropdownBlokNomor() {
    const formData = new FormData();
    formData.append("sheet", "DataStok");
    formData.append("action", "read");

    fetch(baseURL, { method: 'POST', body: formData })
      .then(res => res.json())
      .then(data => {
        dataStok = data;
        const select = document.getElementById("BlokNomor");
        if (!select) return;
        select.innerHTML = `<option value="">-- Pilih Blok --</option>`;
        data.forEach(row => {
          if (row.Status?.toLowerCase() === 'tersedia' || !row.Status) {
            select.innerHTML += `<option value="${row.BlokNomor}">${row.BlokNomor}</option>`;
          }
        });
      });

    document.getElementById("BlokNomor").addEventListener("change", function () {
      const blok = this.value;
      const data = dataStok.find(d => d.BlokNomor === blok);
      if (data) {
        document.getElementById("Type").value = data.TypeRuko || "";
        document.getElementById("Ukuran").value = data.Ukuran || "";
        const rawHarga = data.Harga || 0;
        const hargaAngka = typeof rawHarga === 'string'
          ? parseInt(rawHarga.toString().replace(/\D/g, ''))
          : rawHarga;
        document.getElementById("Harga").value = formatRupiah(hargaAngka);

        const hargaAsliInput = document.getElementById("HargaAsli");
        if (hargaAsliInput) hargaAsliInput.value = hargaAngka;
      }
    });
  }

  function resetFormTanpaReload(form) {
    form.reset();
    document.getElementById("No").value = autoGenerateNomor(3);
    document.getElementById("No_CL").value = `${autoGenerateNomor(3)}/CL-PSG/V/2025`;
    document.getElementById("InputBy").value = localStorage.getItem("username") || "admin@email.com";
    document.getElementById("Tanggal").value = new Date().toISOString().split('T')[0];
    isiDropdownNama();
    isiDropdownBlokNomor();
    document.getElementById("Nama")?.focus();
  }

  function handleFormSubmit() {
    const form = document.getElementById("formPemesanan");
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

      const formData = new FormData(form);
      formData.append("action", "save_pemesanan");
      formData.append("sheet", "TrxPemesanan");

      fetch(baseURL, {
        method: "POST",
        body: formData
      })
        .then(res => res.json())
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
        .then(updateRes => updateRes.json())
        .then(updateRes => {
          if (updateRes.status === 'success') {
            alert("✅ Data berhasil disimpan ke TrxPemesanan dan DataStok.");
            resetFormTanpaReload(form);
            window.initTrxPemesananPage();
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

  window.initTrxPemesananPage = function () {
    const tbody = document.querySelector("#TabelPemesanan tbody");
    if (!tbody) return;

    const formData = new FormData();
    formData.append("action", "read_pemesanan");

    fetch(TrxPemesananURL, { method: 'POST', body: formData })
      .then(res => res.text())
      .then(text => {
        try {
          const data = JSON.parse(text);
          if (!Array.isArray(data)) throw new Error("Data bukan array");

          rowTrxPemesanan = data;
          tbody.innerHTML = "";

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
          console.error("❌ Gagal memuat data pemesanan:", err);
          console.warn("Response was:", text);
        }

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

        document.getElementById("No").value = autoGenerateNomor(3);
        document.getElementById("No_CL").value = `${autoGenerateNomor(3)}/CL-PSG/V/2025`;
        document.getElementById("InputBy").value = localStorage.getItem("username") || "admin@email.com";
        document.getElementById("Tanggal").value = new Date().toISOString().split('T')[0];
        document.getElementById("Tanggal").readOnly = true;

        isiDropdownNama();
        isiDropdownBlokNomor();
        handleFormSubmit();

        document.addEventListener("click", function (e) {
          if (e.target.closest(".editBtn")) {
            const index = e.target.closest(".editBtn").dataset.index;
            const data = rowTrxPemesanan[index];
            document.getElementById("editNo").value = data.No;
            document.getElementById("editStatus").value = "Tersedia";
            document.getElementById("editAlasanContainer").style.display = 'none';
            document.getElementById("editAlasan").value = '';
          }
        });

        document.getElementById("formEditStatus").addEventListener("submit", function (e) {
          e.preventDefault();
          if (!confirm("Yakin ingin memperbarui status?")) return;

          const formData = new FormData(this);
          formData.append("action", "edit_status");

          fetch(baseURL, {
            method: "POST",
            body: formData
          })
            .then(res => res.json())
            .then(res => {
              if (res.status === 'success') {
                alert("✅ Status berhasil diperbarui");
                bootstrap.Modal.getInstance(document.getElementById("editModal")).hide();
                window.initTrxPemesananPage();
              } else {
                alert("❌ Gagal update status: " + res.message);
              }
            })
            .catch(err => console.error("❌ Gagal kirim edit:", err));
        });
      })
      .catch(err => console.error('❌ Gagal memuat data pemesanan:', err));
  };
})();
