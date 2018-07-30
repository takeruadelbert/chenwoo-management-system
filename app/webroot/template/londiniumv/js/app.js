$(document).ready(function () {
    $(".checkall").click(function () {
        var $checkBoxes = $(this).parents("thead").siblings("tbody").find("input.checkboxDeleteRow");
        if ($(this).is(":checked")) {
            $checkBoxes.attr("checked", "checked");
            $checkBoxes.parent("span").addClass("checked");
        } else {
            $checkBoxes.removeAttr("checked");
            $checkBoxes.parent("span").removeClass("checked");
        }
    });
    $('.opensmallwindow').bind('click', function () {
        //alert($(this).attr('href'));
        $.colorbox({
            href: $(this).data('href'),
            width: '555', //width: 555px; height: 296px; 
            height: '296'
        });
        return false;
    });
    $(".required").siblings("label").addClass("label-required");
    reloadDatePicker();
    reloadStyled();
    reloadSelect2();
    coolField();
    $('form input').on('keypress', function (e) {
        return e.which !== 13;
    });
    $('button[data-target="#add"]').on("click", function () {
        if ($("#formSubmit").valid()) {
            return true;
        } else {
            notif("warning","Mohon mengecek kembali kesalahan pada pengisian","growl");
            return false;
        }
    });
});

function ajaxLoadingStart() {
    $("#ajax-loading").modal("show");
}

function ajaxLoadingSuccess() {
    setTimeout(function () {
        $("#ajax-loading").modal("hide");
    }, 500);
}

function reloadDatePicker() {
    $.datetimepicker.setDateFormatter({
        parseDate: function (date, format) {
            var d = moment(date, format);
            return d.isValid() ? d.toDate() : false;
        },
        formatDate: function (date, format) {
            return moment(date).format(format);
        }
    });
    $(".datepicker").not(".datepicker-proccesed").each(function (i) {
        $this = $(this);
        if ($this.val() == "") {
            var val = "";
        } else {
            var val = moment($this.val()).format("Do MMM YYYY");
        }
        var realVal = $this.val();
        var name = $(this).attr("name");
        var formattedName = $(this).attr("id");
        if (formattedName === "") {
            formattedName = "datepicker" + new Date().getTime() + i;
        }
        $this.after("<input class='idpck-slave' type='hidden' value='" + realVal + "' id='idpck_" + formattedName + "' name='" + name + "'/>");
        $this.removeAttr("name").addClass("datepicker-proccesed").data("idpck-target", "idpck_" + formattedName).val(val);
    })
    $(".datepicker").datetimepicker({
        timepicker: false,
        format: "Do MMM YYYY",
        formatDate: 'Do MMM YYYY',
        formatTime: "H:mm",
        yearStart: 1900,
        onSelectDate: function (dp, $input) {
            var targetId = $input.data("idpck-target");
            $("#" + targetId).val(moment($input.val(), "Do MMM YYYY").format("YYYY-MM-DD")).trigger("change");
        }
    });
    $(".datetime").not(".datetime-proccesed").each(function (i) {
        $this = $(this);
        if ($this.val() == "") {
            var val = "";
        } else {
            var val = moment($this.val()).format("Do MMM YYYY H:mm:ss");
        }
        var realVal = $this.val();
        var name = $(this).attr("name");
        var formattedName = "n" + new Date().getTime() + i;
        $this.after("<input class='idpck-slave' type='hidden' value='" + realVal + "' id='idpck_" + formattedName + "' name='" + name + "'/>");
        $this.removeAttr("name").addClass("datetime-proccesed").data("idpck-target", "idpck_" + formattedName).val(val);
    });
    $(".datetime").datetimepicker({
        format: "Do MMM YYYY H:mm:ss",
        formatDate: 'Do MMM YYYY',
        formatTime: "H:mm",
        step: 15,
        onSelectDate: function (dp, $input) {
            var targetId = $input.data("idpck-target");
            $("#" + targetId).val(moment($input.val(), "Do MMM YYYY H:mm:ss").format("YYYY-MM-DD HH:mm:ss"));
        },
        onSelectTime: function (dp, $input) {
            var targetId = $input.data("idpck-target");
            $("#" + targetId).val(moment($input.val(), "Do MMMM YYYY H:mm:ss").format("YYYY-MM-DD HH:mm:ss"));
        },
        onChangeDateTime: function (dp, $input) {
            var targetId = $input.data("idpck-target");
            $("#" + targetId).val(moment($input.val(), "Do MMMM YYYY H:mm:ss").format("YYYY-MM-DD HH:mm:ss"));
        }
    });
    $(".timepicker").datetimepicker({
        format: "H:mm",
        formatDate: 'Do MMM YYYY',
        formatTime: "H:mm",
        step: 15,
        datepicker: false,
    });
}

function reloadStyled() {
    $(".styled, .multiselect-container input").uniform({radioClass: 'choice', selectAutoWidth: false});
}

$(document).ready(function () {
    NProgress.start();
})

$(window).load(function () {
    NProgress.done();
})

function reloadSelect2() {
    $(".select-full").select2({
        allowClear: true,
        width: "100%",
        formatNoMatches: function () {
            return "Pencarian Tidak ditemukan";
        }
    });
    $(".select-full").removeClass("select-full");
}

function notif(type, message, notifType) {
    var template = $("#tmp-alert-" + type).html();
    Mustache.parse(template);
    var rendered = Mustache.render(template, {message: message});
    if (!notifType || notifType == "flashblock") {
        $("#flash-block").append(rendered);
    } else if (notifType == "growl") {
        if (type == "warning") {
            message = '<i class="icon-warning"></i>&nbsp;&nbsp;' + message;
        }
        $.growl[type]({title: "", message: message});
    }
}

function coolField() {
    $(".rupiah-field").wrap("<div class='input-group'></div>").before('<span class="input-group-addon">Rp.</span>').after('<span class="input-group-addon">,00.</span>');
    $(".rupiah-field").removeClass("rupiah-field");
    $(".persen-field").wrap("<div class='input-group'></div>").after('<span class="input-group-addon">%.</span>');
    $(".persen-field").removeClass("persen-field");
    $(".tenor-field").wrap("<div class='input-group'></div>").after('<span class="input-group-addon">Bulan</span>');
    $(".tenor-field").removeClass("tenor-field");

    $(".addon-field").each(function () {
        $(this).wrap("<div class='input-group'></div>").after('<span class="input-group-addon">' + $(this).data("addon-symbol") + '</span>');
        $(this).removeClass("addon-field");
    });
}