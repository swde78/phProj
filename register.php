<?php
	include "inc/header.php";
require_once "dbCon.php";
 if (isset($_POST["submit"])) {

 $username = mysqli_real_escape_string($conn, $_POST["form-username"]);
 $name =     mysqli_real_escape_string($conn, $_POST["form-name"]);
 $email =    mysqli_real_escape_string($conn, $_POST['form-email']);
 $phone =       	                          $_POST['form-phone'];
 $password =                              password_hash($_POST['form-password'], PASSWORD_DEFAULT);
 $re_password = 	                      password_hash($_POST['form-re-password'], PASSWORD_DEFAULT);
 

 
 
 
 $select = "SELECT * FROM product WHERE username = '$username' && name = '$name' && phone = '$phone' && email = '$email' && password = '$password' ";
 $result = mysqli_query($conn, $select);
 if(mysqli_num_rows($result) > 0){
	 $error[] = "المستخدم الذي ادخلته موجود";
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$error[] = "ايميل غير صالخ يرجى التأكد من كتابة اﻻيميل بشكل صخيخ ..!";
	}
		

	$passwordHash = password_hash($password, PASSWORD_DEFAULT);
if (empty($_COOKIE['password']) || $_COOKIE['password'] !== $passwordHash){
	$error[] = "كلمة السر غير مطابقة يجب التأكد";
} 
if (strlen($password) < 8){
	$error[] = "الرقم السري ظعيف او غير صالح";
 }
    /* Redirects here after login */
   $redirect_after_login = 'register.php';
   
    /* Will not ask password again for */
   $remember_password = strtotime('+1 day'); // One day
   if (isset($_POST['password']) && $_POST['password'] == $passwordHash) {
       setcookie("password", $passwordHash, $remember_password);
   header('Location: ' . $redirect_after_login);
     exit;
    }
       else {
		
$stmt = $conn->prepare("INSERT INTO product(username, name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $username, $name, $email, $phone, $passwordHash);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "تمت عملية التسجيل";
} else {
    echo "Error: " . $stmt->error;
}
	   
$stmt->close();
}
 } 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<div class="pages section">
	<div class="container">
		<div class="pages-head"  style="height: 100px;">
			<h3>تسجــيل مستخدم جديد</h3>
		</div>
		<div class="register">
			<div class="row">
				<div class="col s12">
					<form action="register.php" class="register-form" id="register-form" method="post">
						<div class="form-group" id="username-field">
							<input type="text" class="validate" id="form-username" name="form-username" required placeholder="أسم المستخدم" >
						</div>
						<div class="form-group" id="name-field">
							<input type="text" class="validate" id="form-name" name="form-name" required placeholder="الاسم" >
						</div>
						<div class="form-group" id="email-field">
							<input type="email" class="validate" id="form-email" name="form-email" required placeholder="البريد الالكتروني" >
						</div>
						<div class="form-group" id="phone-field">
							<input type="int" class="validate" id="form-phone" name="form-phone" placeholder="رقم الهاتف">
						</div>
						<div class="form-group" id="password-field">
							<input type="password" class="validate" id="form-password"  name="form-password" required placeholder="ادخال رقم سري " >
						</div>
						<div class="form-group" id="repassword-field">
							<input type="password" class="validate" id="form-re-password"  name="form-re-password" required placeholder="إعادة ادخال الرقم السري">
						</div>
						<br></br>
						<div class="form-group">
							<button class="button-default" type="submit" id="submit" name="submit">تأكيد التسجــيل</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>