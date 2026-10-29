<?php
// admin_hit_tracker.php - Track admin dashboard page visits
require_once 'config.php';

// Create stats table if it doesn't exist
$createTableQuery = "CREATE TABLE IF NOT EXISTS admin_stats (
    stat_key VARCHAR(50) PRIMARY KEY,
    value INT DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
@$conn->query($createTableQuery);

// Increment today's hits
$today = date('Y-m-d');
$hitsQuery = "INSERT INTO admin_stats (stat_key, value) VALUES ('live_hits_today', 1) 
              ON DUPLICATE KEY UPDATE value = value + 1";
@$conn->query($hitsQuery);

// Reset hits at midnight (optional - for daily stats)
$resetQuery = "UPDATE admin_stats SET value = 0 WHERE stat_key = 'live_hits_today' AND DATE(updated_at) < CURDATE()";
@$conn->query($resetQuery);

exit();
?>
