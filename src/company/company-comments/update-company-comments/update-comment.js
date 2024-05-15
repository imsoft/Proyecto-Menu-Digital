function updateBranches(companyId) {
  if (companyId) {
    fetch(`getBranches.php?company_id=${companyId}`)
      .then((response) => response.json())
      .then((data) => {
        const branchSelect = document.getElementById("branch");
        branchSelect.innerHTML =
          '<option value="">-- Selecciona Sucursal --</option>';
        data.forEach((branch) => {
          branchSelect.innerHTML += `<option value="${branch.id}">${branch.branch_name}</option>`;
        });
      })
      .catch((error) =>
        console.error("Error al obtener las sucursales:", error)
      );
  } else {
    const branchSelect = document.getElementById("branch");
    branchSelect.innerHTML =
      '<option value="">-- Selecciona Sucursal --</option>';
  }
}
