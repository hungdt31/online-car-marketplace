<?php
$currentTab = $_GET['tab'] ?? 'profile';
?>
<div class="profile-container">
    <!-- Top Navigation Area -->
    <div class="top-nav">
        <div class="user-profile">
            <?php if (!empty($profile['avatar'])): ?>
                <img src="<?= htmlspecialchars($profile['avatar'], ENT_QUOTES, 'UTF-8') ?>" alt="Avatar" class="avatar">
            <?php else: ?>
                <div class="avatar">
                    <i class="fa fa-user-circle"></i>
                </div>
            <?php endif; ?>
            <div class="user-info">
                <h4><?= htmlspecialchars($profile['username'], ENT_QUOTES, 'UTF-8') ?></h4>
                <p><?= htmlspecialchars($profile['email'], ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        </div>

        <div class="nav-links">
            <a href="?tab=profile" class="nav-link <?= $currentTab === 'profile' ? 'active' : '' ?>">
                <i class="fa fa-user"></i>
                Personal Information
            </a>
            <a href="?tab=appointments" class="nav-link <?= $currentTab === 'appointments' ? 'active' : '' ?>">
                <i class="fa fa-calendar"></i>
                Appointments
            </a>
            <button class="btn-danger btn" id="logout-btn">
                <i class="fa fa-sign-out"></i>
                Log out
            </button>
        </div>
    </div>

    <!-- Content Area -->
    <?php if ($currentTab === 'profile'): ?>
        <?php
            RenderSystem::renderOne('components', 'Account/profile', [
                'profile' => $profile
            ]);
        ?>
    <?php elseif ($currentTab === 'appointments'): ?>
        <?php
            RenderSystem::renderOne('components', 'Account/appointments', [
                'appointments' => $appointments,
            ]);
        ?>
    <?php endif; ?>
</div>

<style>
    <?php 
        RenderSystem::renderOne('assets', 'static/css/account/index.css');
    ?>
</style>

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