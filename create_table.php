<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>CREATE TABLE FOR THE NEW MATCH</title>
<style>
body {
    font-family: Arial, Helvetica, sans-serif;
    text-align: center;
    background-image: url('create.webp');
    background-size: cover; /* This will make the background image cover the entire viewport */
    background-repeat: no-repeat; /* Prevent the background image from repeating */
    background-attachment: fixed; /* Fix the background image in place */
}

h2 {
    text-align: center;
    color: white; /* Set text color to white */
}

.container {
    max-width: 500px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: rgba(255, 255, 255, 0.8); /* Add a semi-transparent white background */
}

label {
    font-weight: bold;
    display: block;
    margin-bottom: 10px;
    color: black; /* Set text color to white */
}

select,
input[type="number"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    color: #333; /* Set text color to a readable color */
}

button {
    background-color: #04AA6D;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}

.cancelbtn {
    background-color: #f44336;
}

.message {
    text-align: center;
    font-weight: bold;
    font-size: 24px;
    margin-top: 20px;
    color: white; /* Set text color to white */
}

.error-message {
    color: #f44336;
}
</style>
</head>
<body>
<h2>CREATE TABLE FOR THE NEW MATCH</h2>

<form action="" method="post">

  <div class="container">
    <label for="Team1name"><b>Team 1 Name</b></label>
    <br>
    <select name="Team1name" id="Team1name">
      <option value="">--Select the Team 1 name--</option>
      <option value="india">india</option>
      <option value="pakistan">pakistan</option>
      <option value="australia">australia</option>
    </select>
    <br>

    <label for="Team2name"><b>Team 2 Name</b></label>
    <br>
    <select name="Team2name" id="Team2name">
      <option value="">--Select the Team 2 name--</option>
      <option value="india">india</option>
      <option value="pakistan">pakistan</option>
      <option value="australia">australia</option>
    </select>
    <br>
<label for="match_id">Match No</label>
<input type="number" id="match_id" name="match_id" required min="1" max="48">



    <label for="stage"><b>STAGE OF THE TOURNAMENT</b></label>
    <br>
    <select name="stage" id="stage">
      <option value="">--Select the stage of tournament--</option>
      <option value="league">league</option>
      <option value="semifinal1">semifinal1</option>
      <option value="semifinal2">semifinal2</option>
      <option value="final">final</option>
    </select>
    <br>
        
    <button type="submit" name="createTable">CREATE TABLE</button>

  </div>

</form>

<?php
if (isset($_POST['createTable'])) {
    $con = mysqli_connect("localhost", "root", "", "cricket_match");

    $team1name = $_POST['Team1name'];
    $team2name = $_POST['Team2name'];
    $stage = $_POST['stage'];
    $match_no = $_POST['match_id'];

    // Query to fetch team_id for Team 1
    $q1 = "SELECT team_id FROM teams WHERE team_name='$team1name'";
    $result1 = mysqli_query($con, $q1);
    $row1 = mysqli_fetch_assoc($result1);
    $team1_id = $row1['team_id'];

    // Query to fetch team_id for Team 2
    $q2 = "SELECT team_id FROM teams WHERE team_name='$team2name'";
    $result2 = mysqli_query($con, $q2);
    $row2 = mysqli_fetch_assoc($result2);
    $team2_id = $row2['team_id'];

    // Table name format: team1name_vs_team2name_stage
    $table_name = $team1name . "_vs_" . $team2name . "_" . $stage;

    // SQL statement to create the table
    $sql = "CREATE TABLE `$table_name` (
        ball_id INT PRIMARY KEY,
        batsman_id INT,
        bowler_id INT,
        runs INT,
        wicket INT,
        battingteam_id INT,
        bowlingteam_id INT,
        FOREIGN KEY (batsman_id) REFERENCES players(Player_id),
        FOREIGN KEY (bowler_id) REFERENCES players(Player_id),
        FOREIGN KEY (battingteam_id) REFERENCES teams(Team_id),
        FOREIGN KEY (bowlingteam_id) REFERENCES teams(Team_id)
    )";

    $rs = mysqli_query($con, $sql);

    // Insert match details into the match_detail table
    $sql = "INSERT INTO `match_detail` (match_id, name, team1_name, team2_name, team1_id, team2_id) 
            VALUES ('$match_no', '$table_name', '$team1name', '$team2name', '$team1_id', '$team2_id')";

    $rs = mysqli_query($con, $sql);

    if ($rs) {
        echo '<div class="message">Table created successfully!</div>';
    } else {
        echo '<div class="message error-message">Error creating table: ' . mysqli_error;
}
}
?>
</body>
</html>
