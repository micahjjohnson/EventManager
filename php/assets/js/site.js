$( function (){
    var x = document.getElementById("snackbar");
    if((x != 'undefined') && (x != null))
    {
        // Add the "show" class to DIV
        x.className = "show";

        // After 4 seconds, remove the show class from DIV
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);
    }
});

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});