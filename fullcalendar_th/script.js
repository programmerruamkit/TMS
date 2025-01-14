$(function(){

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',  
            center: 'title',
            right: 'month,agendaWeek,agendaDay',
        },  
        buttonIcons:{
            prev: 'left-single-arrow',
            next: 'right-single-arrow',
            prevYear: 'left-double-arrow',
            nextYear: 'right-double-arrow'         
        },       
        events: {
            url: 'meg_calendar.php',
            error: function() {

            }
        },    
        eventLimit:true,
        lang: 'th',
        dayClick: function() {
        }        
    });
  
    
});