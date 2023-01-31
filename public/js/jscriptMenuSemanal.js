$(document).ready(function(){
 $('#calendarioWeb').fullCalendar({

  header:{
    left:'today, prev, next',
    center:'title',
    right:'month, basicWeek, basicDay'
  },
  dayClick:function(date, jsEvent, view){

    //alert("valor seleccionado: "+date.format());
    //alert("Vista actual "+view.name);
    //$(this).css('background-color','red');
    $('#menu').modal();

  },

  events:[
    {
      title: 'Almuerzo 1',
      description: "Almuerzo holaaaa",
      start: '2019-04-24',
      textColor: "#000",
      backgroundColor: "Yellow",
      borderColor: "yellow"
    },
    {
      title: 'cena',
      description: "Almuerzo como estas",
      start: '2019-04-24',
      end: '2019-04-27',
      textColor: "#000",
      backgroundColor: "red",
      borderColor: "red"
    },

    {
      title: 'Almuerzo 3',
      description: "Almuerzo despues de tiempo",
      start: '2019-04-28T12:30:00',
      allDay: false,
      textColor: "#000",
      backgroundColor: "green",
      borderColor: "green"
    },

  ],
  
  eventClick: function(calEvent, jsEvent, view) {
    $('#menu').modal();
  }


 });     
});