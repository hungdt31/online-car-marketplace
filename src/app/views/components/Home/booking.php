<section class="booking-section">
    <div class="container">
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
</section>
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
<?php
// Load CSS
echo '<style>';
RenderSystem::renderOne('assets', 'static/css/home/booking.css', []);
echo '</style>';

// Load JS

?>