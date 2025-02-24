<?php
    if (empty($user)) {
        // Tạo dữ liệu giả nếu mảng $user rỗng
        $user = [
            [
                "firstname" => "Nguyễn",
                "lastname" => "A",
                "email" => "nguyena@example.com",
                "reg_date" => "2023-01-01"
            ],
            [
                "firstname" => "Trần",
                "lastname" => "B",
                "email" => "tranb@example.com",
                "reg_date" => "2023-02-01"
            ]
        ];
    }
?>
<div class="container mt-3">
    <div class="row row-cols-1 row-cols-sm-2 g-4"> <!-- Bắt đầu với 1 cột và chuyển sang 2 cột khi SM -->
        <?php
        foreach ($user as $value) {
            ?>
            <div class="col">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($value["firstname"]) . ' - ' . htmlspecialchars($value["lastname"]); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($value["email"]); ?></h6>
                        <p class="card-text"><?php echo htmlspecialchars($value["reg_date"]); ?></p>
                        <a href="#" class="card-link">Xem thêm</a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <?php
            if(isset($_POST['button1'])) {
                echo "This is Button1 that is selected";
            }
            if(isset($_POST['button2'])) {
                echo "This is Button2 that is selected";
            }
        ?>
        <form method="post">
        <input type="submit" name="button1"
                value="Button1"/>
        
        <input type="submit" name="button2"
                value="Button2"/>
        </form>
    </div>
</div>