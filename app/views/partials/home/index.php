<?php 
$page_id = null;
$comp_model = new SharedController;
$current_page = $this->set_current_page_link();
?>
<div>
    <div  class="py-5">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <h2 ><center>INFORMASI KUNJUNGAN PASIEN</center></h2>
                </div>
            </div>
        </div>
    </div>
    <div  class="py-3">
        <div class="container">
            <div class="row ">
                <div class="col-sm-9 comp-grid">
                    <div class="text-dark">
                        <?php 
                        $chartdata = $comp_model->barchart_jumlahkunjunganpasien();
                        ?>
                        <div>
                            <h4>JUMLAH KUNJUNGAN PASIEN</h4>
                            <small class="text-muted"></small>
                        </div>
                        <hr />
                        <canvas id="barchart_jumlahkunjunganpasien"></canvas>
                        <script>
                            $(function (){
                            var chartData = {
                            labels : <?php echo json_encode($chartdata['labels']); ?>,
                            datasets : [
                            {
                            label: 'Pasien',
                            backgroundColor:'rgba(0 , 128 , 255, 0.5)',
                            type:'',
                            borderWidth:3,
                            data : <?php echo json_encode($chartdata['datasets'][0]); ?>,
                            }
                            ]
                            }
                            var ctx = document.getElementById('barchart_jumlahkunjunganpasien');
                            var chart = new Chart(ctx, {
                            type:'bar',
                            data: chartData,
                            options: {
                            scaleStartValue: 0,
                            responsive: true,
                            scales: {
                            xAxes: [{
                            ticks:{display: true},
                            gridLines:{display: true},
                            categoryPercentage: 1.0,
                            barPercentage: 0.8,
                            scaleLabel: {
                            display: true,
                            labelString: ""
                            },
                            }],
                            yAxes: [{
                            ticks: {
                            beginAtZero: true,
                            display: true
                            },
                            scaleLabel: {
                            display: true,
                            labelString: ""
                            }
                            }]
                            },
                            }
                            ,
                            })});
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
