<?php

class Wordpress_Doodles_Overview extends WP_List_Table 
{

    private $plugin_name;
    private $version;
    private $doodle_admin_class;
    /**
     * Constructor
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     */
    public function __construct($plugin_name, $version, $doodle_admin_class)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->doodle_admin_class = $doodle_admin_class;

        parent::__construct( array(
            'singular' => __( 'Doodle', 'wordpress-doodle' ), //singular name of the listed records
            'plural'   => __( 'Doodles', 'wordpress-doodle' ), //plural name of the listed records
            'ajax'     => false //should this table support ajax?

        ) );

        add_action( "load-admin_page_doodles", array( $this, 'screen_option' ) );
        add_filter( 'set-screen-option', array($this, 'set_screen'), 10, 3 );

    }

    /**
     * Set Screen
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  string
     */
    public static function set_screen( $status, $option, $value ) {
        return $value;
    }

    /**
     * Screen options
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  
     */
    public function screen_option() {

        $option = 'per_page';
        $args   = array(
            'label'   => 'Doodles',
            'default' => 25,
            'option'  => 'doodles_per_page'
        );

        add_screen_option( $option, $args );
    }

    /**
     * Text displayed when no transaction data is available 
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  array
     */
    public function no_items() {
        _e( 'No doodles avaliable.', 'wordpress-doodle' );
    }

    /**
     * Render a column when no column specific method exist.
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  array
     */
    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'name':
            case 'id':
            case 'location':
            case 'description':
            case 'invitees':
            case 'participants':
            case 'type':
            case 'state':
            case 'export':
            case 'actions':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ); //Show the whole array for troubleshooting purposes
        }
    }

    /**
     * Get the Columns
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  array
     */
    function get_columns() {
        $columns = array(
            'name' => __('Name', 'wordpress-doodle'),
            'id' => __('id', 'wordpress-doodle'),
            'location' => __('Location', 'wordpress-doodle'),
            'description' => __('Description', 'wordpress-doodle'),
            'invitees' => __('Invitees', 'wordpress-doodle'),
            'participants' => __('Participants', 'wordpress-doodle'),
            'type' => __('Type', 'wordpress-doodle'),
            'state' => __('State', 'wordpress-doodle'),
            'export' => __('Export', 'wordpress-doodle'),
            'actions' => __('Actions', 'wordpress-doodle'),
            
        );

        return $columns;
    }

    /**
     * Get the Sortable columns
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'name' => array ('name', true),
            'id' => array ('id', false),
            'location' => array ('name', true),
            'description' => array ('name', false),
            'invitees' => array ('name', true),
            'participants' => array ('name', true),
            'type' => array ('name', true),
            'state' => array ('name', true),
            'export' => array ('name', false),
            'actions' => array ('name', false),
        );

        return $sortable_columns;
    }
    /**
     * Get the hidden columns
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  array
     */
    public function get_hidden_columns()
    {
        return array();
    }

    /**
     * Prepare your items
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  mixed
     */
    public function prepare_items() {

        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        /** Process bulk action */
        $this->process_bulk_action();

        $per_page     = $this->get_items_per_page( 'doodles_per_page', 25 );
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();

        $this->set_pagination_args( array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page'    => $per_page //WE have to determine how many items to show on a page
        ));

        $this->items = $this->doodle_admin_class->get_doodles();
    }

}