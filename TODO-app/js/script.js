// wanneer je op "create new list" klikt, verschijnt een venster waarin je de titel van jouw
// lijst kan geven en opslaan.

//$(document).ready(function(){
  $("#create_new_list").hide();
  $("#create_list_button").click(function(){
    $("#create_new_list").slideDown(1000);
    $(".list_items").hide();
   $("#cancel_button").click(function(){
     $("#create_new_list").hide();
  })
})
//})

// wanneer je op delete klikt bij een taak, verschijnt er een venster
//$(document).ready(function(){
  $("#delete_task").hide();
  $("#delete_task_button").click(function(){
    $("#delete_task").slideDown(1000);
    $("#cancel_task_button").click(function(){
      $("#delete_task").hide();
    })

  })

  $("#delete_list").hide();
  $("#delete_list_button").click(function(){
    $("#delete_list").slideDown(1000);
    $("#cancel_list_button").click(function(){
      $("#delete_list").hide();
    })

  })







//})
