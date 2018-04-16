<?php
$cpost = new SabianCoursePost();

$GLOBALS["sabian_course_post"] = $cpost;

class SabianCoursePost {

    public $post_name = "course";
    public $cat_name = "course_category";
    private $course_nonce = "sabian_course_nonce";
    public $start_date_meta_key = "sabian_course_start_date";
    public $duration_meta_key = "sabian_course_duration";
    public $level_meta_key = "sabian_course_level";

    public function __construct() {

        add_action('init', array($this, 'register_post'));

        add_action('init', array($this, 'register_category'), 0);

        add_filter('post_updated_messages', array($this, 'get_post_messages'));

        add_action('add_meta_boxes', array($this, 'register_boxes'));

        add_action('save_post', array($this, 'post_box_update'));

        add_action("manage_" . $this->post_name . "_posts_columns", array($this, "post_table_head"));

        add_action("manage_" . $this->post_name . "_posts_custom_column", array($this, "post_table_rows"), 1000, 2);
    }

    public function register_post() {

        $labels = array(
            'name' => _x('Courses', 'post type general name'),
            'singular_name' => _x('Course', 'post type singular name'),
            'add_new' => _x('Add Course', 'course'),
            'add_new_item' => __('Add New Course'),
            'edit_item' => __('Edit Course'),
            'new_item' => __('New Course'),
            'all_items' => __('All Courses'),
            'view_item' => __('View Course'),
            'not_found' => __('No courses found'),
            'not_found_in_trash' => __('No courses found in the Trash'),
            'parent_item_colon' => '',
            'menu_name' => 'Courses'
        );

        $args = array(
            'labels' => $labels,
            'description' => 'Collection of various courses',
            'public' => true,
            'menu_position' => 5,
            'supports' => array('title', 'editor', 'thumbnail'),
            'has_archive' => true,
            "menu_icon" => "dashicons-businessman"
        );

        register_post_type($this->post_name, $args);
    }

    public function get_post_messages($messages) {

        global $post, $post_ID;

        $messages[$this->post_name] = array(
            0 => '',
            1 => sprintf(__('Course updated. <a href="%s">View course</a>'), esc_url(get_permalink($post_ID))),
            2 => __('Course field updated.'),
            3 => __('Course field deleted.'),
            4 => __('Course updated.'),
            5 => isset($_GET['revision']) ? sprintf(__('Course restored to revision from %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
            6 => sprintf(__('Testimonial published. <a href="%s">View course</a>'), esc_url(get_permalink($post_ID))),
            7 => __('Course saved.'),
            8 => sprintf(__('Course submitted. <a target="_blank" href="%s">Preview course</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
            9 => sprintf(__('Course scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview course</a>'), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
            10 => sprintf(__('Course draft updated. <a target="_blank" href="%s">Preview course</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
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
                'sabian_course_box', 'Course Details', array($this, 'post_box_settings'), $this->post_name, 'side', 'high'
        );
    }

    public function post_box_settings($post) {

        wp_nonce_field(plugin_basename(__FILE__), $this->course_nonce);

        $startDate = get_post_meta($post->ID, $this->start_date_meta_key, true);

        $duration = get_post_meta($post->ID, $this->duration_meta_key, true);

        $level = get_post_meta($post->ID, $this->level_meta_key, true);
        ?>

        <div class="sky-form form-group">

            <label for="sabian-header-title">Start Date (e.g 12th January 2018)</label>
            <input type="text" class="form-control" value="<?php echo $startDate; ?>" name="course_start_date" placeholder="Enter start date" />

        </div>

        <div class="sky-form form-group">

            <label for="sabian-header-title">Course Duration (Years)</label>
            <input type="text" class="form-control" value="<?php echo $duration; ?>" name="course_duration" placeholder="Enter duration" />

        </div>

        <div class="sky-form form-group">

            <label for="sabian-header-title">Course Level</label>
            <input type="text" class="form-control" value="<?php echo $level; ?>" name="course_level" placeholder="Enter course level" />

        </div>



        <?php
    }

    public function post_box_update($post_id) {

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;

        if (!wp_verify_nonce($_POST[$this->course_nonce], plugin_basename(__FILE__)))
            return;

        if ($this->post_name !== $_POST['post_type'])
            return;

        //if ( !current_user_can( 'edit_page', $post_id ) )
        //return; 

        $sDate = $_POST["course_start_date"];

        $duration = $_POST["course_duration"];

        $level = $_POST["course_level"];

        sabian_update_meta_values($post_id, $this->start_date_meta_key, $sDate);

        sabian_update_meta_values($post_id, $this->duration_meta_key, $duration);

        sabian_update_meta_values($post_id, $this->level_meta_key, $level);
    }

    public function post_table_head($column) {

        unset($column['date']);

        $column["title"] = "Title";

        $column["start_date"] = "Start Date";

        $column["duration"] = "Duration (Years)";

        $column["level"] = "Level";

        $column['date'] = "Date Created";

        return $column;
    }

    public function post_table_rows($column, $post_id) {

        $sPost = WP_Post::get_instance($post_id);

        if ($column == "title") {

            echo $sPost->post_title;
        }

        if ($column == "start_date") {

            $sDate = get_post_meta($post_id, $this->start_date_meta_key, true);

            echo $sDate;
        }
        if ($column == "duration") {

            $duration = get_post_meta($post_id, $this->duration_meta_key, true);

            echo $duration;
        }
        if ($column == "level") {

            $level = get_post_meta($post_id, $this->level_meta_key, true);

            echo $level;
        }
    }

}
?>