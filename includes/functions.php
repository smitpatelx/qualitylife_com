<!--
FILE: 						<?php echo basename(__FILE__, $_SERVER['PHP_SELF'])."\n"; ?>
TITLE:						Apex Listings - User Login Page
AUTHORS:					Smit Patel
LAST MODIFIED:		October 4, 2018
DESCRIPTION:			Allows users to login to their profiles or allows new users to create an account
-->
<?php 
session_start();
date_default_timezone_set('America/Toronto');

function displayCopyrightInfo() //to display copyright information in footer file
{
    $output = "";
    $output .=  "<a class='cell large-2 medium-2 small-2 large-offset-5 medium-offset-5 small-offset-5 waves-effect waves-light btn-flat z-depth-5 transition-1 primary cayan-text text-lighten-4 modal-trigger center-align shift-right' href='#modal1'>&copy; Copyright</a>";

    $output .=  "<div id='modal1' class='modal modal-fixed-footer'>
            <div class='row modal-content black-text'>
            <h4 class='col l12 black-text'>&copy; Copyright Info</h4>
            <h5 class='col l12 black-text left-align'>This website must not use for personal or commercial purpose without permission. We believe in strict copyright rules.       
                This project is created as per the requirements mentioned in
                <a href='http://opentech2.durhamcollege.org/pufferd/webd3201/'>Course WEBD3201</a>
            </h5>
            <h5 class='col l6 offset-l3' style='margin-top:200px;'>
                All rights reserved # GROUP-19
            </h5>
            </div>
            <div class='modal-footer row'>
            <a href='#!' class='col l2 offset-l6 right modal-close waves-effect waves-green btn'>Agree</a>
            <a href='404.php' class='col l2 offset-l6 left modal-close waves-effect waves-green btn'>Disagree</a>
            </div>
        </div>";
    echo $output;
}

function callPost() //to reuse POST request method
{
	return $_SERVER["REQUEST_METHOD"] == "POST";
}


function trimT($anyValue)
{
	return trim($_POST["$anyValue"]);
}

function post($anyValue)
{
	return $_POST["$anyValue"];
}

function hashmd5($value)
{
    return hash(MD5, $value);
}

function dhashmd5($value)
{
    return hash($value, MD5);
}

function display_phone_number($phonenumber)
{
        // Allow only Digits, remove all other characters.
    $phonenumber = preg_replace("/[^\d]/","",$phonenumber);
    
    // get phonenumber length.
    $length = strlen($phonenumber);
    
    // if phonenumber = 10
    if($length == 10) {
        $phonenumber = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "($1)$2-$3", $phonenumber);
    }
    else if($length > 10) {
        $extra = "";
        $extra = $length - 10;
        $nonextra = substr($phonenumber, 0, 10);
        $phonenumber = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "($1)$2-$3", $nonextra)." ext.".substr($phonenumber, -$extra);
    }

    return $phonenumber;
}

function is_valid_postal_code($value)
{
    //to remove all whitespace in between
    $trimvalue = preg_replace('/\s+/', '', $value);

    //to determine valid canada postal code. validation information from https://en.wikipedia.org/wiki/Postal_codes_in_Canada
    if(preg_match("/^([a-ceghj-npr-tv-z]){1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}$/i", $trimvalue))
    { 
        //postal code is valid
        return true;
    }
    else {
        //postal code is in-valid
        return false;
    }
}

function valid_phone_number($phonenumber) {

    $phonenumber = preg_replace("/[^\d]/","",$phonenumber);

    $areacode = substr($phonenumber, 0, 3);
    $exchange = substr($phonenumber, 3, 3);
    $dial_sequence = substr($phonenumber, 6, 4);
<<<<<<< HEAD
    
    if ( ($areacode < MAX_AREA_CODE && $areacode > MIN_AREA_CODE) 
    && ($exchange < MAX_AREA_CODE && $exchange > MIN_AREA_CODE)
    && ($dial_sequence < MAX_DIAL_SEQUENCE && $dial_sequence > MIN_DIAL_SEQUENCE)) {
        //echo "true => ".$phonenumber." => ".$areacode." => ".$exchange." => ".$dial_sequence;
        return true;
    } else {
        //echo "false";
        return false;
    }
}

