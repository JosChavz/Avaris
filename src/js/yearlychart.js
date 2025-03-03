import ApexCharts from 'apexcharts';

(async function() {
const options = {
  series: [
    {
        name: "Expense",
        data: [1500, 1418, 1456, 1526, 1356, 1256],
        color: "#1A56DB",
      },
    {
        name: "Income",
        data: [643, 413, 765, 412, 1423, 1731],
        color: "#7E3BF2",
      },
  ],
  chart: {
    height: "100%",
    maxWidth: "100%",
    type: "area",
    fontFamily: "Inter, sans-serif",
    dropShadow: {
        enabled: false,
      },
    toolbar: {
        show: false,
      },
  },
  tooltip: {
    enabled: true,
    x: {
        show: false,
      },
  },
  legend: {
    show: true 
  },
  fill: {
    type: "gradient",
    gradient: {
        opacityFrom: 0.55,
        opacityTo: 0,
        shade: "#1C64F2",
        gradientToColors: ["#1C64F2"],
      },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    width: 6,
  },
  grid: {
    show: false,
    strokeDashArray: 4,
    padding: {
        left: 2,
        right: 2,
        top: 0
      },
  },
  xaxis: {
    show: true,
    categories: ['01 February', '02 February', '03 February', '04 February', '05 February', '06 February', '07 February'],
    labels: {
        show: false,
      },
    axisBorder: {
        show: false,
      },
    axisTicks: {
        show: false,
      },
  },
  yaxis: {
    show: true,
    labels: {
        formatter: function (value) {
              return '$' + value;
            }
      }
  },
}

  const getMonthlyExpenseSummations = async () => {
    const date = new Date();
    const year = date.getFullYear();
    const months = [];
    const monthSum = [];
    const getMonthSum = async (month) => {
      try {
        const today = new Date();
        const queryParams = new URLSearchParams({
          month: month,
          year: today.getFullYear(),
        });
        const queryString = queryParams.toString();
        // Make the fetch
        const link = `/api/transactions/sum?${queryString}`;
        const res = await fetch(link);
        const j = await res.json();
      } catch(e) {
        console.error("Something went wrong. Defaulting to empty.", e); 
      }
    }
    for (let i = 0; i < date.getMonth(); i += 1) {
      const currDate = new Date(year, i, 1);
      months.push(date.toLocaleString('default', { month: 'long' }));
    }

  }

  if (document.getElementById("yearly-chart") && typeof ApexCharts !== 'undefined') {
    const chart = new ApexCharts(document.getElementById("yearly-chart"), options);
    chart.render();


    chart.updateOptions(getChartOptions(j['transactions']['total']));
  }
})();
