<?php
function formatDate($dateString, $format = 'd/m/Y') {
    if (empty($dateString)) return '';
    $date = new DateTime($dateString);
    return $date->format($format);
}

function formatCurrency($amount) {
    return number_format($amount, 2, '.', ',');
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function getStatusBadge($status) {
    $badges = [
        'active' => 'success',
        'inactive' => 'warning',
        'out_of_stock' => 'danger'
    ];
    return isset($badges[$status]) ? $badges[$status] : 'primary';
}
?>