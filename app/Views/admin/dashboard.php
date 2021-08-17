<?= $this->extend('admin/layouts/index') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
	<!-- Small boxes (Stat box) -->
	<div class="row">
	  <div class="col-lg-3 col-6">
	    <!-- small box -->
	    <div class="small-box bg-info">
	      <div class="inner">
	        <h3 id="label_dashboard_cashiers_temp">0</h3>

	        <p>Kasir</p>
	      </div>
	      <div class="icon">
	        <i class="fas fa-cash-register"></i>
	      </div>
	      <a href="<?php echo site_url('admin/cashiers') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
	    </div>
	  </div>
	  <!-- ./col -->
	  <div class="col-lg-3 col-6">
	    <!-- small box -->
	    <div class="small-box bg-success">
	      <div class="inner">
	        <h3 id="label_dashboard_cashiers">0<sup style="font-size: 20px"></sup></h3>

	        <p>Riwayat Penjualan Perbulan</p>
	      </div>
	      <div class="icon">
	        <i class="fas fa-book"></i>
	      </div>
	      <a href="<?php echo site_url('admin/history') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
	    </div>
	  </div>
	  <!-- ./col -->
	  <div class="col-lg-3 col-6">
	    <!-- small box -->
	    <div class="small-box bg-warning">
	      <div class="inner">
	        <h3  id="label_dashboard_products">0</h3>

	        <p>Produk</p>
	      </div>
	      <div class="icon">
	        <i class="far fa-list-alt"></i>
	      </div>
	      <a href="<?php echo site_url('admin/master_data/products') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
	    </div>
	  </div>
	  <!-- ./col -->
	  <div class="col-lg-3 col-6">
	    <!-- small box -->
	    <div class="small-box bg-danger">
	      <div class="inner">
	        <h3  id="label_dashboard_units">0</h3>

	        <p>Satuan</p>
	      </div>
	      <div class="icon">
	        <i class="far fa-bookmark"></i>
	      </div>
	      <a href="<?php echo site_url('admin/master_data/units') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
	    </div>
	  </div>
	  <!-- ./col -->
	</div>
	<!-- /.row -->
	<!-- Main row -->
	<div class="row">
	  <!-- Left col -->
	  <section class="col-lg-12 connectedSortable">
	    

	    <!-- DIRECT CHAT -->
		<div class="card bg-gradient-info">
		  <div class="card-header border-0">
		    <h3 class="card-title">
		      <i class="fas fa-th mr-1"></i>
		      Grafik Penjualan
		    </h3>

		    <div class="card-tools">
		      <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
		        <i class="fas fa-minus"></i>
		      </button>
		      <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
		        <i class="fas fa-times"></i>
		      </button>
		    </div>
		  </div>
		  <div class="card-body">
		    <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 400px; max-width: 100%;"></canvas>
		  </div>
		  <!-- /.card-body -->
		  <!-- /.card-footer -->
		</div>
	    <!-- /.card -->
	  </section>
	  <!-- /.Left col -->
	  <!-- right col (We are only adding the ID to make the widgets sortable)-->
	  <section class="col-lg-5 connectedSortable">


	  </section>
	  <!-- right col -->
	</div>
	<!-- /.row (main row) -->
	</div><!-- /.container-fluid -->

<script type="text/javascript">
$(document).ready(function() {
	getTotalDashboard();	
	getChart();
})

function getChart(){
	$.get("<?php echo base_url('admin/dashboard/getChart')?>",function(response){
		const res = JSON.parse(response)		
		if(res.message){
			console.log(res.message)
			var chartColors = {
			  red: 'rgb(255, 99, 132)',
			  orange: 'rgb(255, 159, 64)',
			  yellow: 'rgb(255, 205, 86)',
			  green: 'rgb(75, 192, 192)',
			  blue: 'rgb(54, 162, 235)',
			  purple: 'rgb(153, 102, 255)',
			  grey: 'rgb(231,233,237)'
			};
			var randomScalingFactor = function() {
			  return (Math.random() > 0.5 ? 1.0 : -1.0) * Math.round(Math.random() * 100);
			}
			var tanggal = [];
			var nilai = [];
			for(i=1;i<=30;i++){
				tanggal.push(i)
				nilai.push(randomScalingFactor())
			}

			var config = {
			  type: 'line',
			  data: {
			    labels: res.message.tanggal,
			    datasets: [{
			      label: "Penjualan Bulan <?php echo date('M Y')?>",
			      backgroundColor: chartColors.red,
			      borderColor: chartColors.red,
			      data: res.message.nilai,
			      fill: false,
			    }]
			  },
			  options: {
			    responsive: true,
			    tooltips: {
			      mode: 'label',
			    },
			    hover: {
			      mode: 'nearest',
			      intersect: true
			    },
			    scales: {
			      xAxes: [{
			        display: true,
			        scaleLabel: {
			          display: true,
			          labelString: 'Month'
			        }
			      }],
			      yAxes: [{
			        display: true,
			        scaleLabel: {
			          display: true,
			          labelString: 'Value'
			        }
			      }]
			    }
			  }
			};


			var ctx = document.getElementById("line-chart").getContext("2d");
			window.myLine = new Chart(ctx, config);
		}
	})
}
function getTotalDashboard(){
	$.get("<?php echo base_url('admin/dashboard/getTotalDashboard')?>",function(response){
		const res = JSON.parse(response)
		if(res.status){
			$("#label_dashboard_products").html(res.message.totalProducts)
			$("#label_dashboard_units").html(res.message.totalUnits)
			$("#label_dashboard_cashiers_temp").html(res.message.totalCashiersTemp)
			$("#label_dashboard_cashiers").html(res.message.totalCashiers)
		}	
	})
}
</script>
<?= $this->endSection() ?>