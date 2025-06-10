<?php
session_start();
if (!isset($_SESSION['username'])) {
  echo "Akses ditolak. Silakan login.";
  exit;
}
?>


     <!-- Left Panel -->


        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="content mt-3">
		
			
			<div class="col-xl-3 col-lg-6">
                <div class="card text-white bg-flat-color-3" >
                    <div class="card-body">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="ti-user text-light border-light"></i></div>
                            <div class="stat-content dib">
                                <div class="stat-text text-light">Total Pembeli</div>
                                <h2><div id="total-pembeli">Loading...</div></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
			
			<div class="col-xl-3 col-lg-6">
                <div class="card text-white bg-flat-color-1" >
                    <div class="card-body">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="fa fa-home text-light border-light"></i></div>
                            <div class="stat-content dib">
                                <div class="stat-text text-light">Ruko Dipesan</div>
                                <h2><div id="total-booking">Loading...</div></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			

			<div class="col-xl-3 col-lg-6">
                <div class="card text-white bg-flat-color-4" >
                    <div class="card-body">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="fa fa-bar-chart text-light border-light"></i></div>
                            <div class="stat-content dib">
                                <div class="stat-text text-light">Ruko Terjual</div>
                                <h2><div id="total-terjual">Loading...</div></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
			<div class="col-xl-3 col-lg-6">
                <div class="card text-white bg-flat-color-5" >
                    <div class="card-body">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="fa fa-home text-light border-light"></i></div>
                            <div class="stat-content dib">
                                <div class="stat-text text-light">Sisa Ruko</div>
                                <h2><div id="sisa-ruko">Loading...</div></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

			
        </div> <!-- .content -->
    </div><!-- /#right-panel -->

    <!-- Right Panel -->
