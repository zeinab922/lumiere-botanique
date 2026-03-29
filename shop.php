<?php
require_once 'config/database.php';

$category_id = isset($_GET['category']) ? (int)$_GET['category'] : null;
$skin_type = isset($_GET['skin_type']) ? $_GET['skin_type'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : null;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'new';

// Fetch categories
$stmt_cat = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $stmt_cat->fetchAll();

// Fetch products based on filters
$query = "SELECT * FROM products WHERE 1=1";
$params = [];

if ($category_id) {
    $query .= " AND category_id = ?";
    $params[] = $category_id;
}

if ($skin_type && $skin_type !== 'All') {
    $query .= " AND skin_type = ?";
    $params[] = $skin_type;
}

if ($search) {
    $query .= " AND (name LIKE ? OR description LIKE ?)";
    $params[] = "%".$search."%";
    $params[] = "%".$search."%";
}

if ($sort === 'price_asc') {
    $query .= " ORDER BY price ASC";
} else if ($sort === 'price_desc') {
    $query .= " ORDER BY price DESC";
} else {
    $query .= " ORDER BY id DESC";
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Helper to build URLs preserving state
$build_url = function($overrides = []) use ($category_id, $skin_type, $search, $sort) {
    $query_params = array_filter([
        'category' => $category_id,
        'skin_type' => $skin_type,
        'search' => $search,
        'sort' => $sort
    ]);
    if (isset($query_params['skin_type']) && $query_params['skin_type'] === 'All') unset($query_params['skin_type']);
    if (isset($query_params['sort']) && $query_params['sort'] === 'new') unset($query_params['sort']);
    $final_params = array_merge($query_params, $overrides);
    if (isset($overrides['category']) && empty($overrides['category'])) unset($final_params['category']);
    return 'shop.php?' . http_build_query($final_params);
};

require_once 'includes/header.php';
?>

<div class="mb-16 mt-8 max-w-screen-2xl mx-auto px-8" data-aos="fade-down">
    <h1 class="font-headline text-5xl font-extrabold tracking-tighter mb-4 text-on-surface">THE SKINCARE EDIT</h1>
    <p class="font-body text-on-surface-variant max-w-xl text-lg">Curated essentials for a luminous complexion. Discover our high-performance formulas designed for clinical results at home.</p>
</div>

<div class="flex flex-col lg:flex-row gap-12 max-w-screen-2xl mx-auto px-8">
    <!-- Sidebar Filter -->
    <aside class="w-full lg:w-64 flex-shrink-0" data-aos="fade-right" data-aos-delay="200">
        <div class="sticky top-32 space-y-10">
            <div>
                <h3 class="font-label text-xs font-bold uppercase tracking-widest mb-6 text-primary">Category</h3>
                <ul class="space-y-3">
                    <li class="group">
                        <a href="<?= $build_url(['category' => '']) ?>" class="flex items-center justify-between w-full <?= !$category_id ? 'text-on-surface font-semibold' : 'text-on-surface-variant hover:text-primary transition-colors' ?>">
                            <span>All Products</span>
                        </a>
                    </li>
                    <?php foreach($categories as $cat): ?>
                    <li class="group">
                        <a href="<?= $build_url(['category' => $cat['id']]) ?>" class="flex items-center justify-between w-full <?= ($category_id == $cat['id']) ? 'text-on-surface font-semibold' : 'text-on-surface-variant hover:text-primary transition-colors' ?>">
                            <span><?= htmlspecialchars($cat['name']) ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div>
                <h3 class="font-label text-xs font-bold uppercase tracking-widest mb-6 text-primary">Skin Type</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="<?= $build_url(['skin_type' => 'All']) ?>" class="px-4 py-2 rounded-full text-xs font-medium <?= (!$skin_type || $skin_type == 'All') ? 'bg-primary-container text-on-primary-container' : 'bg-surface-container-low text-on-surface-variant hover:bg-primary-container/50 transition-colors' ?>">All</a>
                    <a href="<?= $build_url(['skin_type' => 'Dry']) ?>" class="px-4 py-2 rounded-full text-xs font-medium <?= ($skin_type == 'Dry') ? 'bg-primary-container text-on-primary-container' : 'bg-surface-container-low text-on-surface-variant hover:bg-primary-container/50 transition-colors' ?>">Dry</a>
                    <a href="<?= $build_url(['skin_type' => 'Sensitive']) ?>" class="px-4 py-2 rounded-full text-xs font-medium <?= ($skin_type == 'Sensitive') ? 'bg-primary-container text-on-primary-container' : 'bg-surface-container-low text-on-surface-variant hover:bg-primary-container/50 transition-colors' ?>">Sensitive</a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Product Grid -->
    <div class="flex-1" data-aos="fade-up" data-aos-delay="400">
        <div class="flex justify-between items-center mb-10">
            <span class="text-sm text-on-surface-variant font-medium">
                <?php if($search): ?>
                    Found <?= count($products) ?> results for "<strong><?= htmlspecialchars($search) ?></strong>"
                <?php else: ?>
                    Showing all <?= count($products) ?> products
                <?php endif; ?>
            </span>
            <div class="flex items-center gap-2 border-b-2 border-transparent">
                <span class="text-xs font-bold uppercase tracking-widest text-outline">Sort By:</span>
                <form action="shop.php" method="GET" class="m-0">
                    <?php if($category_id): ?><input type="hidden" name="category" value="<?= $category_id ?>"/><?php endif; ?>
                    <?php if($skin_type): ?><input type="hidden" name="skin_type" value="<?= htmlspecialchars($skin_type) ?>"/><?php endif; ?>
                    <?php if($search): ?><input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>"/><?php endif; ?>
                    <select name="sort" onchange="this.form.submit()" class="bg-transparent border-none text-sm font-semibold focus:ring-0 cursor-pointer p-0 pr-4">
                        <option value="new" <?= $sort == 'new' ? 'selected' : '' ?>>New Arrivals</option>
                        <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-x-8 gap-y-16">
            <?php $delay=100; foreach($products as $product): ?>
            <a href="product.php?id=<?= $product['id'] ?>" class="group block relative" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                <div class="aspect-[4/5] overflow-hidden rounded-xl bg-secondary-container mb-6 relative shadow-sm hover:shadow-2xl transition-all duration-500">
                    <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-full object-cover mix-blend-multiply group-hover:scale-110 transition-transform duration-[1500ms]"/>
                    <?php if(!empty($product['badge'])): ?>
                        <div class="absolute top-4 left-4 px-3 py-1 bg-primary text-white text-[10px] font-bold uppercase tracking-widest rounded-full animate-pulse"><?= htmlspecialchars($product['badge']) ?></div>
                    <?php endif; ?>
                    
                    <form action="cart.php" method="POST" class="absolute top-4 right-4 z-10">
                        <input type="hidden" name="action" value="add"/>
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>"/>
                        <input type="hidden" name="quantity" value="1"/>
                        <button type="submit" class="w-10 h-10 rounded-full bg-surface/80 backdrop-blur-md flex items-center justify-center text-primary opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-xl shadow-primary/5 hover:bg-primary hover:text-white hover:scale-110">
                            <span class="material-symbols-outlined text-sm">add_shopping_cart</span>
                        </button>
                    </form>
                </div>
                
                <div class="space-y-2 transform transition-transform duration-300 group-hover:translate-x-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-label text-[10px] uppercase tracking-[0.2em] text-outline mb-1">Skincare</p>
                            <h3 class="font-headline text-lg font-bold text-on-surface tracking-tight"><?= htmlspecialchars($product['name']) ?></h3>
                        </div>
                        <span class="font-headline font-bold text-primary">$<?= number_format($product['price'], 2) ?></span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
