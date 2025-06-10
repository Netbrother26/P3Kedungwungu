window.initTrxPemesananPage = function () {
  console.log("🔥 initTrxPemesananPage dipanggil");
  initFormPemesanan();
};


(function () {
  const sheetBaseURL = 'https://script.google.com/macros/s/AKfycbxVgwRqAqmKBXnhetkZ2g3JbXofSPFy3oQxh1b9mln1OoinsUzjjoD2Fxf3F6JTKH6ZtA/exec';
  const sheetTrxPemesananURL = `${sheetBaseURL}?sheet=Trxpemesanan`;
  let rowDataStok = [], dataPembeli = [], dataStok = [];

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
    const no = Math.floor(Math.random() * Math.pow(10, length)).toString();
    return no.padStart(length, '0');
  }

  function getStatusBadge(Status) {
    const lower = Status?.toLowerCase() || "";
    if (lower === "booking") return `<span class="badge bg-primary text-white">Booking</span>`;
    if (lower === "terjual") return `<span class="badge bg-danger text-white">Terjual</span>`;
    if (lower === "cancel") return `<span class="badge bg-secondary text-white">Cancel</span>`;
    return `<span class="badge bg-success text-white">Tersedia</span>`;
  }

  function isiDropdownNama() {
    fetch(`${sheetBaseURL}?sheet=DataPembeli`)
      .then(res => res.json())
      .then(data => {
        const select = document.getElementById("Nama");
        if (!select) return;
        select.innerHTML = `<option value="">-- Pilih Nama --</option>`;
        data.forEach(row => {
          if (row.Nama) {
            const option = document.createElement("option");
            option.value = row.Nama;
            option.textContent = row.Nama;
            select.appendChild(option);
          }
        });
      });
  }

  function isiDropdownBlokNomor() {
    fetch(`${sheetBaseURL}?sheet=DataStok`)
      .then(res => res.json())
      .then(data => {
        dataStok = data;
        const select = document.getElementById("BlokNomor");
        if (!select) return;
        select.innerHTML = `<option value="">-- Pilih Blok --</option>`;
        data.forEach(row => {
          if (row.Status?.toLowerCase() === 'tersedia' && row.BlokNomor) {
            const option = document.createElement("option");
            option.value = row.BlokNomor;
            option.textContent = row.BlokNomor;
            select.appendChild(option);
          }
        });
      });
  }

  

  window.initTrxPemesananPage = function () {
    fetch(sheetTrxPemesananURL)
      .then(res => res.json())
      .then(data => {
        rowDataStok = data;
        const tbody = document.querySelector("#TabelPemesanan tbody");
        if (!tbody) return;
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
      })
      .catch(err => console.error('Gagal memuat data:', err));
  };
	

  document.getElementById("BlokNomor").addEventListener("change", function () {
    const blok = this.value;
    const stok = dataStok.find(row => row.BlokNomor === blok);
    if (stok) {
      document.getElementById("Type").value = stok.Type || "";
      document.getElementById("Ukuran").value = stok.Ukuran || "";
      const harga = parseInt((stok.Harga || "0").toString().replace(/\D/g, ""));
      document.getElementById("Harga").value = formatRupiah(harga);
    } else {
      document.getElementById("Type").value = "";
      document.getElementById("Ukuran").value = "";
      document.getElementById("Harga").value = "";
    }
  });

  document.getElementById("formPemesanan").addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = {};
    formData.forEach((val, key) => data[key] = val);
    data.Harga = data.Harga.replace(/[Rp,. ]/g, "") || "0";

    fetch(sheetBaseURL, {
      method: "POST",
      body: JSON.stringify({
        action: "save_pemesanan",
        ...data
      })
    })
      .then(res => res.json())
      .then(res => {
        if (res.status === "success") {
          alert("Pemesanan berhasil disimpan!");
          document.getElementById("formPemesanan").reset();
          initFormPemesanan();
        } else {
          alert("Gagal menyimpan pemesanan.");
        }
      })
      .catch(err => {
        console.error("Error:", err);
        alert("Terjadi kesalahan.");
      });
  });
	
	
	window.initFormPemesanan = function () {
    document.getElementById("No").value = autoGenerateNomor(3);
    document.getElementById("No_CL").value = `${autoGenerateNomor(3)}/CL-PSG/V/2025`;
    document.getElementById("InputBy").value = localStorage.getItem("username") || "admin@email.com";
    document.getElementById("Tanggal").value = new Date().toISOString().split('T')[0];
    isiDropdownNama();
    isiDropdownBlokNomor();
  };
  
  // Jalankan otomatis saat file ini dimuat
  window.addEventListener("load", () => {
  setTimeout(() => {
    if (document.getElementById("formPemesanan")) {
      initFormPemesanan();
    } else {
      console.error("Elemen formPemesanan tidak ditemukan di halaman.");
    }
  }, 30); // beri jeda agar elemen DOM selesai dibuat

	
  });
})();
