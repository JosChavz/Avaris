import ApexCharts from 'apexcharts';

(async function() {
  const getChartOptions = (arr={"": 0}) => {
    const format = (v) => {
      const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        trailingZeroDisplay: 'stripIfInteger',
      });
      return formatter.format(v);
    };

    return {
      series: Object.values(arr).map(s => parseFloat(s)),
      colors: ["#1C64F2", "#16BDCA", "#FDBA8C", "#E74694"],
      chart: {
        height: 320,
        width: "100%",
        type: "donut",
      },
      stroke: {
        colors: ["transparent"],
        lineCap: "",
      },
      plotOptions: {
          pie: {
            donut: {
              labels: {
                show: true,
                name: {
                  show: true,
                  fontFamily: "Inter, sans-serif",
                  offsetY: 20,
                },
                total: {
                  showAlways: true,
                  show: true,
                  label: "Expenses",
                  fontFamily: "Inter, sans-serif",
                  formatter: (v) => {
                    const sum = v.globals.seriesTotals.reduce((partial, a) => partial + a, 0);
                    return format(sum);
                  }
                },
                value: {
                  show: true,
                  fontFamily: "Inter, sans-serif",
                  offsetY: -20,
                  formatter: (v) => format(v),
                },
              },
              size: "80%",
            },
          },
        },
      grid: {
        padding: {
          top: -2,
        },
      },
      labels: Object.keys(arr),
      dataLabels: {
        enabled: false,
      },
      legend: {
        position: "bottom",
        fontFamily: "Inter, sans-serif",
      },
      yaxis: {
        labels: {
        },
      },
      xaxis: {
        labels: {
        },
        axisTicks: {
          show: false,
        },
        axisBorder: {
          show: false,
        },
      },
    }
  }

  if (document.getElementById("donut-chart") && typeof ApexCharts !== 'undefined') {
    // Render a basic view
    const chart = new ApexCharts(document.getElementById("donut-chart"), getChartOptions());
    chart.render();
    try {
      const today = new Date();
      const queryParams = new URLSearchParams({
        month: today.getMonth() + 1,
        year: today.getFullYear(),
      });
      const queryString = queryParams.toString();
      // Gets the split prices from an API
      const id = new URL(document.URL).pathname.split('/').slice(-1)[0];
      // Make the fetch
      const link = `/api/transactions/sum/${id}?${queryString}`;
      const res = await fetch(link);
      const j = await res.json();

      if (Object.keys(j['transactions']).length > 0) {
        // Update with new data
        chart.updateOptions(getChartOptions(j['transactions']));
      }
    } catch(e) {
      console.error("Something went wrong. Defaulting to empty.", e); 
    }
  }
})()
