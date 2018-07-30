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
    .pull-right{
        float:right;
    }
</style>
<link href="<?php echo Router::url('/', true); ?>css/layout_print2.css" rel="stylesheet" type="text/css">
<link href="<?php echo Router::url('/', true); ?>css/media_print.css" rel="stylesheet" type="text/css" media="print">
<link href="<?php echo Router::url('/', true); ?>css/print.css" rel="stylesheet" type="text/css">
<link href="<?php echo Router::url('/', true); ?>css/print2.css" rel="stylesheet" type="text/css">
<style>
    h6 {
        font-weight: normal;
        font-size: 10px;
        line-height: 12px;
        margin: 5px 0 0 0;
        color:black;
    }
</style>

<div class="container-print" style="width:955px;">
    <div class="no-margin no-padding text-center kop" style="width:100%">
        <?php
        $entity = ClassRegistry::init("EntityConfiguration")->find("first");
        ?>
        <div style="display:inline-block;float:left">
            <img src="<?= Router::url($entity['EntityConfiguration']['logo1'], true) ?>"/>
        </div>
        <div style="display:inline-block">
            <?php
            echo $entity['EntityConfiguration']['header'];
            ?>
        </div>
    </div>
    <div style="clear:both"></div>
    <div class="input-data" style="font-size:10px">
        <table class="title">
            <thead>
                <tr>
                    <th class="center-text">
            <div class="report-title">
                <?php echo $data['title'] ?>
            </div>
            </th>
            </tr>
            </thead>
        </table>
        <div class="clear"></div>
        <?php
        echo $this->fetch("content");
        ?>
    </div>
</div>