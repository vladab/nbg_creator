<h2>Articles</h2>
<?php echo anchor('admin/article/edit', '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add an article'); ?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Title</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if(count($articles)): foreach($articles as $article): ?>
        <tr>
            <td><?php echo anchor('admin/article/edit/' . $article->id, $article->title); ?></td>
            <td>
                <?php echo btn_edit('admin/article/edit/' . $article->id); ?>
                <span class="delete" rel="<?php echo $article->id ?>">
                        <span class="glyphicon glyphicon-remove"></span>
                    </span>

            </td>
        </tr>
    <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">We could not find any articles.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
<?php echo $pagination; ?>
<script type="text/javascript">

    $('.delete').click( function() {
        var article_id = $(this).attr('rel');
        var r = confirm("Are you sure you want to delete this article?");
        if (r == true) {
            $.post("<?php echo site_url('admin/article/remove_ajax/' . $start); ?>", {_id: article_id }, function(data) {
                $('#article_list').html(data);
            });
        }
    });
</script>