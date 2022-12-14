# Using Koseu

![VerdantLearn](src/images/VLlogo_100px.png)

This site is VerdantLearn's first Koseu instance

Setup On Localhost
------------------

Here are the steps to set this up on localhost on a Macintosh using MAMP.

Install MAMP (or similar) using https://www.py4e.com/install.php

Fork the skeleton repo and rename it to something meaningful in your own repo.

    https://github.com/tsugiproject/koseu-site.git

Then check out your forked copy:

    cd /Applications/MAMP/htdocs
    git clone https://github.com/csev/scc-chem-309.git

Go into the newly checked out folder and get a copy of Tsugi:

    cd scc-chem-309
    git clone https://github.com/tsugiproject/tsugi.git

Create a database in your SQL server:

    CREATE DATABASE tsugi DEFAULT CHARACTER SET utf8;
    GRANT ALL ON tsugi.* TO 'ltiuser'@'localhost' IDENTIFIED BY 'ltipassword';
    GRANT ALL ON tsugi.* TO 'ltiuser'@'127.0.0.1' IDENTIFIED BY 'ltipassword';

Still in the tsugi folder set up config.php:

    cp config-dist.php config.php

Edit the config.php file, scroll through and set up all the variables.  As you scroll through the file
some of the following values are the values I use on my MAMP:

    $apphome = "http://localhost:8888/scc-chem-309";
    
    ...
    
    $CFG->pdo = 'mysql:host=127.0.0.1;port=8889;dbname=tsugi'; // MAMP
    $CFG->dbuser    = 'ltiuser';
    $CFG->dbpass    = 'ltipassword';
    
    ...
    
    $CFG->adminpw = 'short';  // Make this better
    
    ...
    
    $CFG->context_title = "Chemistry 360";
    $CFG->lessons = $CFG->dirroot.'/../lessons.json';
    
    ... 
    
    $CFG->tool_folders = array("admin", "../tools", "../mod");
    $CFG->install_folder = $CFG->dirroot.'./../mod'; // Tsugi as a store
    
    ...
    
    $CFG->servicename = 'CEM360';

Setting up Login
----------------

Then go to https://console.developers.google.com/apis/credentials and
create an "OAuth Client ID".  Make it a "Web Application", give it a name,
put the following into "Authorized JavaScript Origins":

        http://localhost

And this into Authorized redirect URIs:

    http://localhost/scc-chem-309/tsugi/login.php

Note: You do not need port numbers for either of these values in your Google
configuration.

Google will give you a 'client ID' and 'client secret', add them to `config.php`
as follows:

    $CFG->google_client_id = '96..snip..oogleusercontent.com';
    $CFG->google_client_secret = 'R6..snip..29a';

While you are there, you could "Create credentials", select "API
key", and name the key "My Google MAP API Key" and put the API
key into `config.php` like the following:

    $CFG->google_map_api_key = 'AIza..snip..9e8';

Starting the Application
------------------------

After the above configuration is done, navigate to your application:

    http://localhost:8888/scc-chem-309/

It should complain that you have not created tables and suggest you 
use the Admin console to do that:

    http://localhost:8888/scc-chem-309/tsugi/admin

It will demand the `$CFG->adminpw` from `config.php` (above) before 
unlocking the admin console.  Run the "Upgrade Database" option and
it should create lots of tables in the database and the red warning
message about bad database, should go away.

Got into the database and the `lti_key` table, find the row with the `key_key`
of google.com and put a value in the `secret` column - anything will do - 
just don't leave it empty or the internal LTI tools will not launch.

Next use the administrator interface to install the peer-grading tool
from the github repository:

    http://localhost:8888/scc-chem-309/tsugi/admin/install

Click on "Available Modules" and install https://github.com/tsugitools/peer-grade

