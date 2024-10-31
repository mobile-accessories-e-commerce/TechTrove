<?php
include "../connect.php";

$item_id = $_GET['item_id'];
$erro = 0;

session_start();
if (!isset($_SESSION['userid'])) {
    die('You must be logged in to rate a product.');
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .rating-container {
            background-color: #fff;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .star-rating {
            direction: rtl;
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            font-size: 2.5em;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
            padding: 0 5px;
        }

        .star-rating input:checked~label {
            color: #f5b301;
        }

        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #f5b301;
        }

        label {
            font-size: 1.2em;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1em;
            resize: vertical;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            background-color: #4CAF50;
            color: white;
            font-size: 1.2em;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <?php if ($erro): ?>
        <h1>You Can not rewiew This product again</h1>
        <a href="userorders.php"><button>Go Back</button></a>
    <?php else: ?>
        <div class="rating-container">
            <h2>Rate and Review Product #<?php echo $item_id; ?></h2>

            <!-- Rating Form -->
            <form action="submit_rating.php" method="POST">
                <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">

                <label for="rating">Your Rating:</label>
                <div class="star-rating">
                    <input type="radio" name="rating" id="rating-5" value="5">
                    <label for="rating-5">&#9733;</label>
                    <input type="radio" name="rating" id="rating-4" value="4">
                    <label for="rating-4">&#9733;</label>
                    <input type="radio" name="rating" id="rating-3" value="3">
                    <label for="rating-3">&#9733;</label>
                    <input type="radio" name="rating" id="rating-2" value="2">
                    <label for="rating-2">&#9733;</label>
                    <input type="radio" name="rating" id="rating-1" value="1">
                    <label for="rating-1">&#9733;</label>
                </div>

                <label for="review">Your Review:</label>
                <textarea name="review" id="review" rows="4" placeholder="Write your review here..."></textarea>

                <br><br>

                <input type="submit" value="Submit Rating">
            </form>
        </div>

    <?php endif; ?>
</body>

</html>