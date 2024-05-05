-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2024 at 04:47 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trashtruce`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL,
  `Full_Name` text DEFAULT NULL,
  `Image` text DEFAULT NULL,
  `About` text DEFAULT NULL,
  `Job` text DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `Phone` text DEFAULT NULL,
  `Email` text DEFAULT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `Full_Name`, `Image`, `About`, `Job`, `Address`, `Phone`, `Email`, `password`) VALUES
(1, 'TrashTruce Admin', '../admin_img/admin.png', 'Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.', ' Web Designer', 'Main Street,Kandy', '077922556', 'admin@gmail.com', '$2y$10$hsAX4u0yFB0Ww7uDuKpDwOGR/eJLye9oDACa2aMF3RjwcHP2HCdcG');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `ID` int(11) NOT NULL,
  `Title` text NOT NULL,
  `active` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`ID`, `Title`, `active`) VALUES
(1, 'Compost', 'Yes'),
(2, 'Kohubath Compost', 'Yes'),
(4, 'Dahaiya Compost', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Phone` text NOT NULL,
  `Email` text NOT NULL,
  `Message` text NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`ID`, `Name`, `Phone`, `Email`, `Message`, `Date`) VALUES
(5, 'Customer1', '0775433441', 'zafraziaudeen@gmail.com', 'I am interested in your products and would like to know more about them. Please provide me with details on how I can get it easily', '2024-04-03 16:10:18'),
(7, 'Ziaudeen', '0779833449', 'zafraziaudeen@gmail.com', 'hi', '2024-04-24 07:05:36');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `ID` int(11) NOT NULL,
  `Fname` varchar(500) NOT NULL,
  `Lname` varchar(500) NOT NULL,
  `Email` text NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `Password` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `approval` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `ID` int(11) NOT NULL,
  `e_id` int(11) DEFAULT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`ID`, `e_id`, `name`, `email`, `phone`, `address`) VALUES
(16, 5, 'Ziaudeen Ahamed Fathima Zafra', 'zafraziaudeen@gmail.com', '779833449', '89,Godapola Road'),
(17, 1, 'Ziaudeen Ahamed Fathima Zafra', 'zafraziaudeen@gmail.com', '779833449', '89,Godapola Road');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Image` text NOT NULL,
  `Description` text NOT NULL,
  `Location` text NOT NULL,
  `Date` text NOT NULL,
  `Time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`ID`, `Name`, `Image`, `Description`, `Location`, `Date`, `Time`) VALUES
(1, 'Community Clean-Up Day🗑️', '../event_img/1e.jpg', ' Join us for a day of community engagement and environmental stewardship! Our Recycling Rally invites residents to come together to clean up local neighborhoods, parks, and waterways. Participants will learn about proper waste disposal practices and the importance of recycling while making a tangible impact on the cleanliness of our community. Together, we can work towards a cleaner, greener future.', 'Kandy Town ', '2024-05-06', ' 9:00 AM - 12:00 PM'),
(4, ' 🌱🌍Waste Reduction Workshop Series', '../event_img/4e.png', 'Join us as we embark on a journey towards a greener, more sustainable future. Our workshops are carefully curated to empower individuals, businesses, and organizations with the knowledge and tools needed to make a positive impact on the planet', 'KCC', '2024-05-06', '9.00.A.M- 1.00.P.M'),
(5, 'Trash Truce Recycling Drive♻️', '../event_img/5e.jpg', 'Upgrade your electronics and responsibly dispose of old devices at our E-Waste Recycling Drive! Bring your outdated phones, computers, printers, and other electronic gadgets to our collection site, where trained staff will ensure that they are recycled or refurbished in an environmentally-friendly manner. By diverting e-waste from landfills, you\'ll help conserve resources and prevent harmful chemicals from leaching into the environment. Let\'s make a positive impact together! ', 'Municipal  Council Kandy', '2024-6-2', '9.00.A.M- 12.00.P.M'),
(7, '🌍Plastic-Free Challenge Week♻️', '../event_img/7e.jpg', 'Join the Plastic-Free Challenge! Take a stand against single-use plastics this week. Pledge to ditch disposables and embrace reusables. Engage in workshops, film screenings, and community events to learn and act. Let\'s protect our oceans and wildlife together! #PlasticFreeChallenge', 'Kandy Town ', '2024-05-20', '9.00.A.M- 12.00.P.M');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Rating` int(11) NOT NULL,
  `Feedback` text NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`ID`, `Name`, `Rating`, `Feedback`, `Date`) VALUES
(10, 'Zafra', 2, 'Satisfied with the service', '2024-04-03 13:48:28');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Image` text NOT NULL,
  `Featured` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`ID`, `Name`, `Image`, `Featured`) VALUES
