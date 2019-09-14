
<?php
if (isset($post_single_comment)) {
    $comments = $post_single_comment;
} else {
//    $comments = $post->comments->take(5);
    $comments = $post->comments;
}
?>
<input type="hidden" id="edit_comment_id<?= $post->id ?>">
<!--<input type="hidden" id="edit_commment_comment_id<?= $post->id ?>">-->
<!--<input type="hidden" id="edit_comment_post_id<?= $post->id ?>">-->
<?php
$total_comments = count($comments);
$i = 1;
foreach ($comments as $comment) {
    ?>
    <li id="single-comment-list-<?= $comment->id ?>" class="comments_hidden<?= $post->id ?> single-comment-list-<?= $comment->id ?>" <?php if ($total_comments > 5 && $i <= $total_comments - 5) { ?> style="display: none" <?php }$i++; ?>>
        <div class="d-flex">
            <figure class="figure mr-3 sx-mr-2">
                <span class="bg_image_round w-40" style="background-image: url(<?php echo getUserImage($comment->user->photo, $comment->user->social_photo, $comment->user->gender) ?>)">
                    <?php if ($comment->user->is_online && $comment->user_id != $current_id) { ?>
                        <span class="active_status absolute"></span>
                    <?php } ?>
                </span>                
            </figure>
            <div class="comment_body">
                <div class="comment_meta">
                    <div class="d-flex flex-column flex-sm-row">
                        <div>
                            <a href="<?= asset('profile_timeline/' . $comment->user->id) ?>"><span class="font-weight-bold text_darkblue"><?= $comment->user->first_name . ' ' . $comment->user->last_name ?></span></a>
                        </div>
                        <div class="time_actions ml-sm-auto align-self-sm-start">
                            <?php if ($comment->user_id == $current_id) { ?>
                                <ul  class="un_style no_icon action_dropdown small float-right edit_scroll_<?= $post->id?>">
                                    <li class="dropdown">
                                        <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </a>
                                        <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                            <input type="hidden" value='<?= $comment->edit_data?>' id="hidden_comment_<?= $comment->id ?>">
                                            <a onclick="editComment('<?= $comment->id ?>', '<?= $comment->post_id ?>','')" class="dropdown-item" href="javascript:void(0)">
                                                <i class="fas fa-edit"></i> Edit</a>
                                            <a data-toggle="modal" data-target="#modal_comment_delete_<?= $comment->id ?>" class="dropdown-item" href="javascript:void(0)"><i
                                                    class="fas fa-trash-alt"></i> Delete</a>
                                        </div>
                                    </li>
                                </ul>
                            <?php } ?>
                            <span class="text_grey font-14"> <?= timeago($comment->created_at) ?> </span>
                        </div>
                    </div>
                    <div class="font-15"><?= getMentions($comment->comment) ?></div>
                </div>
            </div>
        </div>
    </li>
    <!--Modal-->
    <!-- Delete Model-->
    <div class="modal fade" id="modal_comment_delete_<?= $comment->id ?>" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div>
                            <label class="font-weight-bold">Are you sure you want to Delete this?</label>
                        </div>
                        <div class="mt-3 text-center">
                            <button type="button"data-id="" class="delete_event btn btn-round btn-gradient btn-xl font-weight-bold" onclick="deletePostComment('<?= $comment->id; ?>', '<?= $comment->post_id ?>')">Yes</button>
                            <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> No </button>
                        </div>
                    </form>
                </div> <!-- modal body -->
            </div>
        </div>
    </div> <!-- Delete modal -->

<?php } ?>