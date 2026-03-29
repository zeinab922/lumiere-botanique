<?php
// product.php
require_once 'config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    die("Product not found");
}

require_once 'includes/header.php';
?>

<!-- Product Section: Asymmetric Layout -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start max-w-screen-2xl mx-auto px-8 mt-8">
    <!-- Left: Editorial Gallery -->
    <div class="lg:col-span-7 grid grid-cols-2 gap-4" data-aos="fade-right">
        <div class="col-span-2 aspect-[4/5] bg-secondary-container rounded-xl overflow-hidden group">
            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"/>
        </div>
        <div class="aspect-square bg-surface-container-low rounded-xl flex items-center justify-center overflow-hidden p-8 hover:bg-primary-container hover:text-white transition-colors duration-500 cursor-pointer">
            <p class="font-headline text-center font-bold text-on-surface">CLINICAL</p>
        </div>
        <div class="aspect-square bg-surface-container-low rounded-xl flex items-center justify-center overflow-hidden p-8 hover:bg-primary-container hover:text-white transition-colors duration-500 cursor-pointer">
            <p class="font-headline text-center font-bold text-on-surface">VEGAN</p>
        </div>
    </div>

    <!-- Right: Product Info -->
    <div class="lg:col-span-5 lg:sticky lg:top-32 space-y-10" data-aos="fade-left" data-aos-delay="200">
        <header class="space-y-4">
            <div class="flex items-center gap-2">
                <?php if(!empty($product['badge'])): ?>
                    <span class="font-label text-[0.7rem] tracking-[0.2em] text-primary uppercase font-bold"><?= htmlspecialchars($product['badge']) ?></span>
                <?php else: ?>
                    <span class="font-label text-[0.7rem] tracking-[0.2em] text-outline uppercase font-bold">Skincare</span>
                <?php endif; ?>
                <div class="h-[1px] w-8 bg-outline-variant/30"></div>
                
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-[14px] text-primary" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined text-[14px] text-primary" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined text-[14px] text-primary" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined text-[14px] text-primary" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="material-symbols-outlined text-[14px] text-primary">star_half</span>
                    <span class="ml-2 font-label text-[0.7rem] text-on-surface-variant">(42 REVIEWS)</span>
                </div>
            </div>
            
            <h1 class="font-headline text-4xl lg:text-5xl font-bold tracking-tighter text-on-surface leading-tight"><?= htmlspecialchars($product['name']) ?></h1>
            <p class="text-3xl font-light text-on-surface-variant">$<?= number_format($product['price'], 2) ?></p>
        </header>

        <div class="space-y-6">
            <p class="text-lg leading-relaxed text-on-surface-variant font-light">
                <?= htmlspecialchars($product['description']) ?>
            </p>

            <form action="cart.php" method="POST" class="flex flex-col gap-4">
                <input type="hidden" name="action" value="add"/>
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>"/>
                
                <div class="flex items-center gap-4 bg-surface-container-low rounded-full px-4 py-2 w-max">
                    <button type="button" onclick="document.getElementById('qty').value = Math.max(1, parseInt(document.getElementById('qty').value)-1)" class="material-symbols-outlined text-sm hover:text-primary">remove</button>
                    <input type="number" name="quantity" id="qty" value="1" min="1" class="w-12 text-center bg-transparent border-none focus:ring-0 font-headline font-bold text-sm"/>
                    <button type="button" onclick="document.getElementById('qty').value = parseInt(document.getElementById('qty').value)+1" class="material-symbols-outlined text-sm hover:text-primary">add</button>
                </div>

                <button type="submit" class="w-full py-5 rounded-full bg-gradient-to-br from-primary to-primary-container text-white font-semibold tracking-wide hover:scale-[1.02] hover:shadow-2xl hover:shadow-primary/30 transition-all duration-300 shadow-lg shadow-primary/10">
                    ADD TO BAG
                </button>
                <button type="button" class="w-full py-5 rounded-full border border-outline-variant/20 font-semibold tracking-wide text-on-surface hover:bg-surface-container-low transition-colors duration-300">
                    COMPLIMENTARY CONSULTATION
                </button>
            </form>
        </div>

        <div class="space-y-0 divide-y divide-outline-variant/20 border-t border-b border-outline-variant/10">
            <details class="group py-6 cursor-pointer">
                <summary class="flex justify-between items-center list-none">
                    <span class="font-headline font-semibold text-sm tracking-widest uppercase">Ingredient list</span>
                    <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                </summary>
                <div class="pt-6 text-on-surface-variant font-light leading-relaxed text-sm">
                    Water (Aqua), Glycerin, Hyaluronic Acid, Rose Damascena Flower Water, Niacinamide, Panthenol, Camellia Sinensis Leaf Extract, Phenoxyethanol, Ethylhexylglycerin, Sodium Phytate.
                </div>
            </details>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
