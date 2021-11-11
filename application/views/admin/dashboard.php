<?php
    // echo "<pre/>";
    // print_r($graph_data);
    // die();
    
    $avg_pro = 0;
   
    if(!empty($graph_data)){
        $graph_data = array_reverse($graph_data);
        $avg_labels = array();
        $avg_data = array();

        $profit = 0;
        $count = 0;
        
        foreach($graph_data as $gdata){
            if($gdata['month'] != ""){
                if($gdata['profit'] != "0.00"){
                    array_push($avg_labels,$gdata['month']);
                    array_push($avg_data,$gdata['profit']);
                    $count++;
                    $profit += $gdata['profit'];
                }
            }
            
        }
        $avg_pro = $profit/$count;
        $avg_labels = "'".implode("', '", $avg_labels)."'";
    }

    // if(!empty($graph_data_revenue)){
    //     $graph_data_rev = array_reverse($graph_data_revenue);
    //     $avg_labels_rev = array();
    //     $revenue_data = array();
    //     foreach($graph_data_rev as $gdata){
    //         array_push($avg_labels_rev,$gdata['day']);
    //         $data = $gdata['AVG(`OrderTotal__Amount`)'] * $gdata['count(*)'];
    //         array_push($revenue_data,$data);
    //     }
    //     $revenue_labels = "'".implode("', '", $avg_labels_rev)."'";
    // }else{    // helpful for local view
    //     $revenue_labels = "'2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th', '12th'";
    //     $revenue_data = array(30, 60, 40, 50, 40, 55, 85, 65, 75, 50, 70);      
    // }
    
    $store_rev = array();
    if(!empty($graph_data_revenue)){
        foreach($graph_data_revenue as $graph_data){
            $store_rev[$graph_data['name']][]  = $graph_data;      
        }
    }else{    // helpful for local view
        $revenue_labels = "";
        $revenue_data = array();      
    }

    $avg_labels_rev = array();

    $temp = array();

    for($i=14; $i >= 0 ; $i--){
        $avg_labels_rev[] = date('jS',strtotime("-".$i." days"));
        $temp[] = date('jS',strtotime("-".$i." days"));
    }

    $revenue_labels = "'".implode("', '", $avg_labels_rev)."'";
    $temp_store = array();

    foreach($store_rev as $key => $datas){
        foreach($datas as $data){
            foreach($temp as $t){
                if($data['day'] == $t){
                    $temp_store[$key][$t] = round($data['AVG(`OrderTotal__Amount`)'] * $data['count(*)'],2) > 0 ? round($data['AVG(`OrderTotal__Amount`)'] * $data['count(*)'],2) : 0;
                }elseif(isset($temp_store[$key][$t]) && $temp_store[$key][$t] != 0){
                }else{
                    $temp_store[$key][$t] = 0;
                }
            }
        }
    }
    
    // echo "<pre>";
    // print_r($temp_store); exit;

    $string = "[";
    $i = 0;
    foreach($temp_store as $key => $st){
        // echo "<pre>";
        // print_r(json_encode(array_values($st))); exit;
        $backgroundColor =  "#".str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT).str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT).str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
        if($i != 0){
            $string .= ",";
        }
        $string .= "{label: '".$key."',data: ".json_encode(array_values($st)).",borderColor: '".$backgroundColor."',fill: false}";
        
        $i++;
    }
    $string .= "]";
    


    $revenue_data =  $string; 

?>
<link href="<?php echo BACKEND; ?>assets/css/datepicker.css" rel="stylesheet" />
<div class="card">
    <div class="card-body">
        <form action="javascript:void(0);" method="post" name="extrasearchForm" id="extrasearchForm">
            <div class="form-row"> 
                <div class="form-group col-md-2">
                    <label class="font-weight-semibold">Start Date</label>
                    <input type="text" id="StartDate" name="StartDate" class="form-control datepicker" placeholder="" style="padding: .55rem 1rem" />
                </div>
                <div class="form-group col-md-2">
                    <label class="font-weight-semibold">End Date</label>
                    <input type="text" id="EndDate" name="EndDate" class="form-control datepicker" placeholder="" style="padding: .55rem 1rem" />
                </div>

                <div class="col-md-4" style="margin-top: 28px;">
                    <div class="form-row align-items-center">
                        <button class="btn btn-primary mr-2" onclick="searchFilter()">Search</button>
                        
                        <a href="<?=ADMIN_LINK; ?>dashboard"><i class="far fa-sync-alt"></i> Refresh</a>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
