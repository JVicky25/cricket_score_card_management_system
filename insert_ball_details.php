<?php
if (isset($_POST['continuation']) && $_POST['continuation'] === 'true') {
    $con = mysqli_connect("localhost", "root", "", "cricket_match");

    $match_no = $_POST['match_no'];
    $ball_no = $_POST['ball_id'];
    $batsman = $_POST['batsman_id'];
    $bowler = $_POST['bowler_id'];
    $run = $_POST['runs'];
    $wicket = $_POST['wicket'];
    $batting_team = $_POST['battingteam_id'];
    $bowling_team = $_POST['bowlingteam_id'];

    // Prepare and execute a query to fetch the table name
    $query = "SELECT name FROM match_detail WHERE match_id = $match_no";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Error fetching table name: " . mysqli_error($con));
    }

    // Fetch the table name from the query result
    $row = mysqli_fetch_assoc($result);
    $table_name = $row['name'];

    // Construct the INSERT query
    $sql = "INSERT INTO `$table_name` (ball_id, batsman_id, bowler_id, runs, wicket, battingteam_id, bowlingteam_id)
            VALUES ('$ball_no', '$batsman', '$bowler', '$run', '$wicket', '$batting_team', '$bowling_team')";

    $rs = mysqli_query($con, $sql);
    

}
?>
<!-- Rest of your HTML form -->


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>INSERT</title>
    <style>
        body {
    font-family: Arial, Helvetica, sans-serif;
    text-align: center;
    background-image: url('insert.webp');
    background-size: cover; /* This will make the background image cover the entire viewport */
    background-repeat: no-repeat; /* Prevent the background image from repeating */
    background-attachment: fixed; /* Fix the background image in place */
    color : black ;
    font-weight : bold;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }

        .button-container button {
            flex: 1;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .button-container button:nth-child(1) {
            background-color: #04AA6D;
            color: white;
            margin-right: 10px;
        }

        .button-container button:nth-child(2) {
            background-color: #f44336;
            color: white;
        }

        button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <h2>INSERT</h2>
    <form action="insert_ball_details.php" method="post">
        <label for="match_no">Match No :</label>
        <input type="number" id="match_no" name="match_no" required min="1" max="48">

        <label for="ball_id">Ball No:</label>
        <input type="number" id="ball_id" name="ball_id" required>

        <label for="batsman_id">Batsman ID:</label>
        <input type="number" id="batsman_id" name="batsman_id" required min="1" max="33">
        
        <label for="bowler_id">Bowler ID:</label>
        <input type="number" id="bowler_id" name="bowler_id" required min="1" max="33">
        
        <label for="runs">Runs:</label>
        <input type="number" id="runs" name="runs" required>
        
        <label for="wicket">Wicket:</label>
        <input type="number" id="wicket" name="wicket" required min="0" max="1">
        
        <label for="battingteam_id">Batting Team ID:</label>
        <input type="number" id="battingteam_id" name="battingteam_id" required min="1" max="3">
        
        <label for="bowlingteam_id">Bowling Team ID:</label>
        <input type="number" id="bowlingteam_id" name="bowlingteam_id" required min="1" max="3">

        <!-- Hidden field to indicate continuation -->
        <input type="hidden" name="continuation" value="true">
        
        <div class="button-container">
            <button type="submit">Continue Insertion</button>
            <button type="button" onclick="window.location.href='home_page.html'">Return to Home Page</button>
        </div>
    </form>
</body>
</html>
