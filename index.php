<?php 



// SOME DATA IN MYSQL
// USERONE 123456 STUDENT
// USERTWO 123456 TEACHER
// USERTHREE 123456 ADMIN
// USER4 123456 STUDENT

session_start();

$conn=new mysqli("localhost","root","","login_system");
$msg="";

if(isset($_POST["login"])){
    $username=$_POST["username"];
    $password=$_POST["password"];
    $password=sha1($password);
    $usertype=$_POST["usertype"];

    $sql="SELECT * FROM users WHERE username=? AND password=? AND usertype=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("sss",$username,$password,$usertype);
    $stmt->execute();
    $result=$stmt->get_result();
    $row=$result->fetch_assoc();

    session_regenerate_id();
    $_SESSION['username']=$row['username'];
    $_SESSION['role']=$row['usertype'];

    session_write_close();

    if($result->num_rows ==1 && $_SESSION['role']=='student'){
        header("location:student.php");
    }else if($result->num_rows ==1 && $_SESSION['role']=='teacher'){
        header("location:teacher.php");
    }else if($result->num_rows ==1 && $_SESSION['role']=='admin'){
        header('location:admin.php');
    }else{
        $msg="username or passsword is incorrect..";
    }


}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Multi login system</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    
    <main>
        <section>
            <div class="container p-4">
                <div class="row justify-content-center">
                    <div class="col-lg-5 m-4 bg-light ">
                        <h3 class="text-center">Login system</h3>
                        <form action=" <?= $_SERVER['PHP_SELF'] ?> " method="post">
                            <div class="form-group">
                                <label for="username">username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group lead">
                                <label for="type">I am a :</label>
                                <input type="radio" name="usertype" value="student" required> &nbsp;Student |
                                <input type="radio" name="usertype" value="teacher" required> &nbsp; Teacher |
                                <input type="radio" name="usertype" value="admin" required> Admin
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-block bg-warning" name="login" value="Submit">
                            </div>
                            <h5 class="text-danger text-center"><?= $msg;  ?></h5>
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </main>
    
</body>
</html>