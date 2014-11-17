<div class="page-header">
    <p><?php echo anchor( site_url(), 'Return back'); ?></p>
    <h1><?php echo $article->title; ?></h1>
</div>
<?php echo $article->body; ?>

<?php if( !empty( $article->files ) ): ?>
            <?php foreach( $article->files  as $image): ?>
                <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img data-src="holder.js/100%x180"
                             src="<?php echo site_url('uploads'). '/' . $image->location ?>" data-holder-rendered="true" style="height: 180px; display: block;">
                    </a>
                </div>
            <?php endforeach; ?>
<?php endif; ?>