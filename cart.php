<?php
// cart.php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $product_id = (int)$_POST['product_id'];
        $quantity = (int)($_POST['quantity'] ?? 1);
        
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
        header("Location: cart.php");
        exit;
    }
    
    if ($action === 'remove') {
        $product_id = (int)$_POST['product_id'];
        unset($_SESSION['cart'][$product_id]);
        header("Location: cart.php");
        exit;
    }
    
    if ($action === 'update_qty') {
        $product_id = (int)$_POST['product_id'];
        $change = (int)$_POST['change'];
        
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $change;
            if ($_SESSION['cart'][$product_id] <= 0) {
                unset($_SESSION['cart'][$product_id]);
            }
        }
        header("Location: cart.php");
        exit;
    }
}

// Fetch products currently in the cart
$cart_items = [];
$subtotal = 0;

if (!empty($_SESSION['cart'])) {
    $placeholders = str_repeat('?,', count($_SESSION['cart']) - 1) . '?';
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute(array_keys($_SESSION['cart']));
    $products = $stmt->fetchAll();
    
    foreach ($products as $p) {
        $qty = $_SESSION['cart'][$p['id']];
        $p['quantity'] = $qty;
        $cart_items[] = $p;
        $subtotal += ($p['price'] * $qty);
    }
}

$tax = $subtotal * 0.085; // Example 8.5% tax
$total = $subtotal + $tax;

require_once 'includes/header.php';
?>

