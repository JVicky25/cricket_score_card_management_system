<!DOCTYPE html>
<html>
<head>
    <title>Display Database Table</title>
    <style>
        body {
            background-image: url('update.avif');
            background-size: cover; /* Adjust as needed */
            background-repeat: no-repeat;
            background-attachment: fixed;
            color : black;
            nt-weight: bold;
        }
        .team-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            text-align: right;
            font-weight: bold;
        }
        .team-card {
            flex: 0 0 48%; /* Adjust the width as needed */
            border: 1px solid #000;
            padding: 10px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            font-weight: bold; /* Make the text bolder */
        }
        h2 {
            text-align: center; /* Center-align the content within <h2> */
        }
    </style>
</head>
<body>

<h2>SCORE CARD</h2>

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "cricket_match";

$con = mysqli_connect($servername, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to retrieve team names
function getTeamName($conn, $teamId) {
    $sql = "SELECT team_name FROM teams WHERE team_id = $teamId";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error executing the query: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row["team_name"];
    } else {
        return "Team not found";
    }
}

$matchNo = $_POST["match_no"];
$q1 = "SELECT team1_id, team2_id, name FROM match_detail WHERE match_id='$matchNo'";
$result1 = mysqli_query($con, $q1);
$row = mysqli_fetch_assoc($result1);
$team1_id = $row['team1_id'];
$team2_id = $row['team2_id'];
$match_name = $row['name'];

$team1_name = getTeamName($con, $team1_id);
$team2_name = getTeamName($con, $team2_id);

$q1 = "SELECT team1_id, team2_id, name FROM match_detail WHERE match_id='$matchNo'";
$result1 = mysqli_query($con, $q1);
$row = mysqli_fetch_assoc($result1);
$team1_id = $row['team1_id'];
$team2_id = $row['team2_id'];
$match_name = $row['name'];

// Function to generate batting card HTML
function generateBattingCard($con, $table_name, $team_id) {
    $sql = "SELECT b.batsman_id, p.player_name, SUM(b.runs) AS total_runs, COUNT(b.batsman_id) AS total_balls_faced
            FROM $table_name b
            INNER JOIN players p ON b.batsman_id = p.player_id
            WHERE b.battingteam_id = $team_id
            GROUP BY b.batsman_id, p.player_name";

    $result = mysqli_query($con, $sql);
    $batting_card = '<table>';
    $batting_card .= '<tr><th>Name</th><th>Total Runs</th><th>Total Balls Faced</th></tr>';
    
    $total_runs = 0; // Initialize total runs
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $batting_card .= "<tr>";
            $batting_card .= "<td>" . $row["player_name"] . "</td>";
            $batting_card .= "<td>" . $row["total_runs"] . "</td>";
            $batting_card .= "<td>" . $row["total_balls_faced"] . "</td>";
            $batting_card .= "</tr>";
            
            // Update total runs
            $total_runs += $row["total_runs"];
        }
    } else {
        $batting_card .= "<tr><td colspan='3'>No data found</td></tr>";
    }
    $batting_card .= '</table>';
    
    // Display total runs
    $batting_card .= "<div>Total Runs: $total_runs</div>";
    
    return $batting_card;
}


// Function to generate bowling card HTML with total overs bowled
function generateBowlingCard($con, $table_name, $team_id) {
    $sql = "SELECT b.bowler_id, p.player_name, SUM(b.wicket) AS total_wickets, SUM(b.runs) AS total_runs_conceded,
            count(b.ball_id) AS total_balls_bowled
            FROM $table_name b
            INNER JOIN players p ON b.bowler_id = p.player_id
            WHERE b.bowlingteam_id = $team_id
            GROUP BY b.bowler_id, p.player_name";

    $result = mysqli_query($con, $sql);

    if (!$result) {
        die("Error executing the query: " . mysqli_error($con));
    }

    $bowling_card = '<table>';
    $bowling_card .= '<tr><th>Name</th><th>Total Wickets</th><th>Total Runs Conceded</th><th>Total Overs Bowled</th></tr>';
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $total_overs_bowled = floor($row["total_balls_bowled"] / 6) . '.' . ($row["total_balls_bowled"] % 6);
            $bowling_card .= "<tr>";
            $bowling_card .= "<td>" . $row["player_name"] . "</td>";
            $bowling_card .= "<td>" . $row["total_wickets"] . "</td>";
            $bowling_card .= "<td>" . $row["total_runs_conceded"] . "</td>";
            $bowling_card .= "<td>" . $total_overs_bowled . "</td>";
            $bowling_card .= "</tr>";
        }
    } else {
        $bowling_card .= "<tr><td colspan='4'>No data found</td></tr>";
    }
    $bowling_card .= '</table>';
    return $bowling_card;
}



$team1_batting_card = generateBattingCard($con, $match_name, $team1_id);
$team2_batting_card = generateBattingCard($con, $match_name, $team2_id);
$team1_bowling_card = generateBowlingCard($con, $match_name, $team1_id);
$team2_bowling_card = generateBowlingCard($con, $match_name, $team2_id);

mysqli_close($con);
?>

<div class="team-container">
    <div class="team-card">
        <h3><?php echo $team1_name; ?> - Batting Card</h3>
        <?php echo $team1_batting_card; ?>
    </div>
    <div class="team-card">
        <h3><?php echo $team2_name; ?> - Batting Card</h3>
        <?php echo $team2_batting_card; ?>
    </div>
</div>


<div class="team-container">
    <div class="team-card">
        <h3><?php echo $team1_name; ?> - Bowling Card</h3>
        <?php echo $team1_bowling_card; ?>
    </div>
    <div class="team-card">
        <h3><?php echo $team2_name; ?> - Bowling Card</h3>
        <?php echo $team2_bowling_card; ?>
    </div>
</div>

</body>
</html>
