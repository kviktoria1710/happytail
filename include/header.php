<?php $base_path = $base_path ?? ''; ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HappyTail</title>
    <!-- Bootstrap 4.6 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Кастомні стилі -->
    <link rel="stylesheet" href="<?= $base_path ?>css/main.css?v=1.1">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-warning">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="<?= $base_path ?>index.php">🐾 HappyTail</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <?php 
                $all_menu = get_menu();
                $top_menu = array_filter($all_menu, function($m) { return ($m['parent_id'] ?? 0) == 0; });
                
                foreach ($top_menu as $menu_item): 
                    $sub_menu = array_filter($all_menu, function($m) use ($menu_item) { return ($m['parent_id'] ?? 0) == $menu_item['id']; });
                    $has_sub = !empty($sub_menu);
                    
                    if ($has_sub): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark font-weight-bold" href="#" id="nav-<?= $menu_item['id'] ?>" role="button" data-toggle="dropdown">
                                <?= htmlspecialchars($menu_item['title']) ?>
                            </a>
                            <div class="dropdown-menu shadow border-0">
                                <?php foreach ($sub_menu as $sub): ?>
                                    <a class="dropdown-item <?= ($sub['title'] == 'Всі тварини') ? 'border-bottom' : '' ?>" href="<?= $base_path ?><?= htmlspecialchars($sub['url']) ?>">
                                        <?= htmlspecialchars($sub['title']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark font-weight-bold" href="<?= $base_path ?><?= htmlspecialchars($menu_item['url']) ?>">
                                <?= htmlspecialchars($menu_item['title']) ?>
                            </a>
                        </li>
                    <?php endif; 
                endforeach; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if (is_admin()): ?>
                    <li class="nav-item mr-2">
                        <a class="btn btn-dark btn-sm mt-1" href="<?= $base_path ?>admin/index.php">Адмінка</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-danger btn-sm mt-1" href="<?= $base_path ?>admin/logout.php">Вихід</a>
                    </li>
                <?php elseif (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <span class="navbar-text mr-3 text-dark">👤 <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-secondary btn-sm mt-1" href="<?= $base_path ?>admin/logout.php">Вихід</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-dark btn-sm mt-1" href="<?= $base_path ?>login/index.php">Увійти</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4 mb-5">
