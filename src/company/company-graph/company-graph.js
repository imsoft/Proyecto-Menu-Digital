document.addEventListener("DOMContentLoaded", function () {
  loadGenderData();
  loadCommentRatings();
});

function loadGenderData() {
  fetch("fetchGenderData.php")
    .then((response) => response.json())
    .then((data) => {
      const ctx = document.getElementById("genderChart").getContext("2d");
      const labels = data.map((item) => item.gender);
      const counts = data.map((item) => item.count);

      new Chart(ctx, {
        type: "pie",
        data: {
          labels: labels,
          datasets: [
            {
              label: "Gender Distribution",
              data: counts,
              backgroundColor: ["blue", "pink", "green"],
            },
          ],
        },
      });
    });
}

function loadCommentRatings() {
  fetch("fetchCommentRatings.php")
    .then((response) => response.json())
    .then((data) => {
      const ctx = document.getElementById("ratingsChart").getContext("2d");
      const labels = data.map((item) => item.rating);
      const counts = data.map((item) => item.count);

      new Chart(ctx, {
        type: "pie",
        data: {
          labels: labels,
          datasets: [
            {
              label: "Comment Ratings",
              data: counts,
              backgroundColor: ["green", "yellow", "red"],
            },
          ],
        },
      });
    });
}
