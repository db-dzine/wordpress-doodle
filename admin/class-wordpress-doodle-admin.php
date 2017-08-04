<?php

class Wordpress_Doodle_Admin
{
    private $plugin_name;
    private $version;
    private $options;

    /**
     * Construct Doodle Admin Class
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @param   string                         $plugin_name
     * @param   string                         $version    
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Enqueue Admin Styles
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     * @return  boolean
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name.'-custom', plugin_dir_url(__FILE__).'css/wordpress-doodle-admin.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name.'-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), $this->version, 'all');
    }

    /**
     * Enqueue Admin Scripts
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     * @return  boolean
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name.'-custom', plugin_dir_url(__FILE__).'js/wordpress-doodle-admin.js', array('jquery'), $this->version, true);
    }

    /**
     * Load Extensions
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  boolean
     */
    public function load_extensions()
    {
        // Load the theme/plugin options
        if (file_exists(plugin_dir_path(dirname(__FILE__)).'admin/options-init.php')) {
            require_once plugin_dir_path(dirname(__FILE__)).'admin/options-init.php';
        }
    }

    /**
     * Get Options
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @param   mixed                         $option The option key
     * @return  mixed                                 The option value
     */
    private function get_option($option)
    {
        if(!is_array($this->options)) {
            return false;
        }

        if (!array_key_exists($option, $this->options)) {
            return false;
        }

        return $this->options[$option];
    }

    /**
     * Init Admin facade
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  [type]                         [description]
     */
    public function init()
    {
        global $Wordpress_Doodle_options;

        $this->options = $Wordpress_Doodle_options;

        if (!$this->get_option('enable')) {
            return false;
        }

    }

    /**
     * Add the Doodles Menu Page
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     */
    public function plugin_menu() {

        $hook = add_submenu_page(
            'Wordpress_Doodle_options_options',
            'Doodles',
            'Doodles',
            'manage_options',
            'doodles',
            array( $this, 'plugin_settings_page' )
        );
    }

