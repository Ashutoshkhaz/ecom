<?php
require_once '../../config.php';
require_once '../auth_check.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$stmt = $pdo->prepare("
    SELECT p.*, u.name as author_name,
           COUNT(c.id) as comment_count
    FROM blog_posts p
    LEFT JOIN users u ON p.author_id = u.id
    LEFT JOIN comments c ON p.id = c.post_id
    GROUP BY p.id
    ORDER BY p.created_at DESC
    LIMIT ? OFFSET ?
");
$stmt->execute([$limit, $offset]);
$posts = $stmt->fetchAll();

$stmt = $pdo->query("SELECT COUNT(*) FROM blog_posts");
$totalPosts = $stmt->fetchColumn();
$totalPages = ceil($totalPosts / $limit);

$pageTitle = "Manage Blog";
require_once '../layout.php';
?>

<div class="admin-blog">
    <div class="page-actions">
        <a href="/admin/blog/create.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Post
        </a>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Comments</th>
                    <th>Status</th>
                    <th>Published</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td>
                            <div class="post-title">
                                <?= htmlspecialchars($post['title']) ?>
                                <?php if ($post['featured']): ?>
                                    <span class="featured-badge">Featured</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($post['author_name']) ?></td>
                        <td>
                            <a href="/admin/blog/comments.php?post_id=<?= $post['id'] ?>">
                                <?= $post['comment_count'] ?> comments
                            </a>
                        </td>
                        <td>
                            <span class="status-badge status-<?= $post['status'] ?>">
                                <?= ucfirst($post['status']) ?>
                            </span>
                        </td>
                        <td><?= date('M d, Y', strtotime($post['published_at'])) ?></td>
                        <td class="action-buttons">
                            <a href="/admin/blog/edit.php?id=<?= $post['id'] ?>" class="btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="toggleFeatured(<?= $post['id'] ?>)" 
                                    class="btn-feature <?= $post['featured'] ? 'active' : '' ?>">
                                <i class="fas fa-star"></i>
                            </button>
                            <button onclick="deletePost(<?= $post['id'] ?>)" class="btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= $page === $i ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<script>
function toggleFeatured(postId) {
    fetch('/admin/blog/toggle-featured.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ postId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error updating featured status');
        }
    });
}

function deletePost(postId) {
    if (confirm('Are you sure you want to delete this post?')) {
        fetch('/admin/blog/delete.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ postId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting post');
            }
        });
    }
}
</script> 