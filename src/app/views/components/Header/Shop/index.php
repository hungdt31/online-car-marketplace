<div class="header">
    <?php
    RenderSystem::renderOne('components', 'Header/navigation', []);
    ?>
    <div class="header__content">
        <div>
            <h2><?php echo $title ?></h2>
        </div>
    </div>
    
</div>

<style>
    .header {
        width: 100%;
        aspect-ratio: 8/2;
        display: flex;
        flex-direction: column;
        position: relative; /* Required for pseudo-element positioning */
        background-image: url('<?php echo _WEB_ROOT . '/assets/static/images/bg/banner.svg' ?>');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        overflow: hidden; /* Ensure no overflow issues */
    }

    /* Pseudo-element for blur effect */
    .header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Black overlay with 50% opacity */
        z-index: 1;
    }

    .header__content {
        flex: 1;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative; /* Ensure content is above blur */
        z-index: 2; /* Place above blur layer */
    }

    .header__content h2 {
        font-weight: 600;
        font-size: 3rem;
    }

    /* Ensure navigation is above blur */
    .header > *:not(.header::before) {
        position: relative;
        z-index: 2;
    }

    @media screen and (max-width: 768px) {
        .header {
            aspect-ratio: 4/2;
        }

        .header__content {
            font-size: 1.5rem; /* Adjust font size for smaller screens */
        }
    }
</style>