document.getElementById("tableButton").addEventListener("click", function () {
  window.location.href = "../../table/table.php";
});

document.getElementById("menuButton").addEventListener("click", function () {
  window.location.href = "../select-business-branch/select-business-branch.php";
});

document.getElementById("statusButton").addEventListener("click", function () {
  window.location.href = "../preparation-status/preparation-status.php";
});

document
  .getElementById("commentsButton")
  .addEventListener("click", function () {
    window.location.href = "../../comment/create-comment/create-comment.php";
  });
