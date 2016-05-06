var currentMonthNo = 0;
var allDays = 0;
var firstDay = new Date();
var lastDay = new Date();
var htmls = '';
var allMonths = [{ "n": "1", "dateY": "2016","dateM":"3","alldays": "35", "days": "31", "empday": "4" }];
var isbgeinSell = true;

var today = new Date();
var drivesdayNum = 2;
var drivesId;
var bgeinSellday;
var dateServer = [];
var dateAll = [{
    "timeId": "",
    "drivesStock": "",
    "adultPrice": "",
    "daydata": ""
}];

$(function() {
    init();
    $.ajax({
        url: "/Api/Api/getDtp",
        data: { drivesId: drivesId },
        dataType: 'json',
        type: 'POST',
        success: function(data) {
            dateServer = data;
            getAllDays();
            addMonths();
            addAllDays();
            addMonthsDateHTmls();
        }
    });
});

function init(){
    drivesId = $('#drivesId').val();
    today = new Date($('#daytime').val().replace(/-/g, '/'));
    bgeinSellday = new Date(today.getFullYear(),today.getMonth(),today.getDate()+drivesdayNum);
    // console.log(today.toLocaleString());
}

function preMonth() {
    if (currentMonthNo != 0) {
        currentMonthNo--;
        $("#calendarprice").children().remove();
        addMonthsDateHTmls();
    }
}

function nextMonth() {
    if (currentMonthNo < allMonths.length - 1) {
        currentMonthNo++;
        $("#calendarprice").children().remove();
        addMonthsDateHTmls();
    }
}

function addMonthsDateHTmls() {
    htmls = '';
    var begin = 0;
    var end = -1;
    for (var j = 0; j < allMonths.length; j++) {
        end = end + parseInt(allMonths[j].alldays);
        if (currentMonthNo == allMonths[j].n) {
            begin = end - allMonths[j].alldays + 1;
            break;
        }
    }
    for (var i = begin; i <= end; i++) {
        //加空白区
        if (dateAll[i].daydata == "") {
            addEmptyDay();
        }
        //加可以选的日期
        if (dateAll[i].daydata != '' && dateAll[i].timeId != '') {
            addDay(dateAll[i].daydata, dateAll[i].adultPrice, dateAll[i].drivesStock,dateAll[i].timeId);
        }
        //加未添加的日期
        if (dateAll[i].daydata != '' && dateAll[i].timeId == '') {
            addPastDay(dateAll[i].daydata, dateAll[i].adultPrice);
        }
    }
    $("#calendarprice").append(htmls);
    var m = parseInt(allMonths[currentMonthNo].dateM);
    if(m<10){
        m = '0'+m;
    }
    $("#currentMonth").html(allMonths[currentMonthNo].dateY+"-"+m);
    if(parseInt(allMonths[currentMonthNo].dateY) == today.getFullYear() && parseInt(allMonths[currentMonthNo].dateM) == today.getMonth()+1){
        $('#'+today.getDate()).parent().addClass("today");
    }
    isbgeinSell = true;
}

function addDay(date, price, tickets, id) {
    var day = date.split('-');
    var days = parseInt(day[2]);
    if (isbgeinSell  && bgeinSellday.getTime() < new Date(date.replace(/-/g, '/')).getTime()){
        isbgeinSell = false;
    }
    if (tickets == '0') {
        htmls = htmls + '<div class="col col-14"><p class="dd" id="' + days + '">' + days +
            '</p><p class="price">' + parseInt(price) +
            '</p><p class="ticket">售罄</p><span class="timeId">'+id+'</span></div>';
    } else if(isbgeinSell){
                htmls = htmls + '<div class="col col-14"><p class="dd"  id="' + days + '">' + days +
            '</p><p class="price">' + parseInt(price) +
            '</p><p class="ticket">售罄</p><span class="timeId">'+id+'</span></div>';
    } else {
        htmls = htmls + '<div class="col col-14"><p  class="dd"  id="' + days + '">' + days +
            '</p><p class="price">' + parseInt(price) +
            '</p><p class="ticket">余' + tickets +
            '</p><span class="timeId">'+id+'</span></div>';
    }
}

function addPastDay(date, price) {
    var day = date.split('-');
    var days = parseInt(day[2]);
    htmls = htmls + '<div class="col col-14 disabled"><p class="dd"  id="' + days + '">' + days +
        '</p><p class="price">' + price +
        '</p><p class="ticket"></p></div>';
}


