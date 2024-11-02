<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Not approved</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            background-color: aliceblue;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            margin-top: 5%;
            margin-left: 25%;
            margin-right: 25%;
            border-style: solid;
            border-width: 1px;
            border-radius: 8px;
            height: 300px;
            width: 600px;
        }

        h1 {
            color: red;
            font-weight: bold;
        }

        button {
            background-color: greenyellow;

            padding: 15px;
            margin-top: 20px;
            border-style: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;

        }

        .note {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>You Are Not approved Yet</h1>
        <p>This can take two to five date to get approved from our adimin</p>
        <p class="note">If you have any problem contact our coustomer service</p>
        <a href="../Home/dashbord.php"><button>Go To Home</button></a>
    </div>

</body>

</html>