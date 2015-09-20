<?php
/**
 * Students List
 *
 * Students List View Template
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

if ($_SERVER['SCRIPT_FILENAME'] == __FILE__) {
    die('You can\'t open this page directly!');
}

require dirname(__FILE__) . '/header.php';

if ($message_error) {
?>
<div class="container">
    <div class="row">
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
                <?php echo $message_error; ?>
        </div>
    </div>
</div>
<?php
}

if ($message_success) {
?>
<div class="container">
    <div class="row">
        <div class="alert alert-success" role="alert">
            <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
            <span class="sr-only">Success:</span>
            <?php echo $message_success; ?>
        </div>
    </div>
</div>
<?php
}

if ($view_list) {
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12 center-block">
            <h1>Students List</h1>
            <?php if (!$students_list) { ?>
            <h2>No Students to be displayed.</h2>
            <?php } else { ?>
            <div class="pull-right">
                <a href="students_export.php" class="btn btn-primary">Export All</a>
                <a href="?action=enroll&id=all" class="btn btn-primary">Enroll All</a>
                <a href="?action=delete&id=all" class="btn btn-danger">Delete All</a>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Email</th>
                        <th>Phone 1</th>
                        <th>Phone 2</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Enrollment ID</th>
                        <th>Enroll</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($students_list as $student) { ?>
                    <tr <?php if ($student->getEnrollmentId()) { echo "class='success'"; } ?>>
                        <td><strong><?php echo $student->getId(); ?></strong></td>
                        <td><?php echo $student->username; ?></td>
                        <td><?php echo $student->firstname; ?></td>
                        <td><?php echo $student->lastname; ?></td>
                        <td><?php echo $student->email; ?></td>
                        <td><?php echo $student->phone1; ?></td>
                        <td><?php echo $student->phone2; ?></td>
                        <td><?php echo $student->city; ?></td>
                        <td><?php echo $student->country; ?></td>
                        <td><?php echo $student->getEnrollmentId(); ?></td>
                        <td>
                            <a href="?action=enroll&id=<?php echo $student->getId(); ?>"
                                class="btn btn-primary">Enroll</a>
                        </td>
                        <td>
                            <a class="btn btn-danger"
                                href="?action=delete&id=<?php echo $student->getId(); ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php } ?>
        </div>
    </div>
</div>
<?php
}
require dirname(__FILE__) . '/footer.php';
?>
