<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/annual-income-statement");
?>
<script type="text/javascript">
    var totalPaymentPurchase = <?= $totalPaymentPurchase ?>;
    var totalPaymentSale = <?= $totalPaymentSale ?>;
    var totalCashDisbursement = <?= $totalCashDisbursement ?>;
    var totalCashIn = <?= $totalCashIn ?>;
    var totalEmployeeSalary = <?= $totalEmployeeSalary ?>;
    var arrayCashIn = [];
    var arrayCashDisbursement = [];
    var arrayPaymentPurchase = [];
    var arrayPaymentSale = [];
    var arrayEmployeeSalary = [];
    var year = "";
    <?php
    if(!empty($this->request->query['year'])) {
    ?>
        year = '<?= $this->request->query['year'] ?>';
    <?php    
    } else {
    ?>
        year = '<?= $currentYear ?>';    
    <?php
    }
    ?>
    <?php
    foreach ($dataAnnualTotalCashIn as $index => $item1) {
    ?>
        arrayCashIn[<?= $index ?>] = [
            
                '<?= $item1[0][0] ?>',
                <?= $item1[0][1] ?>
            
        ]
    <?php
    }
    foreach ($dataAnnualTotalCashDisbursement as $index => $item2) {
    ?>
        arrayCashDisbursement[<?= $index ?>] = [
            
                '<?= $item2[0][0] ?>',
                <?= $item2[0][1] ?>
            
        ]
    <?php
    }
    foreach ($dataAnnualTotalPaymentSale as $index => $item3) {
    ?>
        arrayPaymentSale[<?= $index ?>] = [
            '<?= $item3[0][0] ?>',
            <?= $item3[0][1] ?>
        ]
    <?php
    }
    foreach ($dataAnnualTotalPaymentPurchase as $index => $item4) {
    ?>
        arrayPaymentPurchase[<?= $index ?>] = [
            '<?= $item4[0][0] ?>',
            <?= $item4[0][1] ?>
        ]
    <?php
    }
    foreach ($dataAnnualTotalEmployeeSalary as $index => $item5) {
    ?>
        arrayEmployeeSalary[<?= $index ?>] = [
            '<?= $item5[0][0] ?>',
            <?= $item5[0][1] ?>
        ]
    <?php
    }
    ?>
$(function () {
    // Create the chart
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<strong>LAPORAN LABA RUGI TAHUNAN</strong>'
        },
        subtitle: {
            text: '<strong>Periode Tahun ' + year + '</strong>'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: '<strong>Nominal (Rp)</strong>'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: 'Rp. {point.y:.1f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>Rp. {point.y:.2f}</b><br/>'
        },

        series: [{
            name: 'Kategori',
            colorByPoint: true,
            data: [{
                name: 'Pembelian',
                y: totalPaymentPurchase,
                drilldown: 'Pembelian'
            }, {
                name: 'Pendapatan',
                y: totalPaymentSale,
                drilldown: 'Pendapatan'
            }, {
                name: 'Biaya Pengeluaran',
                y: totalCashDisbursement,
                drilldown: 'Biaya Pengeluaran'
            }, {
                name: 'Pemasukan',
                y: totalCashIn,
                drilldown: 'Pemasukan'
            }, {
                name: 'Biaya Gaji Karyawan',
                y: totalEmployeeSalary,
                drilldown: 'Biaya Gaji Karyawan'
            }]
        }],
        drilldown: {
            series: [{
                name: 'Pembelian',
                id: 'Pembelian',
                data: arrayPaymentPurchase
            }, {
                name: 'Pendapatan',
                id: 'Pendapatan',
                data: arrayPaymentSale
            }, {
                name: 'Biaya Pengeluaran',
                id: 'Biaya Pengeluaran',
                data: arrayCashDisbursement
            }, {
                name: 'Pemasukan',
                id: 'Pemasukan',
                data: arrayCashIn
            }, {
                name: 'Biaya Gaji Karyawan',
                id: 'Biaya Gaji Karyawan',
                data: arrayEmployeeSalary
            }]
        }
    });
});
</script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>