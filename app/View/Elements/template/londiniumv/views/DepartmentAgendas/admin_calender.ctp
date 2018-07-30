<?php echo $this->Form->create("DepartmentAgendas", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Agenda Departemen") ?>
                    </h6>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading" style="background:#114f76">
                        <h6 class="panel-title" style=" color:#fff"><i class="icon-calendar3"></i>Agenda Kegiatan </h6><div class="pull-right label label-success" style="background:#deff9d"></div>
                    </div>
                    <div class="panel-body">
                        <div id="loading" style="display:none">loading ...</div>
                        <div id="calendar"> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>

<style>
    #loading {
        position: absolute;
        top: 5px;
        right: 5px;
    }

    #eventDisplay {
        display: none;
        text-align: left;
    }
</style>

<script>
    var currentEvent, startAdd, endAdd, allDayAdd;
    var calendar;
    $(document).ready(function () {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var isDelete = false;
        calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev, next today',
                center: 'title',
                right: 'month, agendaWeek, agendaDay'
            },
            defaultView: 'month',
            selectable: true,
            selectHelper: true,
            disableDragging: true,
            disableResizing: true,
            select: function (start, end, allDay) {
                startAdd = start;
                endAdd = end;
                allDayAdd = allDay;
<?php
if ($roleAccess['add']) {
    ?>
                    $("#agenda-modal-add").modal("show");
    <?php
}
?>
            },
            editable: true,
            events: <?php echo json_encode($result); ?>,
            eventRender: function (event, element) {
<?php
if ($roleAccess['delete']) {
    ?>
                    element.find('.fc-event-title').append('<button type="button" class="close" style="padding:2px">×</button>');
    <?php
}
?>
                element.find(".close").click(function () {
                    isDelete = true;
                    $("#agenda-modal-delete .judul-deskripsi").html('\n\
                        <div class="form-group">\n\
                        <div class="col-md-3 control-label">\n\
                            <label>Judul Agenda </label>\n\
                        </div>\n\
                        <div class="col-md-9">\n\
                            <input type="text" class="ubahJudulBaru form-control" size="78" value="' + event.title + '" readonly>\n\
                        </div>\n\
                        </div>\n\
                        <div class="form-group">\n\
                        <div class="col-md-3 control-label">\n\
                            <label>Nama Departemen </label>\n\
                        </div>\n\
                        <div class="col-md-9">\n\
                            <input type="text" class="departemen form-control" size="78" value="<?= $this->Echo->department($this->Session->read('credential.admin.Employee.department_id')) ?>" readonly>\n\
                        </div>\n\
                        </div>\n\
                        <div class="form-group">\n\
                        <div class="col-md-12 control-label">\n\
                            <label>Deskripsi Agenda </label>\n\
                        </div>\n\
                        <div class="col-md-12">' + event.description + '</div>\n\
                        </div>');
                    $("#agenda-modal-delete").modal("show");
                });
            },
            eventClick: function (calEvent, jsEvent, view) {
                jsEvent.preventDefault();
                currentEvent = calEvent;
                if (!isDelete) {
<?php
if ($roleAccess['edit']) {
    ?>
                        $("#agenda-modal-edit .ubahJudulBaru").val(calEvent.title);
                        CKEDITOR.instances.deskripsiagendaedit.setData(calEvent.description);
    <?php
} else {
    ?>
                        $("#judulagenda").html(calEvent.title);
                        $("#deskripsiagenda").html(calEvent.description);
    <?php
}
?>
                    $("#agenda-modal-edit").modal("show");
                }
                isDelete = false;
            },
            loading: function (bool) {
                if (bool) {
                    $('#loading').show();
                } else {
                    $('#loading').hide();
                }
            }
        });
    });
