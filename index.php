<?php 
session_start();
if (!$_SESSION["validated"]) {
    header("Location:login.php");
}

$_SESSION["next_question"] = true;

$total_score = 0;
$game_count = 0;

if ($_SESSION["next_question"]) {
    $firstNumber = rand(0,50);
    $secondNumber = rand(0,50);
    $switchCase = rand(0,1);
    $_SESSION["next_question"] = false;

    if ($switchCase == 0) {
        $operator = "+";
    } else {
        $operator = "-";
    }
}
if (isset($_POST['submit'])) {
    $firstNumber = $_POST['first_number'];
    $operator = $_POST['math_operator'];
    $secondNumber = $_POST['second_number'];
    $total_score = $_POST['score'];
    $game_count = $_POST['games'];
    if ($operator == "+") {
        $sumOrDifference = $firstNumber + $secondNumber;
    } else {
        $sumOrDifference = $firstNumber - $secondNumber;
    } 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST['answer'])&& $_POST['answer'] !== "0") {                
            $error = "Please enter a number";
        } else if (!is_numeric($_POST['answer'])) {
            $error = "You must enter a number for your answer.";
        } else if (trim($_POST['answer']) == $sumOrDifference){
            $correct = "Correct";
            $_SESSION["next_question"] = true;
            $firstNumber = rand(0,10);
            $secondNumber = rand(0,50);
            $switchCase = rand(0,1);
            if ($switchCase == 0) {
            $operator = "+";
        } else {
            $operator = "-";
        }
            $_SESSION["next_question"] = false;
            $total_score = $total_score + 1;
            $game_count = $game_count + 1;
        } else {
            $error = "INCORRECT, $firstNumber $operator $secondNumber is $sumOrDifference.";
            $_SESSION["next_question"] = true;
            $firstNumber = rand(0,50);
            $secondNumber = rand(0,50);
            $switchCase = rand(0,1);
            if ($switchCase == 0) {
            $operator = "+";
        } else {
            $operator = "-";
        }
            $_SESSION["next_question"] = false;
            $game_count = $game_count + 1;
        }  
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
    <form action="login.php" method="post">
        <button class="btn btn-sm btn-default col-xs-offset-9" name="logout">Logout</button>
    </form>
    <header>
        <div class="col-xs-offset-5">
        <h1>Math Game</h1>
        </div>
    </header>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <div class="col-xs-offset-4 col-xs-2">
                <label><?php echo $firstNumber; ?></label>
            </div>
            <div class="col-xs-2">
                <label><?php echo $operator; ?></label>
            </div>  
            <div class="col-xs-offset-1">
                <label><?php echo $secondNumber; ?></label><br />
            </div>    
        </div> 
        <input type="hidden" name="first_number" value="<?php echo $firstNumber; ?>"/> 
        <input type="hidden" name="math_operator" value="<?php echo $operator; ?>"/> 
        <input type="hidden" name="second_number" value="<?php echo $secondNumber; ?>"/>
        <input type="hidden" name="model_answer" value="<?php echo $sumOrDifference; ?>"/>
        <input type="hidden" name="score" value="<?php echo $total_score; ?>"/>
        <input type="hidden" name="games" value="<?php echo $game_count; ?>"/>
        <div class="form-group">
            <div class="row">
                <div class="col-xs-offset-5 col-xs-3">        
                    <input class="form-control" type="text" name="answer" placeholder="Enter answer"/>
                </div>
            </div> 
            <div class="row">
                <div class="col-xs-offset-5 col-xs-3" id="submit">
                    <input class="btn btn-sm btn-primary" type="submit" name="submit"/> 
                </div>
            </div>
        </div>
        <hr />
        <footer>
        <div class="form-group">
            <div class="row">
                <div class="col-xs-offset-5 col-xs-3">
                <span class="error2"><?php echo $error; ?></span><br />
                <span class="correct"><?php echo $correct; ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-offset-5 col-xs-3">
                <label>Score: <?php echo $total_score; ?> / <?php echo $game_count; ?></label>
                </div>
            </div>
        </div>
        </footer>
    </form>
</body>
</html>