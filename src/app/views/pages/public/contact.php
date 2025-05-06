<style>
    .container {
        min-width: 100%;
        margin: 0 auto;
        text-align: center;
        font-family: Arial, sans-serif;
        padding: 50px;
        background: black;
        color: white;
        box-sizing: border-box;
    }


    .container form {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px;
        text-align: center;
    }

    .container .content {
        padding-top: 50px;
        text-align: left;
    }

    h2 u {
        text-align: left;
        text-decoration: underline;
    }

    p {
        text-align: left;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    form {
        width: 100%;
    }

    .row {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
        justify-content: center;
    }

    .row input {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 30px;
        background: #e0e0e0;
        outline: none;
    }

    textarea {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 15px;
        background: #e0e0e0;
        outline: none;
        resize: none;
        margin-bottom: 20px;
    }

    button[type="submit"] {
        padding: 10px 40px;
        border: 2px solid white;
        border-radius: 30px;
        background: transparent;
        color: white;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.3s, color 0.3s;
    }

    button[type="submit"]:hover {
        background: white;
        color: black;
    }

    @media (max-width: 600px) {
        .row {
            flex-direction: column;
        }
    }

    .contact-section {
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
        font-family: Arial, sans-serif;
    }

    .contact-section h2 {
        font-size: 30px;
        font-weight: bold;
        margin-bottom: 30px;
        margin-top: 50px;
    }

    .contact-info {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .left-info,
    .right-info {
        margin-bottom: 30px;
        flex: 1 1 45%;
        text-align: left;
    }

    .left-info div,
    .right-info div {
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .right-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .social-section {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .social-icons {
        display: flex;
        gap: 15px;
    }


    .social-icons i {
        font-size: 24px;
        margin: 0 10px;
        cursor: pointer;
    }

    .contact-box {
        background-color: #3b82f6;
        /* Bootstrap blue */
        border-radius: 1rem;
    }

    .contact-icon {
        font-size: 3rem;
    }

    .car {
        width: 100px;
        height: auto;
        border-radius: 0.5rem;
    }

    .margin-top {
        margin-top: 50px;
    }

    .custom-text-lg {
        font-size: 50px;
    }

    .custom-text-lg2 {
        color: #000000;
        font-size: 60px;
    }
</style>

</style>
<div class="container d-flex flex-column flex-md-row align-items-center justify-content-center py-5 bg-white">
    <div class="text-center text-md-start margin-top">
        <h2 class="fw-bold mb-3 custom-text-lg2 text-align-center">
            Have Questions?<br>Say Hello, And Our Experts Will Assist You!
        </h2>

        <div class="contact-box d-flex align-items-center justify-content-between p-3 text-white margin-top ">
            <div>
                <p class="fw-semibold mb-2 custom-text-lg">Feel Free To Contact Us Anytime</p>
                <p class="mb-1">📞 01245678910</p>
                <p class="mb-0">✉️ carvan.contact@gmail.com</p>
            </div>
            <img src="<?= _WEB_ROOT ?>/assets/static/images/contact/1.png" alt="car" class="car">
        </div>
    </div>
</div>
<div class="container">
    <div class="content">
        <h2><u>Connect With Us</u></h2>
        <p>Contact Us for Assistance</p>
        <p>Feugiat pretium nibh ipsum consequat nisl vel pretium lectus quam. Aliquam ut porttitor leo a diam at lectus
            urna
            duis convallis. At urna condimentum mattis pellentesque id nibh tortor id.</p>
    </div>
    <form id="emailForm">
        <div class="row">
            <input type="text" name="name" placeholder="Enter Name *" required>
            <input type="email" name="email" placeholder="Enter Email Id *" required>
        </div>
        <div class="row">
            <input type="tel" name="phone" placeholder="Phone Number *" pattern="[0-9]{10}" required>
            <input type="text" name="address" placeholder="Enter Address *" required>
        </div>
        <div class="row">
            <input type="text" name="city" placeholder="Enter City *" required>
            <input type="date" name="date" required>
        </div>
        <div class="row">
            <input type="time" name="time" required>
        </div>
        <textarea name="message" placeholder="Message Here ..." required></textarea>
        <button type="submit">Submit</button>
    </form>
    <div id="responseMessage" class="response-message"></div>
</div>
<div class="contact-section">
    <h2>Connect, Communicate, Collaborate Seamlessly</h2>
    <div class="contact-info">
        <div class="left-info">
            <div><i class="fas fa-map-marker-alt"></i> H6 Building, HCMUT</div>
            <div><i class="fas fa-phone"></i> 012345678910</div>
            <div><i class="fas fa-clock"></i> Mon - Sat : 9am to 6pm<br> Sunday : Closed</div>
            <div><i class="fas fa-envelope"></i> carvan.contact@gmail.com</div>
        </div>
        <div class="right-info">
            <div>Socially Available On :</div>
            <div class="social-icons">
                <i class="fab fa-instagram"></i>
                <i class="fab fa-facebook-f"></i>
                <i class="fab fa-twitter"></i>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("emailForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Ngăn trang load lại

        let formData = new FormData(this);
        let xhr = new XMLHttpRequest();
        let submitButton = this.querySelector("button[type='submit']");
        let responseMessage = document.getElementById("responseMessage");

        // Hiển thị trạng thái loading
        submitButton.disabled = true;
        submitButton.innerText = "Sending...";

        xhr.open("POST", "product/sendMail", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                submitButton.disabled = false;
                submitButton.innerText = "Submit"; // Khôi phục nút

                if (xhr.status === 200) {
                    responseMessage.innerHTML = "<p style='color: green;text-align: center;'>Email Sent Successfully!</p>";
                } else {
                    responseMessage.innerHTML = "<p style='color: red;text-align: center;'>Failed to send mail!</p>";
                }
            }
        };

        xhr.send(formData);
    });
</script>