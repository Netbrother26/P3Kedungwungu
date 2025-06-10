document.addEventListener("DOMContentLoaded", function () {
  // Cache untuk script yang sudah dimuat
  const loadedScripts = new Set();

	  function bindMenuClick(menuId, pageUrl, scriptPath, initFunctionName) {
	  const menu = document.getElementById(menuId);
	  if (menu) {
		menu.addEventListener("click", function () {
		  loadPage(pageUrl, function () {
			// Hapus script lama jika sudah ada
			const existingScript = document.querySelector(`script[src="${scriptPath}"]`);
			if (existingScript) {
			  existingScript.remove();
			}

			// Tambahkan script baru
			const script = document.createElement("script");
			script.src = scriptPath;
			script.onload = () => {
			  if (typeof window[initFunctionName] === "function") {
				window[initFunctionName]();
			  }
			};
			document.body.appendChild(script);
		  });
		});
	  }
	}



  // Bind menu navigasi
  bindMenuClick("Home", "dashboard.php", "js/dashboard.js", "initDashboardPage");
  bindMenuClick("StokRuko", "DataStok.php", "js/datastok.js", "initDataStokPage");
  bindMenuClick("menu-pembeli", "DataPembeli.php", "js/datapembeli.js", "initPembeliPage");
  bindMenuClick("TrxPemesanan", "TrxPemesanan.php", "js/TrxPemesanan.js", "initTrxPemesananPage", "initFormPemesanan");
  bindMenuClick("TrxPenjualan", "tes.php", "js/TrxPenjualan.js", "initTrxPenjualanPage");

  // Optional: load default halaman saat awal buka
  loadPage("dashboard.php", function () {
    const script = document.createElement("script");
    script.src = "js/dashboard.js";
    script.onload = () => {
      if (typeof window.initDashboardPage === "function") {
        window.initDashboardPage();
      }
    };
    document.body.appendChild(script);
    loadedScripts.add("js/dashboard.js");
  });
});