(16, 'Waste Reduction Workshop Series', '../gallery_image/16g.jpg', 'Yes'),
(17, 'Waste Reduction Workshop Series', '../gallery_image/17g.jpg', 'Yes'),
(18, 'Waste Reduction Workshop Series', '../gallery_image/18g.jpg', 'Yes'),
(19, 'Waste Reduction Workshop Series', '../gallery_image/19g.jpg', 'No'),
(20, 'Waste Reduction Workshop Series', '../gallery_image/20g.jpg', 'No'),
(21, 'Waste Reduction Workshop Series', '../gallery_image/21g.jpg', 'No'),
(22, 'Waste Reduction Workshop Series', '../gallery_image/22g.jpg', 'No'),
(23, 'Waste Reduction Workshop Series', '../gallery_image/23g.jpg', 'No'),
(24, 'Waste Reduction Workshop Series', '../gallery_image/24g.jpg', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `ID` int(11) NOT NULL,
  `Place` text NOT NULL,
  `NearbyLoc` text DEFAULT NULL,
  `Image` text NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`ID`, `Place`, `NearbyLoc`, `Image`, `url`) VALUES
(9, ' Udurawana Mawatha, Kandy', 'Kandy Town', '../location_image/9l.jpg', 'https://maps.app.goo.gl/SrUGG21F5cVdzJCD7');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `ID` int(11) NOT NULL,
  `name` text NOT NULL,
  `Image` text NOT NULL,
  `description` text NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`ID`, `name`, `Image`, `description`, `date`) VALUES
