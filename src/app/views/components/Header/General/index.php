<div class="header">
    <?php
    RenderSystem::renderOne('components', 'Header/navigation', []);
    ?>
    <div class="header__content">
        <div>
            <h2><?php echo $title ?></h2>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php if (isset($description) && is_array($description)): ?>
                    <?php foreach ($description as $index => $breadcrumb): ?>
                        <?php if ($index < count($description) - 1): ?>
                            <li class="breadcrumb-item">
                                <a href="<?php echo htmlspecialchars($breadcrumb['url']); ?>">
                                    <?php echo htmlspecialchars($breadcrumb['name']); ?>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="breadcrumb-item active text-white" aria-current="page">
                                <?php echo htmlspecialchars($breadcrumb['name']); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ol>
        </nav>
    </div>


</div>

<style>
    .header {
        width: 100%;
        aspect-ratio: 8/2;
        display: flex;
        flex-direction: column;
        position: relative;
        /* Required for pseudo-element positioning */
        background-image: url('<?php echo _WEB_ROOT . '/assets/static/images/bg/banner.svg' ?>');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        overflow: hidden;
        /* Ensure no overflow issues */
    }

    /* Pseudo-element for blur effect */
    .header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Black overlay with 50% opacity */
        z-index: 1;
    }

    .header__content {
        flex: 1;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
        /* Ensure content is above blur */
        z-index: 2;
        /* Place above blur layer */
        padding: 0 15px;
        text-align: center;
    }

    .header__content h2 {
        font-weight: 600;
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    /* Ensure navigation is above blur */
    .header>*:not(.header::before) {
        position: relative;
        z-index: 2;
    }

    /* Breadcrumb styling */
    .breadcrumb {
        margin-bottom: 0;
        background-color: transparent;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .breadcrumb-item a:hover {
        color: white;
        text-decoration: underline;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.6);
    }
    
    .breadcrumb-item.active {
        color: white;
    }

    /* Large screens (desktops) */
    @media screen and (min-width: 1200px) {
        .header {
            aspect-ratio: 8/2;
        }
        
        .header__content h2 {
            font-size: 3.5rem;
        }
    }

    /* Medium screens (tablets, small desktops) */
    @media screen and (max-width: 991px) {
        .header {
            aspect-ratio: 6/2;
        }

        .header__content h2 {
            font-size: 2.5rem;
        }
    }

    /* Small screens (tablets, large phones) */
    @media screen and (max-width: 768px) {
        .header {
            aspect-ratio: 4/2;
        }

        .header__content h2 {
            font-size: 2rem;
        }
        
        .breadcrumb {
            font-size: 0.9rem;
        }
    }
    
    /* Extra small screens (phones) */
    @media screen and (max-width: 576px) {
        .header {
            aspect-ratio: 3/2;
        }
        
        .header__content h2 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }
        
        .breadcrumb {
            font-size: 0.8rem;
        }
    }
</style>