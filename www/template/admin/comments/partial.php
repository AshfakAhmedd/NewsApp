<?php
// This partial outputs only the comments table fragment for AJAX/modal use.
// Expects $comments (iterable) and optional $postTitle to be set by controller.
?>
<section class="table-responsive">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="m-0">Comments<?php if (!empty($postTitle)) { echo ' for: ' . htmlspecialchars($postTitle); } ?></h5>
    </div>
    <table class="table table-striped table-sm">
        <caption>List of comments</caption>
        <thead>
            <tr>
                <th>#</th>
                <th>user</th>
                <th>post</th>
                <th>comment</th>
                <th>status</th>
                <th>setting</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $key => $comment) { ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= htmlspecialchars($comment['email']) ?></td>
                <td><?= htmlspecialchars($comment['post_title']) ?></td>
                <td><?= htmlspecialchars($comment['comment']) ?></td>
                <td id="comment_row_<?= $comment['id'] ?>"><?= htmlspecialchars($comment['status']) ?></td>
                <td>
                 <button
                        type="button"
                        class="btn btn-sm text-white comment-status-btn <?= $comment['status'] == 'seen' ? 'btn-success' : 'btn-warning' ?>"
                        data-id="<?= $comment['id'] ?>"
                        data-status="<?= $comment['status'] ?>"
                    >
                        <?= $comment['status'] == 'seen' ? 'Click to approve' : 'Click not to approve' ?>
                    </button>

                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</section>

