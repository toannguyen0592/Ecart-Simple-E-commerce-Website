--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `id` int(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `product_code` int(8) UNIQUE KEY,
  `category` varchar(255) NOT NULL,
  `subcategory` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`name`, `category`, `subcategory`, `code`, `image`, `price`) VALUES
('Mens Jacket', 'Clothing', 'Men', 'MJacket', 'product-images/menjacket.jpg', 125.00),
('Mens Patterned Shirt', 'Clothing', 'Men', 'MShirt', 'product-images/menshirt.jpg', 50.00),
('Mens Skinny-fit Jean', 'Clothing', 'Men', 'MJean', 'product-images/menjean.jpg', 50.00),
('Womens Jacket', 'Clothing', 'Women', 'FJacket', 'product-images/womenjacket.jpg', 125.00),
('Womens Patterned Shirt', 'Clothing', 'Women', 'FTop', 'product-images/womentop.jpg', 50.00),
('Womens Skinny-fit Jean', 'Clothing', 'Women', 'FPant', 'product-images/womenpant.jpg', 50.00),
('Stylish Sunglasses', 'Accessories', 'Glasses', 'SunGlasses', 'product-images/glasses.jpg', 125.00),
('Black Apple Smartwatch', 'Accessories', 'Watches', 'AppSmWatch', 'product-images/smartwatch.jpg', 150.00),
('Fashionable Vintage Watch', 'Accessories', 'Watches', 'VintWatch', 'product-images/vintagewatch.jpg', 200.00),
('Mens Basketball Sneaker', 'Shoes', 'Men', 'MBSneaker', 'product-images/menshoes.jpg', 180.00),
('Womens Midheight Heels', 'Shoes', 'Women', 'WMidHeels', 'product-images/womenshoes.jpg', 120.00),
('Pentax Camera', 'Electronics', 'Cameras', 'PentaxCMR', 'product-images/camera.jpg', 1200.00),
('Kodak Pony 828 Camera', 'Electronics', 'Cameras', 'KodakCMR', 'product-images/vintagecamera.jpg', 1500.00),
('Apple Earbuds', 'Electronics', 'Headphones', 'AppEarbuds', 'product-images/earbuds.jpg', 100.00),
('High-Tech Drone', 'Electronics', 'Drones', 'HTDrone', 'product-images/drone.jpg', 150.00),
('Sony PS4 1TB Console', 'Electronics', 'Gaming', 'PS41TB', 'product-images/gaming console.jpg', 300.00),
('Macbook Pro 128GB', 'Electronics', 'Laptop', 'McBkPRO', 'product-images/laptop.jpg', 1299.00),
('Sporty Cruising Bike', 'Sports', 'Bikes', 'SPBikes', 'product-images/bike.jpg', 200.00),
('High Quality Basketball', 'Sports', 'Equipment', 'hQBasketball', 'product-images/basketball.jpg', 100.00),
('Premium Soccer Ball', 'Sports', 'Equipment', 'PremSoccBall', 'product-images/soccerball.jpg', 180.00),
('Top-rated Tennis Ball', 'Sports', 'Equipment', 'TRTennBall', 'product-images/tennisball.jpg', 70.00);

