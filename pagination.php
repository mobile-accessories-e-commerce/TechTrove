<?php

// pagination.php
function paginate($totalItems, $itemsPerPage, $currentPage, $baseUrl) {
    $totalPages = ceil($totalItems / $itemsPerPage);
    $paginationHtml = '<div class="pagination">';

    // Previous button
    if ($currentPage > 1) {
        $paginationHtml .= '<a href="' . $baseUrl . '?page=' . ($currentPage - 1) . '">&laquo; Prev</a>';
    }

    // Page numbers
    for ($i = 1; $i <= $totalPages; $i++) {
        $paginationHtml .= '<a href="' . $baseUrl . '?page=' . $i . '"';
        if ($i == $currentPage) {
            $paginationHtml .= ' class="active"';
        }
        $paginationHtml .= '>' . $i . '</a>';
    }

    // Next button
    if ($currentPage < $totalPages) {
        $paginationHtml .= '<a href="' . $baseUrl . '?page=' . ($currentPage + 1) . '">Next &raquo;</a>';
    }

    $paginationHtml .= '</div>';
    return $paginationHtml;
}

?>