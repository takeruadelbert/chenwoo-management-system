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
        padding:0px 5px 10px;
    }
    .table-data th{
        text-align: center;
        padding:0px 5px 10px;
    }
    .table-data td:first-child{
        text-align:center !important;
    }
    table {
        border-collapse: collapse;
    }
    table, th, td {
        padding:0px 5px 10px;
        font-size: 9px;
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
    
    @page
    {
        size: landscape;
        margin: 2cm;
    }
    @media all {
        .page-break  { display: none; }
    }

    @media print {
        .page-break  { display: block; page-break-before: always; }
    }
</style>
<?php
echo $this->fetch("content");
?>