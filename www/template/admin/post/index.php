<?php

        require_once (BASE_PATH . '/template/admin/layouts/head-tag.php')

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h5"><i class="fas fa-newspaper"></i> Articles</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a role="button" href="<?= url('admin/post/create') ?>" class="btn btn-sm btn-success">create</a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <caption>List of posts</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>title</th>
                    <th>summary</th>
                    <th>view</th>
                    <th>status</th>
                    <th>user ID</th>
                    <th>cat ID</th>
                    <th>image</th>
                    <th>setting</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach ($posts as $key => $post) { ?>
              
                <tr>
                    <td>
                        <?= $key += 1 ?>
                    </td>
                    <td>
                        <?= $post['title'] ?>
                    <td>
                        <?= $post['summary'] ?>
                    </td>
                    <td>
                        <?= $post['view'] ?>
                    </td>
                    <td>
                        <?php if($post['breaking_news'] == 2) { ?>
                            <span class="badge badge-success">#breaking_news</span>
                        <?php }
                        if($post['selected'] == 2) { ?>
                            <span class="badge badge-dark">#editor_selected</span>
                        <?php } ?>
                    </td>
                    <td>
                        <?= $post['user_id'] ?>
                    </td>
                    <td>
                        <?= $post['cat_id'] ?>
                    </td>
                    <td>
                            <img style="width: 80px;" src="<?= asset($post['image']) ?>" alt="">
                     </td>
                <td style="width: 25rem;">
                    <a role="button" class="btn btn-sm btn-warning btn-info text-dark" href="<?= url('admin/post/breaking-news/' . $post['id']) ?>">
                        <?php if($post['breaking_news'] == 2) { ?>
                   remove breaking news 
                   <?php } else { ?>
                   add breaking news
                   <?php } ?>
                        </a>
                        <a role="button" class="btn btn-sm btn-warning btn-warning text-dark" href="<?= url('admin/post/selected/' . $post['id']) ?>">
                        <?php if($post['selected'] == 2) { ?>
                   remove selcted
                   <?php } else { ?>
                    add selected
                    <?php } ?>
                        </a>
                        <hr class="my-1" />
                        <a role="button" class="btn btn-sm btn-primary text-white" href="<?= url('admin/post/edit/' . $post['id']) ?>">edit</a>
                        <a role="button" class="btn btn-sm btn-danger text-white" href="<?= url('admin/post/delete/' . $post['id']) ?>">delete</a>
                    <?php if (!empty($post['comments_count']) && $post['comments_count'] > 0) { ?>
                        <a role="button" class="btn btn-sm btn-info text-white btn-comment" href="<?= url('admin/comment') . '?post_id=' . $post['id'] ?>">comment</a>
                    <?php } ?>
                </td>
                </tr>

                <?php } ?>
                </tbody>

                </table>
        </div>



<?php

require_once (BASE_PATH . '/template/admin/layouts/footer.php')

?>

<!-- Comments modal -->
<div class="modal fade" id="commentsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Comments</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="commentsModalBody">
                <div class="text-center text-muted">Loading...</div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
        var modalEl = document.getElementById('commentsModal');
        var modalBody = document.getElementById('commentsModalBody');
        var bsModal = null;
        if (typeof bootstrap !== 'undefined' && modalEl) {
                bsModal = new bootstrap.Modal(modalEl);
        }

        document.querySelectorAll('.btn-comment').forEach(function(el){
                el.addEventListener('click', function(e){
                        e.preventDefault();
                        var href = el.getAttribute('href') || '';
                        if (href.indexOf('?') === -1) href += '?ajax=1'; else href += '&ajax=1';
                        modalBody.innerHTML = '<div class="text-center text-muted">Loading...</div>';
                        fetch(href, { credentials: 'same-origin' })
                                .then(function(res){ return res.text(); })
                                .then(function(html){
                                        modalBody.innerHTML = html;
                                        if (bsModal) bsModal.show();
                                })
                                .catch(function(err){
                                        modalBody.innerHTML = '<div class="text-danger">Failed to load comments.</div>';
                                        if (bsModal) bsModal.show();
                                });
                });
        });
});
</script>