    /**
     * Plugin settings page
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  
     */
    public function plugin_settings_page() {

        $doodle_overview = new Wordpress_Doodles_Overview($this->plugin_name, $this->version, $this);
        $doodle_overview->prepare_items();
        add_thickbox();
        ?>
        <div class="wrap">
            <h2>Doodles</h2>
            <p>Possible shortcode tags are: </p>
            <ul>
                <li>id* = Doodle Poll ID</li>
                <li>width = width of the new window (Default: 630px)</li>
                <li>height = height of the new window (Default: 1500px)</li>
                <li>showname = show the poll name (Default: yes)</li>
                <li>showlocation = show the poll location (Default: yes)</li>
                <li>showdescription = show the poll description (Default: yes)</li>
                <li>showoptions = show the poll options (Default: yes)</li>
                <li>showparticipants = show the poll participants (Default: yes)</li>
            </ul>
            <p>Example: [doodle id="YOURID" width="630px" height="1500px" showname="yes" showlocation="yes" showdescription="yes" showoptions="yes" showparticipants="yes"]Participate Now[/doodle]</p>
            
            <a href="#TB_inline?width=800&height=500&inlineId=create-text-poll" title="Create a Text Poll" class="button button-primary thickbox">Create a Text Poll</a>
            <a href="#TB_inline?width=800&height=500&inlineId=create-dates-poll" title="Create a Dates Poll" class="button button-primary thickbox">Create a Dates Poll</a>

            <div id="create-text-poll" style="display: none;">
                <div class="form-wrap">
                    <form id="create_text_poll" method="post" action="<?php echo admin_url( 'admin.php' ); ?>"">
                        <input type="hidden" name="action" value="create_text_poll">
                        <?php wp_nonce_field('create_text_poll','verify_doodle_nonce'); ?>
                        <div class="form-field form-required">
                            <label for="title">Title *</label>
                            <input name="title" id="title" type="text" value="">
                            <p>The name of the poll.</p>
                        </div>
                        <div class="form-field form-required">
                            <label for="location">Location</label>
                            <input name="location" id="location" type="text" value="">
                            <p>The location of the poll.</p>
                        </div>
                        <div class="form-field form-required">
                            <label for="description">Description</label>
                            <input name="description" id="description" type="text" value="">
                            <p>The description of the poll.</p>
                        </div>
                        <div class="form-field form-required doodle-options">
                            <label for="options">Options *</label>
                            <div class="doodle-options-wrapper">
                                <div class="doodle-option-wrapper">
                                    <input name="options[]" id="options[]" type="text" value="">
                                    <a href="#" class="doodle-options-remove"><i class="fa red fa-minus" style="color: red;"></i></a>
                                </div>
                            </div>
                            <div>
                                <a href="#" class="doodle-options-add"><i class="fa fa-plus" ></i> Add More</a>
                            </div>
                        </div> 
                        <p class="submit">
                            <input type="submit" name="submit" id="submit" class="button button-primary" value="Create new Text Poll">
                        </p>                   
                    </form>
                </div>
            </div>
            <div id="create-dates-poll" style="display: none;">
                <div class="form-wrap">
                    <form id="create_dates_poll" method="post" action="<?php echo admin_url( 'admin.php' ); ?>"">
                        <input type="hidden" name="action" value="create_dates_poll">
                        <?php wp_nonce_field('create_dates_poll','verify_doodle_nonce'); ?>
                        <div class="form-field form-required">
                            <label for="title">Title *</label>
                            <input name="title" id="title" type="text" value="">
                            <p>The name of the poll.</p>
                        </div>
                        <div class="form-field form-required">
                            <label for="location">Location</label>
                            <input name="location" id="location" type="text" value="">
                            <p>The location of the poll.</p>
                        </div>
                        <div class="form-field form-required">
                            <label for="description">Description</label>
                            <input name="description" id="description" type="text" value="">
                            <p>The description of the poll.</p>
                        </div>
                        <div class="form-field form-required doodle-dates">
                            <label for="dates">Dates / Time *</label>
                            <div class="doodle-dates-wrapper">
                                <div class="doodle-date-wrapper">
                                    <input name="dates[]" type="date" value="" size="40" style="width: 45%; margin-right: 5px;">
                                    <input name="dates[][]" type="time" value="" size="40" style="width: 45%; margin-right: 5px;">
                                    <a href="#" class="doodle-dates-remove"><i class="fa red fa-minus" style="color: red;"></i></a>
                                </div>
                            </div>
                            <div>
                                <a href="#" class="doodle-dates-add"><i class="fa fa-plus" ></i> Add More</a>
                            </div>
                        </div> 
                        <p class="submit">
                            <input type="submit" name="submit" id="submit" class="button button-primary" value="Create new Date Poll">
                        </p>                   
                    </form>
                </div>
            </div>
            <div id="poststuff">
                <div id="post-body" class="metabox-holder">
                    <div id="post-body-content">
                        <div class="meta-box-sortables ui-sortable">
                            <?php
                                $doodle_overview->display(); 
                            ?>
                        </div>
                    </div>
                </div>
                <br class="clear">
            </div>
        </div>
    <?php
    }

    protected function get_client()
    {

        $doodleUsername = $this->get_option('email');
        $doodlePassword = $this->get_option('password');

        try {
            $client = new \Causal\DoodleClient\Client($doodleUsername, $doodlePassword);
            $client->setCookiePath(plugin_dir_path(dirname(__FILE__)));

            $systemLocale = get_locale();
            if(!empty($systemLocale)) {
                $client->setLocale($systemLocale);
            }
            $client->connect();

            return $client;
        } catch (Exception $e) {
            echo '  <div class="notice-error notice is-dismissible"> 
                        <p><strong>' . __('Could not fetch Doodle data! Please make sure you have set an username & password!', 'wordpress-doodle') . '</strong></p>
                        <p>CURL Response: ' . $e->getMessage() . '</p>
                        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                    </div>';
            return FALSE;
        }

    }

