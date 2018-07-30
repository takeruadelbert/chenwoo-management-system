<?php
echo $this->Html->script('jquery.min');
?>
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
    .table-data td{
        text-align: left;
        padding:0 5px;
    }
    .table-data th{
        text-align: center;
        padding:0 5px;
    }
    .table-data td:first-child{
        text-align:center !important;
    }
    table {
        border-collapse: collapse;
    }
    table, th, td {
        border: none;
        padding:0 5px;
        color: black;
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
</style>
<style type="text/css" media="print">
    @page
    {
        size: portrait;
        margin: 2cm;
    }
    @media all {
        .page-break  { display: none; }
    }

    @media print {
        .page-break  { display: block; page-break-before: always; }
    }
</style>
<link href="<?php echo Router::url('/', true); ?>css/layout_print2.css" rel="stylesheet" type="text/css">
<link href="<?php echo Router::url('/', true); ?>css/media_print.css" rel="stylesheet" type="text/css" media="print">
<link href="<?php echo Router::url('/', true); ?>css/print.css" rel="stylesheet" type="text/css">
<link href="<?php echo Router::url('/', true); ?>css/print2.css" rel="stylesheet" type="text/css">
<link href="<?php echo Router::url('/', true); ?>css/newPrint.css" rel="stylesheet" type="text/css">
<style>
    h6 {
        font-weight: normal;
        font-size: 10px;
        line-height: 12px;
        margin: 5px 0 0 0;
        color:black;
    }
</style>
<?php
echo $this->fetch("content");
?>