<?php
/**
 * Register Form
 *
 * Take Students Data and Put it into the database
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

require_once dirname(__FILE__) . '/login.php';
require_once dirname(__FILE__) . '/../models/students.php';

global $register_form;
$register_form = true;
global $register_error;
$register_error = null;
global $register_success;
$register_success = false;
global $title;
$title = "Registration Form";

if (isset($_POST['register_student'])) {
    // Collect Input from the user form
    $new_user = array(
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'phone1' => $_POST['phone1'],
        'phone2' => $_POST['phone2'],
        'address' => $_POST['address'],
        'city' => $_POST['city'],
        'country' => $_POST['country']
    );

    // Create new student
    $student = new SajjelStudent();
    $student->username = $new_user['username'];
    $student->email = $new_user['email'];
    $student->password = $new_user['password'];
    $student->firstname = $new_user['firstname'];
    $student->lastname = $new_user['lastname'];
    $student->phone1 = $new_user['phone1'];
    $student->phone2 = $new_user['phone2'];
    $student->address = $new_user['address'];
    $student->city = $new_user['city'];
    $student->country = $new_user['country'];
    try {
        $student->save();
        $register_form = false;
        $register_success = true;
    } catch (Exception $e) {
        $register_error = $e->getMessage();
    }
}

// Render the View
require dirname(__FILE__) . '/../views/register.php';

?>
