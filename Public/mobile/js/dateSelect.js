var theYear = new Date().getFullYear();
var theMonth = new Date().getMonth();
var theDay = new Date().getDate();
var theFirstDay = new Date(theYear, theMonth, 1);
var currY = theYear;
var currM = theMonth;
$(function() {
    addHtml();
    if(currM+1<10){
        $("#currentMonth").html(currY+"-0"+(currM+1));
    }else{
        $("#currentMonth").html(currY+"-"+(currM+1));
    }
    // $("#today").html(new Date().getFullYear()+"-"+(new Date().getMonth()+1)+"-"+new Date().getDate());
});


function addHtml(){
    var htmls = '';
    if(currM>11){
        currM = currM %12;
        currY++;
    }else if(currM<0){
        currM = 11;
        currY--;
    }
    var firstDay = new Date(currY,currM,1);
    //获得当月最后一天的日期
    var lastDay = new Date(currY,currM+1, 0);
    var days = lastDay.getDate();
    var emptyDays =  firstDay.getDay();

    for(var i = 0; i<emptyDays;i++){
        htmls = htmls + '<div class="dateSelect"><div class="dateSelectDay"></div></div>';
    }
    for(var j = 0;j<days; j++){
        htmls = htmls + '<div class="dateSelect"><div id="' + currY +'-'+ (currM+1) +'-'+ (j+1) + '" class="dateSelectDay">'+(j+1)+'</div></div>';
    }
    $("#calendarSelect").append(htmls);
    $("#"+new Date().getFullYear()+"-"+(new Date().getMonth()+1)+"-"+new Date().getDate()).addClass("today");
}

function nextMonth() {
    $("#calendarSelect").children().remove();
    currM++;
    addHtml();
    if(currM+1<10){
        $("#currentMonth").html(currY+"-0"+(currM+1));
    }else{
        $("#currentMonth").html(currY+"-"+(currM+1));
    }
}

function preMonth() {
    $("#calendarSelect").children().remove();
    currM--;
    addHtml();
    if(currM+1<10){
        $("#currentMonth").html(currY+"-0"+(currM+1));
    }else{
        $("#currentMonth").html(currY+"-"+(currM+1));
    }
}