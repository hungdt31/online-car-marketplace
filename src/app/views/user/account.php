<div style="margin: 10px;">
    <h4>Profile</h4>
    <p>___ <?= htmlspecialchars($payload['email'], ENT_QUOTES, 'UTF-8') ?></p>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum, hic soluta! Animi hic odio, eum a cum, laborum deserunt obcaecati harum architecto dolore ratione nostrum repudiandae! Corporis accusamus temporibus nostrum.</p>
    <button class="btn btn-info" id="logout-btn">Đăng xuất</button>
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