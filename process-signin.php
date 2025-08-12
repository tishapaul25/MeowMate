<?php if(isset($_POST['signin_btn'])){
  session_start();
  require "db.php";
  $username = $conn->escape_string($_POST['username']);
  $password = $conn->escape_string($_POST['password']);;

  $result = $conn->query("SELECT * FROM users WHERE username = '$username'");
  if($result->num_rows > 0){
    $user = $result ->fetch_assoc();
    if ( password_verify($_POST['password'], $user['password']) ) {
     if($user['status'] != 0){

            $_SESSION['id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;

        if($user['role'] == 1){
          // cat owner
          header("location: index.php");

        }else if($user['role']==2){
          // hostel provider
          header("location: provider.php");

        }else if($user['role'] == 3){
          // vet
          header("location: vet.php");
        }

     }
     else{
      echo "This account in review, please try back later.";
     }
    } else {
      echo "password not found";
    }
  }else{
    echo "No user exist with this username";
  }
}
?>
