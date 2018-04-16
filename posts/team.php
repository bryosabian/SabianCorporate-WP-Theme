<?php
$tepost = new SabianTeamPost();

$GLOBALS["sabian_team_post"] = $tepost;

class SabianTeamPost {

    public $post_name = "team_member";
    public $cat_name = "course_category";
    private $social_nonce = "sabian_team_social_nonce";
    private $position_nonce = "sabian_team_position_nonce";
    public $social_meta_key = "sabian_team_member_social_details";
    public $team_position_meta_key = "sabian_team_member_position";
    private $def_links = array();
    private $dash_icon='dashicons-admin-users';

    public function __construct() {

        add_action('init', array($this, 'register_post'));

        //add_action( 'init', array($this,'register_category'), 0 );

        add_filter('post_updated_messages', array($this, 'get_post_messages'));

        add_action('add_meta_boxes', array($this, 'register_boxes'));

        add_action('save_post', array($this, 'social_post_box_update'));

        add_action('save_post', array($this, 'position_post_box_update'));

        add_action("manage_" . $this->post_name . "_posts_columns", array($this, "post_table_head"));

        add_action("manage_" . $this->post_name . "_posts_custom_column", array($this, "post_table_rows"), 1000, 2);




        $def_links = array();

        $def_links["facebook"] = array("icon" => "facebook", "url" => "", "title" => "Facebook");

        $def_links["twitter"] = array("icon" => "twitter", "url" => "", "title" => "Twitter");

        $def_links["linkedin"] = array("icon" => "twitter", "url" => "", "title" => "Linked In");

        $def_links["google_plus"] = array("icon" => "google-plus", "url" => "", "title" => "Google Plus");

        $this->def_links = $def_links;
    }

    public function register_post() {

        $labels = array(
            'name' => _x('Team Members', 'post type general name'),
            'singular_name' => _x('Team Member', 'post type singular name'),
            'add_new' => _x('Add Team Member', 'course'),
            'add_new_item' => __('Add New Team Member'),
            'edit_item' => __('Edit Team Member'),
            'new_item' => __('New Team Member'),
            'all_items' => __('All Team Members'),
            'view_item' => __('View Team Member'),
            'not_found' => __('No members found'),
            'not_found_in_trash' => __('No members found in the Trash'),
            'parent_item_colon' => '',
            'menu_name' => 'Team Members'
        );

        $args = array(
            'labels' => $labels,
            'description' => 'Collection of various team members',
            'public' => true,
            'menu_position' => 5,
            'supports' => array('title', 'thumbnail'),
            'has_archive' => true,
            'menu_icon' => $this->dash_icon,
        );

        register_post_type($this->post_name, $args);
    }

