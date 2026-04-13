<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestión Administrativo</title>
        <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body>
        <?php
            if (session_status() === PHP_SESSION_NONE) session_start();
            $error = $_SESSION['error'] ?? null;
            $success = $_SESSION['success'] ?? null;
            unset($_SESSION['error'], $_SESSION['success']);
        ?>

        <?php if ($success): ?>
            <div class="floating-alert success">
                <i class="fa-solid fa-check-double"></i> <?= $success ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="floating-alert error">
                <div style="display: flex; align-items: flex-start; gap: 10px;">
                    <i class="fa-solid fa-circle-exclamation" style="margin-top: 4px;"></i>
                    <div>
                        <?php 
                            $decoded = json_decode($error, true);
                            
                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                foreach ($decoded as $index => $message) {
                                    echo '<span style="display: block;' . ($index > 0 ? 'margin-top: 5px;' : '') . '">' 
                                        . htmlspecialchars($message) . 
                                        '</span>';
                                }
                            } else {
                                echo htmlspecialchars($error);
                            }
                        ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="main-wrapper">