function user_redirection() {
    if ($_SESSION['user_type_s'] == ADMIN){
        header("LOCATION: ./admin.php");
        ob_flush();  //Flush output buffer
    }else if ($_SESSION['user_type_s'] == AGENT){
        header("LOCATION: ./dashboard.php");
        ob_flush();  //Flush output buffer
    }else if ($_SESSION['user_type_s'] == DISABLED){
        header("LOCATION: ./406.php");
        ob_flush();  //Flush output buffer
    }else if ($_SESSION['user_type_s'] == CLIENT){
        header("LOCATION: ./welcome.php");
        ob_flush();  //Flush output buffer
    }else if ($_SESSION['user_type_s'] == PENDING){
        header("LOCATION: ./405.php");
        ob_flush();  //Flush output buffer
    }
}

function user_not_valid_redirect($user_type) {
    if ($user_type == ADMIN){
        header("LOCATION: ./admin.php");
        ob_flush();  //Flush output buffer
    }else if ($user_type == AGENT){
        header("LOCATION: ./dashboard.php");
        ob_flush();  //Flush output buffer
    }else if ($user_type == DISABLED){
        header("LOCATION: ./aup.php");
        ob_flush();  //Flush output buffer
    }else if ($user_type == CLIENT){
        header("LOCATION: ./welcome.php");
        ob_flush();  //Flush output buffer
    }else if ($user_type == PENDING){
        header("LOCATION: ./405.php");
        ob_flush();  //Flush output buffer
    }
}

function session_message() {
    if(isset($_SESSION['cookies_message'])) {
        $output = "";
        $output .= "<script type='text/javascript'>";
        $output .= "var myVar = setTimeout(cookies_message, 2000);";
            
        $output .= "function cookies_message() {";
               
        $cookies_message = $_SESSION['cookies_message'];
        foreach($cookies_message as $cookie_message)
        {
            // $cookie_message = "<div class='red_alert'>".$cookie_message."</div>";
            $output .= "M.toast({html: '".$cookie_message."', classes:'red'})";
        }
        unset($_SESSION["cookies_message"]);
                              
        $output .= "}";         
        $output .= "</script>";

        echo $output;
    }
}

function checkRemoteFile($url)
{
    $exist = file_exists($url);
    if($exist==true)
    {
        return true;
    }
    else
    {
        return false;
    }
}

/*
	this function should be passed a integer power of 2, and any decimal number,
	it will return true (1) if the power of 2 is contain as part of the decimal argument
*/
function is_bit_set($power, $decimal) {
	if((pow(2,$power)) & ($decimal)) 
		return 1;
	else
		return 0;
} 

function listing_status_symbol($status) {
    $return_status = "";
    if ($status == LISTING_STATUS_OPEN) {
        $return_status ="<i class='fas fa-circle' style='color:#18c959;'></i>OPEN";
    } else if ($status == LISTING_STATUS_CLOSE) {
        $return_status ="<i class='fas fa-circle' style='color:#c91826;'></i>CLOSE";
    } else if ($status == LISTING_STATUS_SOLD) {
        $return_status ="<i class='fas fa-circle' style='color:#eae025;'></i>SOLD";
    } else if ($status == LISTING_STATUS_HIDE) {
        $return_status ="<i class='fas fa-circle' style='color:#b5b5b5;'></i>HIDDEN";
    }
    return $return_status;
}

