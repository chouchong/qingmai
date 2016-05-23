var theYear = new Date().getFullYear();
var theMonth = new Date().getMonth();
var theDay = new Date().getDate();
var theFirstDay = new Date(theYear, theMonth, 1);
var currY = theYear;
var currM = theMonth;
var servertoday = "2016-05-23";
var servertodays = new Array("2016", "05", "23");

$(function() {
    if (init()) {
        addHtml();
        var currM1 = (currM + 1) < 10 ? '0' + (currM + 1) : (currM + 1);
        $("#currentMonth").html(currY + "-" + currM1);
        $("#today").html(currY + "-" + currM1 + "-" + theDay);
    }
});

function init() {
    if ($("#servertoday").val() != null && $("#servertoday").val() != "") {
        servertoday = $("#servertoday").val();
        servertodays = servertoday.split("-");
        theYear = parseInt(servertodays[0]);
        theMonth = parseInt(servertodays[1]) - 1;
        theDay = parseInt(servertodays[2]);
        theFirstDay = new Date(theYear, theMonth, 1);
        currY = theYear;
        currM = theMonth;
        // console.log(currY + "--" + (theMonth + 1) + "--" + theDay);
        return true;
    } else {//获取不到服务器时间， 本地时间
        // console.log(currY + "--" + (theMonth + 1) + "--" + theDay);
        alert("链接服务器失败!!!!请重新加载.......");
        return false;
    }
}

function addHtml() {
    var htmls = '';
    if (currM > 11) {
        currM = currM % 12;
        currY++;
    } else if (currM < 0) {
        currM = 11;
        currY--;
    }
    var firstDay = new Date(currY, currM, 1);
    //获得当月最后一天的日期
    var lastDay = new Date(currY, currM + 1, 0);
    var days = lastDay.getDate();
    var emptyDays = firstDay.getDay();

    for (var i = 0; i < emptyDays; i++) {
        htmls = htmls + '<div class="dateSelect"><div class="dateSelectDay"></div></div>';
    }
    var currM1 = (currM + 1) < 10 ? '0' + (currM + 1) : (currM + 1);
    for (var j = 0; j < days; j++) {
        var selecteD1 = (j + 1) < 10 ? '0' + (j + 1) : (j + 1);
        htmls = htmls + '<div class="dateSelect"><div id="' + currY + '-' + currM1 + '-' + selecteD1 + '" class="dateSelectDay">' + (j + 1) + '</div></div>';
    }
    $("#calendarSelect").append(htmls);
    var theMonth1 = (theMonth + 1) < 10 ? '0' + (theMonth + 1) : (theMonth + 1);
    $("#" + currY + "-" + theMonth1 + "-" + theDay).addClass("today");
}

function nextMonth() {
    $("#calendarSelect").children().remove();
    currM++;
    addHtml();
    var currM1 = (currM + 1) < 10 ? '0' + (currM + 1) : (currM + 1);
    $("#currentMonth").html(currY + "-" + currM1);
    scenic_heightchange();
}

function preMonth() {
    $("#calendarSelect").children().remove();
    currM--;
    addHtml();
    var currM1 = (currM + 1) < 10 ? '0' + (currM + 1) : (currM + 1);
    $("#currentMonth").html(currY + "-" + currM1);
    scenic_heightchange();
}
