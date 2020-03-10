# FamilyHome 
A web page that show information about an hostal, hotel, etc. with a little software to management this page, the users and some promotions. It's one of my first projects as Freelancer.

## Characteristics
- Written in PHP using [Codeigniter 3 Framework](https://codeigniter.com/).
- MySQL/MariaDB Database for internal data and user registry.
- Language of Web Page and System are in Spanish.
- Principal static landing page to show info about the hostal (Based on [Agency Start Bootstrap template](https://startbootstrap.com/themes/agency/)).
  - Added a Gallery section (in replacement of portfolio) to show photos using Carousel Bootstrap component.
	- Added a Location section with a Google Maps frame.
	- Added a Promotion section that shows offers and discounts when you visit the Web Page between the days the offers are active.
- Administrator panel where registered users can modify some parts of the webpage, like contact info and promotions.
  - The panel can be accesed through /panel route. (This doesn't show on the principal page for security purposes).
	- The panel has a Login form to prevent that any user can modify the web page parameters.
	- The panel has 2 user types, a helper that can modify the promotions and his own personal information, and the Administrator that can manage this, and can register other administrators and helpers. 

## Install and use
To mount this Website, first you need to clone this repository on you PC or server. 

Then, you need to create a database user and execute the [construct_db.sql](https://github.com/Martux1995/familyhome/blob/master/construct_db.sql) file to create the database and tables. The last line of this file has a test user and it's password to access to this system.

Next, you need to modify the enviroment variables from [.htaccess](https://github.com/Martux1995/familyhome/blob/master/.htaccess) file (If you have other way to manage this variables, you need to delete the SetEnv variables). The Enviroment Variables from this system are:
- HTTP_BASE_URL: The base_url() codeigniter config. Can be a local url or the server url (if you are on production).
- HTTP_BASE_URL_LOCAL: The local url to manage google captcha conditions.
- HTTP_DB_HOSTNAME: The url of the hostname DB, generally is localhost.
- HTTP_DB_USERNAME: The user of the system database.
- HTTP_DB_PASSWORD: The password of the user that can access to the system DB.
- HTTP_DB_NAME: The name of the database.
- HTTP_GOOGLE_CAPTCHA_CODE: The code of the Google ReCaptcha server-side.
- HTTP_GOOGLE_CAPTCHA_SITEKEY: The code of the Google ReCaptcha front-side.
- HTTP_SMTP_SERVER: The url to the smtp server.
- HTTP_SMTP_USER: The email account from the smtp server to send mails.
- HTTP_SMTP_PASSWORD: The password of the email account.
