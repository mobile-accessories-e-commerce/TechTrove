<?php
include "../connect.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $service_id = $_GET['id']; // Service ID

    // Query to get Total Requests, View Count, and Location for the given service
    $sql = "
        SELECT 
            s.service_id,
            s.view_count,
            s.location AS service_location,
            COUNT(sr.id) AS total_requests
        FROM services s
        LEFT JOIN service_requests sr ON s.service_id = sr.service_id
        WHERE s.service_id = $service_id
        GROUP BY s.service_id
    ";

    $result = mysqli_query($con, $sql);
    $report_data = mysqli_fetch_assoc($result);

    // Handling cases when no data is found (NULL or empty results)
    $total_requests = $report_data['total_requests'] ?? 0;
    $view_count = $report_data['view_count'] ?? 0;
    $service_location = $report_data['service_location'] ?? 'No location provided';

    // If no data is found for the given service, display a message
    if (!$report_data) {
        $message = "No data available for this Service ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #007BFF;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e2f1ff;
        }
        .action-btn {
            background-color: #007BFF;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .action-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2>Service Report for Service ID: <?php echo $service_id; ?></h2>

<?php if (isset($message)): ?>
    <p style="color: red;"><?php echo $message; ?></p>
<?php else: ?>
    <!-- Table displaying the service report data -->
    <table>
        <thead>
            <tr>
                <th>Metric</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Requests</td>
                <td><?php echo $total_requests; ?></td>
            </tr>
            <tr>
                <td>View Count</td>
                <td><?php echo $view_count; ?></td>
            </tr>
            <tr>
                <td>Service Location</td>
                <td><?php echo $service_location; ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Button to trigger the download -->
    <button class="action-btn" onclick="window.print()">Download Report</button>
<?php endif; ?>

</body>
</html>
