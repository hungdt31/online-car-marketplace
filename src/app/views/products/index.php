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

    button[type="submit"] {
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
</style>
<!-- <?php
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $response = null;
    if (!empty($email) && !empty($subject) && !empty($message)) {
        $response = "<p>Email Sent Successfully!</p>";
        $response .= "<p><strong>Email:</strong> $email</p>";
        $response .= "<p><strong>Subject:</strong> $subject</p>";
        $response .= "<p><strong>Message:</strong> $message</p>";
    } else {
        $response = Mailer::send(
            [
                'address' => getenv('EMAIL_USERNAME'),
                'name' => 'Admin'
            ],
            [
                'address' => $email,
                'name' => 'User'
            ],
            [
                'address' => getenv('EMAIL_USERNAME'),
                'name' => 'Admin'
            ],
            $subject,
            $message
        );
        if (!empty($response)) {
            echo '<p>Sent mail successufully!</p>';
        } else {
            echo '<p>Failed to send mail!</p>';
        }
    }
}
?> -->
</head>


<div class="form-container">
    <h3>Send an email to yourself</h3>
    <form method="post" action="./product/sendMail">
        <input type="email" name="email" placeholder="Enter your email" required />
        <input type="text" name="subject" placeholder="Enter a subject" required />
        <textarea name="message" placeholder="Enter your message" rows="4" required></textarea>
        <div class="group-button">
            <button type="submit" name="submit">Submit</button>
            <button type="reset" name="reset">Reset</button>
        </div>
    </form>


</div>