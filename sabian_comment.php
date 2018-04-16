<?php

/** COMMENTS WALKER */
class SabianCommentWalker extends Walker_Comment {

    // init classwide variables
    var $tree_type = 'comment';
    
    var $db_fields = array('parent' => 'comment_parent', 'id' => 'comment_ID');

    /** CONSTRUCTOR
     * You'll have to use this if you plan to get to the top of the comments list, as
     * start_lvl() only goes as high as 1 deep nested comments */
    function __construct() {
        ?>

    <?php
    }

    /** START_LVL 
     * Starts the list before the CHILD elements are added. Unlike most of the walkers,
     * the start_lvl function means the start of a nested comment. It applies to the first
     * new level under the comments that are not replies. Also, it appear that, by default,
     * WordPress just echos the walk instead of passing it to &$output properly. Go figure.  */
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $GLOBALS['comment_depth'] = $depth + 1;
        ?>

        <ul class="children">
        <?php
        }

        /** END_LVL 
         * Ends the children list of after the elements are added. */
        function end_lvl(&$output, $depth = 0, $args = array()) {
            $GLOBALS['comment_depth'] = $depth + 1;
            ?>

        </ul><!-- /.children -->

    <?php
    }

    /** START_EL */
    function start_el(&$output, $comment, $depth, $args, $id = 0) {
        $depth++;
        $GLOBALS['comment_depth'] = $depth;
        $GLOBALS['comment'] = $comment;
        $parent_class = ( empty($args['has_children']) ? '' : 'parent' );

        $aImage = get_avatar($comment, $args['avatar_size']);
        ?>

        <li class="comment">
            <div class="comment-body bb">
                <div class="comment-avatar">
                    <div class="avatar"><img alt="" src="<?php echo $aImage; ?>" class="avatar avatar-60 photo" height="60" width="60"></div>
                </div>
                <div class="comment-text">
                    <div class="comment-author clearfix">
                        <a href="<?php echo get_comment_author_url(); ?>" class="link-author" hidefocus="true"><?php echo get_comment_author(); ?></a>
                        <span class="comment-meta"><span class="comment-date"><?php echo get_comment_date(); ?></span></span>
                    </div>
                    <div class="comment-entry">
                        <p><?php comment_text(); ?></p>
                    </div>

                    <div class="reply">
                        <?php
                        $reply_args = array(
                            'add_below' => $add_below,
                            'depth' => $depth,
                            'max_depth' => $args['max_depth']);

                        comment_reply_link(array_merge($args, $reply_args));
                        ?>
                    </div>
                </div>
            </div>


            <!-- /#comment-' . get_comment_ID() . ' -->

    <?php }

    function end_el(&$output, $comment, $depth = 0, $args = array()) {
        ?>

        </li><!-- /#comment-' . get_comment_ID() . ' -->

    <?php
    }

    /** DESTRUCTOR
     * I just using this since we needed to use the constructor to reach the top 
     * of the comments list, just seems to balance out :) */
    function __destruct() {
        ?>



    <?php
    }

}
?>