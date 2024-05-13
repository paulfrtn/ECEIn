function toggleDarkMode() {
  var element = document.body;
  element.classList.toggle("dark-mode");

  var btn = document.getElementsByClassName("darkBtn")[0];
  btn.classList.toggle("dark-mode");

  var divHead = document.getElementsByClassName("page-header")[0];
  var divNav = document.getElementsByClassName("navbar")[0];
  var divNavBrand = document.getElementsByClassName("navbar-brand")[0];
  var divFeature = document.getElementsByClassName("features")[0];
  var divFeed = document.getElementsByClassName("feed")[0];
  var divFeedHead = document.getElementsByClassName("feedHead")[0];
  var divFeedBody = document.getElementsByClassName("feedBody")[0];
  var divColumn = document.getElementsByClassName("column");

  divHead.classList.toggle("dark-mode");
  divNav.classList.toggle("dark-mode");
  divNavBrand.classList.toggle("dark-mode");
  divFeature.classList.toggle("dark-mode");
  divFeed.classList.toggle("dark-mode");
  divFeedHead.classList.toggle("dark-mode");
  divFeedBody.classList.toggle("dark-mode");
  }
  
  window.addEventListener('DOMContentLoaded', function () {
    let xOffset = 0;
    let isMouseIn = false;
    const slides = document.getElementsByClassName("my_container");
    const slideWidth = slides[0].offsetWidth;
    const totalSlides = slides.length;
  
    setInterval(translate, 0);
  
    function translate() {
      for (let i = 0; i < slides.length; i++) {
        let offsetIncrementor = isMouseIn ? 0.05 : 0.02;
        xOffset = (xOffset + offsetIncrementor) % (slideWidth * totalSlides);
        slides[i].style.transform = "translateX(-" + xOffset + "px)";
      }
    }
  
   
  });
  
  document.getElementById("btn-evenement").addEventListener("click", function() { 
    document.getElementById("formulaire-container").style.display = "block";
  });
  
  
  