(2, ' New waste management system reduces urban landfill overflow by 30%', '../news_image/2N.jpg', 'In a groundbreaking development aimed at tackling the growing challenge of urban waste management, a cutting-edge system has been introduced, heralding a significant reduction in landfill overflow. The revolutionary solution, designed to address the burgeoning waste crisis, has successfully slashed urban landfill overflow rates by an impressive 30%.\r\n\r\nThis remarkable achievement comes as welcome news amidst mounting concerns over the environmental and public health repercussions of overflowing landfills in urban centers worldwide. With populations continuing to soar and consumption patterns evolving, traditional waste management infrastructures have struggled to cope, leading to detrimental consequences for both communities and ecosystems.\r\n\r\nHowever, this new waste management system represents a beacon of hope in the fight against waste proliferation. Leveraging advanced technologies and innovative strategies, it offers a multifaceted approach to waste handling, encompassing efficient collection, sorting, recycling, and disposal mechanisms.\r\n\r\nKey features of the system include state-of-the-art sorting facilities equipped with automated sorting algorithms, enabling precise categorization and separation of recyclable materials. Additionally, robust recycling initiatives and public awareness campaigns have been integral to fostering a culture of sustainability and waste reduction within urban communities.\r\n\r\nExperts laud the system\'s ability to not only alleviate the strain on overloaded landfills but also to promote resource conservation and environmental stewardship. By diverting a significant portion of waste away from landfills and towards recycling and composting avenues, it paves the way for a more circular and sustainable waste management paradigm.\r\n\r\nLocal authorities and environmental advocates alike have hailed the implementation of this innovative system as a landmark achievement in urban waste management. With its demonstrable success in curbing landfill overflow rates, there is renewed optimism for the future of waste management, signaling a decisive step towards a cleaner, greener, and more resilient urban environment.', '2024-03-05'),
(3, ' Kandy Municipal Council Introduces New Recycling Program', '../news_image/3N.jpg', 'In a proactive move aimed at addressing the pressing issue of waste management, the Kandy Municipal Council has unveiled an ambitious new recycling program set to revolutionize the city\'s approach to waste disposal. With mounting concerns over the environmental impact of unchecked waste accumulation, this initiative signals a significant step towards a more sustainable future for Kandy and its residents.\r\n\r\nThe pioneering recycling program, introduced in collaboration with local stakeholders and environmental organizations, represents a concerted effort to mitigate the adverse effects of waste pollution while fostering a culture of responsible consumption and waste reduction within the community.\r\n\r\nAt the heart of the program lies a comprehensive waste segregation strategy, designed to streamline the collection and processing of recyclable materials. Residents are encouraged to segregate their household waste into distinct categories, including paper, plastic, glass, and organic waste, facilitating more efficient recycling practices.\r\n\r\nTo support this initiative, the Kandy Municipal Council has implemented a network of dedicated recycling collection points strategically located throughout the city. Equipped with state-of-the-art sorting facilities, these collection points serve as hubs for the aggregation and processing of recyclable materials, ensuring optimal resource utilization and minimal waste generation.\r\n\r\nMoreover, the program incorporates robust public awareness campaigns and educational initiatives aimed at promoting eco-conscious behavior and fostering a sense of environmental responsibility among residents. Through workshops, seminars, and community outreach programs, the Municipal Council seeks to empower individuals with the knowledge and tools necessary to participate actively in the recycling process.\r\n\r\nLocal officials and environmental advocates have lauded the launch of the recycling program as a landmark achievement in Kandy\'s ongoing efforts to combat waste pollution and promote sustainable development. By harnessing the collective power of community engagement and innovative waste management solutions, the city is poised to make significant strides towards a cleaner, greener future for generations to come.\r\n\r\nAs the program gains momentum, stakeholders remain optimistic about its potential to not only alleviate the burden on existing landfill infrastructure but also to foster a more circular economy and enhance the overall quality of life for residents. With sustainability at the forefront of its agenda, the Kandy Municipal Council sets a shining example for cities worldwide striving to confront the challenges of urban waste management head-on.', '2024-04-30'),
(4, 'Green Initiatives', '../news_image/4n.png', 'In a groundbreaking move towards sustainable environmental practices, a consortium of leading environmental engineers and technology experts has unveiled a comprehensive waste management system poised to transform green initiatives globally.\r\n\r\nOverview:\r\n\r\nName: EcoCycle 5000\r\nPurpose: To address the growing concern of waste management and promote recycling and sustainability on a large scale.\r\nDevelopers: Collaborative effort between GreenTech Solutions, Eco Innovations, and Environmental Solutions Group.\r\nLaunch Date: Scheduled for Q3 of 2024.\r\nKey Features:\r\n\r\nSmart Sorting Technology:\r\n\r\nEcoCycle 5000 employs advanced AI algorithms and robotic sorting arms to efficiently segregate various types of waste materials.\r\nThese sorting mechanisms can differentiate between recyclables, organic waste, hazardous materials, and general waste with remarkable accuracy.\r\nIntegrated Recycling Facilities:\r\n\r\nThe system incorporates state-of-the-art recycling units capable of processing a wide array of materials including plastics, glass, metals, and paper.\r\nRecycling processes are optimized for maximum efficiency and minimal environmental impact.\r\nEnergy Recovery Systems:\r\n\r\nEcoCycle 5000 integrates energy recovery systems to harness the potential energy from waste materials.\r\nWaste-to-energy conversion technologies are employed to generate electricity, heat, or fuel from non-recyclable waste, thereby reducing reliance on fossil fuels.\r\nReal-Time Monitoring and Analytics:\r\n\r\nThe system features a centralized monitoring platform that provides real-time insights into waste collection, sorting, and recycling operations.\r\nData analytics tools enable continuous optimization of processes and resource allocation, enhancing overall efficiency.\r\nCommunity Engagement and Education:\r\n\r\nEcoCycle 5000 emphasizes public participation and education through interactive outreach programs and educational campaigns.\r\nCommunity involvement is encouraged through incentives for proper waste disposal and recycling practices.\r\nBenefits:\r\n\r\nEnvironmental Impact: By promoting recycling and reducing landfill waste, EcoCycle 5000 significantly reduces environmental pollution and conserves natural resources.\r\nEconomic Efficiency: The system offers cost-effective waste management solutions while also creating new avenues for job opportunities in the green technology sector.\r\nSustainability: By harnessing renewable energy from waste and promoting sustainable practices, EcoCycle 5000 contributes to long-term environmental sustainability goals.\r\nGlobal Implications:\r\n\r\nThe unveiling of EcoCycle 5000 represents a significant milestone in the global effort towards sustainable waste management.\r\nWith its innovative features and comprehensive approach, the system is expected to serve as a model for green initiatives in communities worldwide.\r\nClosing Thoughts:\r\nEcoCycle 5000 heralds a new era in waste management, offering a holistic solution to the challenges posed by increasing waste generation. As societies worldwide strive towards a greener future, innovations like EcoCycle 5000 demonstrate the power of technology and collaboration in fostering environmental sustainability.', '2024-04-17');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `product` text NOT NULL,
  `quantity` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `card_owner` text DEFAULT NULL,
  `card_no` text DEFAULT NULL,
  `Exp` text DEFAULT NULL,
  `cvv` text DEFAULT NULL,
  `payment_method` text DEFAULT NULL,
  `payment_status` text DEFAULT NULL,
  `status` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`o_id`, `u_id`, `product`, `quantity`, `price`, `card_owner`, `card_no`, `Exp`, `cvv`, `payment_method`, `payment_status`, `status`, `date`) VALUES
