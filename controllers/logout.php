<?php
/**
 * Logout Form
 *
 * Logout the admin user from the admin panel
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

require_once dirname(__FILE__) . '/../config.php';

global $login_form;
$login_form = true;
global $login_error;
$login_error = "You have successfully logged out.";
global $login_success;
$login_success = false;

global $title;
$title = "Admin Login";

if (!isset($_SESSION)) {
    SESSION_START();
}

if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    unset($_SESSION['username'], $_SESSION['password']);
}

// Render the login view
require dirname(__FILE__) . '/../views/login.php';

?>
