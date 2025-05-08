<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <a href="<?= _WEB_ROOT ?>/dashboard" class="nav_logo">
                <img src="<?= _WEB_ROOT ?>/assets/static/images/carvan-logo.svg" alt="Logo" class="logo" width="100px">
            </a>
            <div class="nav_list">
                <?php
                foreach ($menu as $item) {
                    echo '<a href="' . $item['link'] . '" class="nav_link ' . ($item['link'] == _WEB_ROOT . $_SERVER['REQUEST_URI'] ? 'active' : '') . '">';
                    echo '<i class="' . $item['icon'] . '"></i>';
                    echo '<span class="nav_name">' . $item['name'] . '</span>';
                    echo '</a>';
                }
                ?>
            </div>
        </div>
        <a href="#" class="nav_link" id="out-btn">
            <i class="bi bi-box-arrow-right"></i>
            <span class="nav_name">SignOut</span>
        </a>
    </nav>
</div>

<script>
    $(document).ready(function() {
        // Logout button functionality
        $('#out-btn').click(function() {
            $.ajax({
                type: 'POST',
                url: '/auth/logout',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href = '/auth';
                        }, 2000);
                    }
                }
            });
        });
    });
</script>