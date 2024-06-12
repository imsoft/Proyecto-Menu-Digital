document.addEventListener("DOMContentLoaded", function () {
  filterMenu("comida");
});

function addToCart(menuItemId) {
  // Redirigir a la página de selección de ingredientes
  window.location.href =
    "../../cart/selectIngredients/selectIngredients.php?menuItemId=" +
    menuItemId;
}

function filterMenu(type) {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    document.getElementById("menuItems").innerHTML = this.responseText;
  };
  xhttp.open("GET", "fetchClientMenu.php?type=" + type);
  xhttp.send();
}

// Inicializar el menú con 'comida'
filterMenu("comida");
