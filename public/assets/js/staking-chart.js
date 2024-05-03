        var predefinedColors = ["#405189", "#f672a7", "#f1963b", "#0ab39c", "#ff5733", "#33ff57", "#3357ff", "#ff33e6"];
        var donutchartportfolioColors = [];
        var stakeAmounts = [];
        @foreach ($stakingData as $stakings)
            stakeAmounts.push({{ $stakings['stake_amount'] }});
        @endforeach

        var options = {
        series: stakeAmounts,
        labels: stakeAmounts,
        chart: {
            type: "donut",
            height: 224,
        },

        plotOptions: {
            pie: {
            size: 100,
            offsetX: 0,
            offsetY: 0,
            donut: {
                size: "70%",
                labels: {
                show: true,
                name: {
                    show: true,
                    fontSize: "18px",
                    offsetY: -5,
                },
                value: {
                    show: true,
                    fontSize: "20px",
                    color: "#343a40",
                    fontWeight: 500,
                    offsetY: 5,
                    formatter: function (val) {
                    return "$" + val;
                    },
                },
                total: {
                    show: true,
                    fontSize: "12px",
                    label: "Total Stake",
                    color: "#9599ad",
                    fontWeight: 500,
                    formatter: function (w) {
                    return (
                        "DU" +
                        w.globals.seriesTotals.reduce(function (a, b) {
                        return a + b;
                        }, 0).toLocaleString()
                    );
                    },
                },
                },
            },
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        yaxis: {
            labels: {
            formatter: function (value) {
                return "DU" + value;
            },
            },
        },
        stroke: {
            lineCap: "round",
            width: 2,
        },
        colors: donutchartportfolioColors,
        };
        var chart = new ApexCharts(document.querySelector("#portfolio_donut_charts"), options);
        chart.render();
