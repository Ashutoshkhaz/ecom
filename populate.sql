-- Clear existing data in the correct order (child tables first)
SET FOREIGN_KEY_CHECKS = 0;

-- First, clear tables with no dependencies
TRUNCATE TABLE product_images;
TRUNCATE TABLE order_items;
TRUNCATE TABLE blog_comments;

-- Then clear tables with foreign keys
TRUNCATE TABLE orders;
TRUNCATE TABLE blog_posts;
TRUNCATE TABLE products;

-- Finally clear parent tables
TRUNCATE TABLE categories;
TRUNCATE TABLE blog_categories;
TRUNCATE TABLE users;

SET FOREIGN_KEY_CHECKS = 1;

-- Now proceed with populating data in the correct order (parent tables first)
-- Populate categories
INSERT INTO categories (name, slug, description, meta_title, meta_description) VALUES
('Electronics', 'electronics', 'Latest electronic gadgets and devices', 'Electronics - Modern E-commerce', 'Shop the latest electronic gadgets and devices'),
('Clothing', 'clothing', 'Trendy fashion and apparel', 'Clothing - Modern E-commerce', 'Discover trendy fashion and apparel'),
('Books', 'books', 'Best-selling books and literature', 'Books - Modern E-commerce', 'Explore our collection of best-selling books'),
('Home & Living', 'home-living', 'Home decor and furniture', 'Home & Living - Modern E-commerce', 'Transform your home with our decor collection'),
('Sports', 'sports', 'Sports equipment and accessories', 'Sports Equipment - Modern E-commerce', 'Quality sports gear for athletes');

-- Insert test user first (needed for blog posts)
INSERT INTO users (email, password, first_name, last_name, role) VALUES
('admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'User', 'admin');

-- Populate blog categories (needed for blog posts)
INSERT INTO blog_categories (name, slug, description) VALUES
('Tech News', 'tech-news', 'Latest technology news and updates'),
('Fashion Trends', 'fashion-trends', 'Current fashion trends and style tips'),
('Lifestyle', 'lifestyle', 'Tips for better living and wellness'),
('Product Reviews', 'product-reviews', 'In-depth reviews of our products');

-- Populate products
INSERT INTO products (name, slug, description, price, stock_quantity, category_id, meta_title, meta_description, created_at) VALUES
-- Electronics
('Wireless Earbuds Pro', 'wireless-earbuds-pro', 'High-quality wireless earbuds with noise cancellation', 129.99, 50, 1, 'Wireless Earbuds Pro - Premium Sound', 'Experience premium sound with our wireless earbuds', NOW()),
('Smart Watch X', 'smart-watch-x', 'Advanced smartwatch with health tracking features', 199.99, 30, 1, 'Smart Watch X - Track Your Health', 'Stay healthy with our advanced smartwatch', NOW()),
('4K Ultra HD TV', '4k-ultra-hd-tv', '55-inch 4K Smart TV with HDR', 699.99, 15, 1, '4K Ultra HD TV - Crystal Clear Display', 'Immerse yourself in 4K entertainment', NOW()),

-- Clothing
('Men\'s Classic T-Shirt', 'mens-classic-tshirt', 'Comfortable cotton t-shirt for everyday wear', 24.99, 100, 2, 'Men\'s Classic T-Shirt - Comfort Wear', 'Classic comfort for everyday style', NOW()),
('Women\'s Yoga Pants', 'womens-yoga-pants', 'High-waisted yoga pants with pocket', 49.99, 75, 2, 'Women\'s Yoga Pants - Active Wear', 'Comfortable yoga pants for active lifestyle', NOW()),
('Denim Jacket', 'denim-jacket', 'Classic denim jacket with modern fit', 79.99, 40, 2, 'Denim Jacket - Timeless Style', 'Classic denim jacket for any occasion', NOW()),

-- Books
('The Art of Programming', 'art-of-programming', 'Comprehensive guide to modern programming', 39.99, 60, 3, 'The Art of Programming - Coding Guide', 'Master programming with our comprehensive guide', NOW()),
('Healthy Living Guide', 'healthy-living-guide', 'Complete guide to healthy lifestyle', 29.99, 45, 3, 'Healthy Living Guide - Wellness Book', 'Transform your life with healthy living tips', NOW()),
('Mystery at Midnight', 'mystery-at-midnight', 'Thrilling mystery novel', 19.99, 80, 3, 'Mystery at Midnight - Thriller Novel', 'Engage in this thrilling mystery story', NOW()),

-- Home & Living
('Modern Coffee Table', 'modern-coffee-table', 'Sleek design coffee table for living room', 199.99, 20, 4, 'Modern Coffee Table - Home Decor', 'Enhance your living room with our modern coffee table', NOW()),
('Scented Candle Set', 'scented-candle-set', 'Set of 3 premium scented candles', 34.99, 65, 4, 'Scented Candle Set - Home Fragrance', 'Create ambiance with our scented candles', NOW()),
('Throw Pillow Set', 'throw-pillow-set', 'Decorative throw pillows set of 4', 49.99, 55, 4, 'Throw Pillow Set - Home Accessories', 'Add comfort and style with our throw pillows', NOW()),

-- Sports
('Yoga Mat Premium', 'yoga-mat-premium', 'Extra thick yoga mat with carrying strap', 39.99, 70, 5, 'Yoga Mat Premium - Exercise Equipment', 'Premium yoga mat for comfortable practice', NOW()),
('Basketball Pro', 'basketball-pro', 'Professional indoor/outdoor basketball', 29.99, 85, 5, 'Basketball Pro - Sports Equipment', 'Professional grade basketball for players', NOW()),
('Fitness Resistance Bands', 'fitness-resistance-bands', 'Set of 5 resistance bands with different strengths', 24.99, 95, 5, 'Fitness Resistance Bands - Exercise Gear', 'Complete your home workout with resistance bands', NOW());

-- Populate product images
INSERT INTO product_images (product_id, image_path, is_primary) VALUES
(1, '/assets/images/products/wireless-earbuds-1.jpg', 1),
(1, '/assets/images/products/wireless-earbuds-2.jpg', 0),
(2, '/assets/images/products/smartwatch-1.jpg', 1),
(2, '/assets/images/products/smartwatch-2.jpg', 0),
(3, '/assets/images/products/tv-1.jpg', 1),
(4, '/assets/images/products/tshirt-1.jpg', 1),
(4, '/assets/images/products/tshirt-2.jpg', 0),
(5, '/assets/images/products/yoga-pants-1.jpg', 1),
(6, '/assets/images/products/denim-jacket-1.jpg', 1);

-- Populate blog posts
INSERT INTO blog_posts (title, slug, content, excerpt, featured_image, category_id, status, meta_title, meta_description) VALUES
('Top Tech Trends of 2024', 'top-tech-trends-2024', 
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
'Discover the latest technology trends shaping our future',
'/assets/images/blog/tech-trends.jpg', 1, 'published',
'Top Tech Trends 2024 - Tech Blog', 'Explore the latest technology trends of 2024'),

('Summer Fashion Guide', 'summer-fashion-guide-2024',
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
'Your complete guide to summer fashion',
'/assets/images/blog/summer-fashion.jpg', 2, 'published',
'Summer Fashion Guide 2024 - Style Blog', 'Get ready for summer with our fashion guide'),

('Healthy Living Tips', 'healthy-living-tips',
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
'Essential tips for a healthy lifestyle',
'/assets/images/blog/healthy-living.jpg', 3, 'published',
'Healthy Living Tips - Lifestyle Blog', 'Transform your life with these healthy living tips'); 