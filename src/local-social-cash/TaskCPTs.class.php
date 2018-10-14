<?php

namespace LocalSocialCash;

//This class creates the CPTs for the Task type:

class TaskCPTs{
    
    public $pluginDirectory;
    public function __construct() {
        $this->pluginDirectory = plugin_dir_url(dirname( __FILE__ ));
        add_action( 'init', array( $this, 'create_taxonomies' ) );
        add_action('init', array( $this, 'createTaskCustomPostType' ) );
    }
    public function activate() {
        $this->create_taxonomies();
        
    }
    function create_taxonomies() {
        $Task_type_args = array(
            'hierarchical' => true,
            'labels' => array(
                'name'=> _x('Task Types', 'taxonomy general name' ),
                'singular_name' => _x('Task Type', 'taxonomy singular name'),
                'search_items' => __('Search Task Types'),
                'popular_items' => __('Popular Task Types'),
                'all_items' => __('All Task Types'),
                'edit_item' => __('Edit Task Type'),
                'edit_item' => __('Edit Task Type'),
                'update_item' => __('Update Task Type'),
                'add_new_item' => __('Add New Task Type'),
                'new_item_name' => __('New Task Type Name'),
                'separate_items_with_commas' => __('Seperate Task Types with Commas'),
                'add_or_remove_items' => __('Add or Remove Task Types'),
                'choose_from_most_used' => __('Choose from Most Used Task Types')
            ),
            'query_var' => true,
            'rewrite' => array('slug' =>'Task-type')
        );
        register_taxonomy('Task-type', 'Task',$Task_type_args);
    }
    function createTaskCustomPostType(){
        //$menu_icon = $this->pluginDirectory . "/assets/images/Task.gif";
        $labels = array(
            'name'                => _x( 'Tasks', 'Post Type General Name', 'crg_text_domain' ),
            'singular_name'       => _x( 'Task', 'Post Type Singular Name', 'crg_text_domain' ),
            'menu_name'           => __( 'Tasks', 'crg_text_domain' ),
            'parent_item_colon'   => __( 'Parent Task:', 'crg_text_domain' ),
            'all_items'           => __( 'All Tasks', 'crg_text_domain' ),
            'view_item'           => __( 'View Task', 'crg_text_domain' ),
            'add_new_item'        => __( 'Add New Task', 'crg_text_domain' ),
            'add_new'             => __( 'Add New', 'crg_text_domain' ),
            'edit_item'           => __( 'Edit Task', 'crg_text_domain' ),
            'update_item'         => __( 'Update Task', 'crg_text_domain' ),
            'search_items'        => __( 'Search Task', 'crg_text_domain' ),
            'not_found'           => __( 'Not found', 'crg_text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'crg_text_domain' ),
        );
        $args = array(
            'label'               => __( 'Task', 'crg_text_domain' ),
            'description'         => __( 'Tasks', 'crg_text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields'),
            'taxonomies'          => array( 'Task-type' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            //'menu_icon'           => $menu_icon,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
        );
        register_post_type('Task', $args);
        
        wp_insert_term( __('Wordpress'),'Task-type', array( 'description' => __('A link to a Wordpress ad'),'slug' => 'feature'));
    }
}
