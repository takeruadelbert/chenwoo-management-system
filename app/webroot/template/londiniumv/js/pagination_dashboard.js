function renderPaginationNews(paginationInfo, datas, template, target, totalButton) {
    var queryString, m, page;
    totalButton = typeof totalButton !== 'undefined' ? totalButton : 5;
    var symmetryCount = Math.floor(parseInt(totalButton) / 2);
    var totalButtonBefore = paginationInfo.currentPage - 1;
    var totalButtonAfter = paginationInfo.totalPage - paginationInfo.currentPage;
    var countButtonBefore = totalButtonBefore > symmetryCount ? symmetryCount : totalButtonBefore;
    var countButtonAfter = totalButtonAfter > symmetryCount ? symmetryCount : totalButtonAfter;
    if (countButtonBefore <= 0 && countButtonAfter <= 0) {
        var buttonBefore = 0;
        var buttonAfter = 0;
    } else {
        var buttonBefore = countButtonBefore + (symmetryCount - countButtonAfter);
        var buttonAfter = countButtonAfter + (symmetryCount - countButtonBefore);
    }
    var dataPush = {
        prev: false,
        next: false,
        buttonBefore: [],
        buttonAfter: [],
        buttonCurrent: {},
    };
    if (paginationInfo.currentPage != 1) {
        page = parseInt(paginationInfo.currentPage) - 1;
        dataPush['prev'] = {
            href: "#",
            onclick:  datas + '(' + page + ')' ,
        };
    }
    for (var n = buttonBefore; n >= 1; n--) {
        m = parseInt(paginationInfo.currentPage) - n;
        if (m < 1) {
            continue;
        }
        dataPush["buttonBefore"].push({
            href: "#",
            onclick:  datas + '(' + m + ')' ,
            number: m,
        });
    }
    dataPush["buttonCurrent"] = {
        href: "#",
        number: parseInt(paginationInfo.currentPage),
    };
    for (var n = 1; n <= buttonAfter; n++) {
        m = parseInt(paginationInfo.currentPage) + n;
        if (m > paginationInfo.totalPage) {
            continue;
        }
        dataPush["buttonAfter"].push({
            href: "#",
            onclick:  datas + '(' + m + ')' ,
            number: m,
        });
    }
    if (paginationInfo.currentPage != paginationInfo.totalPage) {
        page = parseInt(paginationInfo.currentPage) + 1;
        dataPush['next'] = {
            href: "#",
            onclick:  datas + '(' + page + ')' ,
        };
    }
    var source = $(template).html();
    var template = Handlebars.compile(source);
    var html = template(dataPush)
    $(target).html(html);
}
