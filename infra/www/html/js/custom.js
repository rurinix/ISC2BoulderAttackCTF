$(window).resize(function() {
  if ($(window).innerWidth() >= 680) {
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

const observerOptions = {
  threshold: 0,
  rootMargin: "0px 0px -50px 0px"
}

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    console.log(entry)
    if (!entry.isIntersecting) {
      return;
    }
    else {
      entry.target.classList.add('zoom');
      observer.unobserve(entry.target);
    }
  });
}, observerOptions);

const action_item_Elements = document.querySelectorAll ('.action_item');
action_item_Elements.forEach((el) => observer.observe(el));


function openTab(evt, tabName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(tabName).style.display = "inline-flex";
  evt.currentTarget.className += " active";
}


$('#user_name').on('input', function() {
  const username = $(this).val().trim();
  const msg = $('#username_check_msg');

  if (username.length === 0) {
      msg.text('');
      return;
  }

  // Only check if input matches valid pattern
  if (!/^[a-zA-Z0-9\-_]+$/.test(username)) {
      msg.text('');
      return;
  }

  $.ajax({
    url: 'check_username.php',
    method: 'POST',
    data: { user_name: username },
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
    success: function(response) {
        if (response.exists) {
            msg.html('This account exists — are you sure you want to play as <span class="player_name">' + username + '</span>?');
        } else {
            msg.text('');
        }
    }
  });
});
