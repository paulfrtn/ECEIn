function toggleDarkMode() {
  var element = document.body;
  element.classList.toggle("dark-mode");

  var Btn = document.getElementsByClassName("darkBtn");
  Btn.classList.toggle("dark-mode");

  var divHead = document.getElementsByClassName("page-header");
  var divNav = document.getElementsByClassName("navbar");
  var divNavBrand = document.getElementsByClassName("navbar-brand");
  var divFeature = document.getElementsByClassName("feature");
  var divFeed = document.getElementsByClassName("feed");
  var divFeedHead = document.getElementsByClassName("feedHead");
  var divFeedBody = document.getElementsByClassName("feedBody");
  var divColumn = document.getElementsByClassName("column");

  divHead.classList.toggle("dark-mode");
  divNavBrand.classList.toggle("dark-mode");
  divNav.classList.toggle("dark-mode");
  divFeature.classList.toggle("dark-mode");
  divFeed.classList.toggle("dark-mode");
  divFeedHead.classList.toggle("dark-mode");
  divFeedBody.classList.toggle("dark-mode");
  divColumn.classList.toggle("dark-mode");
}

$(document).ready(function () {
  $(".card").not(".card.zoom1").not(".card.req").click(function () {
    var cardId = $(this).attr("id");
    if (cardId === "menu") {
      // Code à exécuter lorsque l'ID est "menu"
    } else {
      var $clickedCard = $(this);
      if (!$clickedCard.hasClass("zoom1") && !$clickedCard.hasClass("req") ) {
        console.log('card');
        $(".card").removeClass("zoom1 zoom2");
        $clickedCard.addClass("zoom1");
        $(".card").not($clickedCard).addClass("zoom2");
        $clickedCard.closest(".card").siblings().remove();
        $clickedCard.closest(".card").parent().siblings().remove();
        $clickedCard.closest(".card").parent().parent().siblings().remove();
        $clickedCard.closest(".card").parent().parent().parent().siblings().remove();
        $clickedCard.children().siblings().remove();

        $clickedCard.load("friend_page.php", { cardId: cardId });
      }  
    }
  });

  $(".card.zoom1").on("click", ".friend_button", function () {
    var buttonId = $(this).attr("id");
    var card_ID = $('.card.zoom1').attr('id');

    location.reload();
      $.ajax({
        url: "friend_request.php",
        method: "POST",
        data: { card_ID: card_ID, buttonId: buttonId }, 
        success: function (response) {
          console.log(response);
        },
      });
  });

  $(".card.zoom1").on("click", ".leave", function () {


    location.reload();
  });

  $(".card.req").on("click", ".req_page", function () {
    var fId = $(this).attr("id");
    //console.log(fId);
    location.reload('friend_request.php');
    $.ajax({
      url: "ami_accept.php",
      method: "POST",
      data: { cardId: null, buttonId: null, fId:fId },
      success: function (response) {
        console.log(response);
      },
    });
  });


});