function addEmptyDay() {
    htmls = htmls + '<div class="col col-14 disabled"></div>';
}
//初始化dateAll
function addAllDays() {
    var index = 0;
    var currDate = firstDay;
    var dateServerNum = 0;
    var dateServerDate = new Date(dateServer[dateServerNum].daydata.replace(/-/g, '/'));
    for (var i = 0; i < allMonths.length; i++) {
        for (var j = 0; j < allMonths[i].empday; j++) {
            dateAll.push({ "timeId": "", "drivesStock": "", "adultPrice": "", "daydata": ""});
            index++;
        }
        for (var k = 0; k < allMonths[i].days; k++) {
            dateAll.push({ "timeId": "", "drivesStock": "", "adultPrice": "", "daydata": ""});
            if (currDate.toLocaleString() == dateServerDate.toLocaleString()) {
                dateAll[index] = dateServer[dateServerNum];
                if (dateServerNum < dateServer.length - 1) {
                    dateServerNum++;
                    dateServerDate = new Date(dateServer[dateServerNum].daydata.replace(/-/g, '/'));
                }
            } else {
                dateAll[index].daydata = currDate.getFullYear() + '-' + (currDate.getMonth() + 1) + '-' + currDate.getDate();
            }
            currDate.setDate(currDate.getDate() + 1);
            index++;
        }
        for (var l = 0; l < (allMonths[i].alldays - allMonths[i].empday - allMonths[i].days); l++) {
            index++;
            if (index != allDays) {
                dateAll.push({ "timeId": "", "drivesStock": "", "adultPrice": "", "daydata": ""});
            }
        }
    }
    // console.log(dateAll);
}


function addMonths() {
    var year1 = firstDay.getFullYear();
    var month1 = firstDay.getMonth();
    var year2 = lastDay.getFullYear();
    var month2 = lastDay.getMonth();
    //通过年,月差计算月份差
    var nextMonthDate = firstDay;
    var monthss = (year2 - year1) * 12 + (month2 - month1) + 1;
    for (var i = 1; i < monthss; i++) {
        allMonths.push({ "n": "1", "dateY": "2016","dateM":"3","alldays": "35", "days": "31", "empday": "4" });
    }
    for (var i = 0; i < monthss; i++) {
        allMonths[i].n = i;
        allMonths[i].dateY = nextMonthDate.getFullYear();
        allMonths[i].dateM = (nextMonthDate.getMonth() + 1);
        var first = new Date(nextMonthDate.getFullYear(), nextMonthDate.getMonth(), 1).getDay();
        var last = 32 - new Date(nextMonthDate.getFullYear(), nextMonthDate.getMonth(), 32).getDate();
        var amonthDays = Math.ceil((first + last) / 7) * 7;
        allMonths[i].alldays = amonthDays;
        allDays = allDays + amonthDays;
        // 这个月有几天
        var lastMonth = nextMonthDate.getMonth() + 1;
        var lastYear = nextMonthDate.getFullYear();
        if (lastMonth > 12) //如果当前大于12月，则年份转到下一年         
        {
            lastMonth -= 12; //月份减         
            lastYear++; //年份增         
        }
        allMonths[i].days = new Date(new Date(lastYear, lastMonth, 1).getTime() - 1000 * 60 * 60 * 24).getDate();
        allMonths[i].empday = nextMonthDate.getDay();
        nextMonthDate = new Date(lastYear, lastMonth, 1);
    }
    // console.log(allMonths);
}


function getMonthWeek(a, b, c) {
    var date = new Date(a, parseInt(b) - 1, c),
        w = date.getDay(),
        d = date.getDate();
    return Math.ceil((d + 6 - w) / 7);
}


function getAllDays() {
    var firstSellDay = new Date(dateServer[0].daydata.replace(/-/g, '/'));
    var lastSellDay = new Date(dateServer[dateServer.length - 1].daydata.replace(/-/g, '/'));
    var lastMonth = lastSellDay.getMonth() + 1;
    var lastYear = lastSellDay.getFullYear();
    if (lastMonth > 12) //如果当前大于12月，则年份转到下一年         
    {
        lastMonth -= 12; //月份减         
        lastYear++; //年份增         
    }

    firstDay = new Date(firstSellDay.getFullYear(), firstSellDay.getMonth(), 1);
    //获得当月最后一天的日期
    lastDay = new Date(new Date(lastYear, lastMonth, 1).getTime() - 1000 * 60 * 60 * 24);
}