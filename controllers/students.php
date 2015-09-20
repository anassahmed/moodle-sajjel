<?php
/**
 * Students List
 *
 * List Students from the Registration table and control them
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

global $view_list;
$view_list = true;
global $message_success;
$message_success = null;
global $message_error;
$message_error = null;

global $title;
$title = "Students List";

if (isset($_GET['action']) && isset($_GET['id'])) {
    if ($_GET['action'] == 'delete') {
        try {
            if ($_GET['id'] == 'all') {
                $students = SajjelStudent::findall();
                foreach ($students as $student) {
                    $res = $student->delete();
                }
            } else {
                $student = SajjelStudent::find($_GET['id']);
                $res = $student->delete();
            }
            if ($res) {
                $message_success = "Student had been deleted successfully";
            } else {
                $message_error = "Student hadn't been deleted";
            }
        } catch (Exception $e) {
            $message_error = $e->getMessage();
        }
    } else if ($_GET['action'] == 'enroll') {
        try {
            if ($_GET['id'] == 'all') {
                $students = SajjelStudent::findall();
                foreach ($students as $student) {
                    if ($student->getEnrollmentId()) {
                        continue;
                    }
                    $res = $student->enroll();
                }
            } else {
                $student = SajjelStudent::find($_GET['id']);
                $res = $student->enroll();
            }
            if ($res) {
                $message_success = "Student had been enrolled into the moodle course sucessfully";
            } else {
                $message_error = "Student hadn't been enrolled";
            }
        } catch (Exception $e) {
            $message_error = $e->getMessage();
        }
    }
}

global $students_list;
$students_list = SajjelStudent::findall();

// Render the students list view
require dirname(__FILE__) . '/../views/students.php';

?>
