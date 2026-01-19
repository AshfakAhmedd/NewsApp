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
                <td><?= htmlspecialchars($comment['status']) ?></td>
                <td>
                    <?php if ($comment['status'] == 'seen') { ?>
                    <a role="button" class="btn btn-sm btn-success text-white" href="<?= url('admin/comment/change-status/' . $comment['id']) ?>">click to approved</a>
                    <?php } else { ?>
                    <a role="button" class="btn btn-sm btn-warning text-white" href="<?= url('admin/comment/change-status/' . $comment['id']) ?>">click not to approved</a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</section>
