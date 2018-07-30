$(document).ready(function () {
    $(".navigation").find(".active").parentsUntil($(".navigation")).siblings(".level-closed").trigger("click");
    $(".paginate_button").on("click", function () {
        if ($(this).find("a").length > 0) {
            window.location = $(this).find("a").attr("href");
        }
    });

})

function filterReload() {
    $(".toggle-bar").click(function () {
        var target = $(this).data("toggle-target");
        $(".toggle-target").not("*[data-toggle-id='" + target + "']").hide();
        $("*[data-toggle-id='" + target + "']").slideToggle();
    })
}

function displayError(data) {

}

function modalChangepp() {
    $("#modalgantipp").modal("show");
}

function exp(type, link) {
    switch (type) {
        case "print":
            window.open(link);
            break;
        case "excel":
            window.open(link);
            break;
        case "pdf":
            window.open(link);
            break;
    }
}

function empty_strip(input) {
    if (input == null || input == "") {
        return "-";
    } else {
        return input;
    }
}

/* this function is removing all tags HTML
 * source : http://stackoverflow.com/questions/13911681/remove-html-tags-from-a-javascript-string */
function removeTags(text) {
    var txt = text;
    var rex = /(<([^>]+)>)/ig;
    return txt.replace(rex, "");
}

function cvtTanggal(date) {
    if (date) {
        var d = new Date(date);
        return d.getUTCDate() + " " + bulan[d.getUTCMonth()] + " " + d.getUTCFullYear();
//        return d.getDate() + " " + d.getMonth() + " " + d.getFullYear()();
    } else {
        return "-";
    }
}

function cvtWaktu(date) {
    var d = new Date(date);
    return d.getUTCDate() + " " + bulan[d.getUTCMonth()] + " " + d.getUTCFullYear() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
}

//https://gist.github.com/skattyadz/1285806
function timeAgo(time) {
    var units = [
        {name: "detik", limit: 60, in_seconds: 1},
        {name: "menit", limit: 3600, in_seconds: 60},
        {name: "jam", limit: 86400, in_seconds: 3600},
        {name: "hari", limit: 604800, in_seconds: 86400},
        {name: "minggu", limit: 2629743, in_seconds: 604800},
        {name: "bulan", limit: 31556926, in_seconds: 2629743},
        {name: "tahun", limit: null, in_seconds: 31556926}
    ];
    var diff = (new Date() - new Date(time)) / 1000;
    if (diff < 5)
        return "kurang dari 5 detik yang lalu";

    var i = 0, unit;
    while (unit = units[i++]) {
        if (diff < unit.limit || !unit.limit) {
            var diff = Math.floor(diff / unit.in_seconds);
            return diff + " " + unit.name;
        }
    }
}

function RP(rp) {
    if (rp == "") {
        return "Rp. 0";
    }
    while (/(\d+)(\d{3})/.test(rp.toString())) {
        rp = rp.toString().replace(/(\d+)(\d{3})/, '$1' + '.' + '$2');
    }
    return "Rp. " + rp + ",00";
}

function IndonesianRupiah(rp) {
    if (rp == "") {
        return "0";
    }
    while (/(\d+)(\d{3})/.test(rp.toString())) {
        rp = rp.toString().replace(/(\d+)(\d{3})/, '$1' + '.' + '$2');
    }
    return rp + ",00";
}

Handlebars.registerHelper('RP', function (rp) {
    return RP(rp);
});

Handlebars.registerHelper('IndonesianRupiah', function (rp) {
    return IndonesianRupiah(rp);
});

Handlebars.registerHelper('removeTags', function (text) {
    return removeTags(text);
});

Handlebars.registerHelper('cvtTanggal', function (date) {
    return cvtTanggal(date);
});

Handlebars.registerHelper('isRead', function (newsId) {
    var status = false;
    var employeeId = 0;
    /* get current employee id login */
    $.ajax({
        url: BASE_URL + "admin/accounts/get_data_login",
        type: "GET",
        dataType: "JSON",
        data: {},
        success: function (data) {
            employeeId = data.Employee.id;
            $.ajax({
                url: BASE_URL + "admin/seen_news/get_status_news/" + newsId + "/" + employeeId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (response) {
                    status = response;
                },
                async: false
            });
        },
        async: false
    });
    if (status) {
        return "<span class='label label-success'>Sudah Dibaca</span>";
    } else {
        return "<span class='label label-danger'>Belum Dibaca</span>";
    }
});

Handlebars.registerHelper('timeAgo', function (time) {
    return timeAgo(time);
});

Handlebars.registerHelper('editNews', function (newsId) {
    return BASE_URL + "admin/internal_news/edit/" + newsId;
});

Handlebars.registerHelper('removeNews', function () {
    return BASE_URL + "admin/internal_news";
});

Handlebars.registerHelper('hasAccess', function (newsAuthorId) {
    var employeeId = 0;
    var userGroup = "";
    $.ajax({
        url: BASE_URL + "admin/accounts/get_data_login",
        type: "GET",
        dataType: "JSON",
        data: {},
        success: function (data) {
            employeeId = data.Employee.id;
            userGroup = data.User.UserGroup.name;
        },
        async: false
    });
    if ((newsAuthorId == employeeId) || (userGroup == 'admin')) {
        return true;
    } else {
        return false;
    }
});