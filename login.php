<!--
FILE: 						<?php echo basename(__FILE__, $_SERVER['PHP_SELF'])."\n"; ?>
TITLE:						Apex Listings - User Login Page
AUTHORS:					Smit Patel
LAST MODIFIED:		October 4, 2018
DESCRIPTION:			Allows users to login to their profiles or allows new users to create an account
-->

<?php

$title = "Login";
$file = "dashboard.php";
$date = "Sept 14 2018";
$banner = "Login";
$desc = "Dashboard Page of QualityLife";

require('header.php');
if (isset($_SESSION['user_type_s'])){
  $session_message = [];
  $session_message[] = "This page is not available.";
  $_SESSION['cookies_message'] = $session_message;
  user_redirection();
}
// echo $_SESSION['user_type_s'];
// echo $_SESSION['username_s'];
?>

<script type="text/javascript">     
    $(window).on('load', function () {
        $('.preloader-background').hide();
    });      
</script>
<?php

  $errors = []; 
  
  $cookies_message = [];
  
  if ($_SERVER["REQUEST_METHOD"] == "GET")
  {
    // echo encrypt_array_to_string($_COOKIE['USER']);
    if(isset($_COOKIE['USER']))
    {
      $cookie_user = (implode('user',$_COOKIE['USER']));
      $loginid = $cookie_user;
      $password= "";  
      $rememberme= "checked='checked'";   
    }
    else{
      $loginid = "";
      $password= "";
      $rememberme= "checked='checked'";
    }
  }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {

      if (isset($_POST['id']) && isset($_POST['password']) ) //if ID and Password not set
      {
        if (isset($_POST['rememberme']))
        {
          $rememberme = $_POST['rememberme'];
        }
        
        $loginid = trimT('id');
        $password = trimT('password');
        
        
        if ($loginid != "" && $password != "" ) //if ID and Password is empty
        {
          $password = hashmd5($password);
          $last_access = date("Y-m-d",time());
          $dbconn = db_connect();

          // Deciding which landing page to be redirected to
          $stmt2 = pg_prepare($dbconn, 'user_login', "SELECT * 
                                                      FROM users
                                                      WHERE users.user_name = $1 AND users.password = $2");
  
          $result2 = pg_execute($dbconn, 'user_login', array($loginid, $password));
          // echo $result2;
          if (pg_num_rows($result2) > 0)
          {
            // if(pg_fetch_assoc($result2))
            // Preparing query for execution
            $stmt1 = pg_prepare($dbconn, 'user_last_access', "UPDATE users
                                                  SET last_access = '".$last_access."'
                                                  WHERE users.user_name = \$1 AND users.password = \$2");
    
            // Execute the prepared query
            $result1 = pg_execute($dbconn, 'user_last_access', array($loginid,$password));
      
            // pg_query($dbconn, $result1);

    
            $data = pg_fetch_array($result2);

            if ($data['user_type']==PENDING || $data['user_type']==DISABLED) {
               user_not_valid_redirect($data['user_type']);
            } else {
              
              $_SESSION['user_type_s'] = $data['user_type'];
              $_SESSION['username_s'] = $data['user_name'];
              $_SESSION['first_name_s'] = $data['first_name'];
              $_SESSION['last_name_s'] = $data['last_name'];
              $_SESSION['last_access_s'] = $data['last_access'];
              $_SESSION['user_id_s'] = $data['user_id'];

              if (isset($rememberme))
              {
                $cookie_user = ($_SESSION['username_s']);
                setcookie('USER[user]', $cookie_user, time() + COOKIES_EXP);
                $cookies_message[] = "Cookie set for 30 days.";
              }
              else
              {
                unset($_COOKIE['USER[user]']);
                setcookie( 'USER[user]',  $_SESSION['username_s'], time()-3600);
                $cookies_message[] = "Cookie Destroyed.";
              }
              $_SESSION['cookies_message'] = $cookies_message;
              //Redirect user to their respective pages, see functions.php
              user_redirection();
            }
            $_SESSION['cookies_message'] = $cookies_message;
            //Redirect user to their respective pages, see functions.php
            user_redirection();
          }
          else
          {
            $errors[] = "Login Id or Password incorrect.";
          }
        }
        else
        {
          $errors[] = "One or more fields are empty.";
        }
      }
      else
      {
        $errors[] = "One or more fields not set";        
      }
    }
    else
    {
      $errors[] = "No Post Request";
    }

  //output error as Toast (java script)
  foreach($errors as $error)
  {
    echo "<script>M.toast({html: '".$error."'})</script>";
  }
  $password= "";
  
?>



<div class="grid-x center my-4 ml-4">

      <div id="sign-in" class="col s12 cell large-8 large-offset-2">
        <div class="cell large-4 large-offset-4 row">
        <form class="col s12" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <div class="row">
            <div class="input-field col s12">
              <input id="id" name="id" value="<?php echo $loginid ?>" type="text" class="validate"/>
              <label for="id">User ID</label>
            </div>
          </div>

        <div class="row">
            <div class="input-field col s12">
              <input id="password" name="password" value="<?php echo $password ?>" type="password" class="validate"/>
              <label for="password">Password</label>
            </div>
        </div>

        <div class="row">
          <label class="input-field col s12">
            <input type="checkbox"  name="rememberme" class="filled-in" value="1" <?php echo $rememberme ?>/>
            <span>Remember Me</span>
          </label>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <button class="btn waves-effect waves-light blue lighten-1" type="submit" name="action">Sign In
                    <i class="fas fa-sign-in-alt"></i>
                </button>
                <a class="btn waves-effect waves-light blue lighten-1" href="./register.php">Register
                    <i class="fas fa-user-plus ml-1"></i>
                </a>
            </div>
            <div class="input-field col s12">
              <a class="btn waves-effect waves-light grey white-text" href="./forget_password.php">Forget Password
              </a>
            </div>
        </div>

        </form>
      </div>
      </div>
</div>

<?php
require("./footer.php");
?>
