document.addEventListener("DOMContentLoaded", function () {
  filterMenu("comida");
});

function addToCart(menuItemId) {
  window.location.href = "../../cart/selectIngredients/selectIngredients.php?menuItemId=" + menuItemId;
}

function filterMenu(type) {
  let url = "fetchClientMenu.php?type=" + type;

  if (type === 'precio') {
      url = "fetchClientMenu.php?orderBy=price";
  } else if (type === 'valorado') {
      url = "fetchClientMenu.php?orderBy=rating";
  }

  const xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
      document.getElementById("menuItems").innerHTML = this.responseText;
  };
  xhttp.open("GET", url);
  xhttp.send();
}

filterMenu("comida");