<div class="max-w-screen-2xl mx-auto px-8 mt-8">
    <header class="mb-12" data-aos="fade-down">
        <h1 class="font-headline text-5xl font-extrabold tracking-tighter text-on-surface mb-2">Your Selection</h1>
        <p class="text-on-surface-variant font-body">Review your curated ritual before proceeding.</p>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
        <!-- Product List Section -->
        <section class="lg:col-span-8 space-y-12">
            
            <?php if(empty($cart_items)): ?>
                <div class="py-12 text-center text-on-surface-variant bg-surface-container-low rounded-xl" data-aos="fade-up">
                    <span class="material-symbols-outlined text-4xl mb-4 animate-bounce">shopping_bag</span>
                    <p class="font-headline text-xl">Your cart is empty.</p>
                    <a href="shop.php" class="inline-block mt-4 text-primary font-bold border-b border-primary hover:text-primary-container transition-colors">Continue Shopping</a>
                </div>
            <?php else: ?>
                <?php $delay=100; foreach($cart_items as $item): ?>
                    <div class="flex flex-col md:flex-row gap-8 items-center md:items-start group" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                        <div class="w-full md:w-48 aspect-[4/5] bg-secondary-container rounded-xl overflow-hidden shrink-0 shadow-sm transition-shadow duration-500 group-hover:shadow-xl">
                            <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-full h-full object-cover mix-blend-multiply transition-transform duration-700 group-hover:scale-110"/>
                        </div>
                        
                        <div class="flex-grow flex flex-col justify-between py-2 w-full">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="font-label text-[0.65rem] tracking-[0.15em] text-primary uppercase font-bold mb-1 block">SKINCARE</span>
                                    <h3 class="font-headline text-2xl font-semibold text-on-surface leading-tight"><?= htmlspecialchars($item['name']) ?></h3>
                                </div>
                                <span class="font-headline text-xl font-bold text-on-surface">$<?= number_format($item['price'], 2) ?></span>
                            </div>
                            
                            <div class="mt-8 flex items-center justify-between">
                                <form action="cart.php" method="POST" class="flex items-center bg-surface-container-low rounded-full px-4 py-2 gap-6">
                                    <input type="hidden" name="action" value="update_qty"/>
                                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>"/>
                                    
                                    <button type="submit" name="change" value="-1" class="hover:text-primary transition-colors focus:outline-none">
                                        <span class="material-symbols-outlined text-sm">remove</span>
                                    </button>
                                    <span class="font-headline font-bold text-sm min-w-[1rem] text-center"><?= $item['quantity'] ?></span>
                                    <button type="submit" name="change" value="1" class="hover:text-primary transition-colors focus:outline-none">
                                        <span class="material-symbols-outlined text-sm">add</span>
                                    </button>
                                </form>
                                
                                <form action="cart.php" method="POST">
                                    <input type="hidden" name="action" value="remove"/>
                                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>"/>
                                    <button type="submit" class="text-on-surface-variant hover:text-red-500 transition-colors flex items-center gap-2 text-xs font-semibold tracking-wide uppercase group-hover:scale-105">
                                        <span class="material-symbols-outlined text-base transition-transform group-hover:rotate-12">delete</span> Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php $delay+=100; endforeach; ?>
            <?php endif; ?>

        </section>

        <!-- Order Summary Section -->
        <aside class="lg:col-span-4 lg:sticky lg:top-32" data-aos="fade-left" data-aos-delay="400">
            <div class="bg-surface-container-low rounded-xl p-8 space-y-8">
                <h2 class="font-headline text-xl font-bold text-on-surface tracking-tight uppercase">Order Summary</h2>
                <div class="space-y-4 border-b border-outline-variant/40 pb-6">
                    <div class="flex justify-between text-on-surface-variant">
                        <span class="text-sm font-medium">Subtotal</span>
                        <span class="text-sm font-bold text-on-surface">$<?= number_format($subtotal, 2) ?></span>
                    </div>
                    <div class="flex justify-between text-on-surface-variant">
                        <span class="text-sm font-medium">Estimated Shipping</span>
                        <span class="text-sm font-bold text-on-surface">$0.00</span>
                    </div>
                    <div class="flex justify-between text-on-surface-variant">
                        <span class="text-sm font-medium">Taxes (8.5%)</span>
                        <span class="text-sm font-bold text-on-surface">$<?= number_format($tax, 2) ?></span>
                    </div>
                </div>
                
                <div class="flex justify-between items-baseline pt-2">
                    <span class="font-headline text-lg font-bold text-on-surface">Total</span>
                    <span class="font-headline text-3xl font-extrabold text-on-surface tracking-tighter">$<?= number_format($total, 2) ?></span>
                </div>
                
                <div class="pt-4">
                    <button <?= empty($cart_items) ? 'disabled' : '' ?> class="w-full bg-gradient-to-br from-primary to-primary-container text-white font-headline py-5 rounded-full font-bold uppercase tracking-widest text-xs shadow-xl shadow-primary/20 hover:scale-[1.03] hover:shadow-2xl hover:shadow-primary/40 transition-all duration-300 disabled:opacity-50 disabled:hover:scale-100 disabled:cursor-not-allowed">
                        Proceed to Checkout
                    </button>
                    <div class="mt-6 flex flex-col items-center gap-4">
                        <p class="text-[0.65rem] text-zinc-400 font-medium uppercase tracking-widest">Secure Payments Via</p>
                        <div class="flex gap-4 opacity-40 grayscale hover:grayscale-0 transition-all duration-500">
                            <span class="material-symbols-outlined hover:text-blue-500 hover:scale-110 transition-all">credit_card</span>
                            <span class="material-symbols-outlined hover:text-green-500 hover:scale-110 transition-all">account_balance</span>
                            <span class="material-symbols-outlined hover:text-purple-500 hover:scale-110 transition-all">contactless</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secondary Info Card -->
            <div class="mt-8 bg-surface-container-lowest border border-outline-variant/10 rounded-xl p-6 flex items-start gap-4 hover:shadow-lg transition-shadow duration-300 group cursor-default">
                <span class="material-symbols-outlined text-primary-container transition-transform duration-500 group-hover:rotate-[360deg] group-hover:scale-110" style="font-variation-settings: 'FILL' 1;">eco</span>
                <div>
                    <h4 class="text-xs font-bold text-on-surface uppercase tracking-wider mb-1">Sustainable Packaging</h4>
                    <p class="text-[0.7rem] text-on-surface-variant leading-relaxed">Your order will be shipped in 100% biodegradable materials as part of our commitment to the earth.</p>
                </div>
            </div>
        </aside>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
