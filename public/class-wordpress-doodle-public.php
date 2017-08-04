<?php

class Wordpress_Doodle_Public
{
    private $plugin_name;
    private $version;
    private $options;

    /**
     * Doodle Plugin Construct
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
     * Enqueue Styles
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  boolean
     */
    public function enqueue_styles()
    {
        global $Wordpress_Doodle_options;

        $this->options = $Wordpress_Doodle_options;

        if (!$this->get_option('enable')) {
            return false;
        }

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__).'css/wordpress-doodle.css', array(), $this->version, 'all');

        $customCSS = $this->get_option('customCSS');

        file_put_contents(dirname(__FILE__)  . '/css/wordpress-doodle-custom.css', $css.$customCSS);

        wp_enqueue_style($this->plugin_name.'-custom', plugin_dir_url(__FILE__).'css/wordpress-doodle-custom.css', array(), $this->version, 'all');

        return true;
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  boolean
     */
    public function enqueue_scripts()
    {
        global $Wordpress_Doodle_options;

        $this->options = $Wordpress_Doodle_options;

        if (!$this->get_option('enable')) {
            return false;
        }

        wp_enqueue_script($this->plugin_name.'-public', plugin_dir_url(__FILE__).'js/wordpress-doodle-public.js', array('jquery'), $this->version, true);

        $customJS = $this->get_option('customJS');
        if (empty($customJS)) {
            return false;
        }

        file_put_contents(dirname(__FILE__)  . '/js/wordpress-doodle-custom.js', $customJS);

        wp_enqueue_script($this->plugin_name.'-public-custom', plugin_dir_url(__FILE__).'js/wordpress-doodle-custom.js', array('jquery'), $this->version, false);

        return true;
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
        if (!is_array($this->options)) {
            return false;
        }

        if (!array_key_exists($option, $this->options)) {
            return false;
        }

        return $this->options[$option];
    }

    /**
     * Init the Doodle
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  boolean
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
     * Add the Shortcode
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  mixed                                 The option value
     */
    public function add_shortcode_doodle()
    {
        add_shortcode('doodle', array($this, 'shortcode_handler_doodle' ));
    }
     
    /**
     * Add the Shortcode Handler
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  string
     */
    public function shortcode_handler_doodle($atts, $content)
    {
        extract(shortcode_atts(array(
            'id' => 'id',
            'width' => '630px',
            'height' => '1500px',
            'showname' => 'yes',
            'showlocation' => 'yes',
            'showdescription' => 'yes',
            'showoptions' => 'yes',
            'showparticipants' => 'yes',
        ), $atts));

        if( $showname === "yes" OR
            $showlocation === "yes" OR
            $showdescription === "yes" OR
            $showoptions === "yes" OR 
            $showUsers === "yes") 
        {

            $doodle = $this->get_doodle($id);

            if($doodle) {
                if($showname === "yes" && !empty($doodle['name'])) {
                    echo '<h2 class="doodle-name">' . $doodle['name'] . '</h2>';
                }

                if($showlocation === "yes" && !empty($doodle['location'])) {
                    echo '<div class="doodle-location">' . __('Location: ', 'wordpress-doodle') . $doodle['location'] . '</div>';
                }

                if($showdescription === "yes" && !empty($doodle['description'])) {
                    echo '<div class="doodle-description">' . __('Description: ', 'wordpress-doodle') . $doodle['description'] . '</div>';
                }

                if($showoptions === "yes" OR $showparticipants === "yes") {
                    echo '<table class="doodle-table" style="border: 1px solid #eee; text-align: center; margin-top: 10px;">';

                    if($showoptions === "yes") {
                        echo '<thead class="doodle-table-head">' . $doodle['options'] . '</thead>';
                    }
                    if($showparticipants === "yes") {
                        echo '<tbody class="doodle-table-body">' .$doodle['participants']. '</tbody>';
                    }

                    echo '</table>';
                }
            }
        }
        
        return '<a id="doodle-button" data-width="' . $width . '" data-width="' . $height . '" class="btn btn-primary button doodle-button" href="http://doodle.com/poll/' . $id . '" target="_blank">' . $content . '</a>';

    }

    /**
     * Get doodle info by Id
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  doodle
     */
    public function get_doodle($id)
    {
        $doodles = $this->get_doodles();
        if(!empty($doodles && isset($doodles[$id]))) {
            return $doodles[$id];
        }
        return FALSE;
    }

    /**
     * Get all doodles
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    http://woocommerce.db-dzine.com
     * @return  doodles
     */
    public function get_doodles()
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

            $doodles = $client->getPersonalPolls();
            
            if(!empty($doodles)) {
                $temp = array();
                $dateTimeFormat = get_option('date_format') . ' ' . get_option('time_format');

                foreach ($doodles as $doodle) {

                    $id = $doodle->getId();

                    $optionsText = "";
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
                    $optionsText .= "</tr>";

                    $participantsText = '';
                    $participants = $doodle->getParticipants();
                    foreach ($participants as $participant) {
                        $participantsText .= '<tr>';
                        $participantsText .= '<td>' . htmlspecialchars($participant->getName()) . '</td>';
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
                            $participantsText .= '<td style="background-color:' . $color . '">' . htmlspecialchars($value) . '</td>';
                        }
                        $participantsText .= '</tr>';
                    }

                    $temp[$id] = array(
                        'name' => htmlspecialchars($doodle->getTitle()), 
                        'url' => $doodle->getPublicUrl(),
                        'location' => $doodle->getLocation(),
                        'description' => nl2br($doodle->getDescription()),
                        'invitees' => $doodle->getInviteesCount(),
                        'type' => $doodle->getType(),
                        'state' => $doodles[0]->getState(),
                        'options' => $optionsText,
                        'participants' => $participantsText,
                        

                    );
                }
                $doodles = $temp;
            }

            // Optional, if you want to prevent actually authenticating over and over again
            // with future requests (thus reusing the local authentication cookies)
            $client->disconnect();
            return $doodles;

        } catch (Exception $e) {
            echo '  <div id="setting-error-tgmpa" class="notice-error notice is-dismissible"> 
                        <p><strong>' . __('Can not fetch Doodle data! Please make sure you have set an username & password!', 'wordpress-doodle') . '</strong></p>
                        <p>CURL Response: ' . $e->getMessage() . '</p>
                        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                    </div>';
            return FALSE;
        }
        return false;
    }
}