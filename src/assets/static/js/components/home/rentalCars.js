$(document).ready(function () {
    const $carsGrid = $("#carsGridContainer");
    let isLoading = false;

    function showLoading() {
        $carsGrid.html('<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-2">Loading cars...</p></div>');
    }

    function fetchCarsByCategory(categoryId) {
        if (isLoading) return;

        isLoading = true;
        showLoading();

        $.ajax({
            url: "/home/getCarsByCategory",
            type: "POST",
            dataType: "html",
            data: { category_id: categoryId },
            success: function (response) {
                $carsGrid.fadeOut(200, function () {
                    $carsGrid.html(response).fadeIn(200);
                });
            },
            error: function () {
                $carsGrid.html('<div class="alert alert-danger text-center">Failed to load cars. Please try again.</div>');
                toastr.error("Cannot get cars by category!");
            },
            complete: function () {
                isLoading = false;
            }
        });
    }

    // Initial load with empty category (All)
    fetchCarsByCategory("");

    // Category click handler
    $(".category-item").click(function () {
        if (isLoading) return;

        $(".category-item").removeClass("active");
        $(this).addClass("active");

        let selectedCategory = $(this).attr("data-category");
        fetchCarsByCategory(selectedCategory);
    });
});