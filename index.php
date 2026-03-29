<?php
// index.php
require_once 'config/database.php';

// Fetch the featured products (for the "Daily Essentials" carousel)
$stmt = $pdo->query("SELECT * FROM products ORDER BY id ASC LIMIT 4");
$featured_products = $stmt->fetchAll();

// Include the standard header
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="relative h-[870px] flex items-center overflow-hidden bg-surface -mt-24">
    <div class="max-w-screen-2xl mx-auto px-8 w-full grid grid-cols-1 md:grid-cols-12 gap-8 items-center pt-24">
        <div class="md:col-span-5 z-10 space-y-8" data-aos="fade-right">
            <div class="space-y-2">
                <span class="label-md tracking-[0.2em] text-primary uppercase font-semibold text-xs animate-pulse inline-block">Summer Collection 2024</span>
                <h1 class="text-7xl md:text-8xl font-headline font-extrabold tracking-tighter leading-[0.9] text-on-surface">
                    The New <br/>Standard <br/><span class="text-primary italic font-medium">of Glow.</span>
                </h1>
            </div>
            <p class="text-lg text-on-surface-variant max-w-md leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                Curated medical-grade skincare that bridges the gap between clinical results and sensory luxury.
            </p>
            <div class="pt-4" data-aos="fade-up" data-aos-delay="400">
                <a href="shop.php" class="inline-block bg-gradient-to-br from-primary to-primary-container text-white px-10 py-5 rounded-full font-headline font-bold tracking-tight shadow-lg shadow-primary/10 hover:scale-[1.05] hover:shadow-2xl hover:shadow-primary/30 transition-all duration-500">
                    SHOP THE COLLECTION
                </a>
            </div>
        </div>
        <div class="md:col-span-7 relative h-full flex justify-end" data-aos="fade-left" data-aos-duration="1200">
            <div class="w-full md:w-[110%] h-[716px] md:h-[819px] rounded-[1.5rem] overflow-hidden relative shadow-2xl">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCDkZvR-VUMe0vwCFTc6PAExri0iHZuc9lJSo3T6Oh_twoVOo3VwV7wTHMWD2H6ZrM8I-2pN-7JuEGOp1jd4jXR3TD6k5ob_eBznO93E45A8NYhe9erCVwEsh8lzbIXtZDYUZPIMXz1d5blwYSXlHoei1_ygq3lPP_X_OFA_r6Al-83wtrmZLzQQU5zljMjm0sO_Zt8WxIZ5gpbptrf4weY9seM9PF5czEXwjkiyDyF9jf1VLlpaz2LdkY6XE0Z0RiZ0lVllk8WSbq-" class="w-full h-full object-cover" alt="Premium Beauty"/>
                <div class="absolute inset-0 bg-primary/5 mix-blend-multiply"></div>
            </div>
            <!-- Asymmetrical element -->
            <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-primary-container/30 rounded-full blur-3xl"></div>
        </div>
    </div>
</section>

<!-- Featured Products Carousel (Dynamic) -->
<section class="py-24 bg-surface" overflow-hidden>
    <div class="max-w-screen-2xl mx-auto px-8">
        <div class="flex justify-between items-end mb-12" data-aos="fade-up">
            <div class="space-y-2">
                <h2 class="text-4xl font-headline font-bold tracking-tight text-on-surface">Daily Essentials</h2>
                <p class="text-on-surface-variant text-sm">Recommended by our head aestheticians.</p>
            </div>
            <div class="flex gap-4">
                <button class="w-12 h-12 rounded-full flex items-center justify-center border border-outline-variant/20 hover:bg-surface-container-low transition-colors duration-300 hover:scale-110 active:scale-95">
                    <span class="material-symbols-outlined transition-transform duration-300 group-hover:-translate-x-1">chevron_left</span>
                </button>
                <button class="w-12 h-12 rounded-full flex items-center justify-center bg-primary text-white hover:opacity-90 transition-colors duration-300 hover:scale-110 active:scale-95 group">
                    <span class="material-symbols-outlined transition-transform duration-300 group-hover:translate-x-1">chevron_right</span>
                </button>
            </div>
        </div>
        
        <div class="flex gap-8 overflow-x-auto hide-scrollbar pb-8">
            <?php $delay = 100; foreach($featured_products as $product): ?>
                <a href="product.php?id=<?= $product['id'] ?>" class="min-w-[320px] group block" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                    <div class="aspect-[4/5] bg-secondary-container rounded-xl overflow-hidden mb-4 relative shadow-sm hover:shadow-2xl transition-all duration-500">
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="<?= htmlspecialchars($product['name']) ?>"/>
                        <form action="cart.php" method="POST" class="absolute bottom-4 right-4">
                            <input type="hidden" name="action" value="add"/>
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>"/>
                            <input type="hidden" name="quantity" value="1"/>
                            <button type="submit" class="bg-white/90 backdrop-blur p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:text-primary">
                                <span class="material-symbols-outlined">add_shopping_cart</span>
                            </button>
                        </form>
                    </div>
                    <div class="space-y-1 transform transition-transform duration-300 group-hover:translate-x-2">
                        <span class="text-[10px] tracking-widest text-primary uppercase font-bold">Skincare</span>
                        <h3 class="font-headline font-bold text-lg text-on-surface group-hover:text-primary transition-colors"><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="text-on-surface-variant font-medium">$<?= number_format($product['price'], 2) ?></p>
                    </div>
                </a>
            <?php $delay += 100; endforeach; ?>
        </div>
    </div>
