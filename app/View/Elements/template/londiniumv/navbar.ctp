<div class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="<?= Router::url("/admin/dashboard", true) ?>"><img src="<?= Router::url("/img/logo.png", true) ?>" alt="<?= _APP_CORPORATE_FULL ?>"></a>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-icons"><span class="sr-only">Toggle navbar</span><i class="icon-grid3"></i></button>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar"><span class="sr-only">Toggle navigation</span><i class="icon-paragraph-justify2"></i></button>
    </div>  
    <?php
    $displayNotif = [];
    foreach ($notifications as $notif) {
        $displayNotif[] = [
            "message" => $notif["Notification"]["message"],
            "target" => $notif["Notification"]["target"],
            "time" => strtotime($notif["Notification"]["created"]),
            "id" => $notif["Notification"]["id"],
            "style" => [
                "icon" => "icon-envelop",
                "textType" => "text-success",
            ],
        ];
    }
    $countNotif = count($displayNotif);
    foreach ($globalNotifications as $globalNotification) {
        $displayNotif[] = [
            "message" => $globalNotification["message"],
            "target" => $globalNotification["url"],
            "time" => strtotime($globalNotification["time"]),
            "id" => 0,
            "style" => [
                "icon" => "icon-alert",
                "textType" => "text-success",
            ],
        ];
    }
    $countNotif+=count($globalNotifications);
    array_multisort(array_column($displayNotif, "time"), SORT_DESC, $displayNotif);
    ?>
    <?php
//    $news = ClassRegistry::init("InternalNews")->find("all", [
//        "order" => [
//            "InternalNews.created DESC",
//        ]
//    ]);
//    $birthday = ClassRegistry::init("Biodata")->find("all", [
//        "conditions" => [
//            "DATE_FORMAT(Biodata.tanggal_lahir, '%m-%d')" => date("m-d"),
//        ]
//    ]);
//    $countNews = count($news);
//    $countBirthday = count($birthday);
//    $countNotif = $countNews + $countBirthday;
    ?>
    <ul class="nav navbar-nav navbar-right collapse" id="navbar-icons">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown">
                <i class="icon-notification"></i>
                <?php
                if ($countNotif > 0) {
                    ?>
                    <span class="label label-default"><?= $countNotif ?></span>
                    <?php
                }
                ?>
            </a>
            <div class="popup dropdown-menu dropdown-menu-right">
                <div class="popup-header">
                    <span><?= __("Notifikasi") ?></span>
                </div>
                <ul class="activity">
                    <?php
                    if (!empty($displayNotif)) {
                        foreach ($displayNotif as $notification) {
                            ?>
                            <li>
                                <i class="<?= $notification["style"]["icon"] ?> <?= $notification["style"]["textType"] ?>"></i>
                                <div>
                                    <a style="color:#00589e" href="javascript:openNotification(<?= $notification["id"] ?>,'<?= Router::url($notification["target"]) ?>')"><?= $notification["message"] ?></a>
                                    <span><?= $this->Html->getTimeago($notification["time"]); ?></span>
                                </div>
                            </li> 
                            <?php
                        }
                    } else {
                        ?>
                        <li class="text-center">Tidak ada notifikasi.</li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </li>

        <li class="dropdown">
            <a class="dropdown-toggle sidebar-toggle">
                <i class="icon-paragraph-justify2"></i>
            </a>
        </li>
    </ul>
</div>

<script>
    function openNotification(id, url) {
        $.ajax({
            url: BASE_URL + "admin/notifications/update_notification/" + id,
            type: "GET",
            dataType: "JSON",
            complete: function () {
                window.location.href = url;
            }
        });
    }
</script>