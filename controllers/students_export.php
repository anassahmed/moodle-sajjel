<?php
/**
 * Students Export
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

  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.

require_once dirname(__FILE__) . '/login.php';
require_once dirname(__FILE__) . '/../config.php';
global $mysqli_obj;
global $table_name;

/**
 * Clean Data for CSV
 *
 * @param string $str The String Variable Reference
 *
 * @return void;
 */
function cleanData(&$str)
{
    if ($str == 't') $str = 'TRUE';
    if ($str == 'f') $str = 'FALSE';
    if (preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
        $str = "'$str";
    }
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// filename for download
$filename = "students_" . date('Ymd') . ".csv";

header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv");

$out = fopen("php://output", 'w');

$flag = false;
$result = $mysqli_obj->query("SELECT * FROM $table_name ORDER BY id;") or die('Query failed!');
while ($row = $result->fetch_assoc()) {
    if (!$flag) {
        // display field/column names as first row
        fputcsv($out, array_keys($row), ',', '"');
        $flag = true;
    }
    array_walk($row, 'cleanData');
    fputcsv($out, array_values($row), ',', '"');
}

fclose($out);
exit;

?>
