document.getElementById("addBranch").addEventListener("click", function () {
  window.location.href = "../../branch/create-branch/create-branch.php";
});

document.getElementById("viewBranch").addEventListener("click", function () {
  window.location.href = "../../branch/read-branch/read-branch.php";
});

document.getElementById("loadProductMenu").addEventListener("click", function () {
  window.location.href = "../../menu/create-menu/create-menu.html";
});

document.getElementById("viewMenu").addEventListener("click", function () {
  window.location.href = "../../menu/read-menu/read-menu.php";
});

document.getElementById("addFiscalInfo").addEventListener("click", function () {
  window.location.href = "../../tax-data/create-tax-data/create-tax-data.php";
});

document.getElementById("viewFiscalInfo").addEventListener("click", function () {
  window.location.href = "../../tax-data/read-tax-data/read-tax-data.php";
});

document.getElementById("consumptionHistory").addEventListener("click", function () {
  window.location.href = "../../company/company-record/company-record.html";
});

document.getElementById("customerFeedback").addEventListener("click", function () {
  window.location.href = "../../comment/read-comment/read-comment.html";
});

document.getElementById("viewGraph").addEventListener("click", function () {
  window.location.href = "../../company/company-graph/company-graph.html";
});
