<?php session_start();

$_SESSION["validated"]=false;

$error = "";

if (isset($_POST['submit'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST['username']) || empty($_POST['password'])) {
            $error = "Invalid login credentials.";
        } 
    }

    $_SESSION["validated"] = false;

    $login = file("./Credentials.config");
    for ($i=0; $i<count($login); ++$i) {
        $loginInfo = explode(",", $login[$i]);

        if (trim($_POST['username']) == trim($loginInfo[0]) && trim($_POST['password']) === trim($loginInfo[1])) { 
            $_SESSION["validated"] = true;
        }
    }

    if ($_SESSION["validated"]) {
        header("Location:index.php");   
    } else {
        $error = "Invalid login credentials.";   
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Math Game</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>
    <header>
        <h1 class="col-xs-offset-3">Please login to enjoy our Math Game.</h1>
    </header>
        <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="form-group">  
                      <label class="col-xs-offset-4 col-xs-1" for="email">Email:</label>
                        <div class="col-xs-3">
                        <input type="text" class="form-control" id="email" name="username" placeholder="Email">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-xs-offset-4 col-xs-1" for="password">Password:</label>
                      <div class="col-xs-3">
                        <input type="text" class="form-control" id="password" name="password" placeholder="Password">
                      </div>
                    </div>
                    <div class="col-xs-offset-5 col-xs-3">
                       <input class="btn btn-sm btn-primary" id="button1" type="submit" name ="submit" value="Login">
                    </div>
                    <div class="col-xs-offset-5 col-xs-3">
                        <span class="error1"><?php echo $error; ?></span>
                    </div>
        </form>
</body>    
</html>