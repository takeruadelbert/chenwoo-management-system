<div class="row">
    <div class="col-md-6">
        <form class="form-horizontal form-separate" action="#" role="form">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">Berita Terbaru 
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>

                    <div id="news_main"> 
                    </div> 
                    <div class="table-actions" style="float:right" id="target-pagination-news">
                    </div>

                    <!-- /task -->
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <form class="form-horizontal form-separate" action="#" role="form">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">Berita Departemen Terbaru 
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>

                    <div id="department_news_main"> 
                    </div> 
                    <div class="table-actions" style="float:right" id="target-pagination-department-news">
                    </div>

                    <!-- /task -->
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <form class="form-horizontal form-separate" action="#" role="form">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">Data Pegawai yang Berulang Tahun 
                            <div class="pull-right label label-danger">
                                <?= $this->Html->getNamaBulan($currentMonth) . " " . $currentYear ?>
                            </div>
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!-- Table view -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title"><i class="icon-people"></i> Data Pegawai</h5>
                        </div>
                        <div class="table-responsive pre-scrollable stn-table">
                            <table width="100%" class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th align="center" valign="middle" class="image-column">Foto</th>
                                        <th align="center" valign="middle">Nama</th>
                                        <th align="center" valign="middle">Department</th>
                                        <th align="center" valign="middle" ali>Tanggal Lahir</th>
                                        <th align="center" valign="middle" class="team-links">Ultah Ke</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                                    $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                                    if (empty($data['rows'])) {
                                        ?>
                                        <tr>
                                            <td class = "text-center" colspan = 5>Tidak Ada Data</td>
                                        </tr>
                                        <?php
                                    } else {
                                        foreach ($data['rows'] as $item) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><a href="<?= Router::url($item['User']['profile_picture'], true) ?>" class="lightbox" title="<?= $item['Biodata']['full_name'] ?>"><img src="<?= Router::url($item['User']['profile_picture'], true) ?>" alt="" class="img-media"></a></td>
                                                <td class="text-semibold"><?= $item['Biodata']['full_name'] ?></td>
                                                <td class="muted"><?= $item['Employee']['Department']['name'] ?></td>
                                                <td class="file-info text-center"><span><?= $this->Html->cvtTanggal($item['Biodata']['tanggal_lahir']) ?></span></td>
                                                <td class="text-center">
                                                    <?php
                                                    $birth_date = $item['Biodata']['tanggal_lahir'];
                                                    $birth_year = date("Y", strtotime($birth_date));
                                                    $result = $currentYear - $birth_year;
                                                    echo $result;
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php echo $this->element(_TEMPLATE_DIR . "/{$template}/pagination") ?>
            </div>
        </form>
    </div>
    <div class="col-md-6 hidden">
        <form class="form-horizontal form-separate" action="#" role="form">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">Data Piutang Penjualan - Export
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <div class="table-responsive pre-scrollable stn-table">
                        <table width="100%" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th align="center" valign="middle">Nomor Invoice</th>
                                    <th align="center" valign="middle">Nama Buyer</th>
                                    <th align="center" valign="middle">Tanggal Jatuh Tempo</th>
                                    <th align="center" valign="middle" colspan ="2">Total Tagihan</th>
                                    <th align="center" valign="middle" colspan ="2">Sisa Tagihan</th>
                                </tr>
                            </thead>
                            <tbody id = "target-piutang">
                            </tbody>
                        </table>
                    </div>
                    <br/>
                    <div class="table-actions" style="float:right" id="target-pagination-sales">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-6 hidden">
        <form class="form-horizontal form-separate" action="#" role="form">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">Data Hutang Pembelian 
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <div class="table-responsive pre-scrollable stn-table">
                        <table width="100%" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th align="center" valign="middle">Nomor Transaksi</th>
                                    <th align="center" valign="middle">Nama Supplier</th>
                                    <th align="center" valign="middle">Tanggal Jatuh Tempo</th>
                                    <th align="center" valign="middle" colspan = "2">Total Hutang</th>
                                    <th align="center" valign="middle" colspan = "2">Sisa Hutang</th>
                                </tr>
                            </thead>
                            <tbody id = "target-hutang">
                            </tbody>
                        </table>
                    </div>
                    <br/>
                    <div class="table-actions" style="float:right" id="target-pagination-transaction-entry">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="default-lihatnews" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg-6">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">BERITA</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <table width="100%" class="table table-hover">
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div>
                                        <b><center id="title" style="font-size:16px; color:#a60000; font-weight:bold;"></center></b>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div id="content">

                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>                                
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
            </div>
        </div>
    </div>    
</div>

<div id="default-lihatdepartmentnews" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg-6">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">BERITA DEPARTEMEN</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <table width="100%" class="table table-hover">
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div>
                                        <b><center id="titleDepartmentNews" style="font-size:16px; color:#a60000; font-weight:bold;"></center></b>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div id="contentDepartmentNews">

                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>                                
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
            </div>
        </div>
    </div>    
</div>

<script>
    $(document).ready(function () {
        requestNews(1);
        requestDepartmentNews(1);
        getViewDataSale(1);
        getViewDataTransactionEntry(1);
        $(".button-page").on("click", function () {
            var $this = $(this);
            requestNews($this.data("page"));
            getViewDataSale($this.data("page"));
            getViewDataTransactionEntry($this.data("page"));
        });
    });
    function getNews() {
        $("a[href='#default-lihatnews']").on("click", function () {
            var newsId = $(this).data("news-id");
            var empId = <?= $stnAdmin->getEmployeeId() ?>;
            $("#content").html("");
            $.ajax({
                url: BASE_URL + "internal_news/view_news/" + newsId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#title").text(data.InternalNews.title);
                    $("#content").append(data.InternalNews.content);
                    updateStatusNews(newsId, empId);
                }
            })
        });
    }

    function getDepartmentNews() {
        $("a[href='#default-lihatdepartmentnews']").on("click", function () {
            var newsId = $(this).data("department-news-id");
            $("#contentDepartmentNews").html("");
            $.ajax({
                url: BASE_URL + "admin/department_news/view_news/" + newsId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#titleDepartmentNews").text(data.DepartmentNews.title);
                    $("#contentDepartmentNews").append(data.DepartmentNews.content);
                }
            })
        });
    }
    
    function requestNews(page) {
        var source = $("#news-template").html();
        var template = Handlebars.compile(source);
        var place = $("#news_main");
        place.html("");
        $.ajax({
            type: 'GET',
            url: BASE_URL + 'internal_news/ajax_news',
            data: {page: page, limit: 3, order: "InternalNews.created desc"},
            dataType: 'json',
            success: function (response) {
                var html = template({news: response.data.items});
                place.append(html);
                renderPaginationNews(response.data.pagination_info, 'requestNews', '#tmpl-pagination-dashboard', '#target-pagination-news');
                getNews();
            }
        });
    }
    
    function requestDepartmentNews(page) {
        var source = $("#department-news-template").html();
        var template = Handlebars.compile(source);
        var place = $("#department_news_main");
        place.html("");
        $.ajax({
            type: 'GET',
            url: BASE_URL + 'department_news/ajax_news',
            data: {page: page, limit: 3, order: "DepartmentNews.created desc"},
            dataType: 'json',
            success: function (response) {
                var html = template({news: response.data.items});
                place.append(html);
                renderPaginationNews(response.data.pagination_info, 'requestDepartmentNews', '#tmpl-pagination-dashboard-department-news', '#target-pagination-department-news');
                getDepartmentNews();
            }
        });
    }

    function updateStatusNews(newsId, employeeId) {
        $.ajax({
            url: BASE_URL + "seen_news/check_is_seen/" + newsId + "/" + employeeId,
            type: "POST",
            dataType: "JSON",
            data: {},
            success: function (response) {

            }
        });
    }

    function getViewDataSale(page) {
        var source = $("#piutang-template").html();
        var template = Handlebars.compile(source);
        var place = $("#target-piutang");
        place.html("");
        $.ajax({
            type: 'GET',
            url: BASE_URL + 'sales/ajax_sales',
            data: {page: page, limit: 5, order: "Sale.due_date desc"},
            dataType: 'json',
            success: function (response) {
                var html = template({
                    sales: response.data.items
                });
                place.append(html);
                renderPaginationNews(response.data.pagination_info, 'getViewDataSale', '#tmpl-pagination-dashboard-sales', '#target-pagination-sales');
            }
        });
    }

    function getViewDataTransactionEntry(page) {
        var source = $("#hutang-template").html();
        var template = Handlebars.compile(source);
        var place = $("#target-hutang");
        place.html("");
        $.ajax({
            type: 'GET',
            url: BASE_URL + 'transaction_entries/ajax_transaction_entries',
            data: {page: page, limit: 5, order: "TransactionEntry.due_date desc"},
            dataType: 'json',
            success: function (response) {
                var html = template({
                    transaction: response.data.items
                });
                place.append(html);
                renderPaginationNews(response.data.pagination_info, 'getViewDataTransactionEntry', '#tmpl-pagination-dashboard-transaction-entry', '#target-pagination-transaction-entry');
            }
        });
    }