(106, 1, 'New Luck Product', '3', 2400.00, 'zafra', '123456789', '6/25', '124', 'card', 'Paid', 'Order Cancelled', '2024-04-23 10:41:48'),
(107, 1, 'New Luck Product', '3', 2400.00, 'zafra', '123456789', '6/25', '124', 'card', 'Paid', 'Delivered', '2024-04-03 18:13:45'),
(108, 1, 'Burned Rice  Compost', '1', 500.00, '', '', '', '', 'cashon delivery', 'on process', 'pending', '2024-04-03 14:12:12'),
(109, 1, 'New Luck Product', '1', 800.00, '', '', '', '', 'cashon delivery', 'on process', 'pending', '2024-04-03 14:12:12'),
(110, 1, 'Burned Rice  Compost', '3', 1500.00, 'zafra', '11111', '11/25', '111', 'card', 'on process', 'Order Cancelled', '2024-04-23 11:34:33'),
(111, 1, 'New Luck Product', '1', 800.00, 'zafra', '11111', '11/25', '111', 'card', 'Paid', 'Delivered', '2024-04-03 18:14:37'),
(112, 1, 'New Luck Product', '1', 800.00, '', '', '', '', 'cashon delivery', 'on process', 'pending', '2024-04-03 14:20:24'),
(113, 1, 'Nature Flower', '1', 750.00, '', '', '', '', 'cashon delivery', 'on process', 'pending', '2024-04-03 14:20:24'),
(114, 1, 'Burned Rice  Compost', '3', 1500.00, '', '', '', '', 'cashon delivery', 'on process', 'pending', '2024-04-23 08:12:03'),
(115, 1, 'Lucky ', '2', 1000.00, 'zafra', '123456789', '12/25', '123', 'card', 'on process', 'pending', '2024-04-24 03:33:38');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Description` text NOT NULL,
  `Image` text NOT NULL,
  `cat_id` int(11) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ID`, `Name`, `Price`, `Description`, `Image`, `cat_id`, `active`) VALUES
