<?php
/**
 * Students Database Model
 *
 * A Simple class to add, edit, delete and enroll students into the database.
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
global $mysqli_obj;
global $table_name;
global $db_prefix;
global $enrollment_course_id;
// $mysqli_obj = $_GLOBALS['db'];
// $table_name = TABLE;

/**
 * Sajjel Student
 *
 * A Model to manipulate students table
 *
 * @category Databse
 * @package  Sajjel
 * @author   Anass Ahmed <anass.1430@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl.html GPLv3
 * @link     https://www.github.com/anassahmed/sajjel
 */
class SajjelStudent
{
    public $username;
    public $email;
    public $password;
    public $firstname;
    public $lastname;
    public $phone1;
    public $phone2;
    public $address;
    public $city;
    public $country;

    protected $id = null;
    protected $enrollment_id = null;

    /**
     * Check Errors and Print them
     *
     * Will be used to log errors to the standard error log
     *
     * @return void
     */
    protected function sqlError()
    {
        global $mysqli_obj;
        if ($mysqli_obj->errno) {
            throw new Exception("Error " . $mysqli_obj->errno . ": " . $mysqli_obj->error);
        }
    }

    /**
     * Get ID
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Enrollment ID
     *
     * @return integer
     */
    public function getEnrollmentId()
    {
        return $this->enrollment_id;
    }

    /**
     * Clean input
     *
     * Clean input from SQL Injections and HTML Entities
     *
     * @return void
     */
    protected function clean()
    {
        global $mysqli_obj;
        global $table_name;
        $clean_sql = function ($name, $strip = false) {
            global $mysqli_obj;
            if ($strip) {
                return strip_tags($mysqli_obj->real_escape_string($name));
            } else {
                return htmlspecialchars($mysqli_obj->real_escape_string($name));
            }
        };
        $this->username = $clean_sql($this->username, true);
        $this->email = $clean_sql($this->email, true);
        $this->password = $clean_sql($this->password);
        $this->firstname = $clean_sql($this->firstname);
        $this->lastname = $clean_sql($this->lastname);
        $this->phone1 = $clean_sql($this->phone1);
        $this->phone2 = $clean_sql($this->phone2);
        $this->address = $clean_sql($this->address);
        $this->city = $clean_sql($this->city);
        $this->country = $clean_sql($this->country);
    }

    /**
     * Save the object into the database
     *
     * @return boolean
     */
    public function save()
    {
        global $mysqli_obj;
        global $table_name;
        // Clean Inputs First
        $this->clean();

        if (!$this->id) {
            // check if the username is already taken
            $query = "SELECT * FROM $table_name WHERE username = '$this->username';";
            $res = $mysqli_obj->query($query);
            if ($res && $res->num_rows) {
                throw new Exception("Username had been already taken!");
            }

            // check if the email is already registered
            $query = "SELECT * FROM $table_name WHERE email = '$this->email';";
            $res = $mysqli_obj->query($query);
            if ($res && $res->num_rows) {
                throw new Exception("Email had been already registered!");
            }

            $query = <<<EOT
INSERT INTO $table_name
(username, email, password, firstname, lastname, phone1, phone2, address,
    city, country)
VALUES ('$this->username', '$this->email', '$this->password', '$this->firstname',
    '$this->lastname', '$this->phone1', '$this->phone2', '$this->address',
    '$this->city', '$this->country');
EOT;
            $res = $mysqli_obj->query($query);
            if ($res) {
                $this->id = $mysqli_obj->insert_id;
                return true;
            } else {
                $this->sqlError();
                return false;
            }
        } else {
            $query = <<<EOT
UPDATE $table_name
SET username='$this->username',email='$this->email',password='$this->password',
    firstname='$this->firstname',lastname='$this->lastname',phone1='$this->phone1',
    phone2='$this->phone2',address='$this->address',city='$this->city',
    country='$this->country',enrollment_id=$this->enrollment_id
WHERE id=$this->id;
EOT;
            $res = $mysqli_obj->query($query);
            if ($res) {
                return true;
            } else {
                $this->sqlError();
                return false;
            }
        }
    }

    /**
     * Delete the current student record from the database
     *
     * @return boolean
     */
    public function delete()
    {
        global $mysqli_obj;
        global $table_name;
        if ($this->id) {
            $query = "DELETE FROM $table_name WHERE id = $this->id;";
            $res = $mysqli_obj->query($query);
            if ($res) {
                $this->id = null;
                return true;
            } else {
                $this->sqlError();
            }
        }
        return false;
    }

