<?php
require_once('partials/header.php');
$title = 'Create a PHP/JavaScript/MySQL AJAX Page';
$assignment = getAssignmentByName($title);
?>
<section id="header">
    <div class="container">
        <div class="row d-block">
            <div class="col-12">
                <h1 class="page-title"><?= $title; ?></h1>
                <h3>Due: <?= $assignment['due_date']; ?>, <?= getAssignmentStatus($assignment['due_date']); ?></h3>
            </div>
        </div>
    </div>
</section>
<main id="main">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <canvas id="chart" class="d-none"></canvas>
                <div id="reset" class="text-center d-none">
                    <button onclick="window.location.reload()">Try Again</button>
                </div>
                <div id="resultsLoading" class="text-center d-none">
                    <b>Loading Results...This might take a bit.</b>
                    <div class="loader"></div>
                </div>
                <form id="covidForm" action="ajax.php" method="post">
                    <h3>COVID-19 case tracker</h3>
                    <p>View change in COVID-19 cases over time. Source: <a href="https://covidtracking.com/">COVID Tracking Project</a></p>
                    <label>
                        Select Start Date:
                        <input type="date" id="startDate" name="startDate" min="2020-03-04" value="<?= date('Y-m-d', strtotime("-14 days")); ?>"/>
                    </label>
                    <label>
                        Select End Date:
                        <input type="date" id="endDate" name="endDate" value="<?= date('Y-m-d', strtotime("-1 days")); ?>" max="<?= date('Y-m-d', strtotime("-1 days")); ?>"/>
                    </label>
                    <button type="submit">See results</button>
                </form>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js" integrity="sha512-SuxO9djzjML6b9w9/I07IWnLnQhgyYVSpHZx0JV97kGBfTIsUYlWflyuW4ypnvhBrslz1yJ3R+S14fdCWmSmSA==" crossorigin="anonymous"></script>
                <script>
                let form = document.getElementById('covidForm');
                let reset = document.getElementById('reset');
                let loader = document.getElementById('resultsLoading');
                let chart = document.getElementById('chart');

                async function submitDateRange(url, data) {
                    const response = await fetch(url, {
                        method: 'POST',
                        body: data
                    });
                    return response.json();
                }

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    console.log(e.target.action);
                    const data = new FormData();
                    data.append('startDate', document.getElementById('startDate').value);
                    data.append('endDate', document.getElementById('endDate').value);
                    //Toggle form and loader before processing data
                    form.classList.toggle('d-none');
                    loader.classList.toggle('d-none');
                    submitDateRange(e.target.action, data)
                        .then(function(data) {
                            //Process JSON response for chart
                            let chartData = {
                                dates: [],
                                deaths: [],
                                hospitalized: [],
                                recovered: [],
                                positive: [],
                            };
                            const { stats } = data;
                            for (const record of stats) {
                                chartData.deaths.push(record.deathIncrease);
                                chartData.dates.push(record.date);
                                chartData.hospitalized.push(record.hospitalizedIncrease);
                                chartData.recovered.push(record.recovered);
                                chartData.positive.push(record.positiveIncrease);
                            }
                            return chartData;
                        })
                        .then(function(chartData) {
                            console.log(chartData);
                            //Build simple line chart from processed data
                            const ctx = chart.getContext('2d');
                            let covidChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: chartData.dates,
                                    datasets: [
                                        {
                                            label: 'Increase In Hospitalized Cases',
                                            data: chartData.hospitalized,
                                            borderColor: 'rgb(255,193,7)',
                                            backgroundColor: 'rgb(255,193,7)',
                                            borderWidth: 3,
                                            fill: false
                                        },
                                        {
                                            label: 'Increase in Positive Cases',
                                            data: chartData.positive,
                                            borderColor: 'rgb(23,162,184)',
                                            backgroundColor: 'rgb(23,162,184)',
                                            borderWidth: 3,
                                            fill: false
                                        },
                                        {
                                            label: 'Increase in Fatalities',
                                            data: chartData.deaths,
                                            borderColor: 'rgb(220,53,69)',
                                            backgroundColor: 'rgb(220,53,69)',
                                            borderWidth: 3,
                                            fill: false
                                        }
                                    ]

                                },
                                options: {
                                    responsive: true,
                                    title: {
                                        display: true,
                                        text: `Positive COVID-19 Cases in US over ${chartData.dates.length} days: ${chartData.dates[0]} to ${chartData.dates[chartData.dates.length - 1]}`
                                    },
                                    scales: {
                                        xAxes: [{
                                            display: true,
                                            scaleLabel: {
                                                display: true,
                                                labelString: 'Date'
                                            },
                                        }],
                                        yAxes: [{
                                            display: true,
                                            scaleLabel: {
                                                display: true,
                                                labelString: 'Cases'
                                            },
                                        }]
                                    }
                                }

                            });
                            //Hide Loader
                            loader.classList.toggle('d-none');
                            //Show chart and controls
                            chart.classList.toggle('d-none');
                            reset.classList.toggle('d-none');


                        });

                    console.log(document.getElementById('startDate').value);
                    console.log(document.getElementById('endDate').value);
                })
                </script>
            </div>
        </div>
    </div>
</main>
<section id="files">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Files Used</h3>
            </div>
            <div class="col-12">
                <ol>
                    <li><a href="download.php?file=index.php">index.php</a></li>
                    <li><a href="download.php?file=partials/header.php">header.php</a></li>
                    <li><a href="download.php?file=partials/footer.php">footer.php</a></li>
                    <li><a href="download.php?file=ajax.php">ajax.php</a></li>
                    <li><a href="download.php?file=ajax_form.php">ajax_form.php</a></li>
                    <li><a href="download.php?file=includes/vars.php">vars.php</a></li>
                    <li><a href="download.php?file=includes/JSONAPIrequest.php">JSONAPIrequest.php</a></li>
                    <li><a href="download.php?file=includes/functions.php">functions.php</a></li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section id="projects">
    <div class="container">
        <h2>What I'm Working On</h2>
        <hr/>
        <?php displayAssignments(); ?>
    </div>
</section>
<?php require_once('partials/footer.php'); ?>

