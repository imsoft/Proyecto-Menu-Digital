function updateOrderStatus(orderId, newState) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "updateOrderStatus.php", true); // Asegúrate que la ruta sea correcta.
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
    if (xhr.status === 200) {
      alert("Estado actualizado");
      location.reload(); // Recarga la página para reflejar los cambios
    } else {
      alert("Error al actualizar el estado: " + xhr.responseText);
    }
  };
  xhr.send("orderId=" + orderId + "&newState=" + newState);
}