</script>
<!-- Default modal -->
<?php
if ($roleAccess['edit']) {
    ?>
    <div class="row">
        <div id="agenda-modal-edit" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg-4">
                <div class="modal-content">
                    <div class="form-horizontal">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">
                                UBAH AGENDA
                            </h4>
                        </div>
                        <!-- New invoice template -->
                        <div class="panel">
                            <div class="panel-body">
                                <div class="block-inner text-danger">
                                    <h6 class="heading-hr">
                                        DATA AGENDA
                                    </h6>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 control-label">
                                        <label>Judul Agenda </label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="ubahJudulBaru form-control" size="78" value="">
                                    </div>
                                    <br><br><br>
                                    <div class="col-md-12 control-label">
                                        <label>Deskripsi Agenda </label>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea rows="4" cols="79" class="ubahDeskripsiBaru form-control ckeditor-fix" id="deskripsiagendaedit" ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>   
                        <!-- /new invoice template -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?= __("Tutup") ?></button>
                            <button type="button" class="btn btn-success" data-dismiss="modal" id="edit"><?= __("Ubah") ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="row">
        <div id="agenda-modal-edit" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg-4">
                <div class="modal-content">
                    <div class="form-horizontal">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">
                                AGENDA
                            </h4>
                        </div>
                        <!-- New invoice template -->
                        <div class="panel">
                            <div class="panel-body">
                                <div class="block-inner text-danger">
                                    <h6 class="heading-hr" id="judulagenda">
                                        AGENDA
                                    </h6>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="deskripsiagenda"></div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                        <!-- /new invoice template -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?= __("Tutup") ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

<!-- /default modal -->

<div class="row">
    <div id="agenda-modal-add" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg-4">
            <div class="modal-content">
                <div class="form-horizontal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">TAMBAH AGENDA</h4>
                    </div>
                    <!-- New invoice template -->
                    <div class="panel">
                        <div class="panel-body">
                            <div class="block-inner text-danger">
                                <h6 class="heading-hr">TAMBAH DATA AGENDA</h6>
                            </div>
                            <div class="form-group">
                                <div class="col-md-3 control-label">
                                    <label>Judul Agenda </label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="tambahJudul form-control" size="78">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-3 control-label">
                                    <label>Nama Departemen </label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="departemen form-control" size="78" value="<?= $this->Echo->department($this->Session->read('credential.admin.Employee.department_id')) ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label">Deskripsi Agenda </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <textarea rows="4" cols="79" class="tambahDeskripsi form-control ckeditor-fix" id="deskripsiagendaadd"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>   
                    <!-- /new invoice template -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?= __("Tutup") ?></button>
                        <button type="button" class="btn btn-success" data-dismiss="modal" id="add"><?= __("Tambah") ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="agenda-modal-delete" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg-4">
        <div class="modal-content">
            <div class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">HAPUS AGENDA</h4>
                </div>
                <!-- New invoice template -->
                <div class="panel">
                    <div class="panel-body">
                        <div class="block-inner text-danger">
                            <h6 class="heading-hr">HAPUS DATA AGENDA</h6>
                        </div>
                        <div class="judul-deskripsi">

                        </div>
                    </div>
                </div>   
                <!-- /new invoice template -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= __("Tutup") ?></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="delete"><?= __("Hapus") ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#edit").click(function () {
            var newTitle = $('.ubahJudulBaru').val();
            var newDescription = CKEDITOR.instances.deskripsiagendaedit.getData();
            if (newTitle) {
                var start = $.fullCalendar.formatDate(currentEvent.start, "yyyy-MM-dd HH:mm:ss");
                var end = $.fullCalendar.formatDate(currentEvent.end, "yyyy-MM-dd HH:mm:ss");
                $.ajax({
                    url: BASE_URL + "admin/department_agendas/calender_edit/" + currentEvent.id,
                    data: {"data[DepartmentAgenda][id]": currentEvent.id, "data[DepartmentAgenda][description]": newDescription, "data[DepartmentAgenda][title]": newTitle, "data[DepartmentAgenda][start]": start, "data[DepartmentAgenda][end]": end, "data[DepartmentAgenda][all_day]": currentEvent.all_day},
                    type: "POST",
                    dataType: "JSON",
                    success: function (json) {
                        calendar.fullCalendar('removeEvents', json.data.department_agenda_id);
                        calendar.fullCalendar('renderEvent', {
                            id: json.data.department_agenda_id,
                            title: newTitle,
                            description: newDescription,
                            start: start,
                            end: end,
                            allDay: currentEvent.allDay
                        },
                        true);
                        $.growl.notice({title: "Sukses!", message: "Agenda berhasil diubah."});
                    }
                });
            }
        });
        $("#add").click(function () {
            var title = $('.tambahJudul').val();
            var description = CKEDITOR.instances.deskripsiagendaadd.getData();
            var all_day = 0;
            if (title != '') {
                var start = $.fullCalendar.formatDate(startAdd, "yyyy-MM-dd HH:mm:ss");
                var end = $.fullCalendar.formatDate(endAdd, "yyyy-MM-dd HH:mm:ss");
                if (allDayAdd) {
                    allDayAdd = 1;
                }
                $.ajax({
                    url: BASE_URL + "admin/department_agendas/calender_add",
                    data: {"data[DepartmentAgenda][description]": description, "data[DepartmentAgenda][title]": title, "data[DepartmentAgenda][start]": start, "data[DepartmentAgenda][end]": end, "data[DepartmentAgenda][all_day]": allDayAdd},
                    type: "POST",
                    dataType: "json",
                    success: function (json) {
                        $.growl.notice({title: "Sukses!", message: "Agenda berhasil ditambahkan."});
                        calendar.fullCalendar('renderEvent', {
                            title: title,
                            description: description,
                            start: start,
                            end: end,
                            allDay: allDayAdd,
                            id: json.data.department_agenda_id,
                        },
                                true);
                        $(".tambahDeskripsi,.tambahJudul").val("");
                        CKEDITOR.instances.deskripsiagendaadd.setData("");
                    }
                });
            } else {
                $.growl.warning({title: "Peringatan!", message: "Judul Agenda harus diisi."});
            }
        });
        $("#delete").click(function () {
            calendar.fullCalendar('removeEvents', currentEvent._id);
            $.ajax({
                type: "DELETE",
                url: BASE_URL + "admin/department_agendas/calender_delete/" + currentEvent.id,
                data: {"data[DepartmentAgenda][id]": currentEvent.id},
                success: function (json) {
                    $.growl.notice({title: "Sukses!", message: "Agenda berhasil dihapus."});
                }
            });
        });
    })
</script>