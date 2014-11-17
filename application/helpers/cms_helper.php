<?php
/**
 * Created by PhpStorm.
 * Date: 16.11.14., 20.07 
 */
function btn_edit($uri){
    return anchor($uri, '<span class="glyphicon glyphicon-pencil"></span>');
}
function btn_delete($uri){
    return anchor($uri, '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>', array(
        'onclick' => "return confirm('Are you sure you wwant to delete this article.');"
    ));
}