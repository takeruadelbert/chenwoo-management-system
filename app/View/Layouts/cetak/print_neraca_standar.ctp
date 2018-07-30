<?php
echo $this->Html->script('jquery.min');
?>
<script>
    $(document).ready(function () {
        window.print();
    })
</script>
<div class="container-print" style="width:955px; margin:10px auto;">
    <div id="identity">
        <div class="no-margin no-padding text-left" style="width:100%">
            <?php
            $entity = ClassRegistry::init("EntityConfiguration")->find("first");
            ?>
            <div style="display:inline-block; margin-right: 15px;">
                <img src="<?php echo Router::url($entity['EntityConfiguration']['logo1'], true) ?>"/>
            </div>
            <div style="display:inline-block;width: 855px;" >
                <?php
                echo $entity['EntityConfiguration']['header'];
                ?>
            </div>
        </div>
    </div>
    <hr/>
</div>
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
<center>
    <div style="font-size:14px; font-weight:bold; text-transform:uppercase; font-family:Tahoma, Geneva, sans-serif;">Neraca Standar</div>
    <div style="color: #993333; font-size:12px; font-family:Tahoma, Geneva, sans-serif;">
        Periode <?php
        if (!empty($this->request->query['bulan']) && !empty($this->request->query['tahun'])) {
            echo $this->Html->getNamaBulan($this->request->query['bulan']) . " " . $this->request->query['tahun'];
        }
        ?>
    </div>
</center>
<?php
echo $this->fetch("content");
?>