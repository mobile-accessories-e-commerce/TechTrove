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
        header{
            background-color: white;
           text-align: center;
            
        }

        .container {
            background-image: url(../images/approve.jpg);
            width: 100%;
            height: 75vh;
            position: relative;
           
           
            
           
            
            

            /* background-color: aliceblue;
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
            width: 600px; */
        }

        .top-text {
            color: white;
            text-align: center;
            font-size: 50px;
            padding-top: 80px;
        }
        .approve-text{
            color: red;
            font-size: 40px;
            padding-bottom: 0;
        }
        .txt{
            padding-top: 0;
            margin-bottom: 5px;
        }
        .note{
            padding-top: 5px;
            padding-bottom: 5px;
            font-weight: bold;
        }
        .approve-msg {
           
            background: rgba(255, 255, 255, 0.2); 
            backdrop-filter: blur(10px);
            padding: 20px 40px;
            border-radius: 10px;
            max-width: 100vw;
           height: 50%
            color: #fff; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
            display:flex;
            align-items:center;
            flex-direction:column;
            

            
        }

        button {
            background-color: black;
            color: white;
            padding: 15px;
            margin-top: 20px;
            border-style: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            width: 500px;
            font-size: 15px;

        }

        
    </style>
</head>

<body>
    <header><img src="../images/elife_logo.png" width="140" height="70" alt="Logo"></header>

    <div class="container">
       
        <div class="approve-msg">
            <h1 class="approve-text">You Are Not approved Yet</h1>
            <p class="txt">It may take a while to verify your account</p>
            <p class="note">If you have any problem contact our coustomer service</p>
            <a href="../Home/dashbord.php"><button>Go To Home</button></a>
        </div>
        <h1 class="top-text">Build Your Online Business With eLife</h1>
        
    </div>

</body>

</html>