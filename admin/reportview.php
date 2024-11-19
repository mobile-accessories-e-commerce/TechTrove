<?php
include "../connect.php";

// Pagination setup
$limit = 10; // Number of rows per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page (defaults to 1)
$offset = ($page - 1) * $limit; // Calculate the offset

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $type = $_GET['type'];

    // Fetching data based on type
    if ($type == "seller") {
        $sql = "SELECT seller_id AS id, store_name AS name FROM sellers LIMIT $limit OFFSET $offset";
    } elseif ($type == "service_provider") {
        $sql = "SELECT service_provider_id AS id, service_name AS name FROM service_providers LIMIT $limit OFFSET $offset";
    } elseif ($type == "product") {
        $sql = "SELECT product_id AS id, product_name AS name FROM products LIMIT $limit OFFSET $offset";
    } elseif ($type == 'service') {
        $sql = "SELECT service_id AS id, service_name AS name FROM services LIMIT $limit OFFSET $offset";
    }

    $result = mysqli_query($con, $sql);
    $report_list = array();
    
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($report_list, $row);
    }

    // Fetch the total number of records for pagination
    $count_sql = "SELECT COUNT(*) AS total FROM " . ($type == 'seller' ? 'sellers' : ($type == 'service_provider' ? 'service_providers' : ($type == 'product' ? 'products' : 'services')));
    $count_result = mysqli_query($con, $count_sql);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_records = $count_row['total'];

    // Calculate total pages
    $total_pages = ceil($total_records / $limit);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f7f7f7;
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
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            padding: 8px 16px;
            text-decoration: none;
            margin: 0 5px;
            border: 1px solid #007BFF;
            color: #007BFF;
            border-radius: 4px;
        }
        .pagination a:hover {
            background-color: #007BFF;
            color: white;
        }
        .pagination .active {
            background-color: #007BFF;
            color: white;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .view-btn {
            background-color: #007BFF;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
        }
        .view-btn:hover {
            background-color: #0056b3;
        }
        .action-column {
            text-align: right; /* Aligning the button to the right */
        }
    </style>
</head>
<body>

<h2>Admin Report - <?php echo ucfirst($type); ?> Data</h2>

<!-- Table to display the report list -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th> <!-- Added column for the View Report button -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($report_list as $report): ?>
            <tr>
                <td><?php echo $report['id']; ?></td>
                <td><?php echo $report['name']; ?></td>
                <td class="action-column">
                    <a href="reportchecker.php?id=<?php echo $report['id']; ?>&type=<?php echo $type; ?>" class="view-btn">View Report</a> <!-- View Report button with link -->
                </td> <!-- Aligning the "View Report" button to the right -->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Pagination -->
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?type=<?php echo $type; ?>&page=<?php echo $page - 1; ?>">Previous</a>
    <?php endif; ?>
    
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?type=<?php echo $type; ?>&page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
    
    <?php if ($page < $total_pages): ?>
        <a href="?type=<?php echo $type; ?>&page=<?php echo $page + 1; ?>">Next</a>
    <?php endif; ?>
</div>

</body>
</html>
