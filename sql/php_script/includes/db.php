<!--
FILE: 						<?php echo basename(__FILE__, $_SERVER['PHP_SELF'])."\n"; ?>
TITLE:						Apex Listings - User Login Page
AUTHORS:					Smit Patel
LAST MODIFIED:		October 4, 2018
DESCRIPTION:			Allows users to login to their profiles or allows new users to create an account
-->
<?php

function db_connect() //to connect database
{

    $connection = pg_connect("host=".DB_HOST." dbname=".DB_NAME." user=".DB_USER." password=".DB_PASSWORD.""); 
    return $connection; 

}

function is_user_id($user){
    $return_value;
    $conn = db_connect();
    $sql_u = "SELECT * FROM users WHERE user_name='$user'";
    $res_u = pg_query($conn, $sql_u);

    if (pg_num_rows($res_u) > 0) { 	
        $return_value = true;
    }
    else{
        $return_value = false;
    }
    return $return_value;
}

function build_simple_dropdown($value, $sticky){
    $conn = db_connect();
    $output = "";

    if ($value == "provinces"){

        $sql_provinces = "SELECT * FROM provinces ";

        $result_provinces = pg_query($conn, $sql_provinces);

        if (pg_num_rows($result_provinces) > 0) {
            // output data of each row
            $output .= "<select name='location'>";
            
            while($row = pg_fetch_assoc($result_provinces)) {
                $output .= "<option value='".$row["province"]."'";

                if ( $row['province'] == $sticky ){
                    $output .= " selected";
                }

                $output .= ">".$row["province_long"]."</option>";            
            }

            $output .= "</select>";
            $output .= "<label>Choose Provinces</label>";
        }
    }
    else if ($value == "salutations"){

        $sql = "SELECT * FROM salutations ";
        $result = pg_query($conn, $sql);
        if (pg_num_rows($result) > 0) {
            // output data of each row
            $output .= "<select name='salutation'>";
            while($row = pg_fetch_assoc($result)) {
                $output .= "<option value='".$row["salutation"]."'";

                    if ( $row['salutation'] == $sticky ){
                        $output .= " selected";
                    }

                $output .= ">".$row["salutation"]."</option>";            
            }
            $output .= "</select>";
            $output .= "<label>Salutation</label>";
        }
    }

    echo $output;
}

function build_dropdown($table, $column_1 ,$name_value, $lable, $sticky) {
        $conn = db_connect();
        $output = "";

        $sql = "SELECT * FROM $table ";
        $result = pg_query($conn, $sql);
        if (pg_num_rows($result) > 0) {
            // output data of each row
            $output .= "<select name='$name_value'>";
            while($row = pg_fetch_assoc($result)) {
                $output .= "<option value='".$row["$column_1"]."'";

                    if ( $row["$column_1"] == $sticky ){
                        $output .= " selected";
                    }

                $output .= ">".ucwords($row["$column_1"])."</option>";            
            }
            $output .= "</select>";
            $output .= "<label>$lable</label>";      
        }

        echo $output;

}

function build_radio($value, $sticky) {
    $conn = db_connect();
    $output = "";

    if ($value == "preferred_contact_method") {

        $sql = "SELECT * FROM preferred_contact_method ";
        $result = pg_query($conn, $sql);
        if (pg_num_rows($result) > 0) {
            // output data of each row    
                $output .= "<div id='preferred_contact_method'>";      
            while($row = pg_fetch_assoc($result)) {
                $output .= "<p><label>";
                $output .= "<input name='contact_method' type='radio' value='".$row['method']."'";
                
                    if ( $row['method'] == $sticky ){
                        $output .= " checked";
                    }

                $output .= "/>";   
                $output .= "<span>".$row['method_name']."</span>";    
                $output .= "</label></p>";     
            }     
                $output .= "</div>";      
        }
    } else if ($value == "listing_status") {

        $sql = "SELECT * FROM listing_status ";
        $result = pg_query($conn, $sql);
        if (pg_num_rows($result) > 0) {
            // output data of each row          
            while($row = pg_fetch_assoc($result)) {
                $output .= "<p><label>";
                $output .= "<input name='listing_status_".$row['value']."' type='radio' ";

                    if ( $row['property'] == $sticky ){
                        $output .= " checked";
                    }
                $output .= "/>";   
                $output .= "<span>".ucwords($row['property'])."</span>";    
                $output .= "</label></p>";     
            }          
        }
    }

    echo $output;
}

function get_property() {

}

?>
