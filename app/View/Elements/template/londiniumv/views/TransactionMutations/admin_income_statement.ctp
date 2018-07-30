<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/income-statement");
?>
<script type="text/javascript">
    var totalPaymentPurchase = <?= $totalPaymentPurchase ?>;
    var totalPaymentSale = <?= $totalPaymentSale ?>;
    var totalCashDisbursement = <?= $totalCashDisbursement ?>;
    var totalCashIn = <?= $totalCashIn ?>;
    var totalEmployeeSalary = <?= $totalEmployeeSalary ?>;
    var month = "";
    var year = "";
    <?php
    if(!empty($this->request->query['start_date']) && !empty($this->request->query['end_date'])) {
    ?>
    var month = "<?= $this->Html->getBulan($this->request->query['start_date']) . ' - ' . $this->Html->getBulan($this->request->query['end_date']) ?>";
    var year = "<?= $this->Html->getTahun($this->request->query['end_date']) ?>";
    <?php
    } else if(!empty($this->request->query['start_date']) && empty($this->request->query['end_date'])){
    ?>
    var month = "<?= $this->Html->getBulan($this->request->query['start_date']); ?>";
    var year = "<?= $this->Html->getTahun($this->request->query['start_date']) ?>";
    <?php
    } else if(empty($this->request->query['start_date']) && !empty($this->request->query['end_date'])){
    ?>
    var month = "<?= $this->Html->getBulan($this->request->query['end_date']); ?>";
    var year = "<?= $this->Html->getTahun($this->request->query['end_date']) ?>";
    <?php
    } else {
    ?>
    var month = "<?= $this->Html->getNamaBulan(date("m")); ?>";
    var year = "<?= $this->Html->getTahun(date("Y")) ?>";
    <?php
    }
    ?>
$(function () {
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<strong>LAPORAN LABA RUGI</strong>'
        },
        subtitle: {
            text: '<strong>Periode Bulan ' + month + " Tahun " + year + "</strong>"
        },
        xAxis: {
            categories: [
                'Pembelian',
                "Pendapatan",
                "Biaya Pengeluaran",
                "Pemasukan",
                "Biaya Gaji Karyawan"
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: '<strong>Nominal (Rp)</strong>'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>Rp. {point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Jumlah',
            data: [
                totalPaymentPurchase,
                totalPaymentSale,
                totalCashDisbursement,
                totalCashIn,
                totalEmployeeSalary
            ]
        }]
    });
});
</script>
                
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>      \
