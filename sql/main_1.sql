-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: May 02, 2025 at 10:42 AM
-- Server version: 11.7.2-MariaDB-ubu2404
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `example`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `car_id`, `date`, `purpose`, `notes`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '2025-05-08 17:30:00', 'purchase', 'Nothing to talk', 'pending', '2025-05-01 03:53:12', '2025-05-01 03:53:12'),
(2, 4, 2, '2025-05-20 12:28:00', 'inspection', 'Hello store, I will see with my friend. See u soon!', 'cancelled', '2025-05-01 04:38:50', '2025-05-02 10:35:32'),
(3, 4, 9, '2025-05-16 17:40:00', 'financing', 'Looking to discuss monthly payment plans.', 'confirmed', '2025-05-01 04:58:31', '2025-05-01 05:00:54');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `cover_image_id` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `content`, `author_id`, `cover_image_id`, `views`, `created_at`, `updated_at`) VALUES
(1, 'How to Choose the Right Car', 'Content about choosing a car...', 1, 7, 144, '2025-04-07 17:38:20', '2025-05-01 15:24:44'),
(2, 'Benefits of Electric Cars', 'Electric cars save fuel...', 2, 8, 217, '2025-04-07 17:38:20', '2025-05-01 15:23:59'),
(3, 'Proper Car Maintenance', 'Guide to maintaining your car...', 3, 12, 171, '2025-04-07 17:38:20', '2025-04-28 02:52:27'),
(34, 'Top 10 Tips for First-Time Car Buyers', '<div style=\"font-family: Arial, sans-serif; line-height: 1.6;\">\r\n    <h2>Introduction</h2>\r\n    <p>Buying your first car is an exciting milestone, but it can also be overwhelming. With so many options and factors to consider, it's easy to feel lost. This guide provides 10 essential tips to help first-time car buyers make an informed decision.</p>\r\n    <h3>1. Set a Budget</h3>\r\n    <p>Before you start shopping, determine how much you can afford to spend. Consider not only the purchase price but also ongoing costs like insurance, fuel, and maintenance. A good rule of thumb is to keep your car payment under 15% of your monthly income.</p>\r\n    <h3>2. Research Your Needs</h3>\r\n    <p>Think about how you'll use the car. Do you need a compact car for city driving, or a larger vehicle for family trips? Make a list of must-have features like fuel efficiency, safety ratings, or cargo space.</p>\r\n    <h3>3. New vs. Used</h3>\r\n    <p>New cars come with a warranty and the latest technology, but they depreciate quickly. Used cars are more affordable but may require more maintenance. Weigh the pros and cons based on your budget and preferences.</p>\r\n    <h3>4. Test Drive Multiple Cars</h3>\r\n    <p>Never buy a car without test-driving it first. Pay attention to how it handles, the comfort of the seats, and the visibility. Test drive a few different models to compare.</p>\r\n    <h3>5. Check the Vehicle History</h3>\r\n    <p>If you're buying a used car, always check its history report using the VIN (Vehicle Identification Number). Look for accidents, ownership history, and maintenance records to ensure you're getting a reliable vehicle.</p>\r\n    <h3>6. Negotiate the Price</h3>\r\n    <p>Don't accept the sticker price as final. Research the market value of the car and be prepared to negotiate. Dealerships often have room to lower the price, especially if you're paying in cash or have a trade-in.</p>\r\n    <h3>7. Understand Financing Options</h3>\r\n    <p>If you're financing your car, shop around for the best loan rates. Dealerships may offer financing, but credit unions or banks often have better terms. Aim for a loan term of 60 months or less to avoid excessive interest.</p>\r\n    <h3>8. Review Insurance Costs</h3>\r\n    <p>Insurance premiums vary based on the car's make, model, and your driving history. Get quotes for the cars you're considering to factor insurance into your budget.</p>\r\n    <h3>9. Inspect the Car</h3>\r\n    <p>Before finalizing the purchase, have the car inspected by a trusted mechanic. They can identify potential issues that might not be obvious during a test drive.</p>\r\n    <h3>10. Read the Fine Print</h3>\r\n    <p>Before signing any paperwork, read all terms and conditions carefully. Make sure you understand the warranty, return policy, and any additional fees.</p>\r\n    <h2>Conclusion</h2>\r\n    <p>Buying your first car doesn't have to be stressful. By following these tips, you'll be well-prepared to find a vehicle that fits your needs and budget. Happy car shopping!</p>\r\n </div>', 1, 17, 155, '2025-04-07 17:38:20', '2025-04-30 18:17:19'),
(35, 'The Future of Electric Vehicles', '<div style=\"font-family: Arial, sans-serif; line-height: 1.6;\">\r\n    <h2>Introduction</h2>\r\n    <p>Electric vehicles (EVs) are revolutionizing the automotive industry. With advancements in battery technology and growing environmental concerns, EVs are becoming a viable option for many drivers. This article explores the future of electric vehicles and their impact on the world.</p>\r\n    <h3>The Rise of EVs</h3>\r\n    <p>In recent years, the demand for EVs has surged. Governments around the world are offering incentives to encourage adoption, while automakers are investing heavily in electric technology. By 2030, it's estimated that EVs will account for 30% of global car sales.</p>\r\n    <h3>Advancements in Battery Technology</h3>\r\n    <p>One of the biggest challenges for EVs has been battery range. However, new developments in solid-state batteries promise to increase range and reduce charging times. Some companies are even working on batteries that can charge in under 10 minutes.</p>\r\n    <h3>Charging Infrastructure</h3>\r\n    <p>A robust charging network is crucial for widespread EV adoption. Many countries are building thousands of charging stations, with some even offering ultra-fast chargers that can power up a car in 20 minutes. Wireless charging technology is also on the horizon.</p>\r\n    <h3>Environmental Benefits</h3>\r\n    <p>EVs produce zero tailpipe emissions, making them a cleaner alternative to traditional gas-powered cars. Over their lifetime, EVs can reduce greenhouse gas emissions by up to 50%, especially when powered by renewable energy sources.</p>\r\n    <h3>Challenges Ahead</h3>\r\n    <p>Despite their benefits, EVs face challenges. The high cost of batteries makes them more expensive than traditional cars, though prices are expected to drop. Additionally, the production of batteries raises concerns about resource scarcity and environmental impact.</p>\r\n    <h3>The Role of Autonomous Driving</h3>\r\n    <p>Many EVs are being designed with autonomous driving in mind. Companies like Tesla are leading the way with advanced driver-assistance systems, and fully autonomous EVs could become a reality in the next decade.</p>\r\n    <h2>Conclusion</h2>\r\n    <p>The future of electric vehicles looks bright, with technology and infrastructure improvements paving the way for mass adoption. While challenges remain, EVs are set to play a key role in creating a more sustainable transportation system.</p>\r\n </div>', 2, 7, 204, '2025-04-07 17:38:20', '2025-04-30 18:16:48'),
(36, 'How to Maintain Your Car Like a Pro', '<div style=\"font-family: Arial, sans-serif; line-height: 1.6;\">\r\n    <h2>Introduction</h2>\r\n    <p>Regular car maintenance is essential for keeping your vehicle in top condition and extending its lifespan. This guide provides professional tips to help you maintain your car like an expert.</p>\r\n    <h3>1. Check Your Oil Regularly</h3>\r\n    <p>Engine oil lubricates your car's engine, preventing wear and tear. Check your oil level monthly and change it every 5,000 to 7,500 miles, depending on your car's requirements. Use the recommended oil type for best performance.</p>\r\n    <h3>2. Monitor Tire Pressure</h3>\r\n    <p>Proper tire pressure improves fuel efficiency and ensures safe handling. Check your tire pressure at least once a month, especially before long trips. The recommended pressure is usually listed in your car's manual or on the driver's side door.</p>\r\n    <h3>3. Rotate Your Tires</h3>\r\n    <p>Tire rotation helps ensure even wear, extending the life of your tires. Rotate your tires every 6,000 to 8,000 miles or during every other oil change.</p>\r\n    <h3>4. Replace Air Filters</h3>\r\n    <p>A dirty air filter can reduce engine performance and fuel efficiency. Check your air filter every 15,000 miles and replace it if it's clogged with dirt or debris.</p>\r\n    <h3>5. Inspect Brakes</h3>\r\n    <p>Your brakes are critical for safety. Listen for unusual noises like squeaking or grinding, and have your brakes inspected if you notice any issues. Replace brake pads every 30,000 to 70,000 miles, depending on your driving habits.</p>\r\n    <h3>6. Keep Your Car Clean</h3>\r\n    <p>Regular washing and waxing protect your car's paint from damage caused by dirt, salt, and UV rays. Clean the interior to prevent wear on upholstery and dashboard components.</p>\r\n    <h3>7. Check Fluid Levels</h3>\r\n    <p>In addition to oil, check other fluids like coolant, brake fluid, transmission fluid, and windshield washer fluid. Top them off as needed to keep your car running smoothly.</p>\r\n    <h2>Conclusion</h2>\r\n    <p>By following these maintenance tips, you can keep your car in excellent condition and avoid costly repairs. A well-maintained car not only performs better but also retains its value over time.</p>\r\n </div>', 3, 8, 207, '2025-04-07 17:38:20', '2025-04-27 13:57:04'),
(37, 'The Best SUVs for Families in 2025', '<div style=\"font-family: Arial, sans-serif; line-height: 1.6;\">\r\n    <h2>Introduction</h2>\r\n    <p>Finding the right SUV for your family can be challenging with so many options on the market. This article highlights the best SUVs for families in 2025, focusing on safety, space, and features.</p>\r\n    <h3>1. Toyota Highlander</h3>\r\n    <p>The Toyota Highlander offers seating for up to 8, excellent safety ratings, and a smooth ride. It comes with standard features like adaptive cruise control and lane departure warning, making it ideal for family road trips.</p>\r\n    <h3>2. Honda Pilot</h3>\r\n    <p>The Honda Pilot is known for its spacious interior and versatile cargo space. It also offers a quiet cabin and a suite of driver-assistance features, perfect for busy families.</p>\r\n    <h3>3. Ford Explorer</h3>\r\n    <p>The Ford Explorer combines power and practicality with a towing capacity of up to 5,600 pounds. Its infotainment system is user-friendly, and it offers plenty of room for passengers and gear.</p>\r\n    <h3>4. Kia Telluride</h3>\r\n    <p>The Kia Telluride stands out with its upscale design and long list of standard features. It has a comfortable ride, ample seating, and a 10-year/100,000-mile warranty for peace of mind.</p>\r\n    <h3>5. Hyundai Palisade</h3>\r\n    <p>The Hyundai Palisade is a close cousin to the Telluride, offering similar features at a competitive price. It's praised for its luxurious interior and smooth handling.</p>\r\n    <h2>Conclusion</h2>\r\n    <p>These SUVs offer the perfect blend of safety, space, and technology for families in 2025. Test drive a few to find the one that best fits your needs.</p>\r\n </div>', 1, 10, 221, '2025-04-07 17:38:20', '2025-04-27 02:11:27'),
(38, 'Understanding Hybrid Cars: Are They Right for You?', '<div style=\"font-family: Arial, sans-serif; line-height: 1.6;\">\r\n    <h2>Introduction</h2>\r\n    <p>Hybrid cars combine a gasoline engine with an electric motor, offering better fuel efficiency and lower emissions. But are they the right choice for you? This article explores the pros and cons of hybrid vehicles.</p>\r\n    <h3>How Hybrids Work</h3>\r\n    <p>Hybrids use both a gas engine and an electric motor, switching between them or using both for optimal efficiency. Many hybrids also feature regenerative braking, which recharges the battery while you drive.</p>\r\n    <h3>Benefits of Hybrids</h3>\r\n    <p>Hybrids typically get better gas mileage than traditional cars, saving you money on fuel. They also produce fewer emissions, making them a greener option. Additionally, many hybrids qualify for tax incentives.</p>\r\n    <h3>Drawbacks of Hybrids</h3>\r\n    <p>Hybrids often have a higher upfront cost due to their dual powertrain. Battery replacement can also be expensive, though most hybrid batteries are designed to last 8-10 years or more.</p>\r\n    <h3>Popular Hybrid Models</h3>\r\n    <p>Some of the best hybrids in 2025 include the Toyota Prius, Honda Accord Hybrid, and Ford Escape Hybrid. Each offers a balance of efficiency, comfort, and technology.</p>\r\n    <h3>Is a Hybrid Right for You?</h3>\r\n    <p>If you drive a lot in stop-and-go traffic, a hybrid can save you money on fuel. However, if you frequently take long highway trips, a traditional gas car might be more practical.</p>\r\n    <h2>Conclusion</h2>\r\n    <p>Hybrid cars are a great option for eco-conscious drivers who want to save on fuel. Consider your driving habits and budget to decide if a hybrid is the right fit.</p>\r\n </div>', 2, 12, 162, '2025-04-07 17:38:20', '2025-04-27 07:16:39'),
(39, 'The Pros and Cons of Leasing a Car', '<div style=\"font-family: Arial, sans-serif; line-height: 1.6;\">\r\n    <h2>Introduction</h2>\r\n    <p>Leasing a car is an alternative to buying that can be appealing for some drivers. This article breaks down the pros and cons of leasing to help you decide if it's the right option for you.</p>\r\n    <h3>Pros of Leasing</h3>\r\n    <p>Leasing often comes with lower monthly payments compared to buying, since you're only paying for the car's depreciation during the lease term. You also get to drive a new car every few years, with the latest technology and features.</p>\r\n    <h3>Cons of Leasing</h3>\r\n    <p>Leasing means you don't own the car, so you can't modify it or sell it. There are also mileage limits (typically 10,000-15,000 miles per year), and exceeding them can result in hefty fees.</p>\r\n    <h3>Leasing Costs</h3>\r\n    <p>In addition to monthly payments, leasing often involves upfront costs like a down payment, security deposit, and acquisition fee. You may also be charged for excess wear and tear when you return the car.</p>\r\n    <h3>Who Should Lease?</h3>\r\n    <p>Leasing is ideal for those who prefer driving new cars, don't drive a lot, and don't want the long-term commitment of ownership. It's less suitable for those who want to customize their vehicle or drive high mileage.</p>\r\n    <h2>Conclusion</h2>\r\n    <p>Leasing can be a smart choice for some drivers, but it's not for everyone. Weigh the pros and cons carefully before signing a lease agreement.</p>\r\n </div>', 3, 21, 193, '2025-04-07 17:38:20', '2025-04-26 16:33:40'),
(40, 'Top 5 Affordable Cars for Young Drivers', '<div style=\"font-family: Arial, sans-serif; line-height: 1.6;\">\r\n    <h2>Introduction</h2>\r\n    <p>Young drivers often need a car that's affordable, reliable, and easy to drive. This article highlights the top 5 affordable cars for young drivers in 2025.</p>\r\n    <h3>1. Honda Civic</h3>\r\n    <p>The Honda Civic is a reliable compact car with excellent fuel efficiency and low maintenance costs. It also has a sporty design that appeals to younger drivers.</p>\r\n    <h3>2. Toyota Corolla</h3>\r\n    <p>The Toyota Corolla is known for its durability and affordability. It comes with standard safety features like automatic emergency braking, making it a great choice for new drivers.</p>\r\n    <h3>3. Hyundai Elantra</h3>\r\n    <p>The Hyundai Elantra offers a stylish design, good fuel economy, and a long warranty. It's also packed with tech features like a touchscreen infotainment system.</p>\r\n    <h3>4. Kia Forte</h3>\r\n    <p>The Kia Forte is a budget-friendly option with a comfortable ride and user-friendly technology. It also has a great warranty, giving young drivers peace of mind.</p>\r\n    <h3>5. Mazda 3</h3>\r\n    <p>The Mazda 3 combines affordability with a premium feel. It's fun to drive and offers good fuel efficiency, making it a popular choice for young drivers.</p>\r\n    <h2>Conclusion</h2>\r\n    <p>These affordable cars offer reliability, safety, and style for young drivers on a budget. Be sure to test drive a few to find the perfect fit.</p>\r\n </div>', 1, 14, 140, '2025-04-07 17:38:20', '2025-04-26 15:35:22'),
(41, 'A Beginner's Guide to Car Insurance', '<div style=\"font-family: Arial, sans-serif; line-height: 1.6;\">\r\n    <h2>Introduction</h2>\r\n    <p>Car insurance is a legal requirement in most places, but understanding it can be confusing for beginners. This guide explains the basics of car insurance and how to choose the right policy.</p>\r\n    <h3>Types of Coverage</h3>\r\n    <p>Car insurance typically includes several types of coverage: liability, collision, comprehensive, and uninsured motorist protection. Liability covers damage you cause to others, while collision and comprehensive cover your car.</p>\r\n    <h3>Factors Affecting Premiums</h3>\r\n    <p>Your insurance premium depends on factors like your age, driving record, location, and the type of car you drive. Sports cars and luxury vehicles often have higher premiums due to their repair costs.</p>\r\n    <h3>How to Save on Insurance</h3>\r\n    <p>You can lower your premium by maintaining a clean driving record, bundling policies (like auto and home insurance), and choosing a car with good safety ratings. Many insurers also offer discounts for students or safe drivers.</p>\r\n    <h3>Choosing a Policy</h3>\r\n    <p>When choosing a policy, consider your budget and coverage needs. A higher deductible can lower your premium, but make sure you can afford the out-of-pocket cost in case of a claim.</p>\r\n    <h2>Conclusion</h2>\r\n    <p>Car insurance is an essential part of car ownership. By understanding your options and shopping around, you can find a policy that offers the right protection at a price you can afford.</p>\r\n </div>', 2, 15, 170, '2025-04-07 17:38:20', '2025-04-26 15:30:45'),
(42, 'The Evolution of Car Safety Features', '<div style=\"font-family: Arial, sans-serif; line-height: 1.6;\">\r\n    <h2>Introduction</h2>\r\n    <p>Car safety features have come a long way over the decades, evolving from basic seat belts to advanced driver-assistance systems. This article explores the history and future of car safety.</p>\r\n    <h3>Early Safety Features</h3>\r\n    <p>In the 1950s, seat belts became one of the first safety features in cars. By the 1980s, airbags were introduced, significantly reducing the risk of injury in crashes.</p>\r\n    <h3>Modern Safety Technology</h3>\r\n    <p>Today's cars are equipped with advanced features like automatic emergency braking, lane departure warnings, and adaptive cruise control. These technologies use sensors and cameras to help prevent accidents.</p>\r\n    <h3>The Role of Crash Testing</h3>\r\n    <p>Organizations like the NHTSA and Euro NCAP conduct crash tests to evaluate car safety. Their ratings help consumers choose vehicles that offer the best protection.</p>\r\n    <h3>The Future of Car Safety</h3>\r\n    <p>Looking ahead, car safety will continue to improve with the rise of autonomous driving. Features like pedestrian detection and vehicle-to-vehicle communication could drastically reduce accidents.</p>\r\n    <h2>Conclusion</h2>\r\n    <p>Car safety features have evolved significantly, making driving safer than ever before. As technology advances, we can expect even greater improvements in the years to come.</p>\r\n </div>', 3, 16, 213, '2025-04-07 17:38:20', '2025-04-26 16:29:39'),
(43, 'How to Prepare Your Car for a Long Road Trip', '<div style=\"font-family: Arial, sans-serif; line-height: 1.6;\">\r\n    <h2>Introduction</h2>\r\n    <p>A long road trip can be a fun adventure, but it's important to prepare your car to ensure a safe and smooth journey. This guide provides tips to get your car ready for the road.</p>\r\n    <h3>1. Check Your Tires</h3>\r\n    <p>Inspect your tires for wear and ensure they're properly inflated. Don't forget to check the spare tire as well, and make sure you have a jack and tools for changing a flat.</p>\r\n    <h3>2. Test Your Battery</h3>\r\n    <p>A dead battery can leave you stranded. Have your battery tested before your trip, and replace it if it's more than 3-4 years old or showing signs of weakness.</p>\r\n    <h3>3. Inspect Fluids</h3>\r\n    <p>Check all fluids, including oil, coolant, brake fluid, and windshield washer fluid. Top them off as needed, and consider an oil change if you're due for one.</p>\r\n    <h3>4. Pack an Emergency Kit</h3>\r\n    <p>Bring an emergency kit with items like a first-aid kit, jumper cables, a flashlight, blankets, and water. It's also a good idea to have a roadside assistance plan.</p>\r\n    <h3>5. Plan Your Route</h3>\r\n    <p>Map out your route in advance and check for road closures or construction. Have a GPS or navigation app handy, but also bring a paper map as a backup.</p>\r\n    <h2>Conclusion</h2>\r\n    <p>Preparing your car for a long road trip can prevent breakdowns and ensure a safe journey. With a little planning, you'll be ready to hit the road with confidence.</p>\r\n </div>', 1, 17, 134, '2025-04-07 17:38:20', '2025-04-27 02:11:16');

-- --------------------------------------------------------

--
-- Table structure for table `branchs`
--

CREATE TABLE `branchs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `branchs`
--

INSERT INTO `branchs` (`id`, `name`, `address`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Toyota HCM', '123 Nguyễn Huệ, Quận 1, TP.HCM', '0901234567', 'toyota.hcm@example.com', '2025-04-30 09:45:17', '2025-04-30 09:45:17'),
(2, 'Tesla Hà Nội', '456 Lê Lợi, Hoàn Kiếm, Hà Nội', '0912345678', 'tesla.hn@example.com', '2025-04-30 09:45:17', '2025-04-30 09:45:17'),
(3, 'BMW Đà Nẵng', '789 Nguyễn Văn Linh, Hải Châu, Đà Nẵng', '0923456789', 'bmw.dn@example.com', '2025-04-30 09:45:17', '2025-04-30 09:45:17');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `country` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `overview` text DEFAULT NULL,
  `fuel_type` enum('Petrol','Diesel','Electric','Hybrid') DEFAULT 'Petrol',
  `mileage` varchar(50) DEFAULT NULL,
  `drive_type` enum('Self','Automatic','Manual') DEFAULT 'Automatic',
  `service_duration` varchar(50) DEFAULT NULL,
  `body_weight` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `avg_rating` decimal(3,2) DEFAULT 0.00,
  `capabilities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`capabilities`)),
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `name`, `location`, `overview`, `fuel_type`, `mileage`, `drive_type`, `service_duration`, `body_weight`, `price`, `avg_rating`, `capabilities`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Toyota Corollaz', 'HCM City', 'Toyota Corolla is a compact sedan ideal for city driving with great fuel efficiency.', 'Petrol', '15 km/l', 'Automatic', '2 years', '1200 kg', 25000.00, 4.50, '{\"engine\":\"1.8L 4-cylinder\",\"seats\":5,\"features\":[\"Bluetooth\",\"Cruise Control\",\"Backup Camera\"]}', 1, '2025-04-07 17:38:20', '2025-04-26 15:05:59'),
(2, 'Tesla Model 3', 'New York', 'Tesla Model 3 is an all-electric sedan with advanced technology and zero emissions.', 'Electric', '130 kWh', 'Automatic', '4 years', '1600 kg', 40000.00, 4.00, '{\"engine\": \"Electric Motor\", \"seats\": 5, \"features\": [\"Autopilot\", \"Touchscreen\", \"Fast Charging\"]}', 2, '2025-04-07 17:38:20', '2025-04-07 17:38:20'),
(3, 'BMW X5', 'London', 'BMW X5 is a luxury SUV offering comfort and performance.', 'Hybrid', '12 km/l', 'Automatic', '3 years', '2000 kg', 70000.00, 4.50, '{\"engine\": \"3.0L Hybrid\", \"seats\": 5, \"features\": [\"Leather Seats\", \"Panoramic Roof\", \"AWD\"]}', 3, '2025-04-07 17:38:20', '2025-04-21 10:58:51'),
(4, 'Porsche 911', 'Tokyo', 'Porsche 911 is a high-performance sports car built for speed enthusiasts.', 'Petrol', '10 km/l', 'Manual', '2 years', '1400 kg', 120000.00, 5.00, '{\"engine\": \"3.8L Turbo\", \"seats\": 4, \"features\": [\"Sport Suspension\", \"Carbon Fiber\", \"Racing Seats\"]}', 4, '2025-04-07 17:38:20', '2025-04-21 11:03:36'),
(5, 'Jeep Wrangler', 'Sydney', 'Jeep Wrangler is an off-road beast designed for rugged adventures.', 'Diesel', '8 km/l', 'Manual', '5 years', '1900 kg', 35000.00, 4.00, '{\"engine\": \"2.0L Turbo Diesel\", \"seats\": 5, \"features\": [\"4WD\", \"Off-Road Tires\", \"Removable Top\"]}', 5, '2025-04-07 17:38:20', '2025-04-30 17:10:02'),
(6, 'Volvo XC90', 'Stockholm', 'Volvo XC90 is a family SUV with top-tier safety features.', 'Hybrid', '14 km/l', 'Automatic', '3 years', '2100 kg', 65000.00, 0.00, '{\"engine\": \"2.0L Hybrid\", \"seats\": 7, \"features\": [\"Airbags\", \"Lane Assist\", \"Blind Spot Monitor\"]}', 6, '2025-04-07 17:38:20', '2025-04-07 17:38:20'),
(7, 'Audi A4', 'Berlin', 'Audi A4 is a tech-savvy sedan with sleek design and modern features.', 'Petrol', '13 km/l', 'Automatic', '2 years', '1500 kg', 48000.00, 0.00, '{\"engine\": \"2.0L TFSI\", \"seats\": 5, \"features\": [\"Virtual Cockpit\", \"LED Lights\", \"Premium Audio\"]}', 7, '2025-04-07 17:38:20', '2025-04-07 17:38:20'),
(8, 'Ford Fiesta', 'Paris', 'Ford Fiesta is a compact hatchback perfect for urban environments.', 'Petrol', '16 km/l', 'Automatic', '2 years', '1100 kg', 20000.00, 0.00, '{\"engine\": \"1.0L EcoBoost\", \"seats\": 5, \"features\": [\"Parking Sensors\", \"Keyless Entry\", \"Apple CarPlay\"]}', 8, '2025-04-07 17:38:20', '2025-04-07 17:38:20'),
(9, 'Ferrari 488', 'Maranello, Italy', 'Ferrari 488 is a high-performance sports car produced by the Italian manufacturer Ferrari.\nIt was first introduced in 2015 as the successor to the Ferrari 458.\nThe 488 features a 3.9-liter twin-turbocharged V8 engine, producing around 660 horsepower (in the GTB version)', 'Petrol', '15km/l', 'Self', '8 months', '1200kg', 50000.00, 5.00, '{\"engine\":\"Turbo\",\"seats\":4,\"features\":[\"high performance and iconic style\",\"lightweight body\"]}', NULL, '2025-04-13 12:18:47', '2025-04-27 09:53:06');

-- --------------------------------------------------------

--
-- Table structure for table `car_assets`
--

CREATE TABLE `car_assets` (
  `car_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `car_assets`
--

INSERT INTO `car_assets` (`car_id`, `file_id`) VALUES
(1, 3),
(2, 10),
(1, 12),
(4, 16),
(5, 17),
(6, 18),
(8, 19),
(7, 20),
(2, 21),
(3, 23),
(9, 24);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` enum('Color','Style','Feature','Performance','Safety','Comfort','Technology','Material','Size','Fuel') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Economy', 'Affordable and fuel-efficient vehicles', 'Feature', '2025-04-07 17:38:20', '2025-04-07 17:38:20'),
(2, 'Electric', 'Vehicles powered by electric batteries', 'Fuel', '2025-04-07 17:38:20', '2025-04-07 17:38:20'),
(3, 'Luxury', 'High-end vehicles with premium features', 'Comfort', '2025-04-07 17:38:20', '2025-04-07 17:38:20'),
(4, 'Sport', 'Vehicles designed for high performance and speed', 'Performance', '2025-04-07 17:38:20', '2025-04-07 17:38:20'),
(5, 'Off-road', 'Vehicles built for rugged terrain', 'Performance', '2025-04-07 17:38:20', '2025-04-07 17:38:20'),
(6, 'Safety', 'Vehicles with advanced safety features', 'Safety', '2025-04-07 17:38:20', '2025-04-07 17:38:20'),
(7, 'Advanced Tech', 'Vehicles with cutting-edge technology', 'Technology', '2025-04-07 17:38:20', '2025-04-07 17:38:20'),
(8, 'Compact', 'Small-sized vehicles for easy parking', 'Size', '2025-04-07 17:38:20', '2025-04-07 17:38:20'),
(9, 'Hybrid', 'Vehicles combining fuel and electric power', 'Fuel', '2025-04-07 17:38:20', '2025-04-07 17:38:20'),
(10, 'Sedan', 'Four-door passenger cars', 'Style', '2025-04-07 17:38:20', '2025-04-07 17:38:20');

-- --------------------------------------------------------

--
-- Table structure for table `category_mappings`
--

CREATE TABLE `category_mappings` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `entity_type` enum('blogs','cars') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `category_mappings`
--

INSERT INTO `category_mappings` (`id`, `category_id`, `entity_id`, `entity_type`) VALUES
(1, 10, 1, 'cars'),
(2, 10, 3, 'cars'),
(3, 4, 3, 'cars'),
(4, 4, 4, 'cars'),
(5, 4, 5, 'cars'),
(6, 8, 6, 'cars'),
(7, 7, 7, 'cars'),
(8, 8, 8, 'cars'),
(9, 2, 2, 'blogs'),
(10, 1, 1, 'blogs'),
(11, 6, 3, 'blogs'),
(12, 2, 3, 'blogs');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_comment_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `title` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `car_id`, `user_id`, `parent_comment_id`, `rating`, `title`, `content`, `file_id`, `created_at`) VALUES
(1, 1, 1, NULL, 5, 'Very Nice!', 'Smooth ride, fuel-efficient.', NULL, '2025-04-07 17:38:20'),
(2, 2, 2, NULL, 4, 'Great Car', 'Love the tech, but charging takes time.', NULL, '2025-04-07 17:38:20'),
(3, 3, 3, NULL, 4, 'Luxurious', 'Comfortable but expensive.', NULL, '2025-04-07 17:38:20'),
(4, 1, 3, NULL, 4, 'Đánh giá nhanh về Toyota Corolla 2023', '<p><strong>Toyota Corolla 2023</strong> tiếp tục là lựa chọn đáng tin cậy trong phân khúc sedan hạng C. Thiết kế hiện đại, nội thất rộng rãi và trang bị công nghệ an toàn tiên tiến như Toyota Safety Sense 3.0. Động cơ 1.8L hybrid tiết kiệm nhiên liệu, phù hợp cho cả di chuyển đô thị lẫn đường trường. Tuy nhiên, khả năng tăng tốc chưa thực sự ấn tượng so với các đối thủ như Honda Civic. Giá cả hợp lý, bảo trì dễ dàng, Corolla vẫn là \"người bạn đồng hành\" lý tưởng cho gia đình!</p>', 13, '2025-04-21 10:30:26'),
(5, 3, 3, NULL, 5, 'Đánh giá BMW X5 2025 – Sự kết hợp hoàn hảo giữa sang trọng và thể thao', '<p><span style=\"color: #004080\"><strong>BMW X5 2025</strong></span> là lựa chọn lý tưởng cho những ai tìm kiếm sự kết hợp giữa hiệu suất, công nghệ và sự sang trọng, dù không phải là rẻ nhất trong phân khúc.</p>', 14, '2025-04-21 10:58:51'),
(6, 4, 3, NULL, 5, 'Đánh giá Porsche 911 2025 – Biểu tượng thể thao trường tồn', '<p>Xe vẫn giữ được sự linh hoạt giữa lái xe hàng ngày và hiệu suất trên đường đua, dù bản GTS hybrid nặng hơn 50kg so với trước. Giá khởi điểm từ<em> 122.095 USD</em>, bản GTS từ <em>166.895 USD</em>, đắt nhưng xứng đáng với trải nghiệm lái đỉnh cao. Tuy nhiên, việc bỏ tùy chọn số sàn ở Carrera S và nút khởi động thay cho chìa xoay truyền thống khiến một số fan tiếc nuối. <span style=\"color: #008080\"><strong>Porsche 911 2025</strong></span> là minh chứng cho sự tiến hóa không ngừng của một huyền thoại</p>', 15, '2025-04-21 11:03:36'),
(9, 9, 3, NULL, 5, 'Review / Ferrari 488', '<p>The Ferrari 488 is a masterpiece of Italian engineering and design. With its <strong>3.9-liter twin-turbocharged V8 engine</strong>, it delivers breathtaking performance while maintaining impressive efficiency at <strong>15 km/l</strong>.<br>The car's <strong>lightweight body</strong> at <strong>1200 kg</strong> ensures sharp handling and a thrilling driving experience.<br>Built for those who seek both <strong>luxury</strong> and <strong>speed</strong>, the 488 offers <strong>self-drive</strong> excitement, making every journey feel like a race on the track.</p>', 26, '2025-04-27 09:50:32'),
(10, 5, 2, NULL, 4, 'Quick Evaluate', '<p>Good experience!</p>', NULL, '2025-04-30 17:10:02');

--
-- Triggers `comments`
--
DELIMITER $$
CREATE TRIGGER `update_car_rating` AFTER INSERT ON `comments` FOR EACH ROW BEGIN
    DECLARE new_avg_rating DECIMAL(3,2);
    -- Tính trung bình rating của tất cả bình luận cho xe
    SELECT COALESCE(AVG(rating), 0) INTO new_avg_rating
    FROM comments
    WHERE car_id = NEW.car_id;
    -- Cập nhật avg_rating trong bảng cars
    UPDATE cars
    SET avg_rating = new_avg_rating
    WHERE id = NEW.car_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount` decimal(5,2) NOT NULL,
  `expiration_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount`, `expiration_date`, `created_at`) VALUES
(1, 'DISCOUNT10', 10.00, '2025-12-31', '2025-04-07 17:38:20'),
(2, 'SUMMER15', 15.00, '2025-08-31', '2025-04-07 17:38:20'),
(3, 'NEWYEAR20', 20.00, '2026-01-01', '2025-04-07 17:38:20');

--
-- Triggers `coupons`
--
DELIMITER $$
CREATE TRIGGER `update_discounted_price_after_coupon_update` AFTER UPDATE ON `coupons` FOR EACH ROW BEGIN
    UPDATE invoice_coupons ic
    JOIN invoices i ON ic.invoice_id = i.id
    SET ic.discounted_price = i.total_price * (1 - NEW.discount / 100)
    WHERE ic.coupon_id = NEW.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `fkey` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `reg_date` timestamp NULL DEFAULT current_timestamp(),
  `size` bigint(20) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `name`, `fkey`, `url`, `reg_date`, `size`, `type`) VALUES
(1, 'avatar1.jpg', 'key_001', 'https://ui.shadcn.com/avatars/01.png', '2025-04-07 17:38:20', 13916, 'png'),
(2, 'avatar2.jpg', 'key_002', 'https://ui.shadcn.com/avatars/02.png', '2025-04-07 17:38:20', 15329, 'png'),
(3, 'car_video.mp4', 'key_003', 'https://videos.pexels.com/video-files/3066463/3066463-uhd_4096_2160_24fps.mp4', '2025-04-07 17:38:20', 10485760, 'video/mp4'),
(7, 'blog_cover1.png', 'key_007', 'https://cdn.pixabay.com/photo/2024/01/17/12/06/car-8514314_1280.png', '2025-04-07 17:38:20', 1556480, 'png'),
(8, 'blog_cover2.jpg', 'key_008', 'https://cdn.pixabay.com/photo/2016/12/03/18/57/car-1880381_1280.jpg', '2025-04-07 17:38:20', 147169, 'jpg'),
(10, 'car_luxury.jpg', 'cars/1744087366_car_luxury.jpg', 'https://carvannn.s3.ap-southeast-2.amazonaws.com/cars/1744087366_car_luxury.jpg', '2025-04-08 04:42:48', 920191, 'image/jpeg'),
(12, 'car_most.jpg', 'cars/1744099160_car_most.jpg', 'https://carvannn.s3.ap-southeast-2.amazonaws.com/cars/1744099160_car_most.jpg', '2025-04-08 07:59:21', 150370, 'image/jpeg'),
(13, '62e26094556760814b47054d31bce8e3.png', 'comments/1745231424_62e26094556760814b47054d31bce8e3.png', 'https://carvannn.s3.ap-southeast-2.amazonaws.com/comments/1745231424_62e26094556760814b47054d31bce8e3.png', '2025-04-21 10:30:26', 52038, 'image/png'),
(14, 'lai_xe_an_toan.jpg', 'comments/1745233130_lai_xe_an_toan.jpg', 'https://carvannn.s3.ap-southeast-2.amazonaws.com/comments/1745233130_lai_xe_an_toan.jpg', '2025-04-21 10:58:51', 10916, 'image/jpeg'),
(15, 'lai_xe_dang_cap.jpg', 'comments/1745233415_lai_xe_dang_cap.jpg', 'https://carvannn.s3.ap-southeast-2.amazonaws.com/comments/1745233415_lai_xe_dang_cap.jpg', '2025-04-21 11:03:36', 11362, 'image/jpeg'),
(16, 'porsche-911-turbo-720x405px.jpg', 'cars/1745285762_porsche-911-turbo-720x405px.jpg', 'https://carvannn.s3.ap-southeast-2.amazonaws.com/cars/1745285762_porsche-911-turbo-720x405px.jpg', '2025-04-22 01:36:03', 46545, 'image/jpeg'),
(17, '2024-jeep-wrangler114-649ade7362678.jpg', 'cars/1745288989_2024-jeep-wrangler114-649ade7362678.jpg', 'https://carvannn.s3.ap-southeast-2.amazonaws.com/cars/1745288989_2024-jeep-wrangler114-649ade7362678.jpg', '2025-04-22 02:29:51', 488197, 'image/jpeg'),
(18, '2025-volvo-xc90-facelift-00015-2-1725689072785199044274-51-0-1301-2000-crop-17256890918831328168766.webp', 'cars/1745289094_2025-volvo-xc90-facelift-00015-2-1725689072785199044274-51-0-1301-2000-crop-17256890918831328168766.webp', 'https://carvannn.s3.ap-southeast-2.amazonaws.com/cars/1745289094_2025-volvo-xc90-facelift-00015-2-1725689072785199044274-51-0-1301-2000-crop-17256890918831328168766.webp', '2025-04-22 02:31:35', 22918, 'image/webp'),
(19, 'ford-fiesta-ban-chay-2017.jpg', 'cars/1745289135_ford-fiesta-ban-chay-2017.jpg', 'https://carvannn.s3.ap-southeast-2.amazonaws.com/cars/1745289135_ford-fiesta-ban-chay-2017.jpg', '2025-04-22 02:32:16', 83015, 'image/jpeg'),
(20, 'Audi-A4-2024-1.webp', 'cars/1745289183_Audi-A4-2024-1.webp', 'https://carvannn.s3.ap-southeast-2.amazonaws.com/cars/1745289183_Audi-A4-2024-1.webp', '2025-04-22 02:33:04', 219126, 'image/webp'),
(21, 'xedoisong_xe_dien_tesla_model_3_facelift_1.jpg', 'cars/1745289428_xedoisong_xe_dien_tesla_model_3_facelift_1.jpg', 'https://carvannn.s3.ap-southeast-2.amazonaws.com/cars/1745289428_xedoisong_xe_dien_tesla_model_3_facelift_1.jpg', '2025-04-22 02:37:09', 63993, 'image/jpeg'),
(23, 'bmw-x5-b59e.webp', 'cars/1745289929_bmw-x5-b59e.webp', 'https://carvannn.s3.ap-southeast-2.amazonaws.com/cars/1745289929_bmw-x5-b59e.webp', '2025-04-22 02:45:30', 30704, 'image/webp'),
(24, 'ferrari-488-gtb-2-8781-1423013568.webp', 'cars/1745742279_ferrari-488-gtb-2-8781-1423013568.webp', 'https://carvannn.s3.ap-southeast-2.amazonaws.com/cars/1745742279_ferrari-488-gtb-2-8781-1423013568.webp', '2025-04-27 08:24:40', 53264, 'image/webp'),
(25, 'images.jpg', 'comments/1745743967_images.jpg', 'https://carvannn.s3.ap-southeast-2.amazonaws.com/comments/1745743967_images.jpg', '2025-04-27 08:52:48', 9917, 'image/jpeg'),
(26, 'images.jpg', 'comments/1745747431_images.jpg', 'https://carvannn.s3.ap-southeast-2.amazonaws.com/comments/1745747431_images.jpg', '2025-04-27 09:50:32', 9917, 'image/jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `status` enum('Pending','Confirmed','Ready for Pickup','Completed','Cancelled') DEFAULT 'Pending',
  `total_price` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `status`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 'Pending', 25000.00, '2025-04-07 17:38:20', '2025-04-07 17:38:20'),
(2, 'Confirmed', 40000.00, '2025-04-07 17:38:20', '2025-04-07 17:38:20'),
(3, 'Completed', 70000.00, '2025-04-07 17:38:20', '2025-04-07 17:38:20');

--
-- Triggers `invoices`
--
DELIMITER $$
CREATE TRIGGER `update_discounted_price_after_invoice_update` AFTER UPDATE ON `invoices` FOR EACH ROW BEGIN
    UPDATE invoice_coupons ic
    JOIN coupons c ON ic.coupon_id = c.id
    SET ic.discounted_price = NEW.total_price * (1 - c.discount / 100)
    WHERE ic.invoice_id = NEW.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_coupons`
--

CREATE TABLE `invoice_coupons` (
  `invoice_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `discounted_price` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `invoice_coupons`
--

INSERT INTO `invoice_coupons` (`invoice_id`, `coupon_id`, `discounted_price`) VALUES
(1, 1, 22500.00),
(2, 2, 34000.00),
(3, 3, 56000.00);

--
-- Triggers `invoice_coupons`
--
DELIMITER $$
CREATE TRIGGER `update_discounted_price_on_insert` BEFORE INSERT ON `invoice_coupons` FOR EACH ROW BEGIN
    DECLARE invoice_total_price DECIMAL(10,2); -- Tổng giá từ bảng invoices
    DECLARE coupon_discount DECIMAL(5,2); -- Phần trăm giảm giá từ bảng coupons
    
    -- Lấy total_price từ bảng invoices
    SELECT total_price INTO invoice_total_price
    FROM invoices
    WHERE id = NEW.invoice_id;
    
    -- Lấy discount từ bảng coupons
    SELECT discount INTO coupon_discount
    FROM coupons
    WHERE id = NEW.coupon_id;
    
    -- Tính và gán discounted_price cho bản ghi mới
    SET NEW.discounted_price = invoice_total_price * (1 - coupon_discount / 100);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_discounted_price_on_update` BEFORE UPDATE ON `invoice_coupons` FOR EACH ROW BEGIN
    DECLARE invoice_total_price DECIMAL(10,2); -- Tổng giá từ bảng invoices
    DECLARE coupon_discount DECIMAL(5,2); -- Phần trăm giảm giá từ bảng coupons
    
    -- Lấy total_price từ bảng invoices dựa trên invoice_id mới
    SELECT total_price INTO invoice_total_price
    FROM invoices
    WHERE id = NEW.invoice_id;
    
    -- Lấy discount từ bảng coupons dựa trên coupon_id mới
    SELECT discount INTO coupon_discount
    FROM coupons
    WHERE id = NEW.coupon_id;
    
    -- Cập nhật discounted_price cho bản ghi
    SET NEW.discounted_price = invoice_total_price * (1 - coupon_discount / 100);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('Global','Personal') NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created_at`) VALUES
(1, 1, 'Order Confirmed', 'Your order has been confirmed.', 'Personal', 0, '2025-04-07 17:38:20'),
(2, NULL, 'New Car Models', 'Check out our new car models!', 'Global', 0, '2025-04-07 17:38:20'),
(3, 2, 'Payment Reminder', 'Please complete your payment.', 'Personal', 0, '2025-04-07 17:38:20');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `car_id`, `invoice_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '2025-04-07 17:38:20', '2025-04-07 17:38:20'),
(2, 2, 2, 2, 1, '2025-04-07 17:38:20', '2025-04-07 17:38:20'),
(3, 3, 3, 3, 1, '2025-04-07 17:38:20', '2025-04-07 17:38:20');

--
-- Triggers `orders`
--
DELIMITER $$
CREATE TRIGGER `update_invoice_total_price_on_insert` AFTER INSERT ON `orders` FOR EACH ROW BEGIN
    IF NEW.invoice_id IS NOT NULL THEN
        -- Cập nhật total_price dựa trên giá xe và số lượng trong đơn hàng
        UPDATE invoices
        SET total_price = (
            SELECT COALESCE(SUM(c.price * o.quantity), 0)
            FROM orders o
            JOIN cars c ON o.car_id = c.id
            WHERE o.invoice_id = NEW.invoice_id
        )
        WHERE id = NEW.invoice_id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_invoice_total_price_on_update` AFTER UPDATE ON `orders` FOR EACH ROW BEGIN
    -- Cập nhật total_price cho hóa đơn cũ (nếu có)
    IF OLD.invoice_id IS NOT NULL THEN
        UPDATE invoices
        SET total_price = (
            SELECT COALESCE(SUM(c.price * o.quantity), 0)
            FROM orders o
            JOIN cars c ON o.car_id = c.id
            WHERE o.invoice_id = OLD.invoice_id
        )
        WHERE id = OLD.invoice_id;
    END IF;
    -- Cập nhật total_price cho hóa đơn mới (nếu có)
    IF NEW.invoice_id IS NOT NULL THEN
        UPDATE invoices
        SET total_price = (
            SELECT COALESCE(SUM(c.price * o.quantity), 0)
            FROM orders o
            JOIN cars c ON o.car_id = c.id
            WHERE o.invoice_id = NEW.invoice_id
        )
        WHERE id = NEW.invoice_id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `gender` enum('Male','Female','Other') NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `provider` enum('credential','google','twitter','github') DEFAULT 'credential',
  `avatar_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fname`, `lname`, `email`, `password`, `role`, `gender`, `phone`, `address`, `provider`, `avatar_id`, `created_at`, `updated_at`, `bio`) VALUES
(1, 'user1', 'Alice', 'Nguyen', 'alice@example.com', '', 'user', 'Female', '0123456789', '123 Main St', 'google', 1, '2025-04-07 17:38:20', '2025-04-07 17:38:20', NULL),
(2, 'bobhandsome', 'Bob', 'Tran', 'bob@example.com', 'bf0950b3391b7707b0a9686730f3bbbf7f3a4484fbceea71ec800c911fe0f205', 'user', 'Male', '0987654325', '456 Elm John St', 'credential', 2, '2025-04-07 17:38:20', '2025-04-30 18:14:20', '<p><strong>At My Worst</strong></p><ul><li><p>I need somebody who can love me at my worst</p></li><li><p>No, I\'m not perfect, but I hope you see my worth</p></li><li><p>\'Cause it\'s only you, nobody new, I put you first</p></li><li><p>And for you, girl, I swear I\'d do the worst</p></li></ul>'),
(3, 'admin', 'Charlie', 'Le', 'charlie@example.com', '7ade42554d38cc87261ea0c42d165aee353520eb07610dd8d934d33cad9cb301', 'admin', 'Other', '0112233445', '789 Oak St', 'credential', NULL, '2025-04-07 17:38:20', '2025-04-07 17:38:20', NULL),
(4, 'D HUNG', 'D', 'HUNG', 'koikoidth12@gmail.com', '', 'user', 'Male', '0394529624', '465, Kitchen Ling St', 'google', NULL, '2025-04-12 07:50:55', '2025-05-02 10:27:11', '<p>Hello Everyone, I\'m <strong>koikoi</strong></p>'),
(5, 'HÙNG ĐOÀN TRÍ', 'HÙNG', 'ĐOÀN TRÍ', 'hung.doantrymybest@hcmut.edu.vn', '', 'user', 'Male', NULL, NULL, 'google', NULL, '2025-05-01 15:41:07', '2025-05-01 15:41:07', NULL),
(7, 'minhanh', NULL, NULL, 'minhanh0204@gmail.com', '91f51db666401870c84873da60014872c7b38b23872d46c24930befb091f9835', 'user', 'Male', NULL, NULL, NULL, NULL, '2025-05-01 15:57:21', '2025-05-01 15:57:21', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `cover_image_id` (`cover_image_id`);

--
-- Indexes for table `branchs`
--
ALTER TABLE `branchs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_id` (`file_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `car_assets`
--
ALTER TABLE `car_assets`
  ADD PRIMARY KEY (`car_id`,`file_id`),
  ADD KEY `file_id` (`file_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `category_mappings`
--
ALTER TABLE `category_mappings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parent_comment_id` (`parent_comment_id`),
  ADD KEY `file_id` (`file_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fkey` (`fkey`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_coupons`
--
ALTER TABLE `invoice_coupons`
  ADD PRIMARY KEY (`invoice_id`,`coupon_id`),
  ADD KEY `coupon_id` (`coupon_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `avatar_id` (`avatar_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `branchs`
--
ALTER TABLE `branchs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `category_mappings`
--
ALTER TABLE `category_mappings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blogs_ibfk_2` FOREIGN KEY (`cover_image_id`) REFERENCES `files` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `car_assets`
--
ALTER TABLE `car_assets`
  ADD CONSTRAINT `car_assets_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `car_assets_ibfk_2` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_mappings`
--
ALTER TABLE `category_mappings`
  ADD CONSTRAINT `category_mappings_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`parent_comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_4` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `invoice_coupons`
--
ALTER TABLE `invoice_coupons`
  ADD CONSTRAINT `invoice_coupons_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_coupons_ibfk_2` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`avatar_id`) REFERENCES `files` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
