<?php
if (isset($_POST['continuation']) && $_POST['continuation'] === 'true') {
    $con = mysqli_connect("localhost", "root", "", "cricket_match");

    $match_no = $_POST['match_no'];
    $ball_no = $_POST['ball_id'];

    // Prepare and execute a query to fetch the table name
    $query = "SELECT name FROM match_detail WHERE match_id = $match_no";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Error fetching table name: " . mysqli_error($con));
    }

    // Fetch the table name from the query result
    $row = mysqli_fetch_assoc($result);
    $table_name = $row['name'];

    // Construct the DELETE query
    $sql ="DELETE FROM $table_name WHERE ball_id=$ball_no";

    $rs = mysqli_query($con, $sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>DELETE</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-image: url('delete.webp'); /* Replace 'delete.jpg' with your image file */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed; /* Fixed background position */
            background-color: rgba(255, 255, 255, 0.8); /* Add a semi-transparent white background color */
            color: white;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent black background */
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
            box-sizing: border-box;
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

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>DELETE</h2>
    <form action="delete.php" method="post" onsubmit="return confirmDelete();">
        <label for="match_no">Match No :</label>
        <input type="number" id="match_no" name="match_no" required min="1" max="48" placeholder="Enter Match Number">

        <label for="ball_id">Ball No:</label>
        <input type="number" id="ball_id" name="ball_id" required placeholder="Enter Ball Number">

        <input type="hidden" name="continuation" value="true">

        <div class="button-container">
            <button type="submit">Delete</button>
            <button type="button" onclick="window.location.href='home_page.html'">Return to Home Page</button>
        </div>
    </form>

    <script>
        function confirmDelete() {
            var confirmation = window.confirm("Are you sure you want to delete this record?");
            return confirmation; // Return true if the user confirms, false if they cancel
        }
    </script>
</body>
</html>
