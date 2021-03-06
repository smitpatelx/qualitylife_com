<!--
FILE: 						<?php echo basename(__FILE__, $_SERVER['PHP_SELF'])."\n"; ?>
TITLE:						Apex Listings - User Login Page
AUTHORS:					Smit Patel
LAST MODIFIED:		October 4, 2018
DESCRIPTION:			Allows users to login to their profiles or allows new users to create an account
-->
<?php

$title = "Listing Display";
$file = "listing-display.php";
$date = "Sept 14 2018";
$banner = "Listing Display";
$desc = "Listing Display Page";

require('header.php');

if (!isset($_SESSION['username_s'])){
    $session_message = [];
    $session_message[] = "Unauthorized access blocked.";
    $_SESSION['cookies_message'] = $session_message;   
    header('Location: ./login.php');
    ob_flush();  //Flush output buffer
}
?>
<script type="text/javascript">     
    $(window).on('load', function () {
        $('.preloader-background').hide();
    });      
</script>
<?php 

if (isset($_GET["listing_id"])) {
  $conn = db_connect();
  $output = "";
  $listing_id = $_GET["listing_id"];

  if ( $_SESSION['user_type_s']==ADMIN){
    $sql = "SELECT * FROM listings WHERE listing_id = $listing_id ORDER BY listings.created_on DESC";
  }else {
    $sql = "SELECT * FROM listings WHERE listing_id = $listing_id AND ( status ='o' OR status ='s' ) ORDER BY listings.created_on DESC";
  }
  

	$result = pg_query($conn, $sql);
	// $records = pg_num_rows($result);

 if (pg_num_rows($result) > 0) {
    // output data of each row
    while($row = pg_fetch_assoc($result)) {
        $property_options = [];
        $property_options = json_decode($row["property_options"]);

        $image_link = "";
        $image_link = $row["images_path"];
        if (true == checkRemoteFile($image_link)) {
            // $image_link = $row["images_path"];
            $image_link = $image_link;
        } else {
            $image_link = "./images/no_image.svg";
        }

        $last_page = isset($_SESSION['listing_matches.php'])?$_SESSION['listing_matches.php']:"1";
        
        

        $user_id = $row['user_id'];

        echo "<div class='grid-x my-4'>";
        echo "<a class='cell small-2 small-offset-5 btn waves-effect waves-block waves-light z-depth-4 blue-grey lighten-2 white-text btn-rounded' onclick='history.back(-1)'><i class='fas fa-chevron-left'></i> BACK</a>";
        if ($_SESSION['user_type_s'] == ADMIN) {
            echo "<div class='row cell small-12'>";
            echo "<div class='input-field center'>";
            echo  admin_add_listing_to_blacklist_btn($_SESSION['user_id_s'], $listing_id);
            echo  admin_add_user_to_blacklist_btn($_SESSION['user_id_s'], $listing_id);
            echo "</div>";
            echo "</div>";
        } else if ($_SESSION['user_type_s'] == CLIENT) {
            echo "<div class='row cell small-12'>";
            echo "<div class='input-field center'>";
            echo like_button($_SESSION['user_id_s'], $listing_id);
            // echo  admin_add_listing_to_blacklist_btn($_SESSION['user_id_s'], $listing_id);
            echo "</div>";
            echo "</div>";
        }
        
            echo "<div class='cell large-6 large-offset-3'>";
                echo  "<div class='card z-depth-4 hoverable' data-aos='zoom-out'>";
                    echo  "<div class='card-image waves-effect waves-block waves-light'>";
                    echo  "<img class='activator' src='".$image_link."' alt='img_".$row["listing_id"]."' />";
                    echo  "</div>";
                echo  "<div class='card-content'>";
            echo  "<h2  class='card-title activator grey-text text-darken-1'><span>".$row["headline"]."</span> </h2>";
            echo "<span class='card-title grey-text h3 center'>Information</span>";
            echo "<ul>";
            echo "<li>Location: ".$row["address"]."</li>";
            echo "<li>Status: ".listing_status_symbol($row["status"])."</li>";
            echo "<li>Price: $".$row["price"]."</li>";
            echo "<li>Space: ".$row["area"]." sqft</li>";
            echo "<li>Contact: ".$row["contact"]."</li>";
            echo "<li>Description: ".$row["description"]."</li>";
            echo "<li>Postal Code: ".$row["postal_code"]."</li>";
            echo "<li>City: ".$row["city"]."</li>";
            echo "<li>No. of Bedrooms: ".$row["bedrooms"]."</li>";
            echo "<li>No. of Bathrooms: ".$row["bathrooms"]."</li>";
            echo "<li>Pets friendly: ".ucwords($row["pets_friendly"])."</li>";

            echo "<li class='left'>Features:";
            echo display_bandage("property_option", "property", "value", $property_options);
            // foreach ($property_options as $options) {
            //     echo "<span class='new badge mt-1 waves-effect waves-block waves-light z-depth-4' data-badge-caption='".ucwords($options)."'></span>";
            // }
            echo "</li>";
            
            echo "</ul>";
            echo  "</div>";
        echo"</div>";
        echo"</div>";
        echo"</div>";
        }
    } else {
        $session_message = [];
        $session_message[] = "You are not allowed to see this listing.";
        $_SESSION['cookies_message'] = $session_message;
        echo "<script> window.history.go(-1); </script>";
    }
} else {
    header('Location: ./listing_search.php');
    ob_flush();
}
?>

<?php
require("./footer.php");
?>