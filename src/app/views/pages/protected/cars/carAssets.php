<div class="container-fluid px-4 pt-3">
    <div class="d-flex justify-content-between align-items-center mb-4 px-2 py-3 bg-light rounded shadow-sm">
        <!-- Left Side: Breadcrumb + Title -->
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="/cars-management">Cars</a></li>
                    <li class="breadcrumb-item"><a href="#">Assets</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $car_name ?></li>
                </ol>
            </nav>
            <h4 class="fw-semibold text-primary mb-0">Media Management</h4>
        </div>

        <!-- Right Side: Add Button -->
        <button class="btn btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <i class="bi bi-plus-lg me-2"></i>
            Add New Media
        </button>
    </div>

    <!-- Media Grid -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-photo-video me-1"></i>
                Media Gallery
            </div>
            <div class="btn-group">
                <button class="btn btn-light active" data-filter="all">All</button>
                <button class="btn btn-light" data-filter="image">Images</button>
                <button class="btn btn-light" data-filter="video">Videos</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-4" id="mediaGrid">
                <?php if (!empty($car_assets)): ?>
                    <?php foreach ($car_assets as $asset): ?>
                        <?php
                        $isVideo = strpos($asset['type'], 'video/') === 0;
                        $mediaClass = $isVideo ? 'video-item' : 'image-item';
                        ?>
                        <div class="col-md-4 col-lg-3 media-container <?php echo $mediaClass; ?>" data-id="<?php echo $asset['id']; ?>">
                            <div class="card h-100 hover-effect">
                                <div class="media-wrapper position-relative">
                                    <?php if ($isVideo): ?>
                                        <video class="card-img-top" controls>
                                            <source src="<?php echo $asset['url']; ?>" type="<?php echo $asset['type']; ?>">
                                            Your browser does not support the video tag.
                                        </video>
                                        <span class="badge bg-primary position-absolute top-0 end-0 m-2">
                                            <i class="fas fa-video"></i>
                                        </span>
                                    <?php else: ?>
                                        <div class="image-container" style="height: 200px; overflow: hidden;">
                                            <img src="<?php echo $asset['url']; ?>"
                                                class="card-img-top h-100 w-100"
                                                style="object-fit: cover;"
                                                alt="<?php echo $asset['name']; ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#imageModal"
                                                data-img-url="<?php echo $asset['url']; ?>">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title text-truncate" title="<?php echo $asset['name']; ?>">
                                        <?php echo $asset['name']; ?>
                                    </h6>
                                    <p class="card-text small text-muted">
                                        Size: <?php echo number_format($asset['size'] / 1024, 2); ?> KB
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button class="btn btn-sm btn-outline-danger delete-media" data-id="<?php echo $asset['id'].','.$car_id; ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary copy-url" data-url="<?php echo $asset['url']; ?>">
                                            <i class="fas fa-link"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-photo-video fa-3x mb-3"></i>
                            <p>No media files available</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Media</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" enctype="multipart/form-data">
                    <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">
                    <div class="mb-3">
                        <label class="form-label">Select Files</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="media" name="media" multiple
                                accept="image/*,video/mp4,video/webm">
                        </div>
                        <small class="text-muted">Supported formats: Images (JPG, PNG, GIF) and Videos (MP4, WebM)</small>
                    </div>
                    <div id="preview" class="row g-2 mt-2"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="uploadButton" data-id="<?= $car_id ?>">Upload</button>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2"
                    data-bs-dismiss="modal" style="z-index: 1050; background-color: white;"></button>
                <img src="" class="img-fluid w-100" id="modalImage">
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3"></div>

<style>
    <?php
    RenderSystem::renderOne('assets', 'static/css/carAssets.css');
    ?>
</style>

<script>
    <?php
    RenderSystem::renderOne('assets', 'static/js/pages/carAssets.js');
    ?>
</script>