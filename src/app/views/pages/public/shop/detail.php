<?php
$account = SessionFactory::createSession('account');
$profile = $account->getProfile();
?>
<div class="container-fluid px-4 py-3">
    <!-- Main Content Grid -->
    <div class="row mt-3">
        <!-- Left Column - Car Details -->
        <div class="col-lg-8">
            <!-- Image/Video Gallery -->
            <div class="card mb-4">
                <div class="card-body p-0">
                    <div id="mediaCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($info['images'] as $index => $media): ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <?php if (strpos($media['type'], 'video/') === 0): ?>
                                        <video controls class="w-100">
                                            <source src="<?php echo htmlspecialchars($media['url']); ?>" type="<?php echo $media['type']; ?>">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else: ?>
                                        <img src="<?php echo htmlspecialchars($media['url']); ?>"
                                            class="d-block w-100"
                                            alt="<?php echo htmlspecialchars($info['name']); ?>"
                                            style="object-fit: cover;">
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($info['images']) > 1): ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#mediaCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#mediaCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Vehicle Logo and Categories -->
            <div class="d-flex flex-wrap gap-2 align-items-center my-3 justify-content-between">
                <!-- Location -->
                <button class="text-muted mb-0 d-flex align-items-center btn btn-light">
                    <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                    <?php echo htmlspecialchars($info['location']); ?>
                </button>

                <!-- Categories -->
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach ($info['categories'] as $index => $category): ?>
                        <button class="custom-badge cursor-pointer" key="<?= $index ?>"><?php echo $category['name']; ?></button>
                    <?php endforeach; ?>
                </div>

            </div>

            <!-- Vehicle Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Vehicle Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-6 col-md-3">
                            <div class="p-3 border rounded text-center">
                                <i class="fas fa-gas-pump mb-2"></i>
                                <div class="small text-muted">Fuel Type</div>
                                <div class="fw-bold"><?php echo htmlspecialchars($info['fuel_type']); ?></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 border rounded text-center">
                                <i class="fas fa-tachometer-alt mb-2"></i>
                                <div class="small text-muted">Mileage</div>
                                <div class="fw-bold"><?php echo htmlspecialchars($info['mileage']); ?></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 border rounded text-center">
                                <i class="fas fa-cog mb-2"></i>
                                <div class="small text-muted">Drive Type</div>
                                <div class="fw-bold"><?php echo htmlspecialchars($info['drive_type']); ?></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 border rounded text-center">
                                <i class="fas fa-clock mb-2"></i>
                                <div class="small text-muted">Services</div>
                                <div class="fw-bold"><?php echo htmlspecialchars($info['service_duration']); ?></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 border rounded text-center">
                                <i class="fas fa-weight mb-2"></i>
                                <div class="small text-muted">Body Weight</div>
                                <div class="fw-bold"><?php echo htmlspecialchars($info['body_weight']); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Overview -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Overview</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><?php echo nl2br(htmlspecialchars($info['overview'])); ?></p>
                </div>
            </div>

            <!-- Vehicle Capabilities -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Premium Vehicle Capabilities</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <?php
                            // Lặp qua các key-value trong $info['capabilities']
                            foreach ($info['capabilities'] as $key => $value):
                                // Chỉ hiển thị nếu không phải là mảng (dành cho các giá trị đơn như engine, seats, v.v.)
                                if (!is_array($value)):
                            ?>
                                    <div class="mb-4">
                                        <h6 class="fw-bold"><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $key))); ?></h6>
                                        <p>
                                            <?php
                                            // Hiển thị giá trị, thêm "seats" nếu key là seats
                                            echo htmlspecialchars($value);
                                            if ($key === 'seats') {
                                                echo ' seats';
                                            }
                                            ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            // Lặp lại để hiển thị các giá trị là mảng (như features)
                            foreach ($info['capabilities'] as $key => $value):
                                // Chỉ hiển thị nếu là mảng (dành cho các danh sách như features)
                                if (is_array($value)):
                            ?>
                                    <div class="mb-4">
                                        <h6 class="fw-bold"><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $key))); ?></h6>
                                        <ul class="list-unstyled">
                                            <?php foreach ($value as $item): ?>
                                                <li class="mb-2">
                                                    <i class="fas fa-check text-success me-2"></i>
                                                    <?php echo htmlspecialchars($item); ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="card mb-4">
                <div class="d-flex justify-content-between align-items-center card-header">
                    <h5 class="card-title mb-0">
                        <?php
                        if (count($info['comments']) == 1) echo count($info['comments']) . " comment";
                        else if (count($info['comments']) == 0) echo 'No comments yet';
                        else echo count($info['comments']) . " comments";
                        ?>
                    </h5>
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Leave a Reply</button>
                </div>
                <div class="card-body">
                    <?php
                    foreach ($info['comments'] as $comment) {
                        // Tạo sao dựa trên rating
                        $ratingStars = '';
                        for ($i = 1; $i <= 5; $i++) {
                            $ratingStars .= $i <= $comment['rating']
                                ? '<i class="fas fa-star text-warning"></i>'
                                : '<i class="far fa-star"></i>';
                        }
                        // Định dạng thời gian
                        $createdAt = new DateTime($comment['created_at']);
                        $formattedDate = $createdAt->format('F d, Y \a\t g:i a');
                    ?>
                        <div class="d-flex align-items-start mb-4 border-bottom pb-3 gap-3">
                            <div class="comment-avatar">
                                <img src="<?php echo $comment['user_avatar'] ?>" alt="Avatar" class="rounded-circle" width="50" height="50">
                            </div>
                            <div class="flex-grow-1">
                                <h5><?= htmlspecialchars($comment['title']); ?></h5>
                                <div class="text-warning"><?= $ratingStars; ?></div>
                                <p><?php echo $comment['content']; ?></p>
                                <?php
                                // kiểm tra xem có file đính kèm không
                                if (!empty($comment['comment_file'])) {
                                    $fileType = pathinfo($comment['comment_file'], PATHINFO_EXTENSION);
                                    if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                                        echo '<img src="' . htmlspecialchars($comment['comment_file']) . '" class="img-fluid" alt="Comment File">';
                                    } else if (in_array($fileType, ['mp4', 'avi', 'mov'])) {
                                        echo '<video controls class="w-100"><source src="' . htmlspecialchars($comment['comment_file']) . '" type="video/' . $fileType . '"></video>';
                                    }
                                }
                                ?>
                                <div>
                                    <strong><?= htmlspecialchars($comment['username']); ?></strong>
                                    <span>said</span>
                                </div>
                                <div class="timestamp text-secondary"><?= htmlspecialchars($formattedDate); ?></div>
                            </div>
                            <!-- <button class="btn btn-light">Reply</button> -->
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Price Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Sale Price</h5>
                        <h3 class="text-primary mb-0 fw-bolder">
                            <span><?php echo number_format($info['price']); ?></span>
                            <i class="bi bi-currency-dollar"></i>
                        </h3>
                    </div>
                    <?php if ($info['avg_rating'] > 0): ?>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="text-warning m-auto fas fa-star<?php echo $i <= $info['avg_rating'] ? '' : '-o'; ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="text-muted"><?php echo number_format($info['avg_rating'], 1); ?> rating</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Opening Hours</h5>
                </div>
                <div class="card-body">
                    <div class="time-row">
                        <span class="status"><i class="bi bi-unlock-fill me-1"></i>Open</span>
                        <span class="time btn btn-light">00:00 - 23:30</span>
                    </div>
                    <div class="time-row">
                        <span class="day">Sunday</span>
                        <span class="time">12:00 - 19:00</span>
                    </div>
                    <div class="time-row">
                        <span class="day">Monday</span>
                        <span class="time">00:00 - 23:30</span>
                    </div>
                    <div class="time-row">
                        <span class="day">Tuesday</span>
                        <span class="time">00:00 - 23:30</span>
                    </div>
                    <div class="time-row">
                        <span class="day">Wednesday</span>
                        <span class="time">00:00 - 23:30</span>
                    </div>
                    <div class="time-row">
                        <span class="day">Thursday</span>
                        <span class="time">00:00 - 23:30</span>
                    </div>
                    <div class="time-row">
                        <span class="day">Friday</span>
                        <span class="time">00:00 - 23:30</span>
                    </div>
                    <div class="time-row">
                        <span class="day">Saturday</span>
                        <span class="time">00:00 - 23:30</span>
                    </div>
                </div>
            </div>

            <!-- Related Vehicles -->
            <?php if (!empty($info['related_cars'])): ?>
                <div class="card pb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Related Vehicles</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <?php foreach ($info['related_cars'] as $related): ?>
                                <div>
                                    <div class="card h-100">
                                        <?php if (!empty($related['image'])): ?>
                                            <img src="<?php echo htmlspecialchars($related['image']); ?>"
                                                class="card-img-top"
                                                alt="<?php echo htmlspecialchars($related['name']); ?>"
                                                style="object-fit: cover;">
                                        <?php else: ?>
                                            <video controls class="w-100 card-img-top" autoplay loop style="object-fit: cover;">
                                                <source src="<?php echo htmlspecialchars($related['video']); ?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <h6 class="card-title mb-3">
                                                <a href="/shop/detail/<?php echo $related['id']; ?>" class="text-decoration-none">
                                                    <?php echo htmlspecialchars($related['name']); ?>
                                                </a>
                                            </h6>
                                            <p class="text-muted mb-0 d-flex align-items-center">
                                                <button class="btn btn-light">
                                                    <i class="bi bi-coin me-2 text-primary m-auto"></i>
                                                    <?php echo number_format($related['price']); ?>
                                                </button>
                                                <i class="fas fa-map-marker-alt me-2 text-danger m-auto"></i>
                                                <?php echo htmlspecialchars($related['location']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    <?php
    RenderSystem::renderOne('assets', 'static/css/shop/detail.css', []);
    ?>.color-picker {
        width: 1.8rem;
        height: 1.8rem;
        border-radius: 50%;
        overflow: hidden;
        padding: 0;
        border: none;
        cursor: pointer;
        position: relative;
        margin: 2px;
        vertical-align: middle;
    }

    .color-picker::-webkit-color-swatch-wrapper {
        padding: 0;
    }

    .color-picker::-webkit-color-swatch {
        border: none;
        border-radius: 50%;
    }

    .color-picker::-moz-color-swatch {
        border: none;
        border-radius: 50%;
    }
</style>

<!-- Modal -->
<form action="/shop/replyCarPost" method="POST" enctype="multipart/form-data" class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="exampleModalLabel">Comment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="commentTitle" class="form-label fw-bold">Title</label>
                    <input type="text" class="form-control" id="commentTitle" placeholder="Enter title" name="commentTitle">
                </div>
                <div class="mb-3">
                    <label for="commentContent" class="form-label fw-bold">Content</label>
                    <div class="editor-container"></div>
                </div>
                <div class="mb-4">
                    <label for="star-rating" class="form-label fw-bold">Rating</label>
                    <div class="star-rating">
                        <i class="far fa-star" data-rating="1"></i>
                        <i class="far fa-star" data-rating="2"></i>
                        <i class="far fa-star" data-rating="3"></i>
                        <i class="far fa-star" data-rating="4"></i>
                        <i class="far fa-star" data-rating="5"></i>
                    </div>
                    <input type="hidden" id="commentRating" name="commentRating" value="">
                </div>
                <div class="mb-3">
                    <label for="commentFile" class="form-label fw-bold">File attached (max 5MB)</label>
                    <input type="file"
                        class="form-control"
                        id="commentFile"
                        accept="image/*,video/*"
                        placeholder="Upload image or video"
                        name="commentFile"
                        onchange="handleFileUpload(this)">
                    <div class="invalid-feedback">File size exceeds the 5MB limit.</div>
                    <p class="form-text text-muted mt-2">Allowed formats: images and videos (max: 5MB)</p>

                    <!-- Preview container -->
                    <div id="filePreviewContainer" class="mt-2" style="display: none;">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div id="filePreview" class="me-3"></div>
                                        <div id="fileInfo">
                                            <h6 id="fileName" class="mb-0"></h6>
                                            <small id="fileSize" class="text-muted"></small>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-light" onclick="clearFileUpload()">
                                        <i class="fas fa-times text-danger m-auto"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary save-comment-btn" data-user-id="<?php echo $profile['id']; ?>" data-car-id="<?php echo $info['id']; ?>">Save changes</button>
            </div>
        </div>
    </div>
</form>

<script>
    <?php
    RenderSystem::renderOne('assets', 'static/js/pages/shop/detail.js', []);
    ?>
</script>

<script type="module">
    <?php
    RenderSystem::renderOne('assets', 'static/js/helper/editor.js', []);
    ?>
</script>