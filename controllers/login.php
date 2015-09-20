<?php
/**
 * Login Form
 *
 * Login the admin user to the admin panel
 *
 * PHP Version 5.4+
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

$itself = false;
if ($_SERVER['SCRIPT_FILENAME'] == __FILE__) {
    $itself = true;
}

require_once dirname(__FILE__) . '/../config.php';

global $login_form;
$login_form = true;
global $login_error;
$login_error = null;
global $login_success;
$login_success = false;

global $title;
$title = "Admin Login";

/**
 * Check Admin Login Credentials
 *
 * @param string $username Username of the Admin user
 * @param string $password Password of the Admin user
 *
 * @return boolean
 */
function checkLogin($username, $password)
{
    global $admin_username;
    global $admin_password;
    if ($username == $admin_username && $password == $admin_password) {
        return true;
    } else {
        return false;
    }
}

if (!isset($_SESSION)) {
    SESSION_START();
}

if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    if (checkLogin($_SESSION['username'], $_SESSION['password'])) {
        $login_form = false;
        if ($itself) {
            $login_success = true;
        }
    }
} else {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        if (checkLogin($_POST['username'], $_POST['password'])) {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];
            $login_form = false;
            $login_success = true;
        } else {
            $login_error = "Username or Password is invalid.";
        }
    }
}

// Render the login view
if ($login_form || $login_success || $login_error) {
    include dirname(__FILE__) . '/../views/login.php';
    exit();
}

?>
