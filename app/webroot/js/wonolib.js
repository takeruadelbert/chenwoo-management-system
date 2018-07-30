function RP(rp) {
    if (rp == "") {
        return "Rp. 0";
    }
    while (/(\d+)(\d{3})/.test(rp.toString())) {
        rp = rp.toString().replace(/(\d+)(\d{3})/, '$1' + '.' + '$2');
    }
    return "Rp. " + rp + ",-";
}

function IDR(rp) {
    if (rp == "") {
        return "0";
    }
    var i;
    if((i=rp.toString().indexOf('.')) !== -1){
        rp=rp.toString().substr(0,i-1);
    }
    while (/(\d+)(\d{3})/.test(rp.toString())) {
        rp = rp.toString().replace(/(\d+)(\d{3})/, '$1' + '.' + '$2');
    }
    return rp;
}

function idr00(rp) {
    if (rp == "") {
        return "0";
    }
    while (/(\d+)(\d{3})/.test(rp.toString())) {
        rp = rp.toString().replace(/(\d+)(\d{3})/, '$1' + '.' + '$2');
    }
    return rp + ",00";
}

function nullToStrip(e) {
    if (e == null) {
        return "-";
    }
    return e;
}

/* source : http://stackoverflow.com/questions/822452/strip-html-from-text-javascript */
function removeHtmlTags(html)
{
    var tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
}