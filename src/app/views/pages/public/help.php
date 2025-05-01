<?php
$page_title = 'Help Center';
?>

<div class="container py-5">
    <div class="row">
        <!-- FAQ Section -->
        <div class="col-lg-7 mt-5">
            <h2 class="mb-4" style="font-weight: bold;">Common Questions</h2>
            <div class="accordion" id="faqAccordion">
                <?php
                $faqs = [
                    [
                        'question' => 'What documents are required to rent a car?',
                        'answer' => "You'll need a valid driver's license, a government-issued ID (like a passport or national ID), and a credit card for the security deposit."
                    ],
                    [
                        'question' => 'What is the minimum age to rent a car?',
                        'answer' => 'The minimum age varies by location, but typically it is 21 years old.'
                    ],
                    [
                        'question' => 'Can I rent a car without a credit card?',
                        'answer' => 'Unfortunately, a credit card is required for security purposes. Debit cards or cash are not accepted for the deposit.'
                    ],
                    [
                        'question' => ' Are there any mileage limits?',
                        'answer' => 'Most rentals come with unlimited mileage. Some luxury or specialty vehicles may have mileage restrictions. Please check the vehicle’s details.'
                    ],
                    [
                        'question' => 'What happens if the car breaks down?',
                        'answer' => "We provide 24/7 roadside assistance. If there's a mechanical failure, we will replace the vehicle or issue a refund depending on the situation."
                    ],
                    [
                        'question' => 'What is the cancellation policy?',
                        'answer' => 'Cancellations are subject to a cancellation fee. Please refer to your booking confirmation for specific details.'
                    ]
                ];

                foreach ($faqs as $index => $faq) {
                    echo '
                    <div class="accordion-item mb-3 border rounded">
                        <h3 class="accordion-header" style="font-weight: bold;" id="heading' . $index . '">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#collapse' . $index . '" aria-expanded="false" 
                                    aria-controls="collapse' . $index . '">
                                ' . htmlspecialchars($faq['question']) . '
                            </button>
                        </h3>
                        <div id="collapse' . $index . '" class="accordion-collapse collapse" 
                             aria-labelledby="heading' . $index . '" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                ' . htmlspecialchars($faq['answer']) . '
                            </div>
                        </div>
                    </div>';
                }
                ?>
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