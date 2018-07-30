
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
        <div class="container-print" style="width:100%; margin:0px auto;">
            <div class="input-data">
                <table width="100%" class="title">
                    <tbody>
                    <thead>
                        <tr>
                            <th class="center-text">
                    <div class="report-title" style="font-family:Tahoma, Geneva, sans-serif; font-size:7px; font-weight:bold; padding-bottom:3px;">KOPERASI MANDIRI<br>PT. CHENWOOFISHERY</div>
                    </th>
                    </tr>
                    </thead>
                    </tbody>
                </table>
                <div class="clear"></div>
                <?php
                echo $this->fetch("content");
                ?>

            </div>

        </div>
    </div>