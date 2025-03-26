<div class="footer">
    <div class="footer-content">
        <div class="logo-section">
            <img src="<?= htmlspecialchars(_WEB_ROOT) ?>/assets/images/carvan-logo.svg" alt="Carvan Logo">
            <div class="car-image">
                <img src="<?= htmlspecialchars(_WEB_ROOT) ?>/assets/images/car-silhouette.svg" alt="Car Silhouette">
            </div>
        </div>

        <div class="footer-info">
            <div class="quick-links">
                <h3>Quick Links</h3>
                <p>Home / Shop / Blog / Contact us / About us</p>
            </div>

            <div class="contact-info">
                <div class="address">
                    <h3>Address</h3>
                    <p>H6 Building, HCMUT</p>
                </div>
                <div class="phone">
                    <h3>Phone</h3>
                    <p>012345678910</p>
                </div>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>


        </div>
    </div>
</div>

<style>
    .footer {
        background-color: #000;
        color: white;
        padding: 40px 0;
        width: 100%;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        gap: 30px;
    }

    .logo-section {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .logo {
        width: 100%;
        text-align: center;
    }

    .logo-section img {
        width: 150px;
        margin: 0 auto;
        display: block;
    }

    .car-image {
        width: 100%;
    }

    .car-image img {
        width: 100%;
        max-width: 400px;
        opacity: 0.8;
        display: block;
        margin: 0 auto;
    }

    .footer-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        gap: 30px;
    }

    .quick-links h3,
    .address h3,
    .phone h3 {
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 15px;
        text-transform: uppercase;
    }

    .quick-links p,
    .address p,
    .phone p {
        color: #ffffff;
        font-size: 16px;
        line-height: 1.5;
    }

    .contact-info {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 30px;
    }

    .address,
    .phone {
        flex: 1;
    }

    .address h3,
    .phone h3 {
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 10px;
    }

    .address p,
    .phone p {
        color: #ffffff;
        font-size: 16px;
    }

    .social-icons {
        flex: 1;
        display: flex;
        gap: 20px;
        justify-content: flex-end;
        align-items: center;
    }

    .social-icons a {
        color: white;
        font-size: 24px;
        text-decoration: none;
        transition: opacity 0.3s;
    }

    .social-icons a:hover {
        opacity: 0.8;
    }

    @media (max-width: 768px) {
        .footer-content {
            flex-direction: column;
            text-align: center;
        }

        .logo-section {
            margin-bottom: 30px;
        }

        .footer-info {
            align-items: center;
        }

        .contact-info {
            flex-direction: column;
            text-align: center;
            align-items: center;
        }

        .social-icons {
            justify-content: center;
            padding-top: 15px;
        }
    }
</style>