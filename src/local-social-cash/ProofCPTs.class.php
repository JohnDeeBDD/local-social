<?php

namespace LocalSocialCash;

//This class creates the CPTs for the Proof type:

class ProofCPTs{
    
    public $pluginDirectory;
    public function __construct() {
        $this->pluginDirectory = plugin_dir_url(dirname( __FILE__ ));
        add_action( 'init', array( $this, 'create_taxonomies' ) );
        add_action('init', array( $this, 'createProofCustomPostType' ) );
    }
    public function activate() {
        $this->create_taxonomies();
        
    }
    function create_taxonomies() {
        $Proof_type_args = array(
            'hierarchical' => true,
            'labels' => array(
                'name'=> _x('Proof Types', 'taxonomy general name' ),
                'singular_name' => _x('Proof Type', 'taxonomy singular name'),
                'search_items' => __('Search Proof Types'),
                'popular_items' => __('Popular Proof Types'),
                'all_items' => __('All Proof Types'),
                'edit_item' => __('Edit Proof Type'),
                'edit_item' => __('Edit Proof Type'),
                'update_item' => __('Update Proof Type'),
                'add_new_item' => __('Add New Proof Type'),
                'new_item_name' => __('New Proof Type Name'),
                'separate_items_with_commas' => __('Seperate Proof Types with Commas'),
                'add_or_remove_items' => __('Add or Remove Proof Types'),
                'choose_from_most_used' => __('Choose from Most Used Proof Types')
            ),
            'query_var' => true,
            'rewrite' => array('slug' =>'Proof-type')
        );
        register_taxonomy('Proof-type', 'Proof',$Proof_type_args);
    }
    function createProofCustomPostType(){
        //$menu_icon = $this->pluginDirectory . "/assets/images/Proof.gif";
        $labels = array(
            'name'                => _x( 'Proofs', 'Post Type General Name', 'crg_text_domain' ),
            'singular_name'       => _x( 'Proof', 'Post Type Singular Name', 'crg_text_domain' ),
            'menu_name'           => __( 'Proofs', 'crg_text_domain' ),
            'parent_item_colon'   => __( 'Parent Proof:', 'crg_text_domain' ),
            'all_items'           => __( 'All Proofs', 'crg_text_domain' ),
            'view_item'           => __( 'View Proof', 'crg_text_domain' ),
            'add_new_item'        => __( 'Add New Proof', 'crg_text_domain' ),
            'add_new'             => __( 'Add New', 'crg_text_domain' ),
            'edit_item'           => __( 'Edit Proof', 'crg_text_domain' ),
            'update_item'         => __( 'Update Proof', 'crg_text_domain' ),
            'search_items'        => __( 'Search Proof', 'crg_text_domain' ),
            'not_found'           => __( 'Not found', 'crg_text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'crg_text_domain' ),
        );
        $args = array(
            'label'               => __( 'Proof', 'crg_text_domain' ),
            'description'         => __( 'Proofs', 'crg_text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields'),
            'taxonomies'          => array( 'Proof-type' ),
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
        register_post_type('Proof', $args);
        
        wp_insert_term( __('Wordpress'),'Proof-type', array( 'description' => __('A link to a Wordpress ad'),'slug' => 'feature'));
    }
}
