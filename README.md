# WordPress Doodle Poll Plugin
## The first and only Doodle Plugin for WordPress

Integrate the awesome Doodle polls into your WordPress site. Get an overview of your events, show the participants and check their choices directly out of WordPress. Create polls (text or date), embed them via an shortcode and let your users participate.

## Features

*   Step by Step Tutorial for the Setup. [See here](http://docs.db-dzine.com/wordpress-doodle/#setup)
*   Create new polls
*   Embed a Doodle pool
*   Show all your doodle polls in an overview
*   Export poll data as Excel, print or PDF
*   Edit a poll on the Doodle site
*   Delete a poll
*   Create new poll options:
    *   Set poll title
    *   Set location
    *   Enter a description
    *   Set the options (as many as you want)

_It is not possible to directly embed a Doodle poll, because Iframes etc are forbidden by Doodle itself. Therefore the participate button was created, which opens the poll in a new window._ _Note: A Doodle Account and the free Redux Framework are required to use this plugin!_

## Compatibility

*   WordPress 3.8.1+
*   PHP 5.4+

## Changelog

<pre>======
1.0.0
======
- Inital release
</pre>



# Documentation

<small>We hope you love this plugin!</small>

* * *

If you find any bugs or enhancements in this script get in touch with a clear description of the problem so we can fix it. We <span style="text-decoration: underline;">do not</span> support modifications!  

#### Requirements

The following things are required to run this script:

*   PHP 5.4.0+
*   MySQL 5+
*   Apache
*   Wordpress 3.8+
*   Redux Framework Plugin

* * *

#### Index

1.  [Installation](#installation)
2.  [Setup](#setup)
3.  [Features](#features)
4.  [Troubleshooting](#troubleshooting)

* * *

## Installation

Make sure you have installed the Redux Framework Plugin before installation!

#### 1\. Upload the ZIP via the wordpress backend

*   Log into your website backend /wp-admin/
*   Go to Plugins -> Install -> Upload Plugin
*   Select the ZIP file and upload it
*   Active it and that's it!

* * *

#### 2\. Upload it via FTP

*   Log into your webserver via FTP
*   Unzip the file on your PC
*   Upload the extracted folder to /wp-content/plugins/
*   Go into your backend and activate the Plugin

* * *

[<span class="icon-arrow-up"></span>Return to the Index](#index)

* * *

## Setup

### Plugin Settings

In the first step you have to configure the plugin. Therefore you will need your Doodle login credentials. If you do not have any, go ahead and [create a Doodle Account](http://doodle.com) - it's free. If you have followed the installation instructions above, you should be able to see the Doodle settings in the left admin sidebar. Go ahead and click on Settings.

[![plugin settings](images/01-settings.png)](images/01-settings.png)

Then enable Doodle and enter your login credentials below. If you do not know your credentials, you can check it on the [Doodle Account page](https://doodle.com/account). Click on save changes and you are done.

[![General settings](images/02-general.png)](images/02-general.png)

If you have entered the correct login credentials, we can now check if everything works. So let us test if we can fetch our Doodles. Click on Doodles in the left sidebar. If you do not get any error and see some Doodles like in the screenshot below then we can say: congratulations! You are done.

If you see nothing or an error: Double check your login credentials. If this does not work, get in touch with us: [support@db-dzine.com](mailto:support@db-dzine.com)

[![All your Doodles in an overview](images/04-overview.png)](images/04-overview.png)

* * *

[<span class="icon-arrow-up"></span>Return to the Index](#index)



* * *



## Features

### General Settings

In the General settings are you have the following options:

*   **Enable:**  
    Enable Doodle Plugin
*   **Your Name:**  
    This will be used for polls that are created by you.
*   **Doodle Email:**  
    Put your Doodle Email here.
*   **Doodle Password:**  
    Put your Doodle Password here.

[![WordPress Doodle plugin settings](images/02-general.png)](images/02-general.png)

* * *

### Advanced Settings

Add custom CSS or custom javascript here if you need.

* * *

### Shortcode (show poll in a page)

With the short code you can embed a Doodle poll into your pages / posts.
participate button was created, which opens the poll in a new window.

The possible shortcode tags are:

*   **id*** = Doodle Poll ID
*   **width** = width of the new window (Default: 630px)
*   **height** = height of the new window (Default: 1500px)
*   **showname** = show the poll name (Default: yes)
*   **showlocation** = show the poll location (Default: yes)
*   **showdescription** = show the poll description (Default: yes)
*   **showoptions** = show the poll options (Default: yes)
*   **showparticipants** = show the poll participants (Default: yes)

An example of a full custom shortcode:

<pre>[doodle id="YOURID" width="670px" height="1500px" showname="yes" showlocation="yes" showdescription="yes" showoptions="yes" showparticipants="yes"]Participate Now[/doodle]
				</pre>

And this is how the rendered shortcode will look on your page:

[![Example doodle poll in frontend](images/03-example-poll-in-frontend.png)](images/03-example-poll-in-frontend.png)

* * *

### Poll overview

In the Doodles menu you can get an overview of all your polls.

*   **Create a new text poll**
*   **Create a new dates poll**
*   **Display name**
*   **Display id**
*   **Display location**
*   **Display description**
*   **Display invitees**
*   **Show participants**
*   **See type / state**
*   **Export poll data as Excel, print or PDF**
*   **Edit the poll on the Doodle site**
*   **Delete the poll**

[![All Doodle polls in an overview](images/04-overview.png)](images/04-overview.png)

* * *

### Create a new text poll

You can directly create a new text poll within WordPress.

*   **Set poll title**
*   **Set location**
*   **Enter a description**
*   **Set the options (as many as you want)**

[![Create a text poll](images/05-create-text-poll.png)](images/05-create-text-poll.png)

* * *

### Create a new dates poll

You can directly create a new dates poll within WordPress.

*   **Set poll title**
*   **Set location**
*   **Enter a description**
*   **Set the date (left) and the time (right)**

[![Create a dates poll](images/06-create-date-poll.png)](images/06-create-date-poll.png)

* * *

### Show participants

When you click on the show participants button you get a popup, that show the participants and their choices.

[![Show participants](images/07-show-participants.png)](images/07-show-participants.png)

* * *

[<span class="icon-arrow-up"></span>Return to the Index](#index)



* * *



## Troubleshooting

#### Where can I find the Doodle Plugin settings?

You can find the everything inside your Admin Panel in the left sidebar. If you do not see anything, make sure the Redux Framework Plugin is installed.

[![](images/01-settings.png)](images/01-settings.png)

* * *

#### I found a bug / got an error

Please make a comment on codecanyon. We will take care asap!

* * *

[<span class="icon-arrow-up"></span>Return to the Index](#index)



* * *
