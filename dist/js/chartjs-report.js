

var ra = document.getElementById("reportAffiliate");
var rpa = document.getElementById("reportProdukAffiliate");
var rds = document.getElementById("reportDropship");

var myChart = new Chart(ra, {
  type: 'line',
  data: {
    labels: [],
    datasets: [{
      data: [],
      borderWidth: 3,
      borderColor:'#FFE5B4',
      label: '',
      fill: false,
      tension: 0.1
    },{
      data: [],
      borderWidth: 3,
      borderColor:'#FF9400',
      label: '',
      fill: false,
      tension: 0.1
    }]
  },
  options: {
    responsive: true,
    title: {
      display: true,
      text: "Grafik Affiliate",
    },
 
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true,
        }
      }]
    }
  }
});
function downloadReports(a, k, t){
  var filename = 'Laporan - '+ k +' antara tanggal ' + t + '.csv';
  var blob=new Blob([a]);
  var link=document.createElement('a');
  link.href=window.URL.createObjectURL(blob);
  link.download=filename;
  link.click();
}
function ssReportOrdersAffiliate(download = false){
  $('.loadingchart').show();
  var ajaxType = 'ajaxReportOrdersAffiliate';
  if (download == true) {
    ajaxType = 'ajaxDownloadReportOrdersAffiliate';
  }
  $.ajax({
    type: 'POST',
    url: hostServer+"ajax/post",
    data: {
      "ajaxType":ajaxType,
      "id_komunitas":$('#komunitas').val(),
      "dateRange":$('#reservation').val(),
    },
    success: function(a) {
      if (download == false) {
        var xValues = null;
        var yValues = null;
        var rValues = null;
        
        yValues = JSON.parse(a).all.split(',');
        xValues = JSON.parse(a).tgl.split(',');
        rValues = JSON.parse(a).conv.split(',');

        let i = 0;
        while (i < xValues.length) {
          myChart.data.labels.push(xValues[i]);
          i++;
        }
        let ix = 0;
        myChart.data.datasets[0].label = 'Lead';
        while (ix < yValues.length) {
          myChart.data.datasets[0].data.push(yValues[ix]);
          ix++;
        }

        // conversion
        let ix2 = 0;
        myChart.data.datasets[1].label = 'Konversi';
        while (ix2 < rValues.length) {
          myChart.data.datasets[1].data.push(rValues[ix2]);
          ix2++;
        }
        myChart.update();
      }else{
        downloadReports(a, 'Affiliate Koomuntias '+$('#komunitas option:selected').text(), $('#reservation').val());
      }
      $('.loadingchart').hide();
      // batas success ajax
    }
  });
}
// batas produk aff
var myChartRpa = new Chart(rpa, {
  type: 'bar',
  data: {
    labels: [],
    datasets: [{
      data: [],
      borderWidth: 3,
      borderColor:'#FFE5B4',
      label: '',
      fill: false,
      tension: 0.1
    },{
      data: [],
      borderWidth: 3,
      borderColor:'#FF9400',
      label: '',
      fill: false,
      tension: 0.1
    }]
  },
  options: {
    responsive: true,
    title: {
      display: true,
      text: "Grafik Affiliate Produk ",
    },
 
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true,
        }
      }]
    }
  }
});
function ssReportOrdersProdukAffiliate(download = false){
  $('.loadingchart').show();
  var ajaxType = 'ajaxReportOrdersProdukAffiliate';
  if (download == true) {
    ajaxType = 'ajaxDownloadReportOrdersProdukAffiliate';
  }
  $.ajax({
    type: 'POST',
    url: hostServer+"ajax/post",
    data: {
      "ajaxType":ajaxType,
      "id_komunitas":$('#komunitas_produk_affiliate').val(),
      "dateRange":$('#reservation_produk_affiliate').val(),
    },
    success: function(a) {
      if(download == false){
        var xValues = null;
        var yValues = null;
        var rValues = null;
        
        yValues = JSON.parse(a).all.split(',');
        xValues = JSON.parse(a).tgl.split(',');
        rValues = JSON.parse(a).conv.split(',');

        let i = 0;
        while (i < xValues.length) {
          myChartRpa.data.labels.push(xValues[i]);
          i++;
        }
        let ix = 0;
        myChartRpa.data.datasets[0].label = 'Lead';
        while (ix < yValues.length) {
          myChartRpa.data.datasets[0].data.push(yValues[ix]);
          ix++;
        }

        // conversion
        let ix2 = 0;
        myChartRpa.data.datasets[1].label = 'Konversi';
        while (ix2 < rValues.length) {
          myChartRpa.data.datasets[1].data.push(rValues[ix2]);
          ix2++;
        }
   
        myChartRpa.update();
      }else{
        downloadReports(a, 'Affiliate Poroduk '+$('#komunitas_produk_affiliate option:selected').text(), $('#reservation_produk_affiliate').val());
      }
      $('.loadingchart').hide();
      // batas success ajax
    }
  });
}
// drosphip
var myChartRds = new Chart(rds, {
  type: 'bar',
  data: {
    labels: [],
    datasets: [{
      data: [],
      borderWidth: 3,
      borderColor:'#FFE5B4',
      label: '',
      fill: false,
      tension: 0.1
    },{
      data: [],
      borderWidth: 3,
      borderColor:'#FF9400',
      label: '',
      fill: false,
      tension: 0.1
    }]
  },
  options: {
    responsive: true,
    title: {
      display: true,
      text: "Grafik Dropship",
    },
 
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true,
        }
      }]
    }
  }
});
function ssReportOrdersDropship(download = false){
  $('.loadingchart').show();
  var ajaxType = 'ajaxReportOrdersDropship';
  if (download == true) {
    ajaxType = 'ajaxDownloadReportOrdersDropship';
  }
  $.ajax({
    type: 'POST',
    url: hostServer+"ajax/post",
    data: {
      "ajaxType":ajaxType,
      "id_komunitas":$('#komunitas_dropship').val(),
      "dateRange":$('#reservation_dropship').val(),
    },
    success: function(a) {
      if (download == false) {
        var xValues = null;
        var yValues = null;
        var rValues = null;
        
        yValues = JSON.parse(a).all.split(',');
        xValues = JSON.parse(a).tgl.split(',');
        rValues = JSON.parse(a).conv.split(',');

        let i = 0;
        while (i < xValues.length) {
          myChartRds.data.labels.push(xValues[i]);
          i++;
        }
        let ix = 0;
        myChartRds.data.datasets[0].label = 'Lead';
        while (ix < yValues.length) {
          myChartRds.data.datasets[0].data.push(yValues[ix]);
          ix++;
        }

        // conversion
        let ix2 = 0;
        myChartRds.data.datasets[1].label = 'Konversi';
        while (ix2 < rValues.length) {
          myChartRds.data.datasets[1].data.push(rValues[ix2]);
          ix2++;
        }

        myChartRds.update();
        // batas success ajax
      }else{
        downloadReports(a, 'Dropship/reseller' + $('#komunitas_dropship option:selected').text(), $('#reservation_dropship').val());
      }
      $('.loadingchart').hide();
    }
  });
}

ssReportOrdersAffiliate();
ssReportOrdersProdukAffiliate();
ssReportOrdersDropship();