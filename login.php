<?php
include_once ('dbCon.php');
//require_once 'home.php'; 
$redirect_after_login = 'home.php';

if (isset($_POST['submit'])) {
    
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    //$password =                                 ($_POST['password']);
    $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    
    if(empty($username) || empty('password')){
        array_push($errors,'username or password is not corrected');
        
        
    }
    
    require_once 'home.php';
    if(count($errors) == 1){
        $_SESSION['errors'] = $errors;
        
        //password_verify($passwordHash, 'password');
        $query = "SELECT * FROM product WHERE username = ? AND password = $passwordHash" ;
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 1 ){
            $_SESSION['username'] = $username;
        //$_SESSION['success'] = 'you are logged in ...Welcome';
        
  }else if (password_verify($passwordHash, 'password')) {
            $_SESSION['password'] = $passwordHash;
            header('Location : ' . $redirect_after_login);
            exit;
     
        
    } else{ 
        array_push($errors,'error on password...');
        header('Location : login6.php');
     
    }

}   

}

?>
<div class="pages section">
    <div class="container">
        <div class="pages-head"  style="height: 100px;">
            <h3>صفحة الدخول </h3>
</div>
 
        <div class="login" >
            <div class="row">
                <div class="col s12">
                    <form action="login6.php" class="login-form" id="login-form" method="POST">
                        <div class="form-group" id="phone">
                            <label for="">رقم الهاتف</label>
                            <input type="text" class="validate" id="username" name="username" placeholder="ادخل رقم الهاتف" >
                        </div>
                        <br>
                        <label for="">الرقم السري</label>
                        <div class="form-group" id="password-field">
                            <input type="password" class="validate" id="password"  name="password"  placeholder="ادخال رقم سري " >
                        </div>
                        <br></br>
                        <div class="form-group">
                            <button class="button-default" type="submit" id="submit" name="submit">تأكيدالدخول</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Login -->

<!-- footer -->
</body>
</html>