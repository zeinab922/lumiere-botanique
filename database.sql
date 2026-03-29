CREATE DATABASE IF NOT EXISTS lumiere_botanique;
USE lumiere_botanique;

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url TEXT,
    badge VARCHAR(50),
    ingredients TEXT,
    usage_instructions TEXT,
    skin_type VARCHAR(50) DEFAULT 'All',
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

INSERT INTO categories (name, slug) VALUES 
('Skincare', 'skincare'),
('Body', 'body'),
('Sets', 'sets'),
('Editorial', 'editorial');

INSERT INTO products (category_id, name, slug, description, price, image_url, badge, skin_type) VALUES 
(1, 'HYDRA-SILK BARRIER CREAM', 'hydra-silk-barrier-cream', 'A weightless, biocompatible moisturizer.', 84.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAPBajqKvvfXXTa3YqQKlOj5cEDn-wQr3TOaAoj02VvWugX4RWhQ41NNZoon4tuBBMyxbcceDbxIMG1JCaToXqMWLvDYwvApTANISOyTGUYJH4S_0vp80rpg8dtOHqlqhQfVfTpqF_Z_8McCKJqm_GO4rHqqPXFTZBDOO8M1_KeVFBWt9QHuIyD4_FlxYrK_Nmgf9Q6aOXjv1ckVlofFifk4MTvXO5yqh8OCgyC1fEY5QBeQWElq6o2KWcm1pUB0zmDHmM0obcVFRqS', '', 'Dry'),
(1, 'RETINOL ALTERNATIVE ELIXIR', 'retinol-alternative-elixir', 'A luxury serum alternative for retinol.', 110.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuBiasSPS7LfkeK6kn9brhB9Gxqv0qYkuqf7BxD8B4HWEwNCtDkayR7n6ncJx3uUXLXlGq2pCc5ixk1CNbZYL7NbfdF4esR4C5Xr_0mtIJIhvqnf4Q2YMMgG8DF8kPh8E0EOHEKg8Cs5LbdNmvQt_VJMCYSf80dSLFwCFB8FFLz-w-msYXwI9qtiFJdBj0JUV7JQPhMUr8IIs8JQcvSaHX2VWu9TzYUEbmmQQsrXFTNKOsxTdMc_FyuGR96wgPwtOavS1MEdbpHrkrQ9', '', 'All'),
(1, 'DOUBLE PHASE OIL CLEANSER', 'double-phase-oil-cleanser', 'A gentle dual phase cleanser.', 45.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuBkN_T-O-xK840z8HYzhBe47aVcIxI24O98RR6OrOd4ADGbAv6Y8Y45TAphag6MiWUJshyTXINUubXwAUXUymBQzNF1APn9O6nEWjZw2dFM_Xd9VCLsdXAc8oHzwe-6wVF9IYLjyVnFYaAmRbpzRajXMRLbOycfQkR95hNRHhmcwrajeV-gys-3hxfvnjn9xI4BAzVUYlcOZgGknIwsNNxDfG8VD4IkAYC3mOR9NelJPnlCCgxdudjiU_d_dSspknCTjHJY6iu3-J90', '', 'Sensitive'),
(1, 'INVISIBLE SPF 50 SHIELD', 'invisible-spf-50-shield', 'An invisible sun shield with level 50 protection.', 62.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuB6utlojq9CDVxyZxHJsEComPrmGZnpLkEI_iGgxwFkpUuEC-aWHpwP5HQR3VpO67EZqZZK5RoHo8StYD8oydr9PgjSVoDRp3aN_H6VydiGAcO8R7bLN7LyF8aTW7Ac-U8FSyOLskgaufKbbZ0Ed2IhRlLtSmMOCX5NXdUEdo4vEdMvYUkwFUv1AlhRSmkTcFagT7cwiAHYyhxpF-UmtUECDNo9YB4Paytg-l8NpW9GPFHRLS8nl0WLExxVxjQ1986A2IGEjcy5mnK3', '', 'All'),
( 1, 'VELLUM HYDRATING NECTAR', 'vellum-hydrating-nectar', 'A weightless, biocompatible serum engineered to mimic the skin\'s natural lipid barrier. Infused with fermented botanical extracts to deliver intense cellular hydration and a luminous, glass-skin finish.', 84.00, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAr992XCKBMPhcHfpvmnmyG2-EPop00NRScZWtrs-divUgJUU6wD8sQOhYXUUPqJWyVd-hOSP267eutuDQBoJsEp-nD2mAH93IBmKlpM3LC1JYGZEagyHTbLM6RL_sGhu2BCMvOGtqRZDJJ1QFmBK-tWO9rJtZd64snCUqUk2hPDd97iiw6nCVgY71Etv2igY3v5XtDm3fIp-TykX7TpKHnZqLav4AWjPqcjzDnheUm_rYLHe2-gEjJSDHOx_kcmW98jPlJjpE3m1Bg', 'New Arrival', 'Dry');
