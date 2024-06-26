document.addEventListener("DOMContentLoaded", function () {
  loadRestaurants(); // Carga los restaurantes al cargar la página

  document.getElementById("restaurant").addEventListener("change", function () {
    loadBranches(this.value); // Carga las sucursales cuando se selecciona un restaurante
  });
});

function loadRestaurants() {
  fetch("getRestaurants.php") // Asegúrate de que la ruta es correcta
    .then((response) => response.json())
    .then((data) => {
      const select = document.getElementById("restaurant");
      select.innerHTML =
        '<option value="">-- Selecciona Restaurante --</option>';
      data.forEach((restaurant) => {
        const option = new Option(restaurant.name, restaurant.id);
        select.appendChild(option);
      });
    })
    .catch((error) => console.error("Error loading restaurants:", error));
}

function loadBranches(companyId) {
  fetch(`getBranches.php?companyId=${companyId}`) // Asegúrate de que la URL es correcta
    .then((response) => response.json())
    .then((data) => {
      const branchSelect = document.getElementById("branch");
      branchSelect.innerHTML =
        '<option value="">-- Selecciona Sucursal --</option>';
      data.forEach((branch) => {
        const option = new Option(branch.branch_name, branch.id);
        branchSelect.appendChild(option);
      });
    })
    .catch((error) => console.error("Error loading branches:", error));
}

document.getElementById("viewComments").addEventListener("click", function () {
  window.location.href = "../read-comment/read-comment.php";
});

document.getElementById("restaurant").addEventListener("change", function () {
  const restaurantId = this.value;
  const branchSelect = document.getElementById("branch");
  branchSelect.innerHTML =
    '<option value="">-- Selecciona Sucursal --</option>';
  branchSelect.innerHTML += '<option value="0">No aplica</option>'; // Añadir opción "No aplica"

  if (restaurantId) {
    fetch("get-branches.php?restaurant_id=" + restaurantId)
      .then((response) => response.json())
      .then((data) => {
        if (data.length > 0) {
          data.forEach((branch) => {
            branchSelect.innerHTML += `<option value="${branch.id}">${branch.branch_name}</option>`;
          });
        } else {
          branchSelect.innerHTML = '<option value="0">No aplica</option>';
        }
      });
  } else {
    branchSelect.innerHTML =
      '<option value="">-- Selecciona Sucursal --</option>';
    branchSelect.innerHTML += '<option value="0">No aplica</option>';
  }
});
