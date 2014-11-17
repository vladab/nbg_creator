<h3><?php echo empty($article->id) ? 'Add a new article' : 'Edit article ' . $article->title; ?></h3>
<?php echo validation_errors(); ?>
<?php echo form_open_multipart(); ?>
<table class="table">
    <tr>
        <td>Title</td>
        <td><?php echo form_input('title', set_value('title', $article->title), 'class="form-control"'); ?></td>
    </tr>
    <tr>
        <td>Slug</td>
        <td><?php echo form_input('slug', set_value('slug', $article->slug), 'class="form-control"'); ?></td>
    </tr>
    <tr>
        <td>Body</td>
        <td><?php echo form_textarea('body', set_value('body', $article->body), 'class="tinymce"'); ?></td>
    </tr>
    <tr>
        <td>Add Picture</td>
        <td><?php echo form_upload('userfile[]', '', 'class="form-control" multiple=""'); ?></td>
    </tr>
    <?php if( !empty( $article->files ) ): ?>
    <tr>
        <td>Article Pictures</td>
        <td>
            <?php foreach( $article->files  as $image): ?>
                <div class="col-xs-6 col-md-3">
                <div class="thumbnail">
                    <img data-src="holder.js/100%x180"
                         src="<?php echo site_url('uploads'). '/' . $image->location ?>" data-holder-rendered="true" style="height: 180px; display: block;">
                    <div class="caption">
                        <p>
                            <span class="btn btn-primary remove_image" rel="<?php echo $image->id; ?>" role="button">Remove</span>
                        </p>
                    </div>
                </div>
                </div>
            <?php endforeach; ?>
        </td>
    </tr>
    <?php endif; ?>
    <tr>
        <td></td>
        <td>
            <?php echo form_submit('submit', 'Cancel', 'class="btn btn-warning"'); ?>
            <?php echo form_submit('submit', 'Save', 'class="btn btn-primary"'); ?>
        </td>
    </tr>
</table>
<?php echo form_close();?>
<script type="text/javascript">
    $('.remove_image').click( function() {
        var _image_id = $(this).attr('rel');
        var elem = $(this);
        var r = confirm("Are you sure you want to delete this image?");
        if (r == true) {
            $.post("<?php echo site_url('admin/article/remove_media_ajax'); ?>", {_id: _image_id }, function(data) {
                elem.closest('.col-xs-6').remove();
            });
        }
    });
</script>