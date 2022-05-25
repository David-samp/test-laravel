var dates = document.getElementsByClassName("timetolocalezone");
for (var i = 0; i < dates.length; i++) {
   let date = $(dates.item(i)).html();
   let cdate = new Date (date);
   let ndate = new Date(Date.UTC(cdate.getFullYear(), cdate.getMonth(), cdate.getDate(), cdate.getHours(), cdate.getMinutes(), cdate.getSeconds()));
   let strdate = ndate.toLocaleString().replace(",", " ");
   $(dates.item(i)).html(strdate);
}
