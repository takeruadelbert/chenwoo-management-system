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
    <h1>Laporan Arus Kas</h1>
    <h4>
    <?php
    if(!empty($this->request->query['start_date']) && !empty($this->request->query['end_date'])) {
        echo "Periode " . $this->Html->cvtTanggal($this->request->query['start_date']) . " - " . $this->Html->cvtTanggal($this->request->query['end_date']);
    }
    ?>
    </h4>
</center>
<?php
echo $this->fetch("content");
?>
</div>