<?php
include "../connect.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id']; // Service Provider ID

    // Query to calculate total services, total customers, pending requests, and completed requests for a service provider
    $sql = "
        SELECT 
            sp.service_provider_id,
            COUNT(s.service_id) AS total_services,
            COUNT(DISTINCT sr.user_id) AS total_customers,
            SUM(CASE WHEN sr.accept = 0 THEN 1 ELSE 0 END) AS pending_requests,
            SUM(CASE WHEN sr.accept = 1 THEN 1 ELSE 0 END) AS completed_requests
        FROM services s
        LEFT JOIN service_requests sr ON s.service_id = sr.service_id
        LEFT JOIN service_providers sp ON s.service_provider_id = sp.service_provider_id
        WHERE sp.service_provider_id = $id
        GROUP BY sp.service_provider_id
    ";

    $result = mysqli_query($con, $sql);
    $report_data = mysqli_fetch_assoc($result);

    // Handling cases when the query returns no results (NULL or 0)
    $total_services = $report_data['total_services'] ?? 0;
    $total_customers = $report_data['total_customers'] ?? 0;
    $pending_requests = $report_data['pending_requests'] ?? 0;
    $completed_requests = $report_data['completed_requests'] ?? 0;

    // If no report data exists for the given ID, display a message.
    if (!$report_data) {
        $message = "No data available for this Service Provider ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Provider Report</title>
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

<h2>Service Provider Report for ID: <?php echo $id; ?></h2>

<?php if (isset($message)): ?>
    <p style="color: red;"><?php echo $message; ?></p>
<?php else: ?>
    <!-- Table displaying the service provider report data -->
    <table>
        <thead>
            <tr>
                <th>Metric</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Services</td>
                <td><?php echo $total_services; ?></td>
            </tr>
            <tr>
                <td>Total Customers</td>
                <td><?php echo $total_customers; ?></td>
            </tr>
            <tr>
                <td>Pending Requests</td>
                <td><?php echo $pending_requests; ?></td>
            </tr>
            <tr>
                <td>Completed Requests</td>
                <td><?php echo $completed_requests; ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Button to trigger the download -->
    <button class="action-btn" onclick="window.print()">Download Report</button>
<?php endif; ?>

</body>
</html>
