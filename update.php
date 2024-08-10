<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>UPDATE</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-image: url('update.webp'); /* Replace 'background.jpg' with your image file */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed; /* Fixed background position */
            background-color: rgba(255, 255, 255, 0.8); /* Add a semi-transparent white background color */
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        h2 {
            text-align: center;
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
    <form action="update.php" method="post">
        <h2>UPDATE</h2>
        <label for="match_no">Match No :</label>
        <input type="number" id="match_no" name="match_no" required min="1" max="48">

        <label for="ball_id">Ball No:</label>
        <input type="number" id="ball_id" name="ball_id" required>

        <label for="feature"><b>FEATURE TO BE UPDATED</b></label>
    <br>
    <select name="feature" id="stage">
      <option value="">--Select the feature--</option>
      <option value="batsman_id">BATSMAN ID</option>
      <option value="bowler_id">BOWLER ID</option>
      <option value="runs">RUNS</option>
      <option value="wicket">WICKET</option>
      <option value="battingteam_id">BATTING TEAM ID</option>
      <option value="bowlingteam_id">BOWLING TEAM ID</option>
    </select>
    <br>
    <label for="feature_value">Value :</label>
    <input type="number" id="feature _value" name="feature_value" required>


        <input type="hidden" name="continuation" value="true">
        
        <div class="button-container">
            <button type="submit">Update</button>
            <button type="button" onclick="window.location.href='home_page.html'">Return to Home Page</button>
        </div>
    </form>
<?php
if (isset($_POST['continuation'])) {
    // Check if the form was submitted

    $con = mysqli_connect("localhost", "root", "", "cricket_match");

    $match = $_POST['match_no'];
    $ball = $_POST['ball_id'];
    $feature = $_POST['feature'];
    $value = $_POST['feature_value'];

    // Query to fetch table name based on match_id
    $q1 = "SELECT name FROM match_detail WHERE match_id='$match'";
    $result1 = mysqli_query($con, $q1);
    $row1 = mysqli_fetch_assoc($result1);
    $table_name = $row1['name'];

    // SQL statement to update the table
    $sql = "UPDATE $table_name SET $feature=$value WHERE ball_id=$ball";
    
    if (mysqli_query($con, $sql)) {
        echo "Update successful!";
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>

</body>
</html>
