<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>IPL AI Akinator</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial,sans-serif;
        }

        body{
            background:linear-gradient(135deg,#0f172a,#1e293b);
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            color:white;
            padding:20px;
        }

        .container{
            width:100%;
            max-width:750px;
            background:#111827;
            padding:45px;
            border-radius:20px;
            text-align:center;
            box-shadow:0 0 30px rgba(0,0,0,0.5);
        }

        h1{
            font-size:45px;
            color:#38bdf8;
            margin-bottom:20px;
        }

        p{
            font-size:20px;
            line-height:1.8;
            color:#cbd5e1;
        }

        .start-btn{
            margin-top:30px;
            background:#38bdf8;
            color:black;
            border:none;
            padding:18px 40px;
            border-radius:12px;
            font-size:22px;
            font-weight:bold;
            cursor:pointer;
            transition:0.3s;
        }

        .start-btn:hover{
            transform:scale(1.05);
            background:#0ea5e9;
        }

        .features{
            margin-top:40px;
            text-align:left;
        }

        .features h2{
            color:#38bdf8;
            margin-bottom:15px;
        }

        .features ul{
            padding-left:20px;
        }

        .features li{
            margin-bottom:12px;
            font-size:18px;
            color:#e2e8f0;
        }

        .footer{
            margin-top:35px;
            color:#94a3b8;
            font-size:15px;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>🏏 IPL AI Akinator</h1>

    <p>
        Think of any IPL Player.<br><br>

        AI will ask smart adaptive questions
        and guess your player intelligently.
    </p>

    <form action="engine.php" method="POST">

        <button type="submit"
                name="start_game"
                class="start-btn">

            Start Game

        </button>

    </form>

    <div class="features">

        <h2>✨ Features</h2>

        <ul>

            <li>✔ AI Adaptive Questioning</li>

            <li>✔ Dynamic Candidate Filtering</li>

            <li>✔ Probability Based Guessing</li>

            <li>✔ Modern Responsive UI</li>

            <li>✔ IPL Player Database</li>

            <li>✔ Intelligent Elimination Engine</li>

        </ul>

    </div>

    <div class="footer">
        By: CHANDAN KUMAR (IT ENGINEER) <BR>
        Built using PHP + MySQL

    </div>

</div>

</body>
</html>