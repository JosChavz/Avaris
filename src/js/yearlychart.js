import ApexCharts from 'apexcharts';

(async function() {
  const getChartOptions = (monthlySummations= {expense: [], income: []} ) => {
    console.log('monthly summation', monthlySummations);
    return {
      series: [
        {
          name: "Expense",  
          data: monthlySummations['expense'],
          color: "#1A56DB",
        },
        {
          name: "Income",
          data: monthlySummations['income'],
          color: "#54db1a",
        }
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
        categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
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
    };
  }

  if (document.getElementById("yearly-chart") && typeof ApexCharts !== 'undefined') {
    const chart = new ApexCharts(document.getElementById("yearly-chart"), getChartOptions());
    await chart.render();

    const getMonthlySummations = async () => {
        const date = new Date();
        const year = date.getFullYear();
        const months = [];
        const monthSumPromises = [];
        const getMonthSum = async (month) => {
          try {
            // expense = number ; income = number ;
            const summations = {};

            const today = new Date();
            const queryParams = new URLSearchParams({
              month: month,
              year: today.getFullYear(),
            });
            const queryString = queryParams.toString();

            const expenseLink = `/api/transactions/sum?${queryString}`;
            const expenseRes = await fetch(expenseLink);

            const incomeLink = `/api/transactions/income?${queryString}`;
            const incomeRes = await fetch(incomeLink);

            summations['expense'] = await expenseRes.json();
            summations['income'] = await incomeRes.json();

            return summations;
          } catch(e) {
            console.error("Something went wrong. Defaulting to empty.", e); 
          }

          return undefined;
        }

        for (let i = 0; i <= date.getMonth(); i += 1) {
          const currDate = new Date(year, i, 1);
          months.push(date.toLocaleString('default', { month: 'long' }));
          monthSumPromises.push(getMonthSum(i+1));
        }

        return await Promise.all(monthSumPromises);
      }

      getMonthlySummations().then((d) => {
        const monthlySums = {
          expense: d.map((d) => d.expense['transactions']['total']),
          income: d.map((d) => d.income['sum']),
        };
        chart.updateOptions(getChartOptions(monthlySums));
      }).catch((e) => console.error(e));
  }
})();
