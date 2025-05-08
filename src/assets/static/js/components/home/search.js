// document.addEventListener("DOMContentLoaded", function () {
//     const form = document.getElementById("searchForm");
//     const resultsContainer = document.getElementById("searchResults");

//     form.addEventListener("submit", function (e) {
//         e.preventDefault(); // Ngăn reload trang

//         const formData = new FormData(form);
//         const params = new URLSearchParams(formData).toString();

//         fetch("search_cars.php?" + params)
//             .then((response) => response.text())
//             .then((data) => {
//                 resultsContainer.innerHTML = data;
//             })
//             .catch((error) => {
//                 resultsContainer.innerHTML = `<p style="color:red;">Error: ${error}</p>`;
//             });
//     });
// });
