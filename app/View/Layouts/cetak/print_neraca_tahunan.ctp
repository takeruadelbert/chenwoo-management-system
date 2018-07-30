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
<center>
    <div style="color: #993333; font-size:14px; font-weight:bold; text-transform:uppercase; font-family:Tahoma, Geneva, sans-serif;">Neraca Tahun 
    <?php
    if(!empty($this->request->query['year'])) {
        echo $this->request->query['year'];
    } else {
        echo date("Y");
    }
    ?>
    </div>
	<br>
</center>
<?php
echo $this->fetch("content");
?>