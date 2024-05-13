function toggleDarkMode() {
  var element = document.body;
  var isDarkMode = element.classList.toggle("dark-mode");

  // Enregistrez l'état du mode sombre dans le stockage local
  localStorage.setItem("isDarkMode", isDarkMode);

  var classesToToggle = [
    "darkBtn",
    "navbar",
    "navbar-brand",
    "historique",
    "conversation",
    "wrapper",
    "actionMess",
    "submitmsg"
  ];

  classesToToggle.forEach(function (className) {
    var elements = document.getElementsByClassName(className);
    for (var i = 0; i < elements.length; i++) {
      elements[i].classList.toggle("dark-mode");
    }
  });
}

$(document).ready(function () {
  var isDarkMode = localStorage.getItem("isDarkMode");

  if (isDarkMode === "true") {
    toggleDarkMode();
    document.getElementById("dark_Btn").checked = true;
  }
});