</section>

<!-- Category Promotion Bento -->
<section class="py-12 overflow-hidden">
    <div class="max-w-screen-2xl mx-auto px-8 grid grid-cols-1 md:grid-cols-12 gap-6 h-auto md:h-[600px]">
        <div class="md:col-span-8 bg-surface-container-low rounded-3xl relative overflow-hidden group shadow-lg hover:shadow-2xl transition-all duration-700" data-aos="fade-right">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDX4DIcm6nd7BAB3cqwZm69rAznHKeDwEwfvKO3qMAOC9gSIxrd3TC-g20g5oIt--UvjEvxHi8qCMwjOiiKxLC7l79eeqrchGRhF4jtwQc-7dTuW2PJZ-Q7DHXk4RB6gvHSdbP70F52nSxXFdVA5dGD3yjQP4EJnTukhaN3E6HMn9POLc9irhGwsDeDSWZtblguxtrbFv0dOqEBNlTtBIqN9DZG-QdLS50opZ6v7GAes6H7tqFG5BKkc77smwLSTBwwxRD6lIyXTXUI" class="absolute inset-0 w-full h-full object-cover transition-transform duration-[1500ms] group-hover:scale-110" alt="Ritual"/>
            <div class="absolute inset-0 bg-black/30 group-hover:bg-black/10 transition-colors duration-700"></div>
            <div class="absolute bottom-12 left-12 max-w-md transform transition-transform duration-700 group-hover:translate-y-[-10px]">
                <h2 class="text-5xl font-headline font-extrabold text-white mb-4">THE RITUAL<br/>FINDER</h2>
                <p class="text-white/90 mb-6 font-medium text-sm">Take our skin assessment to discover your personalized 4-step medical-grade regimen.</p>
                <button class="bg-white text-primary px-8 py-3 rounded-full font-bold tracking-tight hover:bg-primary hover:text-white transition-all duration-300 text-xs uppercase hover:shadow-xl hover:shadow-primary/30">START ASSESSMENT</button>
            </div>
        </div>
        <div class="md:col-span-4 bg-primary-container rounded-3xl p-12 flex flex-col justify-between relative overflow-hidden group hover:shadow-xl transition-all duration-500" data-aos="fade-left" data-aos-delay="200">
            <div class="z-10 transform transition-transform duration-500 group-hover:translate-x-2">
                <span class="text-[10px] tracking-[0.3em] font-bold text-primary uppercase">Editorial</span>
                <h2 class="text-3xl font-headline font-bold text-on-primary-fixed mt-4 leading-tight">The Science of Barrier Health</h2>
                <p class="mt-4 text-on-primary-fixed-variant leading-relaxed text-sm">How ceramides and fatty acids work together to protect your natural glow.</p>
            </div>
            <a href="#" class="z-10 flex items-center gap-2 font-bold text-primary text-xs uppercase hover:gap-4 transition-all group duration-300">
                READ MORE <span class="material-symbols-outlined transition-transform group-hover:translate-x-2">arrow_right_alt</span>
            </a>
            <!-- Abstract Shape -->
            <div class="absolute -right-20 -bottom-20 w-64 h-64 border-[32px] border-white/20 rounded-full transition-transform duration-[2000ms] group-hover:scale-150 group-hover:rotate-180"></div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
