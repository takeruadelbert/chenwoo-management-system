<script src="<?= Router::url("/js/jquery.min.js") ?>"></script>
<script src="<?= Router::url("/js/plugin/jquery.qrcode-0.12.0.min.js") ?>"></script>
<script>
    $(document).ready(function () {
        window.print();
    })
</script>
<style>
    .no-margin *{
        margin:0;
    }
    .no-padding *{
        padding:0;
    }
    .table-data{
        font-size:10px;
    }
    .table-data td{
        text-align: left;
        padding:0 5px;
    }
    .table-data th{
        text-align: center;
        padding:0 5px;
    }
    .table-data tbody td:first-child{
        text-align:center !important;
    }
    table {
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid black;
        padding:0 5px;
    }
    .table-data th{
        background-color: lightgray;
    }
    .text-center{
        text-align:center !important;
    }
    .text-right{
        text-align:right !important;
    }
    .text-left{
        text-align:left !important;
    }
    table.no-border,.no-border th,.no-border td{
        border:none !important;
        padding:0;
    }
    .table-data-input{
        font-size:12px !important;
    }
    .table-data-input td{
        padding:10px;
    }
    .table-data-nowrap td{
        white-space:nowrap;
    }
</style>
<div class="print">
    <?php
    echo $this->fetch("content");
    ?>
</div>