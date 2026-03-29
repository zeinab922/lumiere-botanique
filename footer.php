</main>

<!-- Footer -->
<footer class="w-full py-16 px-8 mt-20 bg-zinc-100">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-12 max-w-screen-2xl mx-auto">
        <div class="space-y-6">
            <div class="font-headline text-lg font-bold text-zinc-900 uppercase">AESTHETICIAN</div>
            <p class="font-body text-sm tracking-wide text-zinc-600 leading-relaxed max-w-xs">
                Curating the world's most effective skincare products with an uncompromising focus on clinical results and aesthetic pleasure.
            </p>
        </div>
        
        <div class="space-y-6">
            <h4 class="font-headline text-xs font-bold uppercase tracking-widest text-zinc-900">Experience</h4>
            <ul class="space-y-4">
                <li><a href="#" class="font-body text-sm text-zinc-500 hover:text-zinc-900 transition-all hover:underline underline-offset-8 decoration-rose-200">Sustainability</a></li>
                <li><a href="#" class="font-body text-sm text-zinc-500 hover:text-zinc-900 transition-all hover:underline underline-offset-8 decoration-rose-200">The Journal</a></li>
                <li><a href="#" class="font-body text-sm text-zinc-500 hover:text-zinc-900 transition-all hover:underline underline-offset-8 decoration-rose-200">Our Clinics</a></li>
            </ul>
        </div>
        
        <div class="space-y-6">
            <h4 class="font-headline text-xs font-bold uppercase tracking-widest text-zinc-900">Support</h4>
            <ul class="space-y-4">
                <li><a href="#" class="font-body text-sm text-zinc-500 hover:text-zinc-900 transition-all hover:underline underline-offset-8 decoration-rose-200">Shipping</a></li>
                <li><a href="#" class="font-body text-sm text-zinc-500 hover:text-zinc-900 transition-all hover:underline underline-offset-8 decoration-rose-200">Returns</a></li>
                <li><a href="#" class="font-body text-sm text-zinc-500 hover:text-zinc-900 transition-all hover:underline underline-offset-8 decoration-rose-200">Contact</a></li>
            </ul>
        </div>
        
        <div class="space-y-6">
            <h4 class="font-headline text-xs font-bold uppercase tracking-widest text-zinc-900">Newsletter</h4>
            <div class="space-y-4">
                <div class="relative">
                    <input type="text" placeholder="YOUR EMAIL" class="w-full bg-white border border-outline-variant/20 py-3 px-4 rounded-xl text-xs tracking-widest focus:ring-1 focus:ring-primary focus:border-transparent outline-none"/>
                    <button class="absolute right-2 top-1/2 -translate-y-1/2 text-primary font-bold text-xs p-2">JOIN</button>
                </div>
                <p class="text-[10px] text-zinc-400 leading-tight">By subscribing you agree to receive marketing communications.</p>
            </div>
        </div>
    </div>
    
    <div class="max-w-screen-2xl mx-auto px-8 mt-20 pt-8 border-t border-zinc-200/50 flex flex-col md:flex-row justify-between items-center gap-4">
        <span class="font-body text-xs tracking-wide text-zinc-400">&copy; 2024 THE DIGITAL AESTHETICIAN. ALL RIGHTS RESERVED.</span>
        <div class="flex gap-8 text-[10px] tracking-widest text-zinc-400 uppercase font-bold">
            <a href="#" class="hover:text-zinc-900">Terms</a>
            <a href="#" class="hover:text-zinc-900">Privacy</a>
            <a href="#" class="hover:text-zinc-900">Cookies</a>
        </div>
    </div>
</footer>

<!-- Floating Cart Pill -->
<div class="fixed bottom-8 right-8 z-50">
    <a href="cart.php" class="bg-white/80 backdrop-blur-xl border border-white/50 px-6 py-4 flex items-center gap-3 shadow-xl rounded-full group hover:scale-105 transition-all duration-300 text-primary hover:shadow-2xl hover:-translate-y-1">
        <span class="material-symbols-outlined group-hover:rotate-12 transition-transform duration-300">shopping_bag</span>
        <span class="font-headline font-bold text-xs tracking-widest text-on-surface uppercase">Cart</span>
        <?php if($cart_count > 0): ?>
            <div class="flex items-center justify-center w-5 h-5 rounded-full bg-primary text-[10px] text-white animate-bounce"><?= $cart_count ?></div>
        <?php else: ?>
            <div class="w-2 h-2 rounded-full bg-primary relative"><div class="absolute inset-0 bg-primary rounded-full animate-ping opacity-75"></div></div>
        <?php endif; ?>
    </a>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true,
        offset: 50
    });
</script>

</body>
</html>
