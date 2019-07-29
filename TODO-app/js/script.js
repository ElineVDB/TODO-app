// wanneer je op "create new list" klikt, verschijnt een venster waarin je de titel van jouw
// lijst kan geven en opslaan.

$(document).ready(function(){
  $("#create_new_list").hide();
  $("#create_list_button").click(function(){
    $("#create_new_list").show(1000);
   $("#cancel_button").click(function(){
     $("#create_new_list").hide();
  })
})
})
