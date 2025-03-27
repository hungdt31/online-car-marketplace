$(document).ready(function () {
    function fetchCarsByCategory(categoryId) {
        $.ajax({
            url: "/home/getCarsByCategory",
            type: "POST",
            dataType: "html",
            data: { category_id: categoryId },
            success: function (response) {
                $(".cars-grid").html(response);
            },
            error: function () {
                toastr.error("Cannot get cars by category!");
            }
        });
    }

    // 🔹 Khi trang vừa load, tự động lấy danh mục đang active (nếu có)
    let initialCategory = $(".category-item.active").attr("data-category");
    fetchCarsByCategory(initialCategory);

    // 🔹 Khi click vào một danh mục
    $(".category-item").click(function () {
        $(".category-item").removeClass("active");
        $(this).addClass("active");

        let selectedCategory = $(this).attr("data-category");
        fetchCarsByCategory(selectedCategory);
    });
});