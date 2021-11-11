<?php
    // $avg_labels = "'January', 'February', 'March'";
    // $avg_data = array(12,35,36);

    $avg_pro = 0;
    if(!empty($graph_data)){
        $graph_data = array_reverse($graph_data);
        $avg_labels = array();
        $avg_data = array();

        $profit = 0;
        $count = 0;
        foreach($graph_data as $gdata){
            array_push($avg_labels,$gdata['month']);
            array_push($avg_data,$gdata['profit']);
            $count++;
            $profit += $gdata['profit'];
        }
        $avg_pro = $profit/$count;
        $avg_labels = "'".implode("', '", $avg_labels)."'";
    }
?>

<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="m-b-0" id="avg-profit-amount">$<?php echo number_format($avg_pro,2); ?></h2>
                        <p class="m-b-0 text-muted">Avg.Profit</p>
                    </div>
                    <div>
                        <span class="font-size-12">
                            <!-- <span class="font-weight-semibold m-l-5" id="avg-profit-percent">+5.7%</span> -->
                            <button class="btn btn-primary" id="btn-download">Download</button>
                        </span>
                    </div>
                </div>
                <div class="m-t-50" style="height: 375px">
                     <canvas class="chart" id="avg-profit-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo BACKEND; ?>assets/js/Chart.min.js"></script>
<script type="text/javascript">

    var myAvgChart = new Chart(document.getElementById("avg-profit-chart").getContext('2d'), {
        type: 'bar',
        data: {
          labels: [<?php echo $avg_labels; ?>],
          datasets: [{
            label: 'Avg. Profit',
            data: [<?php echo implode(',', $avg_data); ?>], 
            backgroundColor: '#1067ee',
          }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }], 
                xAxes: [{
                    barPercentage: 0.2
                }]                    
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: false,
                    //text: 'Custom Chart Title'
                }

            }

        }
    });    

    $('#btn-download').on('click', function() {
        // Trigger the download
        var a = document.createElement('a');
        a.href = myAvgChart.toBase64Image();
        a.download = 'ProfitShare_<?php echo date("YmdHis"); ?>.png';
        a.click();
    });	
</script>