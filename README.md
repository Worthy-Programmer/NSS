#  Application for NSS WebOps Coordinator

NOTE: Product showcase is at NSS IITM.mov

## Setup
1. **Install MAMP/XAMPP**
 - Link: https://www.mamp.info/
 - Open the MAMP file and start the Apache server.

2. **Setting up the database**
 - Create a database of any name in mysql and import the file `nss_iitm.sql` in the mysql
 - In `logic/setting.ini` please update your database details

3. **Install composer**
  - Link: https://getcomposer.org/
  - Install composer from the link above, if you haven't installed it.
  - Go to the directory in command prompt / terminal and run `composer install`.

5. **Open the webpage in localhost**
  - Now view the webpage at localhost through the link. The index page is at view/index.html.
