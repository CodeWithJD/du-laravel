// Total Portfolio Donut Charts
var donutchartportfolioColors = ["#405189", "#f672a7", "#f1963b", "#0ab39c"];
var options = {
  series: [3435.00, 4235.00, 3135.00, 2445.00],
  labels: ["Du 3435", "Du 4235", "Du 3135", "Du 2445"],
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
                }, 0)
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



// Distributed Columns Charts
var chartColumnDistributedColors = ['#3577f1', '#405189', '#6559cc', '#f672a7', '#f06548', '#f1963b', '#f7b84b', '#0ab39c', '#02a8b5', '#299cdb', '#f672a7', '#6559cc']; // Random colors
var options = {
  series: [{
    data: [21, 22, 10, 28, 16, 21, 13, 30, 16, 21, 13, 30],
    
  }],
  chart: {
    height: 250,
    type: 'bar',
    events: {
      click: function (chart, w, e) {
        // console.log(chart, w, e)
      }
    },
    toolbar: {
      show: false // Disable toolbar
    }
  },
  colors: chartColumnDistributedColors,
  plotOptions: {
    bar: {
      columnWidth: '50%',
      distributed: true,
    }
  },
  dataLabels: {
    enabled: false
  },
  legend: {
    show: false
  },
  xaxis: {
    categories: [
      ['L1'],
      ['L2'],
      ['L3'],
      ['L4'],
      ['L5'],
      ['L6'],
      ['L7'],
      ['L8'],
      ['L9'],
      ['L10'],
      ['L11'],
      ['L12'],
    ],
    labels: {
      style: {
        colors: chartColumnDistributedColors,
        fontSize: '12px'
      }
    }
  }
};

var chart = new ApexCharts(document.querySelector("#column_distributed"), options);
chart.render();


document.addEventListener("DOMContentLoaded", function() {
  counter();
});

function counter() {
  var counter = document.querySelectorAll(".counter-value");
  var speed = 250; // The lower the slower
  counter &&
      Array.from(counter).forEach(function(counter_value) {
          function updateCount() {
              var target = +counter_value.getAttribute("data-target");
              var count = +counter_value.innerText;
              var inc = target / speed;
              if (inc < 1) {
                  inc = 1;
              }
              // Check if target is reached
              if (count < target) {
                  // Add inc to count and output in counter_value
                  counter_value.innerText = (count + inc).toFixed(0);
                  // Call function every ms
                  setTimeout(updateCount, 1);
              } else {
                  counter_value.innerText = numberWithCommas(target);
              }
              numberWithCommas(counter_value.innerText);
          }
          updateCount();
      });

  function numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
}