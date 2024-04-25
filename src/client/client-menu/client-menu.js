function addToCart(menuItemId) {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    alert("Producto añadido al carrito");
  };
  xhttp.open("POST", "../../cart/addToCart/addToCart.php");
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("menuItemId=" + menuItemId);
}

function filterMenu(type) {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    document.getElementById("menuItems").innerHTML = this.responseText;
  };
  xhttp.open("GET", "fetchClientMenu.php?type=" + type);
  xhttp.send();
}

// Inicializar el menú con todos los ítems
filterMenu(); // Sin argumentos muestra todos los ítems
