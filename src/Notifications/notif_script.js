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
  