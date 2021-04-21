# employees-management-system
### A simple PHP Employees Management System in which you can manage and track your employees attendance, setup payrolls and many more

## How to use it

This is a php system which you can host under your local or online server which **requires only a DB import** which you can find under database folder.

Admin panel can be accessed using http://www.your-domain.com/admin
Employees can check in check out using an Employeed ID that admin can provide or using a QR code scan.

make sure you create a database called ' company_ems '

## Features

* Employee and Administrative side
* Add, Edit, Remove and View Employees
* Manage Attendance
* Overtime Works
* Advance Cash
* Manage Schedules
* Deductions
* Position Titles
* Payroll

## Credits

* jQuery 3
* Google Font (Source+Code+Pro)
* Bootstrap 3.3.7
* Moment JS
* Font Awesome
* code-projects.org

## Notes

1. The QR code generation for now is done manually, it can be generated using any free online QR generator
ex: qrcode-monkey.com; generate the QR based on the following structure:
http://www.your-domain.com/attendance.php?employee={employeeId}

2. You can predefine your timezone by updating timezone.php to fit your needs.

3. DB connection settings can be found under ./conn.php & ./admin/includes/conn.php

## Admin Access
* path: http://www.your-domain.com/admin
* username: admin
* password: password

## Contribute

We're always looking for:

* Bug reports, especially those for aspects with a reduced test case
* Ideas for enhancements