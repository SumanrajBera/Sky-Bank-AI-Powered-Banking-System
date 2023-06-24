<?php

require('../connection/conn.php');



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <canvas id="myChart1" height="100px" width="400px"></canvas>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var dar = [];
        const depo = [];
        const trans = [];
        <?php
        $graphQuery = "SELECT * FROM graph WHERE acc = 'SKYBNK00002'";
        $res = mysqli_query($conn, $graphQuery);
        $count = mysqli_num_rows($res);

        if ($count > 0) {

            while ($graph = mysqli_fetch_assoc($res)) {
        ?>
                dar.push((<?php echo  json_encode($graph["date"]); ?>));
                depo.push(<?php echo  $graph["depo"]; ?>);
                trans.push(<?php echo  $graph["trans"]; ?>)
        <?php
            }

            echo "
            const ctx = document.getElementById('myChart1').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dar,
                    datasets: [{
                        label: 'Savings',
                        data: depo,
                        backgroundColor: 'rgba(144,238,145,0.4)',
                        borderColor: 'rgb(0,255,0)',
                        tension: 0.1,
                        borderWidth: 1.5,
                        fill: true
                    }, {
                        label: 'Transaction',
                        data: trans,
                        backgroundColor: 'rgba(193, 100, 104,0.4)',
                        borderColor: 'rgb(250, 110, 110)',
                        borderWidth: 1.5,
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                    plugins: {
                        filler: {
                            propagate: false,
                        },
                        title: {
                            display: true,
                        }
                    },
                    interaction: {
                        intersect: false,
                    }
                }
            });
        ";
        } else {
            echo "
        const ctx = document.getElementById('myChart1').getContext('2d');
        ctx.font = '20px Arial';
        ctx.fillText('No information to display', 10,30);
        ";
        }

        ?>
    </script>
</body>

</html>