</script>
<script id="news-template" type="text/x-handlebars-template">
    {{#news}}
    <div class = "block task task-high">
    <div class = "row with-padding" >
    <div class = "col-sm-8">
    <div class="task-description">
    <a data-toggle="modal" data-news-id="{{InternalNews.id}}" href="#default-lihatnews" class="viewData">
    {{InternalNews.title}}
    </a>
    <i>{{Employee.Account.Biodata.full_name}}</i>
    <span>{{removeTags InternalNews.synopsis}}</span>
    </div>
    </div>
    <div class = "col-sm-4">
    <div class = "task-info">
    <span>{{cvtTanggal InternalNews.created}}</span>
    <span>
    {{{isRead InternalNews.id}}}
    </span>
    </div>
    </div>
    </div>
    <div class="panel-footer">
    <div class="pull-left">
    <span><i class="icon-clock"></i>{{timeAgo InternalNews.created}} yang lalu</span>
    </div>
    {{#if (hasAccess InternalNews.employee_id)}}
    <div class="pull-right">
    <ul class="footer-icons-group">
    <li class="dropup"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-wrench"></i></a>
    <ul class="dropdown-menu icons-right dropdown-menu-right">
    <li><a href="{{editNews InternalNews.id}}"><i class="icon-pencil"></i> Edit</a></li>
    <li><a href="{{removeNews}}"><i class="icon-remove3"></i> Remove</a></li>
    </ul>
    </li>
    </ul>
    </div>
    {{/if}}
    </div>
    </div>
    {{/news}}
    {{^news}}
    <div class = "block task task-high">
    <div class = "row with-padding" >
    <div class = "col-sm-12">
    <div class = "task-description" >
    <span>
    <i class= "icon-warning"></i> Tidak ada berita terbaru <i class= "icon-warning"></i>
    </span>
    </div>
    </div>
    </div>
    </div>
    {{/news}}
</script>
<script id="tmpl-pagination-dashboard" type="text/x-handlebars-template">
    <ul class="pagination">
    {{#prev}}
    <li><a href="{{href}}" onclick="{{onclick}}">Prev</a></li>
    {{/prev}}
    {{#buttonBefore}}
    <li><a href="{{href}}" onclick="{{onclick}}">{{number}}</a></li>
    {{/buttonBefore}}
    {{#buttonCurrent}}
    <li class="active"><a href="{{href}}">{{number}}</a></li>
    {{/buttonCurrent}}
    {{#buttonAfter}}
    <li><a href="{{href}}" onclick="{{onclick}}">{{number}}</a></li>
    {{/buttonAfter}}
    {{#next}}
    <li><a href="{{href}}" onclick="{{onclick}}">Next</a></li>
    {{/next}}
    </ul>
</script>


<script id="piutang-template" type="text/x-handlebars-template">
    {{#sales}}
    <tr>
    <td class = 'text-center'>
    {{Sale.sale_no}}     
    </td>
    <td class = 'text-center'>
    {{Buyer.company_name}}     
    </td>
    <td class = 'text-center'>
    {{cvtTanggal Sale.due_date}}     
    </td>
    <td class = 'text-center' style = "border-right-style:none !important;">
    $     
    </td>
    <td class = 'text-right' style = "border-left-style:none !important;">
    {{Sale.grand_total}}     
    </td>
    <td class = 'text-center' style = "border-right-style:none !important;">
    $     
    </td>
    <td class = 'text-right' style = "border-left-style:none !important;">
    {{Sale.remaining}}     
    </td>
    </tr>
    {{/sales}}
</script>
<script id="tmpl-pagination-dashboard-sales" type="text/x-handlebars-template">
    <ul class="pagination">
    {{#prev}}
    <li><a href="{{href}}" onclick={{onclick}}>Prev</a></li>
    {{/prev}}
    {{#buttonBefore}}
    <li><a href="{{href}}" onclick={{onclick}}>{{number}}</a></li>
    {{/buttonBefore}}
    {{#buttonCurrent}}
    <li class="active"><a href="{{href}}">{{number}}</a></li>
    {{/buttonCurrent}}
    {{#buttonAfter}}
    <li><a href="{{href}}" onclick={{onclick}}>{{number}}</a></li>
    {{/buttonAfter}}
    {{#next}}
    <li><a href="{{href}}" onclick={{onclick}}>Next</a></li>
    {{/next}}
    </ul>
</script>

<script id="hutang-template" type="text/x-handlebars-template">
    {{#transaction}}
    <tr>
    <td class = 'text-center'>
    {{TransactionEntry.transaction_number}}     
    </td>
    <td class = 'text-center'>
    {{Supplier.name}}     
    </td>
    <td class = 'text-center'>
    {{cvtTanggal TransactionEntry.due_date}}     
    </td>
    <td class = 'text-center' style = "border-right-style:none !important;">
    Rp.
    </td>
    <td class = 'text-right' style = "border-left-style:none !important;">
    {{IndonesianRupiah TransactionEntry.total}}     
    </td>
    <td class = 'text-center' style = "border-right-style:none !important;">
    Rp.
    </td>
    <td class = 'text-right' style = "border-left-style:none !important;">
    {{IndonesianRupiah TransactionEntry.remaining}}     
    </td>
    </tr>
    {{/transaction}}
</script>
<script id="tmpl-pagination-dashboard-transaction-entry" type="text/x-handlebars-template">
    <ul class="pagination">
    {{#prev}}
    <li><a href="{{href}}" onclick="{{onclick}}">Prev</a></li>
    {{/prev}}
    {{#buttonBefore}}
    <li><a href="{{href}}" onclick="{{onclick}}">{{number}}</a></li>
    {{/buttonBefore}}
    {{#buttonCurrent}}
    <li class="active"><a href="{{href}}">{{number}}</a></li>
    {{/buttonCurrent}}
    {{#buttonAfter}}
    <li><a href="{{href}}" onclick="{{onclick}}">{{number}}</a></li>
    {{/buttonAfter}}
    {{#next}}
    <li><a href="{{href}}" onclick="{{onclick}}">Next</a></li>
    {{/next}}
    </ul>
</script>

<script id="department-news-template" type="text/x-handlebars-template">
    {{#news}}
    <div class = "block task task-high">
    <div class = "row with-padding" >
    <div class = "col-sm-8">
    <div class="task-description">
    <a data-toggle="modal" data-department-news-id="{{DepartmentNews.id}}" href="#default-lihatdepartmentnews" class="viewData">
    {{DepartmentNews.title}}
    </a>
    <i>{{Employee.Account.Biodata.full_name}}</i>
    <span>{{removeTags DepartmentNews.synopsis}}</span>
    </div>
    </div>
    <div class = "col-sm-4">
    <div class = "task-info">
    <span>{{cvtTanggal DepartmentNews.created}}</span>
    <span class='label label-danger' style="color: white;">{{Department.name}}</span>
    </div>
    </div>
    </div>
    <div class="panel-footer">
    <div class="pull-left">
    <span><i class="icon-clock"></i>{{timeAgo DepartmentNews.created}} yang lalu</span>
    </div>
    </div>
    </div>
    {{/news}}
    {{^news}}
    <div class = "block task task-high">
    <div class = "row with-padding" >
    <div class = "col-sm-12">
    <div class = "task-description" >
    <span>
    <i class= "icon-warning"></i> Tidak ada berita terbaru <i class= "icon-warning"></i>
    </span>
    </div>
    </div>
    </div>
    </div>
    {{/news}}
</script>
<script id="tmpl-pagination-dashboard-department-news" type="text/x-handlebars-template">
    <ul class="pagination">
    {{#prev}}
    <li><a href="{{href}}" onclick="{{onclick}}">Prev</a></li>
    {{/prev}}
    {{#buttonBefore}}
    <li><a href="{{href}}" onclick="{{onclick}}">{{number}}</a></li>
    {{/buttonBefore}}
    {{#buttonCurrent}}
    <li class="active"><a href="{{href}}">{{number}}</a></li>
    {{/buttonCurrent}}
    {{#buttonAfter}}
    <li><a href="{{href}}" onclick="{{onclick}}">{{number}}</a></li>
    {{/buttonAfter}}
    {{#next}}
    <li><a href="{{href}}" onclick="{{onclick}}">Next</a></li>
    {{/next}}
    </ul>
</script>