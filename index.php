<?php

require_once 'config.php';

$players_json = @file_get_contents("http://{$fivem_server_ip}:{$fivem_server_port}/players.json");
$info_json = @file_get_contents("http://{$fivem_server_ip}:{$fivem_server_port}/info.json");

$server_status = ($players_json === FALSE || $info_json === FALSE) ? "offline" : "online";
$player_count = 0;
$max_players = $max_players_manual;

if ($server_status == "online") {
    $players = json_decode($players_json, true);
    $info = json_decode($info_json, true);
    
    $player_count = count($players);
    if (isset($info['vars']['sv_maxclients'])) {
        $max_players = $info['vars']['sv_maxclients'];
    }

    usort($players, function($a, $b) {
        return $a['ping'] - $b['ping'];
    });
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_title; ?></title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <div class="talhacaba-background-pattern"></div>
    <div class="talhacaba-overlay"></div>

    <div class="talhacaba-main-container">
        <div class="talhacaba-header-section">
            <h1 class="talhacaba-server-title"><?php echo htmlspecialchars($server_name); ?></h1>
            <div class="talhacaba-info-line">
                <span class="talhacaba-status-badge <?php echo $server_status; ?>">
                    <?php echo ($server_status == "online" ? "Çevrimiçi" : "Çevrimdışı"); ?>
                </span>
                <span class="talhacaba-player-count">
                    Oyuncular: <?php echo $player_count; ?> / <?php echo $max_players; ?>
                </span>
            </div>
            <div class="talhacaba-btn-group">
                <button onclick="copyToClipboard('connect <?php echo $fivem_server_ip; ?>:<?php echo $fivem_server_port; ?>')" class="talhacaba-btn talhacaba-btn-primary">
                    <i class="fas fa-play"></i> Bağlan
                </button>
                <?php if (!empty($discord_link)): ?>
                    <a href="<?php echo $discord_link; ?>" class="talhacaba-btn talhacaba-btn-secondary" target="_blank">
                        <i class="fab fa-discord"></i> Discord
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($server_status == "online"): ?>
            <div class="talhacaba-player-list-section">
                <h2 class="talhacaba-section-title">Aktif Oyuncular</h2>
                <div class="talhacaba-player-grid">
                    <?php foreach ($players as $player): ?>
                        <div class="talhacaba-player-card">
                            <div class="talhacaba-player-header">
                                <span class="talhacaba-player-id">#<?php echo $player['id']; ?></span>
                            </div>
                            <div class="talhacaba-player-body">
                                <span class="talhacaba-player-name"><?php echo htmlspecialchars($player['name']); ?></span>
                                <span class="talhacaba-player-ping"><i class="fas fa-signal"></i> <?php echo $player['ping']; ?> ms</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="talhacaba-offline-message">
                Sunucu şu anda ulaşılamıyor. Daha sonra tekrar deneyin.
            </div>
        <?php endif; ?>
    </div>

    <script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Bağlantı adresi panoya kopyalandı!');
        }, function(err) {
            console.error('Kopyalama başarısız: ', err);
        });
    }
    </script>
</body>
</html>
