// Statistik siswa per tahun
$(function () {
    var options = {
        chart: {
            type: "bar",
            toolbar: { show: false },
            width: "100%",
        },
        series: [
            {
                name: "Jumlah Siswa",
                data: [30, 40, 35, 50, 49, 60, 70, 91, 125],
            },
        ],
        xaxis: {
            categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999],
        },
    };

    var chart = new ApexCharts(
        document.querySelector("#statistik_siswa"),
        options
    );

    chart.render();
});

$(function () {
    // var options = {
    //     series: [44, 55],
    //     // name: 'Jumlah Siswa',
    //     chart: {
    //         width: 380,
    //         type: "pie",
    //     },
    //     plotOptions: {
    //       pie: {
    //         dataLabels: {
    //         //   offset: -10,
    //         formatter: function(value, { seriesIndex, dataPointIndex, w }) {
    //             return w.config.series[seriesIndex].name + ":  " + value
    //           }
    //         }, 
    //       }
    //     },
    //     labels: ["Guru", "BK"],
    //     responsive: [
    //         {
    //             breakpoint: 480,
    //             options: {
    //                 chart: {
    //                     width: 200,
    //                 },
    //                 legend: {
    //                     position: "bottom",
    //                 },
    //             },
    //         },
    //     ],
    // };

    // var statistik_user = new ApexCharts(
    //     document.querySelector("#statistik_user"),
    //     options
    // );
    // statistik_user.render();
    var options = {
        chart: {
          width: 380,
          type: 'pie',
        },
        labels: [
          'Guru',
          'BK',
        ],
        series: [202, 80],
        dataLabels: {
          formatter: function (val, opts) {
              return opts.w.config.series[opts.seriesIndex]
          },
        },
      }
  
      var chart = new ApexCharts(
        document.querySelector("#statistik_user"),
        options);
      chart.render();
  
});
