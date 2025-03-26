<div class="header">
    <?php
    require 'navigation.php';
    ?>
    <div class="header-content">
        <button class="arrow left-arrow">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
        <?php require 'highlightText.php'; ?>
        <button class="arrow right-arrow">
            <i class="fa-solid fa-arrow-right"></i>
        </button>
    </div>
    <div class="searchContainer">
        <?php require 'searchBar.php'; ?>
    </div>
    <div class="progress-bar">
        <div class="progress"></div>
    </div>
</div>

<div class="_searchContainer">
    <?php require 'searchBar.php'; ?>
</div>
<style>
    .header {
        position: relative;
        min-height: 600px;
        display: flex;
        flex-direction: column;
        /* Giá trị mặc định cho màn hình lớn (desktop) */
        background-image: url("<?= htmlspecialchars(_WEB_ROOT) ?>/assets/images/header.svg");
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        transition: background-image 0.5s ease-in-out;
        /* Hiệu ứng chuyển đổi mượt mà */
    }

    .left-arrow {
        position: absolute;
        top: 50%;
        left: 20px;
        transform: translateY(-50%);
    }

    .right-arrow {
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
    }

    .arrow {
        border-radius: 100%;
        width: 40px;
        height: 40px;
        border: 2px solid white;
        background-color: transparent;
        color: white;
        cursor: pointer;
    }

    /* Thêm lớp mờ đen phía trên hình nền */
    .header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1;
    }

    /* Đảm bảo nội dung trong .header nằm trên lớp mờ */
    .header>* {
        position: relative;
        z-index: 2;
    }

    .searchContainer {
        display: block;
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        padding: 0 20px;
        z-index: 999;
    }

    ._searchContainer {
        padding: 20px;
        display: none;
    }

    .header-content {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-grow: 1;
        padding: 10px;
    }

    /* CSS cho thanh chạy */
    .progress-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background-color: rgba(255, 255, 255, 0.3);
        /* Nền của thanh chạy */
        z-index: 2;
    }

    .progress {
        width: 0;
        height: 100%;
        background-color: white;
        /* Màu của thanh chạy */
        animation: progress 7s linear infinite;
        /* Animation chạy trong 7 giây, lặp vô hạn */
    }

    @keyframes progress {
        0% {
            width: 0;
        }

        100% {
            width: 100%;
        }
    }

    /* Responsive cho tablet (màn hình từ 768px đến 1024px) */
    @media (max-width: 1024px) {
        .header {
            min-height: 500px;
        }
    }

    /* Responsive cho điện thoại (màn hình nhỏ hơn 767px) */
    @media (max-width: 767px) {
        .header {
            min-height: 300px;
        }

        .searchContainer {
            display: none;
        }

        ._searchContainer {
            display: block;
        }

        .progress-bar {
            height: 3px;
            /* Giảm chiều cao thanh chạy trên điện thoại */
        }
    }
</style>

<script>
    class HeaderSlider {
        constructor() {
            this.backgroundImages = [
                `<?= _WEB_ROOT ?>/assets/images/header.svg`,
                `<?= _WEB_ROOT ?>/assets/images/header1.avif`,
                `<?= _WEB_ROOT ?>/assets/images/header2.avif`
            ];

            this.header = document.querySelector('.header');
            this.progress = document.querySelector('.progress');
            this.leftArrow = document.querySelector('.left-arrow');
            this.rightArrow = document.querySelector('.right-arrow');

            this.currentIndex = 0;
            this.autoSlide = null;

            this.init();
        }

        init() {
            this.autoSlide = setInterval(() => this.nextImage(), 7000);
            this.setupEventListeners();
        }

        setupEventListeners() {
            this.leftArrow.addEventListener('click', () => this.handleArrowClick('left'));
            this.rightArrow.addEventListener('click', () => this.handleArrowClick('right'));
        }

        changeBackground() {
            this.header.style.backgroundImage = `url(${this.backgroundImages[this.currentIndex]})`;
            this.resetProgress();
        }

        resetProgress() {
            this.progress.style.animation = 'none';
            void this.progress.offsetWidth;
            this.progress.style.animation = 'progress 7s linear infinite';
        }

        nextImage() {
            this.currentIndex = (this.currentIndex + 1) % this.backgroundImages.length;
            this.changeBackground();
        }

        previousImage() {
            this.currentIndex = (this.currentIndex - 1 + this.backgroundImages.length) % this.backgroundImages.length;
            this.changeBackground();
        }

        handleArrowClick(direction) {
            clearInterval(this.autoSlide);

            if (direction === 'left') {
                this.previousImage();
            } else {
                this.nextImage();
            }

            this.autoSlide = setInterval(() => this.nextImage(), 7000);
        }
    }

    // Initialize slider when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        new HeaderSlider();
    });
</script>