    public function get_post_messages($messages) {

        global $post, $post_ID;

        $messages[$this->post_name] = array(
            0 => '',
            1 => sprintf(__('Member updated. <a href="%s">View testimonial</a>'), esc_url(get_permalink($post_ID))),
            2 => __('Member field updated.'),
            3 => __('Member field deleted.'),
            4 => __('Member updated.'),
            5 => isset($_GET['revision']) ? sprintf(__('Member restored to revision from %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
            6 => sprintf(__('Member published. <a href="%s">View course</a>'), esc_url(get_permalink($post_ID))),
            7 => __('Member saved.'),
            8 => sprintf(__('Member submitted. <a target="_blank" href="%s">Preview course</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
            9 => sprintf(__('Member scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview course</a>'), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
            10 => sprintf(__('Member draft updated. <a target="_blank" href="%s">Preview course</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
        );

        return $messages;
    }

    public function register_category() {

        $labels = array(
            'name' => _x('Course Categories', 'taxonomy general name'),
            'singular_name' => _x('Course Category', 'taxonomy singular name'),
            'search_items' => __('Search Course Categories'),
            'all_items' => __('All Course Categories'),
            'parent_item' => __('Parent Course Category'),
            'parent_item_colon' => __('Parent Course Category:'),
            'edit_item' => __('Edit Course Category'),
            'update_item' => __('Update Course Category'),
            'add_new_item' => __('Add New Course Category'),
            'new_item_name' => __('New Course Category'),
            'menu_name' => __('Course Categories'),
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
        );

        register_taxonomy($this->cat_name, $this->post_name, $args);
    }

    public function register_boxes() {

        add_meta_box(
                'sabian_team_member_social_box', 'Social Details', array($this, 'social_post_box_settings'), $this->post_name, 'normal'
        );


        add_meta_box(
                'sabian_team_member_position', 'Role/Position', array($this, 'position_post_box_settings'), $this->post_name, 'side', 'high'
        );
    }

    public function social_post_box_settings($post) {

        wp_nonce_field(plugin_basename(__FILE__), $this->social_nonce);

        $links = get_post_meta($post->ID, $this->social_meta_key, true);

        if ($links) {

            $links = json_decode($links, true);
        } else {
            $links = array();
        }

        $def_links = $this->def_links;

        if (isset($links["facebook"])) {
            $def_links["facebook"] = $links["facebook"];
        }

        if (isset($links["twitter"])) {
            $def_links["twitter"] = $links["twitter"];
        }

        if (isset($links["linkedin"])) {
            $def_links["linkedin"] = $links["linkedin"];
        }

        if (isset($links["google_plus"])) {
            $def_links["google_plus"] = $links["google_plus"];
        }
        ?>

        <?php
        foreach ($def_links as $i => $link) {

            extract($link);

            $val[$i] = $link;
            ?>
            <div class="sky-form form-group">

                <label for="sabian-header-title"><?php echo $title; ?></label>
                <input type="text" class="form-control" value="<?php echo $url; ?>" name="social_<?php echo $i; ?>" placeholder="Enter <?php echo $title; ?> Url" />

            </div>
            <?php
            unset($link);
        }
        ?>




        <?php
    }

    public function social_post_box_update($post_id) {

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;

        if (!wp_verify_nonce($_POST[$this->social_nonce], plugin_basename(__FILE__)))
            return;

        if ($this->post_name !== $_POST['post_type'])
            return;

        $def_links = $this->def_links;

        $the_links = array();

        $prefix = "social_";

        foreach ($def_links as $i => $link) {

            $post = $prefix . $i;

            if (!isset($_POST[$post])) {
                continue;
            }

            if ($_POST[$post] == "" | !$_POST[$post]) {
                continue;
            }

            $url = $_POST[$post];

            $link["url"] = $url;

            $the_links[$i] = $link;
        }

        $the_links = json_encode($the_links);

        sabian_update_meta_values($post_id, $this->social_meta_key, $the_links);
    }

    public function position_post_box_settings($post) {

        wp_nonce_field(plugin_basename(__FILE__), $this->position_nonce);

        $pos = get_post_meta($post->ID, $this->team_position_meta_key, true);
        ?>

        <div class="sky-form form-group">

            <label for="sabian-header-title">Team Member Role/Position</label>
            <input type="text" class="form-control" value="<?php echo $pos; ?>" name="team_position" placeholder="Enter user's position" />

        </div>

        <?php
    }

    public function position_post_box_update($post_id) {

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;

        if (!wp_verify_nonce($_POST[$this->position_nonce], plugin_basename(__FILE__)))
            return;

        if ($this->post_name !== $_POST['post_type'])
            return;

        $position = $_POST["team_position"];

        sabian_update_meta_values($post_id, $this->team_position_meta_key, $position);
    }

    public function post_table_head($column) {

        unset($column['date']);

        $column["title"] = "Title";

        $column["position"] = "Position";

        $column['date'] = "Date Created";

        return $column;
    }

    public function post_table_rows($column, $post_id) {

        $sPost = WP_Post::get_instance($post_id);

        if ($column == "title") {

            echo $sPost->post_title;
        }

        if ($column == "position") {

            $pos = get_post_meta($post_id, $this->team_position_meta_key, true);

            echo $pos;
        }
    }

}
?>