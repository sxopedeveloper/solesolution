<?php
    $revenue_labels = '';
    $revenue_data = array();

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

<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Total Revenue</h5>
                    <button class="btn btn-primary" id="btn-download">Download</button>
                </div>
                <div class="m-t-50" style="height: 330px">
                    <canvas class="chart" id="revenue-chart"></canvas>
                </div>
            </div>
        </div>
    </div>    
</div>
<script src="<?php echo BACKEND; ?>assets/js/Chart.min.js"></script>
<script type="text/javascript">
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
    
    //  var myRevenueChart = new Chart(document.getElementById("revenue-chart").getContext('2d'), {
    //     type: 'line',
    //     data: {
    //       labels: ['14th', '16th', '17th', '19th'],
    //       datasets: [{
    //         label: 'Revenue',
    //         data: [5.97,5.31,21.08,10.3], 
    //         borderColor: '#1067ee',
    //         backgroundColor: '#FFF',
    //         fill: false
    //       },{
    //         label: 'Revenue',
    //         data: [4,6,25,11], 
    //         borderColor: '#1067ee',
    //         backgroundColor: '#FFF',
    //         fill : false
    //       },{
    //         label: 'Revenue',
    //         data: [3,7,24,12], 
    //         borderColor: '#1067ee',
    //         backgroundColor: '#FFF',
    //         fill: false
    //       },{
    //         label: 'Revenue',
    //         data: [2,8,23,15], 
    //         borderColor: '#1067ee',
    //         backgroundColor: '#FFF',
    //         fill : false
    //       }]
    //     },
    //     interaction: {
    //       mode: 'index',
    //       intersect: false
    //     },
    //     options: {
    //         responsive: true,
    //         maintainAspectRatio: false,
    //         scales: {
    //           x: {
    //             display: true,
    //             title: {
    //               display: false,
    //             }
    //           },
    //           y: {
    //             display: true,
    //             title: {
    //               display: false,
    //             }
    //           }/*,
    //             xAxes: [{
    //                 gridLines: {
    //                     display:true, 
    //                     color: "#ccc",
    //                 }
    //             }],
    //             yAxes: [{
    //                 gridLines: {
    //                     display:true, 
    //                     color: "#ccc",
    //                 }   
    //             }]  */            
    //         },
    //         plugins: {
    //             legend: {
    //                 display: false
    //             },
    //             title: {
    //                 display: false,
    //                 //text: 'Custom Chart Title'
    //             }

    //         }

    //     }
    // });    

    $('#btn-download').on('click', function() {
        // Trigger the download
        var a = document.createElement('a');
        a.href = myRevenueChart.toBase64Image();
        a.download = 'Revenue_<?php echo date("YmdHis"); ?>.png';
        a.click();
    });
</script>