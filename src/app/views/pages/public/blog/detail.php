<div class="container mt-5 mb-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article>
                <!-- Featured Image -->
                <div class="mb-4 position-relative">
                    <img src="<?php echo !empty($blog['cover_image_url']) ? htmlspecialchars($blog['cover_image_url']) : 'https://via.placeholder.com/800x400?text=No+Image'; ?>" 
                         class="img-fluid rounded shadow" alt="<?php echo htmlspecialchars($blog['title']); ?>"
                         style="width: 100%; height: 400px; object-fit: cover;">
                    
                    <?php if (!empty($blog['categories'])): ?>
                        <div class="position-absolute top-0 start-0 m-3">
                            <?php foreach ($blog['categories'] as $category): ?>
                                <a href="<?php echo _WEB_ROOT; ?>/blog/category/<?php echo $category['id']; ?>" 
                                   class="badge bg-primary text-decoration-none me-1">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Title and Meta -->
                <h1 class="mb-3"><?php echo htmlspecialchars($blog['title']); ?></h1>
                <div class="d-flex flex-wrap mb-4 text-muted">
                    <div class="me-4">
                        <i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($blog['author_name']); ?>
                    </div>
                    <div class="me-4">
                        <i class="fas fa-calendar-alt me-1"></i> <?php echo date('F d, Y', strtotime($blog['created_at'])); ?>
                    </div>
                    <div>
                        <i class="fas fa-eye me-1"></i> <?php echo $blog['views']; ?> views
                    </div>
                </div>

                <!-- Content -->
                <div class="blog-content mb-5">
                    <?php echo $blog['content']; ?>
                </div>

                <!-- Share -->
                <div class="d-flex align-items-center mb-5">
                    <span class="me-3 fw-bold">Share:</span>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-info"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-danger"><i class="fab fa-pinterest"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-success"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Author Box -->
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="d-flex">
                            <img src="https://ui.shadcn.com/avatars/01.png" alt="Author" class="rounded-circle me-4" width="80" height="80">
                            <div>
                                <h5 class="mb-1"><?php echo htmlspecialchars($blog['author_name']); ?></h5>
                                <p class="text-muted mb-3">Author</p>
                                <p class="mb-0">Passionate automotive writer with expertise in luxury vehicles and the latest technological advancements in the automotive industry.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Search -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Search</h5>
                    <form action="<?php echo _WEB_ROOT; ?>/blog/search" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" placeholder="Enter keyword">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Categories -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Categories</h5>
                    <div class="list-group list-group-flush">
                        <?php foreach ($categories as $category): ?>
                            <a href="<?php echo _WEB_ROOT; ?>/blog/category/<?php echo $category['id']; ?>" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($category['name']); ?>
                                <span class="badge bg-primary rounded-pill"><?php echo $category['post_count']; ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Recent Posts</h5>
                    <?php foreach ($recentPosts as $post): ?>
                        <div class="d-flex mb-3">
                            <img src="<?php echo !empty($post['cover_image_url']) ? htmlspecialchars($post['cover_image_url']) : 'https://via.placeholder.com/100?text=No+Image'; ?>" 
                                 class="flex-shrink-0 me-3" alt="<?php echo htmlspecialchars($post['title']); ?>"
                                 style="width: 70px; height: 70px; object-fit: cover;">
                            <div>
                                <h6 class="mb-1">
                                    <a href="<?php echo _WEB_ROOT; ?>/blog/detail/<?php echo $post['id']; ?>" class="text-decoration-none text-dark">
                                        <?php echo htmlspecialchars($post['title']); ?>
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i> 
                                    <?php echo date('M d, Y', strtotime($post['created_at'])); ?>
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Tags -->
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h5 class="card-title">Tags</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?php echo _WEB_ROOT; ?>/blog/tag/branded" class="btn btn-sm btn-outline-secondary">Branded</a>
                        <a href="<?php echo _WEB_ROOT; ?>/blog/tag/luxury" class="btn btn-sm btn-outline-secondary">Luxury</a>
                        <a href="<?php echo _WEB_ROOT; ?>/blog/tag/suv" class="btn btn-sm btn-outline-secondary">SUV's</a>
                        <a href="<?php echo _WEB_ROOT; ?>/blog/tag/electric" class="btn btn-sm btn-outline-secondary">Electric</a>
                        <a href="<?php echo _WEB_ROOT; ?>/blog/tag/sports" class="btn btn-sm btn-outline-secondary">Sports</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.blog-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.blog-content p {
    margin-bottom: 1.5rem;
}

.blog-content img {
    max-width: 100%;
    height: auto;
    margin: 2rem 0;
}

.blog-content h2, .blog-content h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.blog-content ul, .blog-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.blog-content blockquote {
    border-left: 4px solid #0d6efd;
    padding-left: 1rem;
    font-style: italic;
    margin: 1.5rem 0;
}
</style>
