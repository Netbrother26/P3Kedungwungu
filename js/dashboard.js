(function () {
  const sheetStatsURL = 'https://script.google.com/macros/s/AKfycbxMbTidfkhOdMWuToBOFfG5q4QM_kml8m5IAzZ-Xz-Np-4z0DKfbvJ1MoONqtJesPTKQA/exec?sheet=pivot';

  window.initDashboardPage = function () {
    loadStats();
    console.log("✅ Halaman Dashboard berhasil diinisialisasi");
  };

  async function loadStats() {
    try {
      const res = await fetch(sheetStatsURL, { cache: "no-store" });
      const data = await res.json();

      const totalPembeli = document.getElementById('total-pembeli');
      const totalBooking = document.getElementById('total-booking');
      const totalTerjual = document.getElementById('total-terjual');
      const sisaRuko = document.getElementById('sisa-ruko');

      if (!totalPembeli || !totalBooking || !totalTerjual || !sisaRuko) {
        console.warn("⚠️ Elemen statistik tidak ditemukan di halaman. Pastikan ID elemen tersedia di HTML:", {
          'total-pembeli': totalPembeli,
          'total-booking': totalBooking,
          'total-terjual': totalTerjual,
          'sisa-ruko': sisaRuko
        });
        return;
      }

      totalPembeli.textContent = data.totalPembeli ?? 'N/A';
      totalBooking.textContent = data.totalBooking ?? 'N/A';
      totalTerjual.textContent = data.totalTerjual ?? 'N/A';
      sisaRuko.textContent = data.sisaRuko ?? 'N/A';
    } catch (error) {
      console.error("Gagal mengambil data statistik:", error);
    }
  }
})();
