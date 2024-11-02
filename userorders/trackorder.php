<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>

    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .tracking-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        #order-info p {
            font-size: 14px;
            margin: 5px 0;
        }

        /* Progress bar container */
        .progress-bar-container {
            margin-top: 30px;
            position: relative;
            text-align: center;
        }

        .progress-bar {
            width: 100%;
            height: 10px;
            background-color: #ddd;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress {
            height: 100%;
            width: 0;
            background-color: #28a745;
            transition: width 0.4s ease;
        }

        .progress-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 12px;
            color: #333;
        }

        /* Confirm delivery button */
        button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            display: block;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="tracking-container">
        <h1>Order Tracking</h1>


        <div id="order-info">
            <p>Order Item ID: <span id="order-item-id"></span></p>
            <p>Status: <span id="order-status"></span></p>
        </div>


        <div class="progress-bar-container">
            <div class="progress-bar">
                <div class="progress" id="progress"></div>
            </div>
            <div class="progress-labels">
                <span>Order Placed</span>
                <span>Shipped</span>
            </div>
        </div>


        <button id="confirm-btn" style="display:none;" onclick="confirmOrder()">Confirm Delivery</button>
    </div>

    <script>

        function updateProgressBar(status) {
            const progress = document.getElementById('progress');
            const orderStatus = document.getElementById('order-status');
            orderStatus.textContent = status;

            if (status === 'pending') {
                progress.style.width = '50%';
            } else if (status === 'shiped') {
                progress.style.width = '100%';
                document.getElementById('confirm-btn').style.display = 'block';
            }
        }


        function getstatus() {
            const urlParams = new URLSearchParams(window.location.search);
            const orderItemId = urlParams.get('order_item_id');
            document.getElementById('order-item-id').innerHTML = orderItemId;
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `getorderstatus.php?order_item_id=${orderItemId}`, true);
            xhr.onload = function () {
                if (xhr.status === 200) {

                    let status = JSON.parse(xhr.responseText);
                    updateProgressBar(status);
                }
            }
            xhr.send();
        }

        window.onload = function () {
            getstatus();
        }

        function confirmOrder() {
            const urlParams = new URLSearchParams(window.location.search);
            const orderItemId = urlParams.get('order_item_id');
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `confirmorder.php?order_item_id=${orderItemId}`, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    window.location.href = "userorders.php";
                }
            }
            xhr.send();
        }




    </script>
</body>

</html>