(1, 'Burned Rice  Compost', 500.00, 'Burned Rice compost that doubles and triples the yield', '../product_image/1P.avif', 4, 'Yes'),
(2, 'New Luck Product', 800.00, 'Can be used for all crops\r\nex: Vegitable,fruits', '../product_image/2P.jpg', 2, 'Yes'),
(3, 'Nature Flower', 750.00, 'This is used only for flowers', '../product_image/3P.jpg', 2, 'Yes'),
(4, 'Lucky ', 500.00, 'This can be used for vegetable crops. It gives high yield', '../product_image/4P.jpg', 1, 'Yes'),
(5, 'NW new one', 1100.00, 'It can be used for any purpose and is a high quality product', '../product_image/5P.jpg', 2, 'Yes'),
(6, 'Black Dahaiya', 800.00, 'Hoin incinerated manure', '../product_image/6P.avif', 4, 'Yes'),
(7, 'Burned Kohubath', 1000.00, 'Prepared with roasted coir', '../product_image/7P.jpeg', 2, 'Yes'),
(8, 'Net Use ', 500.00, 'This is a sought after product that is available at low cost', '../product_image/8P.jpg', 1, 'Yes'),
(9, 'Green compost', 600.00, 'Prepared from plant leaves', '../product_image/9P.webp', 1, 'Yes'),
(10, 'PL compost', 2500.00, 'This can be used for Fruit crops. It gives high yield', '../product_image/10P.jpg', 4, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `recycling_bin`
--

CREATE TABLE `recycling_bin` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Category` text NOT NULL,
  `Description` text NOT NULL,
  `Image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recycling_bin`
--

INSERT INTO `recycling_bin` (`ID`, `Name`, `Category`, `Description`, `Image`) VALUES
(3, 'Paper and Cardboard📦📄 ', 'Accepted', 'To dispose of paper and cardboard: Collect them, ensure they\'re clean and dry, and remove non-paper materials. Open the designated bin, deposit the items, and flatten cardboard boxes if needed. Close the lid securely to maintain cleanliness. Regularly empty the bin to prevent odors and pests.', '../bimg/3b.jpg'),
(6, 'Food waste', 'Accepted', 'To dispose of food waste properly, gather organic leftovers, fruit peels, and vegetable scraps. Ensure they\'re free of non-organic materials. Open the food waste bin, deposit the waste, and close the lid securely. Regularly empty the bin to prevent odors and pests.', '../bimg/6b.jpg'),
(7, 'Plastic Bottles♻️', 'Accepted', 'To dispose of plastic bottles: Collect them, rinse, and remove caps and labels. Check for recycling bins; if unavailable, place them in the general waste bin. Ensure they\'re dry before depositing. Close lids securely for recycling bins to prevent contamination.', '../bimg/7b.webp'),
(8, 'Electronics', 'Not Accepted', 'To dispose of electronics: Do not place them in regular bins. Instead, take them to designated e-waste recycling centers for proper disposal. This helps prevent environmental pollution and promotes responsible recycling practices.', '../bimg/8b.webp'),
(9, 'Chemicals🧪', 'Not Accepted', 'Hazardous chemicals like cleaning products, pesticides, and paints should not be disposed of in regular bins. Contact your local waste management authority for guidance on proper disposal methods to prevent environmental contamination.', '../bimg/9b.jpg'),
(10, 'Batteries', 'Not Accepted', 'Avoid putting batteries in regular bins as they contain toxic materials. Take used batteries to designated battery recycling drop-off locations for safe disposal to minimize environmental impact and hazards.', '../bimg/10b.jpg'),
(11, 'Metal Cans', 'Other Materials', 'Rinse metal cans, such as aluminum and steel cans used for food and beverages, and place them in the designated recycling bin for metal. If there isn\'t a separate recycling bin, they can be included with other recyclable materials or placed in the general waste bin.', '../bimg/11b.jpg'),
(12, 'Large Furniture', 'Other Materials', 'Large furniture items should not be disposed of in regular bins. Instead, consider options for reuse, donation, or proper disposal through bulky waste collection services provided by your local municipality. This helps minimize waste and supports recycling efforts.', '../bimg/12b.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `recycling_guide`
--

CREATE TABLE `recycling_guide` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Gfile` text NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recycling_guide`
--

INSERT INTO `recycling_guide` (`ID`, `Name`, `Gfile`, `Date`) VALUES
(1, 'Recycle Guide', 'Recycling Guidelines.pdf', '2024-03-28 19:01:44');

-- --------------------------------------------------------

--
-- Table structure for table `recycling_process`
--

CREATE TABLE `recycling_process` (
  `ID` int(11) NOT NULL,
  `Process_Name` text NOT NULL,
  `Process_Des` text NOT NULL,
  `Process_Vid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recycling_process`
--

INSERT INTO `recycling_process` (`ID`, `Process_Name`, `Process_Des`, `Process_Vid`) VALUES
(2, 'Plastic Bottles Recycling♻️', 'Recycle all Plastic♻️', '3196563-hd_1920_1080_25fps.mp4'),
(3, 'Metal Cans Recycle', 'Recycle all Metal Cans', '6591440-hd_2048_1080_25fps.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Description` text NOT NULL,
  `File` text NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`ID`, `Name`, `Description`, `File`, `Date`) VALUES