/*
	this function can be passed an array of numbers (like those submitted as 
	part of a named[] check box array in the $_POST array).
*/
/*
	this function can be passed an array of numbers (like those submitted as 
	part of a named[] check box array in the $_POST array).
*/
function sum_check_box($array)
{
	$num_checks = count($array); 
	$sum = 0;
	for ($i = 0; $i < $num_checks; $i++)
	{
	  $sum += $array[$i]; 
	}
	return $sum;
}


function like_button($userid, $listing_id) {
    $output = "";

    $conn = db_connect();
    $sql = "SELECT * FROM favourites WHERE user_id::VARCHAR='$userid' AND listing_id=$listing_id";
    $query = pg_query($conn, $sql);

    if(pg_num_rows($query) > 0) {
        $output = "<a class='btn waves-effect waves-light red darken-2 white-text' href='./favourite.php?listing_id=".$listing_id."&method=dislike'><i class='fas fa-heart'></i> You Liked This
        </a>";
    } else {
        $output = "<a class='btn waves-effect waves-light red darken-2 white-text' href='./favourite.php?listing_id=".$listing_id."&method=like'><i class='fas fa-heart'></i> Like
        </a>";
    }

    return $output;
=======
    
    if ( ($areacode < MAX_AREA_CODE && $areacode > MIN_AREA_CODE) 
    && ($exchange < MAX_AREA_CODE && $exchange > MIN_AREA_CODE)
    && ($dial_sequence < MAX_DIAL_SEQUENCE && $dial_sequence > MIN_DIAL_SEQUENCE)) {
        //echo "true => ".$phonenumber." => ".$areacode." => ".$exchange." => ".$dial_sequence;
        return true;
    } else {
        //echo "false";
        return false;
    }
}

function user_redirection() {
    if ($_SESSION['user_type_s'] == ADMIN){
        header("LOCATION: ./admin.php");
        ob_flush();  //Flush output buffer
    }else if ($_SESSION['user_type_s'] == AGENT){
        header("LOCATION: ./dashboard.php");
        ob_flush();  //Flush output buffer
    }else if ($_SESSION['user_type_s'] == DISABLED){
        header("LOCATION: ./406.php");
        ob_flush();  //Flush output buffer
    }else if ($_SESSION['user_type_s'] == CLIENT){
        header("LOCATION: ./welcome.php");
        ob_flush();  //Flush output buffer
    }
}

function session_message() {
    if(isset($_SESSION['cookies_message'])) {
        $output = "";
        $output .= "<script type='text/javascript'>";
        $output .= "var myVar = setTimeout(cookies_message, 2000);";
            
        $output .= "function cookies_message() {";
               
        $cookies_message = $_SESSION['cookies_message'];
        foreach($cookies_message as $cookie_message)
        {
            // $cookie_message = "<div class='red_alert'>".$cookie_message."</div>";
            $output .= "M.toast({html: '".$cookie_message."', classes:'red'})";
        }
        unset($_SESSION["cookies_message"]);
                              
        $output .= "}";         
        $output .= "</script>";

        echo $output;
    }
}

function checkRemoteFile($url)
{
    $exist = file_exists($url);
    if($exist==true)
    {
        return true;
    }
    else
    {
        return false;
    }
}

/*
	this function should be passed a integer power of 2, and any decimal number,
	it will return true (1) if the power of 2 is contain as part of the decimal argument
*/
function is_bit_set($power, $decimal) {
	if((pow(2,$power)) & ($decimal)) 
		return 1;
	else
		return 0;
} 

/*
	this function can be passed an array of numbers (like those submitted as 
	part of a named[] check box array in the $_POST array).
*/
/*
	this function can be passed an array of numbers (like those submitted as 
	part of a named[] check box array in the $_POST array).
*/
function sum_check_box($array)
{
	$num_checks = count($array); 
	$sum = 0;
	for ($i = 0; $i < $num_checks; $i++)
	{
	  $sum += $array[$i]; 
	}
	return $sum;
}

function decode_check_box($value)
{
    $array = [];
    
>>>>>>> 5a03d788a70a72822cda86d705291dd82127a05a
}

?>