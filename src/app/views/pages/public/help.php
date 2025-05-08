<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$page_title = 'Help Center';
?>

<div class="container py-5">
    <div class="row">
        <!-- FAQ Section -->
        <div class="col-lg-7 mt-5">
            <h2 class="mb-4" style="font-weight: bold;">Common Questions</h2>
            <div class="accordion" id="faqAccordion">
                <?php if (!empty($faqs)) : ?>
                <?php foreach ($faqs as $index => $faq) : ?>
                <?php if ($faq['status'] == 'active') : ?>
                <div class="accordion-item mb-3 border rounded">
                    <h3 class="accordion-header" style="font-weight: bold;" id="heading<?= $index ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse<?= $index ?>" aria-expanded="false"
                            aria-controls="collapse<?= $index ?>">
                            <?= htmlspecialchars($faq['question']) ?>
                        </button>
                    </h3>
                    <div id="collapse<?= $index ?>" class="accordion-collapse collapse"
                        aria-labelledby="heading<?= $index ?>" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <?= htmlspecialchars($faq['answer']) ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
                <?php else : ?>
                <div class="alert alert-info">
                    No FAQs available at the moment. Please check back later.
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Help Center Image -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <img src="<?= _WEB_ROOT ?>/assets/static/images/help/carvan-banner.jpg" alt="Luxury Car Rental"
                    class="card-img-top p-4">
                <div class="card-body bg-primary text-white">
                    <h4 class="card-title">LUXURY CAR RENTAL</h4>
                    <p class="card-text">Professional service, quality cars</p>
                    <a href="/contact" class="btn btn-light">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
    <form action="/help/send-question" method="POST" class="mt-5 p-4 border rounded bg-light">
        <h5 class="mb-3 fw-bold">Still need help? Send us your question:</h5>
        <div class="mb-3">
            <label for="name" class="form-label">Your Name</label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Your Email</label>
            <input type="email" class="form-control" name="email">
        </div>

        <div class="mb-3">
            <label for="question" class="form-label">Your Question</label>
            <textarea class="form-control" name="question" rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Question</button>
    </form>

</div>

<style>
.accordion-button:not(.collapsed) {
    color: #0d6efd;
    background-color: #e7f1ff;
}

.accordion-button:focus {
    box-shadow: none;
    border-color: rgba(0, 0, 0, .125);
}

.accordion-button:not(.collapsed)::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%230d6efd'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
}

.accordion-item {
    background-color: #fff;
    transition: all 0.3s ease;
}

.accordion-item:hover {
    transform: translateY(-2px);
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}
</style>

<?php if (isset($success_message)): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($success_message) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if (isset($error_message)): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($error_message) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<script>
document.querySelector('form[action="/help/send-question"]').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;

    submitButton.disabled = true;
    submitButton.innerHTML = 'Sending...';

    fetch('/help/send-question', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show success message
                alert(data.message);
                // Reset form
                this.reset();
            } else {
                // Show error message
                alert(data.message || 'Failed to send question. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        })
        .finally(() => {
            // Re-enable submit button and restore original text
            submitButton.disabled = false;
            submitButton.innerHTML = originalButtonText;
        });
});
</script>