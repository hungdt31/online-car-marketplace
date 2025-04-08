<?php
$session = SessionFactory::createSession('account');
$profile = $session->getProfile();
?>
<header class="header" id="header">
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    <div class="d-flex align-items-center gap-2">
        <i class="bi bi-cloud-lightning-fill"></i>
        <span id="current-date"></span>
    </div>
    <div class="d-flex align-items-center gap-3 p-2" style="max-width: 350px;">
        <div class="header_img">
            <img src="https://i.imgur.com/hczKIze.jpg" alt="Avatar" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
        </div>
        <div class="d-flex flex-column">
            <p class="mb-0 fw-semibold text-dark"><?= $profile['username'] ?></p>
            <small class="text-muted"><?= $profile['email'] ?></small>
        </div>
    </div>
</header>
<script>
    const dateEl = document.getElementById("current-date");
    const now = new Date();

    const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];

    const dayName = days[now.getDay()];
    const date = now.getDate();
    const month = months[now.getMonth()];
    const year = now.getFullYear();

    dateEl.textContent = `${dayName}, ${date} ${month} ${year}`;
</script>