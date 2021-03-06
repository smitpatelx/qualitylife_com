<!--
FILE: 						<?php echo basename(__FILE__, $_SERVER['PHP_SELF'])."\n"; ?>
TITLE:						Apex Listings - User Login Page
AUTHORS:					Smit Patel
LAST MODIFIED:		October 4, 2018
DESCRIPTION:			Allows users to login to their profiles or allows new users to create an account
-->
<?php
require('./includes/constants.php');
require('./includes/db.php');
require("./includes/functions.php");

if (empty($_SESSION['username_s']) || ($_SESSION['user_type_s'] != ADMIN)){
    echo $_SESSION['user_type_s'];
    header('Location: ./405.php');
    ob_flush();  //Flush output buffer
}
?>
<div class="scroll-table-y scroll_snap">
<table class="highlight centered responsive-table">
    <thead class='scroll_snap_item'>
        <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class='transition-1'>
<?php

    $conn7 = db_connect();
    $search7 = "trim(LOWER('$_GET[search7]%'))";
    $sql7 = "SELECT * FROM users WHERE LOWER(user_id::text) LIKE $search7 
        OR LOWER(first_name) LIKE $search7 
        OR LOWER(last_name) LIKE $search7 
        OR LOWER(user_name) LIKE $search7 
        OR LOWER(email_address) LIKE $search7 
        ORDER BY users.user_id DESC";

    $result7 = pg_query($conn7, $sql7); 

    while($row7 = pg_fetch_assoc($result7)) {
    echo "<tr class='scroll_snap_item'>";
    echo "<td>".$row7["user_id"]."</td>";
    echo "<td>".$row7["first_name"]."</td>";
    echo "<td>".$row7["last_name"]."</td>";
    echo "<td>".$row7["user_name"]."</td>";
    echo "<td>".$row7["email_address"]."</td>";
    echo "<td><a class='btn red' href='".$row7["user_id"]."'><i class='fas fa-trash'></i></a></td>";
    echo "</tr>";
    }
    ?>       
    </tbody>
    </table>
</div>