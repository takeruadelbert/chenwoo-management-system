<?php
echo $this->Html->script('jquery.min');
?>
<script>
    $(document).ready(function () {
        window.print();
    })
</script>
<div class="no-margin no-padding text-center" style="width:100%">
    <?php
    $entity = ClassRegistry::init("EntityConfiguration")->find("first");
    ?>
    <div style="display:inline-block;float:left">
        <img src="<?= Router::url($entity['EntityConfiguration']['logo1'], true) ?>" height="75px"/>
    </div>
    <div style="display:inline-block">
        <?php
        echo $entity['EntityConfiguration']['header'];
        ?>
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
        padding:0 5px;
		font-family:Tahoma, Geneva, sans-serif;
		font-size:10px;
    }
    .table-data th{
        text-align: center;
        padding:0 5px;
		font-family:Tahoma, Geneva, sans-serif;
		font-size:10px;
    }
    .table-data td:first-child{
        text-align:center !important;
		font-family:Tahoma, Geneva, sans-serif;
		font-size:10px;
    }
    table {
        border-collapse: collapse;
		font-family:Tahoma, Geneva, sans-serif;
		font-size:10px;
    }
    table, th, td {
        border: 1px solid #000;
        padding:0 5px;
		font-family:Tahoma, Geneva, sans-serif;
		font-size:10px;
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
<?php
echo $this->fetch("content");
?>