    /**
     * Retrieve doodles data from Doodle
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  array
     */
    public function get_doodles()
    {
        $client = $this->get_client();

        try {
            $doodles = $client->getPersonalPolls();
                
            if(!empty($doodles)) {
                $temp = array();
                $dateTimeFormat = get_option('date_format') . ' ' . get_option('time_format');

                foreach ($doodles as $doodle) {

                    $id = $doodle->getId();

                    $optionsText = "";
                    $optionsText .= '<div id="doodle-' . $id . '" style="display: none;">';
                    $optionsText .= '<table style="border: 1px solid #eee; text-align: center;">';
                    $optionsText .= '<thead>';
                    $optionsText .= '<tr>';
                    $optionsText .= '<th></th>';
                    $options = $doodle->getOptions();
                    foreach ($options as $option) {
                        if($doodle->getType() === "TEXT") {
                            $optionsText .= '<th>' . $option->getText() . '</th>';
                        } else {
                            $optionsText .= '<th>' . $option->getText() . ' ' . $option->getDate()->format($dateTimeFormat) . '</th>';
                        }
                    }
                    $optionsText .= '</tr>';
                    $optionsText .= '</thead>';

                    $optionsText .= '<tbody>';
                    $participants = $doodle->getParticipants();
                    foreach ($participants as $participant) {
                        $optionsText .= '<tr>';
                        $optionsText .= '<td>' . htmlspecialchars($participant->getName()) . '</td>';
                        foreach ($participant->getPreferences() as $preference) {
                            switch ($preference) {
                                case 'i':
                                    $value = 'If needed';
                                    $color = '#ffeda1';
                                    break;
                                case 'y':
                                    $value = 'YES';
                                    $color = '#d1f3d1';
                                    break;
                                case 'n':
                                    $value = 'NO';
                                    $color = '#ffccca';
                                    break;
                                case 'q':
                                default:
                                    $value = '?';
                                    $color = '#eaeaea';
                                    break;
                            }
                            $optionsText .= '<td style="background-color:' . $color . '">' . htmlspecialchars($value) . '</td>';
                        }
                        $optionsText .= '</tr>';
                    }
                    $optionsText .= '</tbody>';
                    $optionsText .= '</table>';
                    $optionsText .= '</div>';
                    echo $optionsText;

                    $temp[] = array(
                        'name' => '<a href="' . htmlspecialchars($doodle->getPublicUrl()) . '" target="_blank">' . htmlspecialchars($doodle->getTitle()) . '</a>', 
                        'id' => $id,
                        'location' => $doodle->getLocation(),
                        'description' => nl2br($doodle->getDescription()),
                        'invitees' => $doodle->getInviteesCount(),
                        'participants' => $doodle->getParticipantsCount() . ' <a href="#TB_inline?width=800&height=500&inlineId=doodle-' . $id . '" class="button button-primary thickbox">Show me</a>',
                        'type' => $doodle->getType(),
                        'state' => $doodles[0]->getState(),
                        'export' =>     '<a href="' . htmlspecialchars($doodle->getExportExcelUrl()) . '">Excel</a> | ' .
                                        '<a href="' . htmlspecialchars($doodle->getExportPrintUrl()) . '">Print</a> | ' .
                                        '<a href="' . htmlspecialchars($doodle->getExportPdfUrl()) . '">PDF</a>',
                        'actions' =>    '<a class="button button-primary" href="' . htmlspecialchars($doodle->getPublicUrl()) . '" target="_blank">Edit</a>' .
                                        '<form class="delete_poll" method="post" action="' . admin_url( 'admin.php' ) . '">' .
                                            '<input type="hidden" name="action" value="delete_poll">' .
                                            '<input type="hidden" name="id" value="' . $id . '">' .
                                             wp_nonce_field('delete_poll','verify_doodle_nonce') .
                                             '<input type="submit" name="submit" id="submit" class="button button-primary" style="background-color: #e74c3c; border-color: #e74c3c; text-shadow: none; box-shadow: none;" value="Delete poll">' .
                                        '</form>',
                    );
                }
                $doodles = $temp;
            }
        } catch (Exception $e) {
            echo '  <div class="notice-error notice is-dismissible"> 
                        <p><strong>' . __('Could not fetch Doodle data! Please make sure you have set an username & password!', 'wordpress-doodle') . '</strong></p>
                        <p>CURL Response: ' . $e->getMessage() . '</p>
                        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                    </div>';
            return FALSE;
        }

        return $doodles;
    }

