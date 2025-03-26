<div style="margin: 10px;">
    <div style="text-align: center;">
        <?php
        echo '<h3 style="margin-top: 50px;">';
        print_r($title);
        echo '</h3>';
        ?>
        <p>#<?= htmlspecialchars($payload['email'], ENT_QUOTES, 'UTF-8') ?></p>
    </div>
    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quas iusto nihil dolorem reiciendis vero laboriosam in, voluptate dicta pariatur eum nemo fuga earum quisquam sint tenetur, cupiditate quibusdam! Hic, obcaecati?</p>
    <button class="btn btn-info" id="logout-btn">Log out</button>
</div>
<script>
    $(document).ready(function() {
        $('#logout-btn').click(function() {
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