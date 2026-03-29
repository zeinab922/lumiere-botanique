<?php
session_start();
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Aesthetician | The Digital Luxury</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#7b5455",
                        "primary-container": "#f4c2c2",
                        "on-surface": "#1a1c1c",
                        "on-surface-variant": "#504444",
                        "surface": "#f9f9f9",
                        "surface-container-low": "#f3f3f3",
                        "secondary-container": "#e2e2e2",
                        "outline-variant": "#d4c2c2"
                    },
                    fontFamily: {
                        "headline": ["Manrope"],
                        "body": ["Plus Jakarta Sans"],
                        "label": ["Plus Jakarta Sans"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "1.5rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
        .glass-nav {
            background: rgba(249, 249, 249, 0.8);
            backdrop-filter: blur(20px);
        }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-surface font-body text-on-surface">

<!-- Top NavBar -->
<nav class="fixed top-0 w-full z-50 glass-nav border-b border-primary/5">
    <div class="flex justify-between items-center w-full px-8 py-4 max-w-screen-2xl mx-auto">
        <a href="index.php" class="text-2xl font-bold tracking-tighter text-zinc-900 font-headline uppercase">AESTHETICIAN</a>
        
        <div class="hidden md:flex gap-10 items-center">
            <a href="shop.php?category=1" class="text-zinc-500 hover:text-rose-400 font-headline tracking-tight uppercase text-xs font-semibold transition-colors">SKINCARE</a>
            <a href="shop.php?category=2" class="text-zinc-500 hover:text-rose-400 font-headline tracking-tight uppercase text-xs font-semibold transition-colors">BODY</a>
            <a href="shop.php?category=3" class="text-zinc-500 hover:text-rose-400 font-headline tracking-tight uppercase text-xs font-semibold transition-colors">SETS</a>
        </div>

        <div class="flex items-center gap-6">
            <form action="shop.php" method="GET" class="hidden md:block relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">search</span>
                <input type="text" name="search" placeholder="SEARCH" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" class="bg-surface-container-low border-none rounded-full py-2 pl-10 pr-4 text-[10px] tracking-widest focus:ring-1 focus:ring-primary w-48"/>
            </form>
            
            <a href="cart.php" class="transition-opacity duration-300 hover:opacity-70 scale-95 relative">
                <span class="material-symbols-outlined text-zinc-800">shopping_bag</span>
                <?php if($cart_count > 0): ?>
                    <span class="absolute -top-1 -right-1 flex h-3 w-3 items-center justify-center rounded-full bg-primary text-[8px] font-bold text-white"><?= $cart_count ?></span>
                <?php endif; ?>
            </a>
            
            <button class="transition-opacity duration-300 hover:opacity-70 scale-95">
                <span class="material-symbols-outlined text-zinc-800">person</span>
            </button>
        </div>
    </div>
</nav>

<main class="pt-24 pb-20">
