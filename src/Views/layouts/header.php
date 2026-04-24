<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestión Administrativo</title>
        <link href="<?= BASE_URL ?>fontawesome/css/all.min.css" rel="stylesheet" >
        <link href="<?= BASE_URL ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= BASE_URL ?>css/style.css" rel="stylesheet">
    </head>
    <body>
        <?php
            if (session_status() === PHP_SESSION_NONE) session_start();
            $error = $_SESSION['error'] ?? null;
            $success = $_SESSION['success'] ?? null;
            unset($_SESSION['error'], $_SESSION['success']);
        ?>

        <div id="alert-container">
            <?php if ($success): ?>
                <div class="floating-alert success" onclick="this.remove()">
                    <i class="fa-solid fa-check-double"></i> <?= $success ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="floating-alert error" onclick="this.remove()">
                    <div class="d-flex align-items-start gap-2">
                        <i class="fa-solid fa-circle-exclamation mt-1"></i>
                        <div>
                            <?php 
                                $decoded = json_decode($error, true);
                                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                    foreach ($decoded as $message) {
                                        echo '<span class="d-block">' . htmlspecialchars($message) . '</span>';
                                    }
                                } else {
                                    echo htmlspecialchars($error);
                                }
                            ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="main-wrapper">