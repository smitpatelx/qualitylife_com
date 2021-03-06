<!--
FILE: 						<?php echo  basename(__FILE__, $_SERVER['PHP_SELF'])."\n"; ?>
TITLE:						Apex Listings - User Login Page
AUTHORS:					Smit Patel
LAST MODIFIED:		October 4, 2018
DESCRIPTION:			Allows users to login to their profiles or allows new users to create an account
-->
<?php

	//Form @start
	define('MAX_USERNAME_LENGTH', '20' );
	define('MIN_USERNAME_LENGTH', '6' );

	define('MAX_PASSWORD_LENGTH', '8' );
	define('MIN_PASSWORD_LENGTH', '16' );

	define('MAX_FIRST_NAME_LENGTH', '20' );
	define('MIN_FIRST_NAME_LENGTH', '3' );

	define('MAX_LAST_NAME_LENGTH', '30' );
	define('MIN_LAST_NAME_LENGTH', '3' );

  	define('MAX_EMAIL_LENGTH', '30' );
	define('MIN_EMAIL_LENGTH', '5' );
	  
  	define('MAX_ADDRESS_LENGTH', '30' );
	define('MIN_ADDRESS_LENGTH', '6' );
	  
	define('POSTAL_CODE_LENGTH', '6' );
	  
	define('MAX_PHONE_LENGTH', '15' );
	define('MIN_PHONE_LENGTH', '10' );
	  
  	define('MAX_CITY_LENGTH', '17' );
	define('MIN_CITY_LENGTH', '3' );

	define('MAX_FAX_LENGTH', '15' );
	define('MIN_FAX_LENGTH', '6' );

	define('MAX_AREA_CODE', '999' );
	define('MIN_AREA_CODE', '200' );

	define('MAX_DIAL_SEQUENCE', '9999' );
	define('MIN_DIAL_SEQUENCE', '0000' );
	//form constants @ends

	//listing @start
<<<<<<< HEAD
	define('MAX_FILE', 100000);
=======
	define('MAX_FILE', '2097152' );
>>>>>>> 5a03d788a70a72822cda86d705291dd82127a05a

	define('MAX_HEADING', '60' );
	define('MIN_HEADING', '6' );

	define('MAX_PRICE', '10' );
	define('MIN_PRICE', '4' );

	define('MAX_DESC', '1000' );
	define('MIN_DESC', '60' );

	define('MAX_ADDRESS', '40' );
	define('MIN_ADDRESS', '6' );

	define('MAX_AREA', '10' );
	define('MIN_AREA', '4' );

	define('MAX_CONTACT', '15' );
	define('MIN_CONTACT', '10' );
	//listing @end

	// User Type Constants
	define('ADMIN', 's');
	define('AGENT', 'a');
	define('CLIENT', 'c');
	define('PENDING', 'p');
	define('DISABLED', 'd');

	//Database Constants
	define("DB_HOST", "127.0.0.1");
	define("DB_NAME","group19_db");
	define("DB_PASSWORD", "apexscdb18");
	define("DB_USER", "group19_admin");

	//MD5
	define("MD5", "md5");

	define("EMAIL", "");
	define("PHONE", "");
	define("POSTED_EMAIL", "");

	define("LISTING_STATUS_OPEN", "o");
	define("LISTING_STATUS_CLOSE", "c");
	define("LISTING_STATUS_SOLD", "s");
<<<<<<< HEAD
	define("LISTING_STATUS_HIDE", "h");

	define("COOKIES_EXP", 2592000);
	define("MAX_UPLOAD_IMAGE", 6);
=======

>>>>>>> 5a03d788a70a72822cda86d705291dd82127a05a
?>
