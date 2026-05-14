<?php

session_start();

$conn = new mysqli("localhost", "root", "", "ipl_akinator");

if ($conn->connect_error) {
    die("Database Connection Failed");
}



// QUESTIONS DATABASE

$questions = [

    [
        "question" => "Is your player Indian?",
        "field" => "nationality",
        "value" => "Indian"
    ],

    [
        "question" => "Is your player an overseas player?",
        "field" => "nationality",
        "value" => "Overseas"
    ],

    [
        "question" => "Is your player primarily a batsman?",
        "field" => "role",
        "value" => "Batsman"
    ],

    [
        "question" => "Is your player primarily a bowler?",
        "field" => "role",
        "value" => "Bowler"
    ],

    [
        "question" => "Is your player an all-rounder?",
        "field" => "role",
        "value" => "All-rounder"
    ],

    [
        "question" => "Is your player a wicketkeeper?",
        "field" => "role",
        "value" => "WK"
    ],

    [
        "question" => "Has your player captained an IPL team?",
        "field" => "is_captain",
        "value" => 1
    ],

    [
        "question" => "Has your player won Orange Cap?",
        "field" => "has_orange_cap",
        "value" => 1
    ]

];



// START GAME

if (isset($_POST['start_game'])) {

    $_SESSION['question_no'] = 0;
    $_SESSION['answers'] = [];
    $_SESSION['used_questions'] = [];

    askQuestion();
    exit;
}



// HANDLE ANSWERS

if (isset($_POST['answer'])) {

    $_SESSION['answers'][$_SESSION['question_no']] = $_POST['answer'];

    $_SESSION['question_no']++;

    if ($_SESSION['question_no'] >= 8) {

        makeGuess();
        exit;
    }

    makeGuess(true);
    exit;
}





// ASK QUESTION

function askQuestion()
{
    global $questions;

    $index = $_SESSION['question_no'];

    $q = $questions[$index];

?>

<!DOCTYPE html>
<html>

<head>

<title>IPL AI Engine</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial;
}

body{
background:linear-gradient(135deg,#0f172a,#1e293b);
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
padding:20px;
color:white;
}

.box{
width:100%;
max-width:850px;
background:#111827;
padding:45px;
border-radius:25px;
box-shadow:0 0 25px rgba(0,0,0,0.5);
text-align:center;
}

.progress{
margin-bottom:20px;
font-size:18px;
color:#94a3b8;
}

h1{
color:#38bdf8;
margin-bottom:20px;
}

.question{
font-size:36px;
line-height:1.5;
margin-bottom:35px;
}

.btn{
padding:16px 30px;
border:none;
border-radius:12px;
cursor:pointer;
font-size:18px;
font-weight:bold;
margin:10px;
transition:0.3s;
}

.yes{
background:#22c55e;
color:white;
}

.no{
background:#ef4444;
color:white;
}

.maybe{
background:#f59e0b;
color:white;
}

.dont{
background:#64748b;
color:white;
}

.btn:hover{
transform:scale(1.05);
}

.ai{
margin-top:20px;
font-size:17px;
color:#cbd5e1;
}

</style>

</head>

<body>

<div class="box">

<div class="progress">

Question <?php echo ($index + 1); ?> / 8

</div>

<h1>🤖 IPL AI Reasoning Engine</h1>

<div class="question">

<?php echo $q['question']; ?>

</div>

<form method="POST">

<button class="btn yes" type="submit" name="answer" value="yes">
YES
</button>

<button class="btn no" type="submit" name="answer" value="no">
NO
</button>

<button class="btn maybe" type="submit" name="answer" value="maybe">
MAYBE
</button>

<button class="btn dont" type="submit" name="answer" value="dontknow">
DON'T KNOW
</button>

</form>

<div class="ai">

AI is dynamically reducing uncertainty using probabilistic reasoning...

</div>

</div>

</body>
</html>

<?php
}





// AI GUESS ENGINE

function makeGuess($continue = false)
{
    global $conn, $questions;

    $players = $conn->query("SELECT * FROM players");

    $bestPlayer = null;
    $highestScore = 0;

    while ($player = $players->fetch_assoc()) {

        $score = 0;

        foreach ($_SESSION['answers'] as $index => $answer) {

            if (!isset($questions[$index])) {
                continue;
            }

            $field = $questions[$index]['field'];
            $value = $questions[$index]['value'];

            if ($answer == "yes") {

                if ($player[$field] == $value) {
                    $score += 20;
                }

            } elseif ($answer == "no") {

                if ($player[$field] != $value) {
                    $score += 20;
                }

            } elseif ($answer == "maybe") {

                $score += 10;

            } elseif ($answer == "dontknow") {

                $score += 5;
            }
        }

        if ($score > $highestScore) {

            $highestScore = $score;
            $bestPlayer = $player;
        }
    }

    $confidence = min(100, $highestScore);

    if ($confidence >= 80 || $_SESSION['question_no'] >= 7) {

        showResult($bestPlayer, $confidence);

    } else {

        askQuestion();
    }
}





// FINAL RESULT

function showResult($player, $confidence)
{

$image = $player['image_url'];

if (empty($image)) {

$image = "https://cdn-icons-png.flaticon.com/512/149/149071.png";

}

?>

<!DOCTYPE html>
<html>

<head>

<title>AI Final Guess</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial;
}

body{
background:linear-gradient(135deg,#0f172a,#1e293b);
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
padding:20px;
color:white;
}

.card{
width:100%;
max-width:650px;
background:#111827;
padding:45px;
border-radius:25px;
text-align:center;
box-shadow:0 0 25px rgba(0,0,0,0.5);
}

img{
width:240px;
height:240px;
border-radius:50%;
object-fit:cover;
border:5px solid #38bdf8;
margin-bottom:20px;
background:white;
}

h1{
color:#38bdf8;
margin-bottom:20px;
}

h2{
font-size:36px;
margin-bottom:20px;
}

p{
font-size:20px;
margin-bottom:10px;
}

.confidence{
margin-top:20px;
font-size:26px;
font-weight:bold;
color:#22c55e;
}

.play{
margin-top:30px;
padding:16px 35px;
border:none;
border-radius:12px;
background:#38bdf8;
color:black;
font-size:20px;
font-weight:bold;
cursor:pointer;
transition:0.3s;
}

.play:hover{
transform:scale(1.05);
}

.ai-text{
margin-top:25px;
color:#cbd5e1;
line-height:1.7;
}

</style>

</head>

<body>

<div class="card">

<h1>🎯 AI Final Prediction</h1>

<img 
src="<?php echo htmlspecialchars($image); ?>" 

onerror="this.onerror=null;
this.src='https://cdn-icons-png.flaticon.com/512/3135/3135715.png';"

alt="IPL Player">

<h2>

<?php echo $player['name']; ?>

</h2>

<p>

<strong>Role:</strong>
<?php echo $player['role']; ?>

</p>

<p>

<strong>Nationality:</strong>
<?php echo $player['nationality']; ?>

</p>

<p>

<strong>Captain:</strong>

<?php echo ($player['is_captain']) ? "Yes" : "No"; ?>

</p>

<div class="confidence">

AI Confidence Score :
<?php echo $confidence; ?>%

</div>

<div class="ai-text">

The AI engine dynamically reduced the player candidate pool
using adaptive questioning and probability-based reasoning.

</div>

<form action="index.php" method="POST">

<button class="play" type="submit">

🔄 Play Again

</button>

</form>

</div>

</body>
</html>

<?php

}
?>