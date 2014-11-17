<section>
    <h2>Articles</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Title</th>
        </tr>
        </thead>
        <tbody>
        <?php if(count($articles)): foreach($articles as $article): ?>
            <tr>
                <td><?php echo anchor( 'article/view/' . $article->slug, $article->title ); ?></td>
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
</section>