</div>

<div class="row">
   <div class="col-md-6 col-lg-3">
        <div class="card top-list">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="m-b-0">Total Stores</p>
                        <h2 class="m-b-0">
                                <span id="total_order"><?= isset($total_stores) ? $total_stores : '0'; ?></span>    
                        </h2>
                    </div>
                    <div class="avatar avatar-icon avatar-lg avatar-blue">
                        <i class="far fa-store"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card top-list">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="m-b-0">Total Unshipped Orders</p>
                        <h2 class="m-b-0">
                            <span id="unshipped_order"><?= isset($total_unshipped_orders) ? $total_unshipped_orders : '0'; ?></span>
                        </h2>
                    </div>
                    <div class="avatar avatar-icon avatar-lg avatar-cyan">
                        <i class="fal fa-money-bill-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card top-list">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="m-b-0" id="daycount">Pending Orders (Last 30 days)</p>
                        <h2 class="m-b-0">
                            <span id="pending_order"><?= isset($total_pending_orders) ? $total_pending_orders : '0'; ?></span>
                        </h2>
                    </div>
                    <div class="avatar avatar-icon avatar-lg avatar-red">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card top-list">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="m-b-0">Month to Date</p>
                        <h2 class="m-b-0">
                            <span id="Month_to_Date"><?= isset($total_month_to_orders) ? $total_month_to_orders : '0'; ?></span>
                        </h2>
                    </div>
                    <div class="avatar avatar-icon avatar-lg avatar-gold">
                        <i class="fas fa-globe-europe"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
                            <button class="btn btn-primary" id="btn-profit-download">Download</button>
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
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Total Revenue</h5>
                    <button class="btn btn-primary" id="btn-revenue-download">Download</button>
                    
                    <!-- <div>
                        <div class="btn-group">
                            <button class="btn btn-default active">
                                <span>Month</span>
                            </button>
                            <button class="btn btn-default">
                                <span>Year</span>
                            </button>
                        </div>
                    </div> -->
                </div>
                <div class="m-t-50" style="height: 330px">
                    <canvas class="chart" id="revenue-chart"></canvas>
                </div>
                <div class="ml-auto mr-auto d-block center mt-2" style="text-align: center;">
                    <button class="btn btn-primary" id="toggle">Select/Unselect All</button>
                </div>
            </div>
        </div>
    </div>    
</div>
<script src="<?php echo BACKEND; ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo BACKEND; ?>assets/js/Chart.min.js"></script>
<script type="text/javascript">
    $(".datepicker").datepicker({ 
        autoclose: true, 
        todayHighlight: true
    }).datepicker('update', new Date());

    function searchFilter() 
    {
        $.ajax({
            type : 'POST',
            url : '<?php echo ADMIN_LINK ?>User/filter/',
            data:  $('#extrasearchForm').serialize(),
            dataType: "json",
            success:function(data) 
            {
                $("#unshipped_order").html(data.total_unshipped_orders);
                $("#total_order").html(data.total_stores);
                $("#pending_order").html(data.total_pending_orders);
                $("#Month_to_Date").html(data.total_month_to_orders);
                $("#daycount").html("Pending Orders (Last "+data.day_diff+" days)");
            }
        });
    }


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

    $('#btn-profit-download').on('click', function() {
        // Trigger the download
        var a = document.createElement('a');
        a.href = myAvgChart.toBase64Image();
        a.download = 'ProfitShare_<?php echo date("YmdHis"); ?>.png';
        a.click();
    }); 

    var myRevenueChart = new Chart(document.getElementById("revenue-chart").getContext('2d'), {
        type: 'line',
        data: {
          labels: [<?php echo $revenue_labels; ?>],
          datasets: <?php echo $revenue_data; ?>
        },
        interaction: {
          mode: 'index',
          intersect: true
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
            
            ticks: { min: 0 },
              x: {
                display: true,
                title: {
                  display: false,
                }
              },
              y: {
                display: true,
                title: {
                  display: false,
                },
                beginAtZero: true
              }           
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

    $('#btn-revenue-download').on('click', function() {
        // Trigger the download
        var a = document.createElement('a');
        a.href = myRevenueChart.toBase64Image();
        a.download = 'Revenue_<?php echo date("YmdHis"); ?>.png';
        a.click();
    });

    $("#toggle").click(function() {
         myRevenueChart.data.datasets.forEach(function(ds) {
        ds.hidden = !ds.hidden;
      });
      myRevenueChart.update();
    });
</script>