    /**
     * Create a text poll
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     * @return  bool
     */
    public function create_text_poll()
    {
        if ( !isset( $_REQUEST['action'] ) ) return; 
        if ( $_REQUEST['action'] !== 'create_text_poll') return;
        if ( empty( $_POST ) ) return;
        if ( !check_admin_referer( 'create_text_poll', 'verify_doodle_nonce' ) ) return;

        $client = $this->get_client();

        $post = sanitize_post($_POST);

        try {
            $newPoll = $client->createPoll([
                'type' => 'text',
                'title' => $post['title'],
                'location' => $post['location'],
                'description' => $post['description'],
                'name' => $this->get_option('name'),
                'email' => $this->get_option('email'),
                'options' => $post['options'],
            ]);
        } catch (Exception $e) {
            echo '  <div class="notice-error notice is-dismissible"> 
                        <p><strong>' . __('Could not create text poll', 'wordpress-doodle') . '</strong></p>
                        <p>CURL Response: ' . $e->getMessage() . '</p>
                        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                    </div>';
            return FALSE;
        }
        
        wp_redirect( $_SERVER['HTTP_REFERER'] );
        exit(); 

    }

    /**
     * Create a dates poll
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     * @return  bool
     */
    public function create_dates_poll()
    {
        if ( !isset( $_REQUEST['action'] ) ) return; 
        if ( $_REQUEST['action'] !== 'create_dates_poll') return;
        if ( empty( $_POST ) ) return;
        if ( !check_admin_referer( 'create_dates_poll', 'verify_doodle_nonce' ) ) return;

        $client = $this->get_client();
        $post = sanitize_post($_POST);

        $dates = array();
        foreach ($post['dates'] as $dateTime) {
            
            if(!is_array($dateTime)) {
                $date = str_replace('-', '', $dateTime);
                if(!isset($dates[$date])) {
                    $dates[$date] = array();
                }
            } else {
                foreach ($dateTime as $time) {
                    $time = str_replace(':', '', $time);
                    $dates[$date][$time] = $time;
                }
            }
        }
        
        try {
            $newPoll = $client->createPoll([
                'type' => 'date',
                'title' => $post['title'],
                'location' => $post['location'],
                'description' => $post['description'],
                'name' => $this->get_option('name'),
                'email' => $this->get_option('email'),
                'dates' => $dates,
            ]);
        } catch (Exception $e) {
            echo '  <div class="notice-error notice is-dismissible"> 
                        <p><strong>' . __('Could not create dates poll.', 'wordpress-doodle') . '</strong></p>
                        <p>CURL Response: ' . $e->getMessage() . '</p>
                        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                    </div>';
            return FALSE;
        }
        
        wp_redirect( $_SERVER['HTTP_REFERER'] );
        exit(); 
    }

    /**
     * Delete a poll
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.de
     * @return  bool
     */
    public function delete_poll()
    {
        if ( !isset( $_REQUEST['action'] ) ) return; 
        if ( $_REQUEST['action'] !== 'delete_poll') return;
        if ( empty( $_POST ) ) return;
        if ( !check_admin_referer( 'delete_poll', 'verify_doodle_nonce' ) ) return;

        if ( !isset($_POST['id']) || empty($_POST['id'])) return;

        $client = $this->get_client();
        $post = sanitize_post($_POST);

        $id = $post['id'];

        try {

            $poll = new \Causal\DoodleClient\Domain\Model\Poll( $id );

            $info = $client->_getInfo($poll);
            $rep = new \Causal\DoodleClient\Domain\Repository\PollRepository( $client );
            $newPoll = $rep->create( $info );

            
            $client->deletePoll($newPoll);
        } catch (Exception $e) {
            echo '  <div class="notice-error notice is-dismissible"> 
                        <p><strong>' . __('Could not fetch Doodle data! Please make sure you have set an username & password!', 'wordpress-doodle') . '</strong></p>
                        <p>CURL Response: ' . $e->getMessage() . '</p>
                        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                    </div>';
            return FALSE;
        }

        wp_redirect( $_SERVER['HTTP_REFERER'] );
        exit(); 

    }
}