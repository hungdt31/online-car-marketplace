<style>
    .form-container {
        background: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        width: 300px;
        text-align: center;
        margin: 20px auto;
    }

    input,
    textarea {
        width: 100%;
        margin: 5px 0;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    .form-container button[type='submit'] {
        width: 100%;
        padding: 10px;
        background: #0074A2;
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    .group-button {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin: 10px 0;
    }

    .response-message {
        margin-top: 10px;
        font-weight: bold;
    }
</style>

<div class="form-container">
    <h3>Send an email to us</h3>
    <form id="emailForm">
        <input type="email" name="email" placeholder="Enter your email" required />
        <input type="text" name="subject" placeholder="Enter a subject" required />
        <textarea name="message" placeholder="Enter your message" rows="4" required></textarea>
        <div class="group-button">
            <button type="submit">Submit</button>
            <button type="reset">Reset</button>
        </div>
    </form>
    <div id="responseMessage" class="response-message"></div>
</div>

<script>
    document.getElementById("emailForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Ngăn trang load lại

        let formData = new FormData(this);
        let xhr = new XMLHttpRequest();
        let submitButton = this.querySelector("button[type='submit']");
        let responseMessage = document.getElementById("responseMessage");

        // Hiển thị trạng thái loading
        submitButton.disabled = true;
        submitButton.innerText = "Sending...";

        xhr.open("POST", "shop/sendMail", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                submitButton.disabled = false;
                submitButton.innerText = "Submit"; // Khôi phục nút

                if (xhr.status === 200) {
                    responseMessage.innerHTML = "<p style='color: green;'>Email Sent Successfully!</p>";
                } else {
                    responseMessage.innerHTML = "<p style='color: red;'>Failed to send mail!</p>";
                }
            }
        };

        xhr.send(formData);
    });
</script>