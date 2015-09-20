<?php
/**
 * Index Page
 *
 * Home Page of Sajjel App
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

require dirname(__FILE__) . '/config.php';

SESSION_START();

require dirname(__FILE__) . '/views/header.php';

?>

<div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="page-header">
                <h1>Sajjel Moodle Application</h1>
            </div>
            <p class="lead">
                This application is designed to help your students register into your moodle courses without exposing moodle registration forms to spammers.
            </p>
            <a href="<?php echo $root_url; ?>/controllers/register.php" class="btn btn-primary">Register Now</a>
            <a href="<?php echo $root_url; ?>/controllers/login.php" class="btn btn-danger">Login Now</a>
        </div>
    </div>
</div>

<?php

require dirname(__FILE__) . '/views/footer.php';

?>
