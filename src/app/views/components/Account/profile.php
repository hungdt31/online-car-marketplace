<div class="card">
    <div class="card-header">
        <h3 class="card-title">Personal Information</h3>
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="timestamp-info">
                    <small class="text-muted d-flex align-items-center">
                        <i class="fas fa-calendar-plus me-2"></i>
                        Account created: 
                        <span class="ms-1 text-dark">
                            <?= date('M j, Y', strtotime($profile['created_at'])) ?>
                        </span>
                    </small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="timestamp-info">
                    <small class="text-muted d-flex align-items-center">
                        <i class="fas fa-edit me-2"></i>
                        Last updated: 
                        <span class="ms-1 text-dark">
                            <?= date('M j, Y \a\t g:i a', strtotime($profile['updated_at'])) ?>
                        </span>
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <form action="/user/account/updateProfile" method="POST" class="card-body" id="profileForm">
        <div class="profile-info">
            <div class="info-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($profile['username'], ENT_QUOTES, 'UTF-8') ?>" disabled>
            </div>
            <div class="input-group">
                <span class="input-group-text">First and last name</span>
                <input type="text" id="fname" name="fname" aria-label="fname" class="form-control" value="<?= htmlspecialchars($profile['fname'], ENT_QUOTES, 'UTF-8') ?>" disabled>
                <input type="text" id="lname" name="lname" aria-label="lname" class="form-control" value="<?= htmlspecialchars($profile['lname'], ENT_QUOTES, 'UTF-8') ?>" disabled>
            </div>
            <div class="info-group">
                <label for="bio">Biography</label>
                <div class="editor-container" data-default="<?= $profile['bio'] ?>"></div>
                <textarea id="bio" name="bio" disabled><?= htmlspecialchars($profile['bio'], ENT_QUOTES, 'UTF-8') ?></textarea>
                <div id="bio-view"><?= $profile['bio']?></div>
            </div>
            <div class="info-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($profile['email'], ENT_QUOTES, 'UTF-8') ?>" disabled>
            </div>
            <div class="row gap-2">
                <div class="info-group col">
                    <label for="gender">Gender</label>
                    <select class="form-select" id="gender" name="gender" disabled>
                        <option value="Male" <?= $profile['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $profile['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                        <option value="Other" <?= $profile['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                <div class="info-group col">
                    <label for="phone">Telephone</label>
                    <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($profile['phone'], ENT_QUOTES, 'UTF-8') ?>" disabled>
                </div>
            </div>
            <div class="info-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" disabled><?= htmlspecialchars($profile['address'], ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
        </div>
        <button id="toggleEdit" class="btn btn-primary d-flew gap-2 mt-3" type="button">
            <i class="fa fa-pencil m-auto"></i>
            <span>Edit Profile</span>
        </button>
        <div class="form-actions" style="display: none;">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <button type="button" id="cancelEdit" class="btn btn-secondary">Cancel</button>
        </div>
    </form>
</div>

<style>
    <?php 
        RenderSystem::renderOne('assets', 'static/css/account/profile.css');
    ?>
</style>

<script>
    <?php
        RenderSystem::renderOne('assets', 'static/js/pages/account/profile.js');
    ?>
</script>

<script type="module">
    <?php
    RenderSystem::renderOne('assets', 'static/js/helper/editor.js', []);
    ?>
</script>