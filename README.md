# Sajjel

Sajjel is a PHP Script Prototype for enrolling students into specific course using Moodle database. This is only
development prototype for testing purposes only. It's not intended for production use. It has major security and
performance issues which needs to be worked on.

## Dependencies

1. PHP 5.4+
2. MariaDB/MySQL 5.5+
3. PHP MySQLi extension

## Usage

* Modify `config.php` to adjust it to your moodle database configuration:
    - `$db_host` = Database Server Hostname/IP.
    - `$db_user` = Database user.
    - `$db_pass` = Database password.
    - `$db_name` = Database name (same as moodle database).
    - `$db_prefix` = Database tables prefix (same as moodle database, default is `'mdl_'`).
    - `$admin_username` = Admin Username to login to Admin Control Panel.
    - `$admin_password` = Admin Password.
    - `$course_enrollment_id` = Moodle Course ID to enroll students to.
    - `$root_url` = Sajjel Script URL (for links in menus to work fluently).
* Upload the script to your website.
* Change permissions of `config.php` file to `0600` (non-readable by any other user).
* Launch the application (The App will install itself in the first time Automatically).
* You will find three elements in the main menu:
    - **Home**: The index page.
    - **Register yourself**: The student registration page.
    - **Admin Login**: The Admin Control Panel Login page.
* When you login using `admin_username` and `admin_password` you have specified in `config.php`, you will find 2 other elements:
    - **Students List**: The Students List of who had registered into Sajjel.
    - **Logout**: The Logout page.
* From **Students List** you can:
    - **Enroll** students into Moodle Course.
    - **Delete** students from Sajjel Registration Table (Doesn't remove the moodle student record).
    - **Export** students to CSV file (Excel-compatible format).
    - You can enroll, or delete single or all records of the students list.
* The main columns in **Students List** are:
    - **#**: The ID of the student in Sajjel Registration Table.
    - **Username**: The Username of the student.
    - **First name**: The First name of the student.
    - **Second name**: The Second name of the student.
    - **Email**: The Email of the student.
    - **Phone 1**: The Phone 1 of the student.
    - **Phone 2**: The Phone 2 of the student.
    - **City**: The City of the student.
    - **Country**: The Country of the student.
    - **Enrollment ID**: The Enrollment ID of the student in the Moodle User table.

## Disclaimer

This application is not intended for public/production use. It has potential security issues. Use it for learning-purposes only and use it with caution.

## License

This application is licensed under [GPLv3+](https://www.gnu.org/licenses/gpl.html)
