<?php
/**
 * Login Form
 *
 * Login Form View Template
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

global $tilte;
$tile = "Admin Login";

require dirname(__FILE__) . '/header.php';

if ($login_error) {
?>
<div class="container">
    <div class="row">
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
                <?php echo $login_error; ?>
        </div>
    </div>
</div>
<?php
}

if ($login_success) {
?>
<div class="container">
    <div class="row">
        <div class="alert alert-success" role="alert">
            <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
            <span class="sr-only">Success:</span>
            <?php echo "You have successfully logged in."; ?>
        </div>
    </div>
    <div class="row">
        <div class="text-center">
            <h1>Welcome to Sajjel!</h1>
            <h2>Please use the navigation bar to reach to the Students List.</h2>
        </div>
    </div>
</div>
<?php
}

if ($login_form) {
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-3"></div>
        <div class="col-xs-12 col-md-6 center-block">
            <h1>Login into Sajjel</h1>
            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username"
                        name="username" placeholder="Username" required/>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password"
                        name="password" placeholder="Password" required/>
                </div>
                <button type="sumbit" class="btn btn-primary pull-right">Login</button>
            </form>
        </div>
    </div>
</div>
<?php
}

require dirname(__FILE__) . '/footer.php';
?>