    /**
     * Enroll Studnet into Moodle Course
     *
     * @return boolean
     */
    public function enroll()
    {
        global $mysqli_obj;
        global $table_name;
        global $db_prefix;
        global $enrollment_course_id;
        // Create User;
        $user_table = $db_prefix . 'user';
        $check_query = "SELECT id FROM $user_table WHERE username = '$this->username';";
        $res = $mysqli_obj->query($check_query);
        if ($res && $res->num_rows) {
            throw new Exception("Username is already taken in Moodle Users table!");
        }

        $timemodified = time();
        $query = <<<EOT
INSERT INTO $user_table
(username, email, password, firstname, lastname, phone1, phone2, address,
    city, country, timecreated, timemodified, confirmed)
VALUES ('$this->username', '$this->email', '$this->password', '$this->firstname',
    '$this->lastname', '$this->phone1', '$this->phone2', '$this->address',
    '$this->city', '$this->country', $timemodified, $timemodified, 1);
EOT;
        $res = $mysqli_obj->query($query);
        if ($res) {
            // Create Enrollment
            $enroll_table = $db_prefix . 'enrol';
            $userid = $mysqli_obj->insert_id;
            $query = "INSERT INTO $enroll_table (enrol, status, courseid, roleid) VALUES ('manual', 0, $enrollment_course_id, 5);";
            $res = $mysqli_obj->query($query);
            if ($res) {
                // Create User Enrollment
                $user_enrollment_table = $db_prefix . "user_enrolments";
                $enrollid = $mysqli_obj->insert_id;
                $query = "INSERT INTO $user_enrollment_table (enrolid, userid) VALUES ($enrollid, $userid);";
                $res = $mysqli_obj->query($query);
                if ($res) {
                    $this->enrollment_id = $userid;
                    $this->save();

                    // Send Mail to the Student
                    $message = <<<EOT
Dear $this->firstname,

Kindly informed that your registration in our course had been approved.

You're now enrolled in our course and you can log into our system and start your lessons.

Best Regards.
EOT;
                    $message = wordwrap($message, 70, "\r\n");
                    mail($this->email, "$this->firstname, You had been Approved", $message);
                    return true;
                } else {
                    $this->sqlError();
                    return false;
                }
            } else {
                $this->sqlError();
                return false;
            }
        } else {
            $this->sqlError();
            return false;
        }
    }

    /**
     * Find a student by ID
     *
     * @param integer $student_id the student ID
     *
     * @return SajjelStudent
     */
    public static function find($student_id)
    {
        global $mysqli_obj;
        global $table_name;
        $query = "SELECT * FROM $table_name WHERE id = $student_id;";
        $res = $mysqli_obj->query($query);
        if ($res) {
            $data = $res->fetch_assoc();
            $student = new self();
            $student->id = $data['id'];
            $student->enrollment_id = $data['enrollment_id'];
            $student->username = $data['username'];
            $student->email = $data['email'];
            $student->password = $data['password'];
            $student->firstname = $data['firstname'];
            $student->lastname = $data['lastname'];
            $student->phone1 = $data['phone1'];
            $student->phone2 = $data['phone2'];
            $student->address = $data['address'];
            $student->city = $data['city'];
            $student->country = $data['country'];
            return $student;
        } else {
            $this->sqlError();
            return null;
        }
    }

    /**
     * Get All Students
     *
     * @return Array
     */
    public static function findall()
    {
        global $mysqli_obj;
        global $table_name;
        $query = "SELECT id FROM $table_name ORDER BY id;";
        $res = $mysqli_obj->query($query);
        if ($res) {
            $students = array();
            while ($row = $res->fetch_assoc()) {
                $student = self::find($row['id']);
                array_push($students, $student);
            }
            return $students;
        } else {
            $this->sqlError();
            return array();
        }
    }
}

// New Student:
// $test = new SajjelStudent();
// $test->username = 'anassahmed';
// $test->password = 'password';
// $test->email = 'ans@ans.com';
// $test->firstname = 'Anass\'DROP TABLE mdl_sajjel_register;';
// $test->lastname = 'Ahmed <br />';
// $test->save();
// echo $test->getId();

// Delete Student
// $test->delete();

// Find Student
// $test = SajjelStudent::find(8);
// echo $test->username . "\n";
// echo $test->password . "\n";
// echo $test->email . "\n";
// echo $test->getId() . "\n";
// $test->address = "54 Ahmed Sarhan st, Omrania";
// $test->save();

// Find All Students
// $tests = SajjelStudent::findall();
// print_r($tests);
?>
