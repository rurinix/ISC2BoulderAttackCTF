$(window).resize(function() {
  if ($(window).width() >= 680) {
    $("#menu_bar").css("display", "flex");
  } else {
    $("#menu_bar").css("display", "none");
    $("#burger_btn").removeClass("is-active");
  }
});
  
$("#burger_btn").click(function () {
  $("#burger_btn").toggleClass( "is-active");
  if ($("#menu_bar").css('display') == 'none'){
    $("#menu_bar").slideDown("fast", "linear");}
  else{
    $("#menu_bar").slideUp("fast", "linear");}
});