(13, 'Garbage Collect Schedule', 'Garbage collection schedule in Kandy city', 'schedule.pdf', '2024-03-31 04:06:37');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `ID` int(11) NOT NULL,
  `First_Name` text NOT NULL,
  `Last_Name` text NOT NULL,
  `position` text NOT NULL,
  `DOB` text NOT NULL,
  `Email` text NOT NULL,
  `Password` text NOT NULL,
  `Contact` text NOT NULL,
  `Address` text NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`ID`, `First_Name`, `Last_Name`, `position`, `DOB`, `Email`, `Password`, `Contact`, `Address`, `Date`) VALUES
(5, 'Staff', 'Staff', 'Staff', '1997-02-19', 'staff@gmail.com', '$2y$10$iRsi/7XqKf0Vb0MiG9fHO.W0eaLWgxsh/aGGuZyZVHaagEixHtLE6', '0779832446', 'Kandy', '2024-04-04 17:48:40');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Image` text NOT NULL,
  `Position` text NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`ID`, `Name`, `Image`, `Position`, `Description`) VALUES
(10, 'Kanchana Perera', '../team_image/10t.jpg', 'Municipal Commissioner', '\r\nA Municipal Commissioner is a senior administrative officer responsible for the overall management and administration of a municipality or city corporation. Their role is crucial in ensuring the efficient functioning of various municipal services and implementing policies and programs aimed at improving the quality of life for residents within the municipality'),
(11, 'Niroshan thilakarathna', '../team_image/11t.jpg', 'Administrative officers', 'The administrative officers waste management system is a comprehensive framework designed to efficiently manage waste within an organization or administrative setting. It involves the implementation of policies, procedures, and practices to minimize waste generation, promote recycling and reuse, and ensure proper disposal of waste materials. Here\'s a description of the key components of such a system'),
(12, 'Prasanna Sanjeewa', '../team_image/12t.jpg', 'management service officer', 'A Management Service Officer (MSO) in a waste management system is typically responsible for overseeing and coordinating various aspects of waste management operations within an organization or municipality. Their role involves ensuring that waste is efficiently collected, processed, and disposed of in accordance with regulations and best practices. Here\'s a description of the responsibilities and tasks commonly associated with a Management Service Officer in a waste management system'),
(13, 'Noyel Perera', '../team_image/13t.jpg', 'Development Officer', 'A Development Officer plays a crucial role in fundraising and resource mobilization efforts within an organization. They are responsible for identifying, cultivating, and soliciting donations from individuals, corporations, foundations, and other potential donors. Additionally, they may be involved in planning and executing fundraising events, maintaining donor databases, and stewarding relationships with existing donors. The Development Officer works closely with the development team, executive leadership, and other stakeholders to achieve fundraising goals and support the organization\'s mission and programs.'),
(14, 'Jayantha bandara', '../team_image/14t.jpg', 'Public health  inspector ', 'A public health inspector is a professional responsible for monitoring and enforcing public health regulations and standards within communities. Their primary role is to ensure that public spaces, facilities, and environments are safe and sanitary to prevent the spread of diseases and protect the health of the population. Here\'s a more detailed description of their responsibilities');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `recycling_bin`
--
ALTER TABLE `recycling_bin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `recycling_guide`
--
ALTER TABLE `recycling_guide`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `recycling_process`
--
ALTER TABLE `recycling_process`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `recycling_bin`
--
ALTER TABLE `recycling_bin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `recycling_guide`
--
ALTER TABLE `recycling_guide`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `recycling_process`
--
ALTER TABLE `recycling_process`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
