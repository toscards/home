 function date_time(id)
{
        date = new Date;
        year = date.getFullYear();
        month = date.getMonth();
        months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'Jully', 'August', 'September', 'October', 'November', 'December');
        d = date.getDate();
        day = date.getDay();
        days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        h = date.getHours();
       /*  if(h<10)
        {
                h = "0"+h;
        } */
		
		var suffix = "AM";
		if (h >= 12) {
		suffix = "PM";
		h = h - 12;
		}
			if (h == 0) {
			h = 12;
		}
	
        m = date.getMinutes();
        if(m<10)
        {
                m = "0"+m;
        }
		
        s = date.getSeconds();
        if(s<10)
        {
                s = "0"+s;
        }
        result = '<b>'+months[month]+' '+d+', '+year+' - '+days[day]+' - '+h+':'+m+' '+suffix+'</b>';
        document.getElementById(id).innerHTML = result;
        setTimeout('date_time("'+id+'");','1000');
        return true;
}
