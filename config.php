<?php
/**
 * Sajjel Moodle Config File
 *
 * PHP version 5.4+
 *
 * LICENSE: this source file is subject to version 3 of GPL License.
 *
 * @category  Learning_Management_Systems
 * @package   Sajjel
 * @author    Anass Ahmed <anass.1430@gmail.com>
 * @website   www.anassahmed.com
 * @copyright 2015 Anass Ahmed
 * @license   https://www.gnu.org/licenses/gpl.html GPLv3
 * @version   GIT: <git_id>
 * @link      https://www.github.com/anassahmed/sajjel
 */

// Modify the bottom configuration to connect properly to your database
// Use the same database configuration of your moodle database
// This connection is appropriate with mysqli only
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'moodle';

global $db_prefix;
$db_prefix = 'mdl_';

// Sajjel Control Panel Admin User and Password
global $admin_username;
$admin_username = 'admin';

global $admin_password;
$admin_password = 'admin';

// Moodle Course that will be used to enrol students
global $enrollment_course_id;
$enrollment_course_id = '3';

// ROOT URL
global $root_url;
$root_url = 'http://localhost/~anass/sajjel';




/* DON'T modify the following lines! */

// Creating Sajjel Database Connection
global $mysqli_obj;
$mysqli_obj = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($mysqli_obj->connect_errno) {
    echo "Failed to connect to MySQL/MariaDB: " . $mysqli_obj->connect_error;
    die();
}
global $table_name;
$table_name = $db_prefix . "sajjel_register";

// check if sajjel already installed on this database
$installed_query = "SELECT * FROM " . $db_prefix . "sajjel_register;";
$check_installed = $mysqli_obj->query($installed_query);
if (!$check_installed) {
    // Create the table scheme
    echo "App is not installed<br />";
    echo "Installing the App...<br />";
    $table_query = <<<EOT
CREATE TABLE $table_name (
    id int NOT NULL AUTO_INCREMENT,
    username char(255),
    email char(255),
    password char(255),
    firstname char(255),
    lastname char(255),
    phone1 char(255),
    phone2 char(255),
    address text,
    city char(255),
    country char(255),
    enrollment_id int,
    PRIMARY KEY (id),
    UNIQUE (username)
);
EOT;
    $res = $mysqli_obj->query($table_query);
    var_dump($res);
    if ($res) {
        echo "App had been installed successfully.";
    } else {
        echo "Error happened while installing the application: " .
            $mysqli_obj->error;
    }
}
?>
