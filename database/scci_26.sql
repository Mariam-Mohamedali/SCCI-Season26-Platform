-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2026 at 03:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scci`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `workshop_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `status` enum('present','absent') NOT NULL DEFAULT 'absent',
  `marked_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `committees`
--

CREATE TABLE `committees` (
  `committee_id` int(11) NOT NULL,
  `head_id` int(11) NOT NULL,
  `committee_description` varchar(255) NOT NULL,
  `missoin` longtext NOT NULL,
  `committe_name` varchar(50) NOT NULL,
  `committee_member` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `committees`
--

INSERT INTO `committees` (`committee_id`, `head_id`, `committee_description`, `missoin`, `committe_name`, `committee_member`) VALUES
(3, 7, 'A passionate moderator who empowers participants to discover their strengths and passions, develop technical and soft skills, step out of their comfort zones, and excel academically and professionally through engaging, up-to-date guidance.', ' helping participants to explore their interests and know their strengths and work on their weakness and develop them (technical and personal (soft skills)) and deliver high quality and updated content and helping them to get out of their comfort zone and It is the duty of moderator to help our student’s academic life and the needs of the marketplace and should encourage the participations to attend the session and Passionate to do their best in the conference and closing and mid-year project and helping the participants to Discovery their passion and maximizing their output', 'Academic Committee', 'AC Member'),
(4, 8, 'Committee of Fund Development & B2B Activities.	', 'The role focuses on building and managing strategic commercial relationships with corporate partners while representing SCCI as a professional Non-Profit Organization. It involves negotiating and executing partnerships, sponsorships, and commercial transactions that align with SCCI’s values and long-term vision. The role also leads the creation and execution of innovative projects and events aimed at fundraising, sustainability, and value creation for both SCCI and its partners. In addition, it ensures securing high-quality training and resources needed by SCCI, while strategically covering annual operational expenses.', 'Business Development Committee ', 'BD Member'),
(5, 9, ' Role Online coverage, social networking & creating marketing campaigns.\r\n', 'The role is responsible for managing and executing comprehensive social media coverage for all SCCI activities, including events, outings, campaigns, and official updates. It focuses on maintaining an active and engaging presence across social media platforms such as Facebook and Instagram by creating relevant content, publishing timely updates, and interacting with the audience through responding to comments, questions, and inquiries. The role also ensures consistent branding, audience engagement, and effective communication of SCCI’s message and values online.', 'Social Media Marketing Committee', 'SMM Member'),
(6, 17, '\r\nDedicated to supply core technical services related to Information technology and for the technical solutions and supporting technical tools for the community of SCCI, like SCCI\'s official website ', 'The role is responsible for designing, developing, and continuously improving the SCCI website to ensure a professional, user-friendly, and up-to-date digital presence. It includes building and maintaining a comprehensive SCCI database in collaboration with the MC, developing and managing online forms required throughout the year, and providing reliable technical support during sessions and events to ensure smooth operations.', 'Information Technology Committee ', 'IT Member'),
(7, 16, 'SCCI theme, t-shirts, web and mobile designs ', 'The role is responsible for planning, designing, and executing all visual and decorative elements for SCCI’s internal and external booths, photobooths, workshops, and events. It oversees the creative design and production of all branding and promotional materials, including T-shirts, IDs, brochures, flyers, tickets, posters, certificates, and gifts for general meetings, ensuring consistency with SCCI’s identity and high visual quality across all activities.', 'Design and Decoration Committee ', 'DD Member'),
(8, 12, 'Making a healthy & social environment inside the crew. \r\n', 'The role focuses on planning and organizing charitable events and community service campaigns that reflect SCCI’s values and social responsibility. It includes designing engaging activities during coffee breaks to enhance participants’ experience and encourage interaction, as well as building and maintaining cooperation with external community and charitable organizations to maximize impact and outreach.', 'Community Relations Committee', 'CR Member'),
(9, 11, ' Coverage of materials, catering & outings.', 'The role is responsible for planning, organizing, and managing all SCCI outings, including crew outings and mid-year outings, ensuring a well-organized and enjoyable experience for all participants. It also involves securing catering sponsors for sessions and outings, as well as providing and coordinating all required materials such as T-shirts, booth materials, certificates, and other event necessities.', 'Logistics Committee ', 'Logistics Member'),
(10, 13, 'Media coverage by using tools such as short videos, documentaries, photography, and interactive media to deliver SCCI images. \r\n', 'The role is responsible for producing high-quality promotional videos and documentaries for all SCCI sessions, events, outings, and campaigns. It includes providing professional photography and video coverage for all activities and their preparations, as well as managing and updating the SCCI YouTube channel to showcase content that reflects SCCI’s identity and impact.', 'Media Production Committee ', 'MP Member'),
(11, 14, 'Dealing with media sponsors and organizing our main events (Opening – Closing – etc…). \r\n', 'Internal Public Relations (IPR): Responsible for managing relationships between SCCI and other student activities within Cairo University, handling all internal documentation and procedures, and coordinating the reservation of labs and halls for SCCI sessions.\r\n\r\nExternal Public Relations (EPR): Responsible for building relationships with media sponsors, organizing ushering, managing external documentation and procedures, planning and executing main SCCI events (e.g., Opening, Closing), inviting VIPs and public figures, selecting and reserving suitable event venues, marketing events through various channels, and maintaining relationships with external student activities, organizations, and models outside Cairo University.', 'Public Relations Committee', 'PR Member'),
(12, 19, 'Designing of formal systems to ensure the effective use of members\' and heads\' knowledge, skills, abilities, and other characteristics. \r\n', 'The role is responsible for managing all human resources functions, including research and development, recruitment, interviewing, selection, performance monitoring, and workforce planning. It focuses on training and developing members by providing the necessary learning opportunities to enhance efficiency and performance. The role also evaluates members’ work and SCCI’s overall output across sessions, events, and projects by monitoring workflows, writing detailed reports, and delivering constructive feedback to improve both individual and leadership performance. In addition, it ensures full compliance with SCCI’s policies, code of ethics, rules, and values, resolves internal issues, maintains positive relationships among members, and fosters motivation and high team spirit.', 'Human Resources and R&D Committee ', 'HR Member');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `contactUs_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `text` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` int(11) NOT NULL,
  `session_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `session_name`) VALUES
(1, 'Session 1'),
(2, 'Session 2'),
(3, 'Session 3\r\n'),
(4, 'Session 4'),
(5, 'Session 5 '),
(6, 'Session 6'),
(7, 'Session 7 '),
(8, 'Session 8'),
(9, 'Session 9'),
(10, 'Session 10'),
(11, 'Session 11 '),
(12, 'Session 12'),
(13, 'Session 13'),
(14, 'Session 14'),
(15, 'Session 15'),
(16, 'Session 16');

-- --------------------------------------------------------

--
-- Table structure for table `session_materials`
--

CREATE TABLE `session_materials` (
  `material_id` int(11) NOT NULL,
  `workshop_session_id` int(11) NOT NULL,
  `material_type` enum('technical','soft') NOT NULL,
  `material_title` varchar(200) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spells`
--

CREATE TABLE `spells` (
  `spells_id` int(11) NOT NULL,
  `opening_spell` longtext NOT NULL,
  `core_magic` longtext NOT NULL,
  `advanced_spell` longtext NOT NULL,
  `final_quest` longtext NOT NULL,
  `workshop_id` int(11) NOT NULL,
  `button1` varchar(50) NOT NULL,
  `button2` varchar(50) NOT NULL,
  `button3` varchar(50) NOT NULL,
  `button4` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spells`
--

INSERT INTO `spells` (`spells_id`, `opening_spell`, `core_magic`, `advanced_spell`, `final_quest`, `workshop_id`, `button1`, `button2`, `button3`, `button4`) VALUES
(1, 'Participants begin their journey by understanding what Embedded Systems are and how software interacts with hardware.\nThey are introduced to Arduino, basic electronics concepts, and how real-world devices are controlled through code.\nThis phase builds a strong foundation for thinking like an engineer.', 'In this phase, participants work hands-on with sensors, motors, and electronic circuits.\nThey learn how to read inputs, control outputs, and connect components correctly.\nProblem-solving and teamwork play a key role while building small functional systems', 'Participants learn how to combine hardware and software into complete smart systems.\nThey write logic that responds to real-world data and automate actions.\nThis phase focuses on system thinking and practical implementation.', 'In the final stage, participants design and build a complete embedded system project from scratch.\nThey apply everything they’ve learned to create a real, working solution that solves a real problem.', 1, 'Opening Circuit', 'Core Components', 'Smart Systems', 'Final Build'),
(2, 'Participants are introduced to how the web works, including browsers, servers, and client-server communication.\nThey start with HTML, CSS, and JavaScript, learning how to structure, style, and add behavior to web pages.', 'This phase focuses on building responsive and interactive user interfaces.\nParticipants deepen their knowledge of JavaScript and get an introduction to React, learning how modern front-end applications are structured.', 'Participants explore Back-End Development using Laravel (PHP Framework).\nThey learn how to work with SQL databases, handle user data, and connect the front end with the back end.', 'Participants build a complete full-stack web application, combining front-end and back-end skills.\nThe project demonstrates both technical ability and creative problem-solving.', 2, 'Opening Spell', 'Core Magic', 'Advanced Spells', 'Final Quest'),
(3, 'Participants are introduced to entrepreneurship and how ideas turn into opportunities.\nThey learn how to think like founders and identify problems worth solving.', 'This phase covers finance, accounting, and resource management.\nParticipants learn how to plan budgets, understand costs, and make informed business decisions.', 'Participants explore digital marketing, branding, and market analysis.\nThey learn how to communicate their vision and reach the right audience effectively.\n', 'Participants develop a complete business model and present their ideas as a real startup concept.\nThe focus is on clarity, confidence, and execution.', 4, 'Opening Vision', 'Core Strategy', 'Growth Tools', 'Final Pitch'),
(4, 'Participants learn what data is, where it comes from, and why it matters.\nThey are introduced to data types and basic data analysis concepts.', 'This phase focuses on using Python, Excel, SQL, and Power BI to analyze and visualize data.\nParticipants create charts and dashboards that turn numbers into insights.', 'Participants learn how to interpret data and extract meaningful insights.\nThey use data to support decisions and solve real-world problems.', 'Participants explore the basics of Machine Learning and how data is used to predict and automate outcomes.\nThis phase opens the door to advanced data-driven technologies.', 3, 'Data Foundations', 'Data Tools', 'Data Intelligence', 'Future Data');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `workshop_session_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `taskName` varchar(255) NOT NULL,
  `taskDeadline` date NOT NULL,
  `taskBio` varchar(255) NOT NULL,
  `task_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_feedback`
--

CREATE TABLE `task_feedback` (
  `feedback_id` int(11) NOT NULL,
  `submission_id` int(11) NOT NULL,
  `feedback_text` text NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `given_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_submissions`
--

CREATE TABLE `task_submissions` (
  `submission_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `submit_link` varchar(255) NOT NULL,
  `status` enum('submitted','not_submitted','pending','') NOT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `workshop_id` int(11) DEFAULT NULL,
  `committee_id` int(11) DEFAULT NULL,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 1,
  `Image` longtext NOT NULL,
  `githup` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `workshop_id`, `committee_id`, `user_name`, `email`, `phone`, `password`, `role`, `Image`, `githup`, `linkedin`, `status`) VALUES
(6, NULL, NULL, 'Marwan Wael', 'maroownnm003@gmail.com', 11, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 5, 'Marwan Wael.jpg', '', '', 1),
(7, NULL, NULL, 'Mohamed Ahmed', 'mohamedddd2710@gmail.com', 11, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 5, 'Mohamed Ahmed.jpg', '', '', 1),
(8, NULL, NULL, 'Omar Hesham', 'ohesham179@gmail.com', 11, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 4, 'Omar Hesham.jpg', '', '', 1),
(9, NULL, NULL, 'Nour Mohamed', 'nonymahim@gmail.com', 11, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 4, 'Nour Mohamed.jpg', '', '', 1),
(10, NULL, NULL, 'Mohamed Hesham', 'mohameddhesham37@gmai.com', 11, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 5, 'Mohamed Hesham.jpg', '', '', 1),
(11, NULL, NULL, 'Asser El-Sayed', 'Asser.sayed@hotmail.com', 11, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 4, 'Asser El-Sayed.jpg', '', '', 1),
(12, NULL, NULL, 'Belal Omar', 'Bilalomar493@gmail.com', 11, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 4, 'Belal Omar.jpg', '', '', 1),
(13, NULL, NULL, 'Omar Ahmed', 'Omar4ahmed999@gmail.com', 11, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 4, 'Omar Ahmed.jpg', '', '', 1),
(14, NULL, NULL, 'Yasmine Gawish', 'Yasminegawish22@gmail.com', 11, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 4, 'Yasmine Gawish.jpg', '', '', 1),
(15, NULL, NULL, 'Mohamed Ali', 'mohamed.ali.ismail26@gmail.com', 11, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 5, 'Mohamed Ali.jpg', '', '', 1),
(16, NULL, NULL, 'Mohamed El Hossiny', 'mohammedelhossiny546@gmail.com', 11, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 4, 'Mohamed El Hossiny.jpg', '', '', 1),
(17, NULL, NULL, 'Mahmoud Alaam', 'malllam146@gmail.com', 11, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 5, 'Mahmoud Alaam.jpg', '', '', 1),
(19, NULL, NULL, 'Alaa Aboelazm', 'aalaaaboelazm@gmail.com', 11, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 5, 'Alaa Aboelazm.jpg', '', '', 1),
(39, NULL, 10, 'Omar Refaat', '1omarrefaat19@gmail.com', 1021043435, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1848368309.07998619.png', '', '', 1),
(40, NULL, 10, 'Salma Akram ', 'Salmaakramm414@gmail.com', 1155688610, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1907ab7ce2.41487928.png', '', '', 1),
(41, NULL, 10, 'Salma Mahmoud ', 'salmamahmoud689@gmail.com', 1001094166, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1929dad0f6.57749523.png', '', '', 1),
(42, NULL, 10, 'Ebtihal Sobhy ', 'ebtihalsobhy9@gmail.com', 1102026030, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c194c66da68.86959078.png', '', '', 1),
(43, NULL, 9, 'Menna Ezz El-Deen ', 'mennaezz506@gmail.com', 1025925644, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c19f7e015d4.36670293.png', '', '', 1),
(44, NULL, 9, 'Eman Essam ', 'Emann.essam010@gmail.com', 1024961812, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1a1bbb1bf9.88758867.png', '', '', 1),
(45, NULL, 9, 'Ayten Mohamed ', 'Ayten.salah22@gmail.com', 1015535900, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1a3b1e0f47.49627983.png', '', '', 1),
(46, NULL, 9, 'Basmala Mohamed ', 'basamalamohammed9@gmail.com', 1021835927, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1a62106bb8.59761487.png', '', '', 1),
(47, NULL, 9, 'nour eldin ', 'noormahmoud747@gmail.com', 1158797683, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1a82171d58.00064271.png', '', '', 1),
(48, NULL, 9, 'Rana barakat', 'barakatrana08@gmail.com', 1210947381, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1aa4b04243.70454184.png', '', '', 1),
(49, NULL, 9, 'Hagar Salah', 'ha01271702469@gmail.com', 1271702469, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1ae4c6cc79.10456279.png', '', '', 1),
(50, NULL, 11, 'Eman hamdy', 'Tnontana64@gmail.com', 1270189726, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1bd909d2e8.00993195.png', '', '', 1),
(51, NULL, 11, 'Jana abdelaziz', 'Jannamuhammed808@gmail.com', 1556217774, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1bf91089c1.51472860.png', '', '', 1),
(52, NULL, 11, 'Zeyad Ahmed ', 'zeyadattallah1@gmail.com', 1205351015, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1c20c5f975.13563960.png', '', '', 1),
(53, NULL, 11, 'Nourseen Ahmed', 'nour987230@gmail.com', 1069713066, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1c43bce210.96894183.png', '', '', 1),
(54, NULL, 11, 'Karen Ekramy ', 'karenakramy@gmail.com', 1210492590, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1c6336c8f3.70744109.png', '', '', 1),
(55, NULL, 11, 'Suhaila Muhammed ', 'sohilasabry65@gmail.com', 1099464829, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1c86f12784.70163068.png', '', '', 1),
(56, NULL, 11, 'Abdelhamid Ahmed ', 'abdelhamidahmd331@gmail.com', 1015868672, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1ca79c3a04.12852471.png', '', '', 1),
(57, NULL, 11, 'Ahmed Hassan ', 'ahmeedhassannn77@gmail.com', 1063543320, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1cc71f3501.56290792.png', '', '', 1),
(58, NULL, 11, 'Roaa Elmarakby', 'roaaelmarakby88@gmail.com', 1005459684, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1ce4302de0.50670546.png', '', '', 1),
(59, NULL, 8, 'Noha amr ', 'nohaamro712@gmail.com', 1098154747, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1d64e4d254.53652295.png', '', '', 1),
(60, NULL, 8, 'Rodina efad ', 'efadrodina@gmail.com', 1223871352, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1d847521a4.19815510.png', '', '', 1),
(61, NULL, 8, 'Hana mahros ', 'hanamahrous2@gmail.com', 1096524001, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1da463a0e3.28510213.png', '', '', 1),
(62, NULL, 8, 'Jana Reda ', 'jana.r.aboelkhair@gmail.com', 1144484143, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1dc544b3d9.99343634.png', '', '', 1),
(63, NULL, 8, 'Nour mohamed ', 'nour.mohamed.khedr139@gmail.com', 1147795711, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1de695e445.83928710.png', '', '', 1),
(64, NULL, 8, 'ziad karim ', 'ziadkareemezzat22@gmail.com', 1129374006, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1e04159c52.73948035.png', '', '', 1),
(65, NULL, 8, 'farah abdallah ', 'nourfarah097@gmail.com', 1151531468, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1e22759c90.82242721.png', '', '', 1),
(66, NULL, 8, 'aya yasser ', 'ayay61436@gmail.com', 1024961679, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c1e3e78af56.95481045.png', '', '', 1),
(67, NULL, 5, 'Abdelrhman Yasser ', 'abdelrhmanyasserbahaaelden@gmail.com', 1276064665, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c427b44e867.96676886.png', '', '', 1),
(68, NULL, 5, 'Malak Adel ', 'malak.adel520@icloud.com', 1115409765, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c42b394a165.51300310.png', '', '', 1),
(69, NULL, 5, 'Nouran khaled ', 'nony.khaled.h@gmail.com', 1024254111, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c42e07e5d95.08087610.png', '', '', 1),
(70, NULL, 5, 'Dalia abdelkhalek ', 'Daliaabdelkhalek00@gmail.com', 1009897915, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c4303805477.48517680.png', '', '', 1),
(71, NULL, 5, 'Nadine Walid ', 'nadeenwalid772004@gmail.com', 1114071345, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c432119aaf7.03468691.png', '', '', 1),
(72, NULL, 5, 'Mariam osama ', 'Mariamosamaelgohary@gmail.com', 1026747188, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c4344991986.13205921.png', '', '', 1),
(73, NULL, 5, 'Esraa alhawary', 'Esraa.abdrabou0@gmail.com', 1119238114, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c43661f82d6.34298702.png', '', '', 1),
(74, NULL, 5, 'Renad Walid ', 'renadwalid60@gmail.com', 1066434257, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c4390cd4ae7.73622028.png', '', '', 1),
(75, NULL, 5, 'Rawda Ahmed ', 'rawdaahassaan@gmail.com', 1009065028, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c43bd296613.48846519.png', '', '', 1),
(76, NULL, 5, 'Nouran hani ', 'nouranhani10@gmail.com', 1140456633, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c43e34839d3.13597586.png', '', '', 1),
(77, NULL, 5, 'Rawan Emad ', 'elasantinyrawan@gmail.com', 1025084144, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c4419974460.94151725.png', '', '', 1),
(78, NULL, 5, 'Nagham Shawki', 'Naghamelkady84@gmail.com', 1094913317, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c443dcf4004.29665893.png', '', '', 1),
(79, NULL, 5, 'Roaa Raslan', 'roaraslan2005@gmail.com', 1023644335, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c44c88c8319.37433584.png', '', '', 1),
(80, NULL, 7, 'Amr tamer  ', 'Amrtamer1012@gmail.com', 1100110141, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c468736c336.58429562.png', '', '', 1),
(81, NULL, 7, 'Malak Ayman', 'malakayman3010@gmail.com', 1286558787, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c46ba5556a3.96594190.png', '', '', 1),
(82, NULL, 7, 'nour khaled ', 'nourkhaled91572@gmail.com', 1063696468, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c46ea2d48a0.83816170.png', '', '', 1),
(83, NULL, 7, 'Mariam Mohamed ', 'mariammariam7704@gmail.com', 1204232794, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c4733244f49.38331686.png', '', '', 1),
(84, NULL, 7, 'khadija ahmed', 'Khadijaahmed1m@gmail.com', 1151572687, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c475a902b55.15830731.png', '', '', 1),
(85, NULL, 7, 'Sama Youssef ', 'samayoussef824@gmail.com', 1023371068, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c478ae56ec2.38741074.png', '', '', 1),
(86, NULL, 7, 'ghada saeed ', 'ghadasaeedmohammedebedo@gmail.com', 1273286235, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c47a86872d8.99426755.png', '', '', 1),
(87, NULL, 7, 'Basmala Osama ', 'Basmala.osama200@gmail.com', 1120372709, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c47cb6b4150.13451478.png', '', '', 1),
(88, NULL, 7, 'Jana Yasser ', 'jennayasser2005@gmail.com', 1032689146, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c47ff34b2e4.89924709.png', '', '', 1),
(89, NULL, 7, 'Nancy Mohamed ', 'nancymoohameed@gmail.com', 1027261747, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c4820adc742.39867281.png', '', '', 1),
(90, NULL, 7, 'Malake Emad El-Din ', 'malakagonim@gmail.com', 1030541775, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696c487a3bd484.56140006.png', '', '', 1),
(91, 2, 6, 'Mahmoud awad', 'mahmoud.awad.offical@gmail.com', 1030656171, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696c496ed62555.62635810.png', '', '', 1),
(92, 2, 6, 'Omar Raslan', 'omarayman.oa999@gmail.com', 1011237981, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696c49f7e15257.08183945.png', '', '', 1),
(93, 4, 6, 'Abdelrhman ramssy', 'itsabdelrahman.r@gmail.com', 1008106851, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696c4a37748947.24974072.png', '', '', 1),
(94, 3, 6, 'Ahmed Hany', 'ahmedmohamedhany1234567@gmail.com', 1282664850, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696c4a5a1240e6.76366785.png', '', '', 1),
(95, 3, 6, 'Hazem yousry', 'hi.hazem321@gmail.com', 1210358404, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696c4a9e032bd0.17439993.png', '', '', 1),
(96, 3, 6, 'Ahmed Gamal', 'a.gamal.1914@gmail.com', 1552249444, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696c4ac939e171.86426337.png', '', '', 1),
(97, 2, 6, 'yasmin mohamed', 'mony.mony005@gmail.com', 1095955995, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696c4af85d1436.82554178.png', '', '', 1),
(98, 1, 6, 'jana haitham', 'janahaitham436@gmail.com', 1279739222, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696c4b1f47c712.97628226.png', '', '', 1),
(99, 4, 6, 'mariam mohamed', 'mariammohamedali127@gmail.com', 1226622320, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696c4b450a2882.58159022.png', '', '', 1),
(100, 1, 6, 'nada ashraf', 'nadaashash8@gmail.com', 1097423817, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696c4b78aa0394.84480010.png', '', '', 1),
(101, 4, 6, 'mohamed Radwan', 'mohamed.radwan.aglaan2004@gmail.com', 1123040511, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696c4c3252fb57.75182122.png', '', '', 1),
(102, 4, 12, 'Karim yasser', 'Karimyhamam25@gmail.com', 1140007298, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696c564ab0c7a5.87395481.png', '', '', 1),
(103, 4, 3, 'Ahmed Mahmoud', 'ahmedmahmo0ud19@gmail.com', 1090299481, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696c574c24f060.94680426.png', '', '', 1),
(104, 4, 12, 'aisha sayed', 'aishasayedyahya19@gmail.com', 1121149900, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d921989fe52.42363077.png', '', '', 1),
(105, 3, 12, 'Hamza Mohamed', 'hamzamohamed2110@gmail.com', 1202204695, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d9259a32d86.50477541.png', '', '', 1),
(106, 1, 12, 'Haneen borhan ', 'neno1263gfv@gmail.com', 1271338848, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d92788e4745.74552570.png', '', '', 1),
(107, 2, 12, 'Yousef yasser ', 'Yuossefy524@gmail.com', 1002561246, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d92977d5f56.71672686.png', '', '', 1),
(108, 3, 12, 'Omar Ramadan ', 'Omar27025676@gmail.com', 1127025676, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d92bb4e6cc7.17731627.png', '', '', 1),
(109, 3, 12, 'Naira Mohamed ', 'nm321537@gmail.com', 1118188671, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d92db868a32.81740669.png', '', '', 1),
(110, 1, 12, 'Basmala hosam ', 'basmalahosam122@gmail.com', 1226672239, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d92ffa1edb8.60268612.png', '', '', 1),
(111, 2, 12, 'Mohamed elnaggar', 'mohamedsaid23311@gmail.com', 1094348872, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d932211f911.66273490.png', '', '', 1),
(112, 1, 12, 'Ahmed Hassan ', 'ahmed555apotalp@gmail.com', 1001993248, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d935940a088.98143275.png', '', '', 1),
(113, 1, 12, 'Muhammed EL TaYeb', 'muhammedeltayeb0@gmail.com', 1147937905, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d93e3289f68.18251396.png', '', '', 1),
(114, 2, 3, 'Shahd amr  ', 'amrs8397@gmail.com', 1024976219, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d9471a07146.31083786.png', '', '', 1),
(115, 4, 3, 'Nesrin Khaled ', 'nesrinkhaled233@gmail.com', 1225832619, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d94934726d2.71429232.png', '', '', 1),
(116, 3, 3, 'Hoor Mohamed ', 'hooreya167@gmail.com', 1204233547, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d94c02f7fa0.45669437.png', '', '', 1),
(117, 3, 3, 'Malak osama ', 'Malak.osamaa107@gmail.com', 1115109653, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d94df524e85.80325349.png', '', '', 1),
(118, 2, 3, 'Zeyad Waleed ', 'zeyadelshreif20@gmail.com', 1025904445, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d9514eb3e77.69756075.png', '', '', 1),
(119, 2, 3, 'Mostafa Mohamed  ', 'Mostafa.hanafy404@gmail.com', 1111501778, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d9537e9cef4.16571235.png', '', '', 1),
(120, 1, 3, 'Yassmine Mohamed ', 'yassminem999@gmail.com', 1114381800, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d9562b7a5f3.82155758.png', '', '', 1),
(121, 3, 3, 'Eyad Walied ', 'eyadwalied21@gmail.com', 1129759181, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d9580701842.71432123.png', '', '', 1),
(122, 4, 3, 'Farah Ebrahim ', 'farahebrahim881@gmail.com', 1121378857, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d95a2ed3f50.02645599.png', '', '', 1),
(123, 2, 3, 'Maryam Hussein  ', 'mariamabomuslam@gmail.com', 1129717111, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d95d6927ab3.25868870.png', '', '', 1),
(124, 1, 3, 'Abdallah Nabil ', 'drabdallah.nabil123@gmail.com', 1030006154, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d95f2652c52.76722816.png', '', '', 1),
(125, 4, 3, 'Mai Shaaban ', 'maishalaby17@gmail.com', 1033041644, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d960ee09db7.17719155.png', '', '', 1),
(127, 2, 12, 'Marianne Ehab', 'Marianneehab0@gmail.com', 1005071247, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 2, 'IMG-696d984629a7b3.05237249.png', '', '', 1),
(129, NULL, 4, 'Malak Hussein', 'malakhussein353@gmail.com', 1204744481, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696d9a48470df8.52153360.png', '', '', 1),
(130, NULL, 4, 'Farah Ashraf', 'farahashraf69@gmail.com', 1145444195, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696d9a62ac2013.84655233.png', '', '', 1),
(131, NULL, 4, 'Alaa Fouda', 'aalaafouda4@gmail.com', 1030741062, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696d9a908ecbd7.97087166.png', '', '', 1),
(132, NULL, 4, 'Yasmin Mohamed', 'sosymido2006@gmail.com', 1123114970, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696d9ab7c18c73.33013153.png', '', '', 1),
(133, NULL, 4, 'Salma Adel', 'salmaadel1390@gmail.com', 1023384051, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696d9adfe12b30.85183445.png', '', '', 1),
(134, NULL, 4, 'Sama Ahmed', 'samaahmeddd0@gmail.com', 1129016468, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696d9b2b1bf649.28899418.png', '', '', 1),
(135, NULL, 4, 'Sagy Emad', 'sagyemad698@gmail.com', 1276672290, '$2y$10$kJ/AgmSvyVEN5DSXnMQrQudewcx3s5xr4Bo0C8LEk/T9.bzZECTTW', 3, 'IMG-696d9b7cd62fa3.45683121.png', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `workshops`
--

CREATE TABLE `workshops` (
  `workshop_id` int(11) NOT NULL,
  `workshop_name` varchar(50) NOT NULL,
  `workshop_description` varchar(255) NOT NULL,
  `visson` longtext NOT NULL,
  `workshop_icon` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workshops`
--

INSERT INTO `workshops` (`workshop_id`, `workshop_name`, `workshop_description`, `visson`, `workshop_icon`) VALUES
(1, 'TechSolve', 'Hold on, you are detected!', 'TechSolve – Embedded Systems & Innovation\r\n\r\nTechSolve takes you into the world of Arduino and hardware innovation — where ideas turn into real products. Participants learn to work with sensors, motors, and circuits, mastering how software and hardware connect. Along the way, they build problem-solving, teamwork, and communication skills while developing their own smart tech projects from scratch.', 'techSolve.png'),
(2, 'Devology ', 'From front to back , we have got the stack. ', 'Devology – Full Stack Web Development\r\n\r\nDevology takes participants through the full journey of building modern web applications.\r\nStarting with HTML, CSS, and JavaScript, they gain a solid understanding of front-end development before exploring a brief introduction to React.\r\nThe backend focuses on Laravel (PHP framework) \r\nteaching participants how to  manage databases with SQL, and connect all parts into one powerful web platform.\r\nBy the end, they’ll develop a complete web project showcasing both their technical and creative skills.', 'devolgy.png'),
(3, 'Data Station ', 'Decode the data , discover the story', 'Data Station \r\n\r\nNumbers tell stories — and at Data Station, you’ll learn how to read them.\r\n\r\nStep into the world where data becomes your power.\r\nLearn to use Python, Excel, Power BI, and SQL to collect, clean, and visualize information that reveals real insights.\r\nCreate interactive charts and dashboards that turn complex data into clear, powerful visuals anyone can understand.\r\nDiscover how to turn numbers into meaning and make smarter, data-driven decisions.\r\nYou’ll even dive into the world of Machine Learning, exploring how data shapes the future.\r\n\r\nBy the end, you won’t just read data — you’ll make it speak.', 'dataAnalysis.png'),
(4, 'Marketneur ', 'Cash the dream rule the scene', 'Marketneur \r\nThis is where your business journey begins\r\nDo you have an idea that could change the game?\r\n At Marketneur,  you’ll learn how to turn that spark into something real.\r\nThis workshop brings entrepreneurship, finance, accounting, and digital marketing — giving you the tools to plan, build, and grow your own success story.\r\nYou’ll learn how to market your vision, manage your resources, and make confident business decisions that matter. \r\nEvery session is hands-on, creative, and made to unlock the entrepreneur inside you.', 'marketive.png');

-- --------------------------------------------------------

--
-- Table structure for table `workshop_session`
--

CREATE TABLE `workshop_session` (
  `workshop_session_id` int(11) NOT NULL,
  `workshop_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workshop_session`
--

INSERT INTO `workshop_session` (`workshop_session_id`, `workshop_id`, `session_id`, `created_at`) VALUES
(1, 1, 1, '2026-01-15 04:53:26'),
(2, 1, 2, '2026-01-15 04:53:26'),
(3, 1, 3, '2026-01-15 04:53:26'),
(4, 2, 1, '2026-01-15 04:53:26'),
(5, 2, 2, '2026-01-15 04:53:26'),
(6, 2, 3, '2026-01-15 04:53:26'),
(7, 3, 1, '2026-01-15 04:53:26'),
(8, 3, 2, '2026-01-15 04:53:26'),
(9, 3, 3, '2026-01-15 04:53:26'),
(10, 4, 1, '2026-01-15 04:53:26'),
(11, 4, 2, '2026-01-15 04:53:26'),
(12, 4, 3, '2026-01-15 04:53:26'),
(16, 1, 4, '2026-01-15 06:56:28'),
(17, 1, 5, '2026-01-15 06:56:40'),
(18, 2, 4, '2026-01-15 06:56:53'),
(19, 2, 5, '2026-01-15 06:57:07'),
(20, 3, 4, '2026-01-15 06:57:28'),
(21, 3, 5, '2026-01-15 06:57:28'),
(22, 4, 4, '2026-01-15 06:57:49'),
(23, 4, 5, '2026-01-15 06:57:49'),
(24, 1, 6, '2026-01-15 17:51:51'),
(25, 2, 6, '2026-01-15 17:51:51'),
(26, 3, 6, '2026-01-15 17:57:26'),
(27, 4, 6, '2026-01-15 17:57:26'),
(28, 1, 7, '2026-01-15 18:04:39'),
(29, 2, 7, '2026-01-15 18:04:39'),
(30, 3, 7, '2026-01-15 18:04:39'),
(31, 4, 7, '2026-01-15 18:04:39'),
(32, 1, 8, '2026-01-15 18:04:39'),
(33, 2, 8, '2026-01-15 18:04:39'),
(34, 3, 8, '2026-01-15 18:04:39'),
(35, 4, 8, '2026-01-15 18:04:39'),
(36, 1, 9, '2026-01-15 18:04:39'),
(37, 2, 9, '2026-01-15 18:04:39'),
(38, 3, 9, '2026-01-15 18:04:39'),
(39, 4, 9, '2026-01-15 18:04:39'),
(40, 1, 10, '2026-01-15 18:04:39'),
(41, 2, 10, '2026-01-15 18:04:39'),
(42, 3, 10, '2026-01-15 18:04:39'),
(43, 4, 10, '2026-01-15 18:04:39'),
(44, 1, 11, '2026-01-15 18:04:39'),
(45, 2, 11, '2026-01-15 18:04:39'),
(46, 3, 11, '2026-01-15 18:04:39'),
(47, 4, 11, '2026-01-15 18:04:39'),
(48, 1, 12, '2026-01-15 18:04:39'),
(49, 2, 12, '2026-01-15 18:04:39'),
(50, 3, 12, '2026-01-15 18:04:39'),
(51, 4, 12, '2026-01-15 18:04:39'),
(52, 1, 13, '2026-01-15 18:04:39'),
(53, 2, 13, '2026-01-15 18:04:39'),
(54, 3, 13, '2026-01-15 18:04:39'),
(55, 4, 13, '2026-01-15 18:04:39'),
(56, 1, 14, '2026-01-15 18:04:39'),
(57, 2, 14, '2026-01-15 18:04:39'),
(58, 3, 14, '2026-01-15 18:04:39'),
(59, 4, 14, '2026-01-15 18:04:39'),
(60, 1, 15, '2026-01-15 18:04:39'),
(61, 2, 15, '2026-01-15 18:04:39'),
(62, 3, 15, '2026-01-15 18:04:39'),
(63, 4, 15, '2026-01-15 18:04:39'),
(64, 1, 16, '2026-01-15 18:04:39'),
(65, 2, 16, '2026-01-15 18:04:39'),
(66, 3, 16, '2026-01-15 18:04:39'),
(67, 4, 16, '2026-01-15 18:04:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD UNIQUE KEY `uq_att` (`workshop_id`,`session_id`,`user_id`,`attendance_date`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `marked_by` (`marked_by`);

--
-- Indexes for table `committees`
--
ALTER TABLE `committees`
  ADD PRIMARY KEY (`committee_id`),
  ADD KEY `head_id` (`head_id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`contactUs_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `session_materials`
--
ALTER TABLE `session_materials`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `fk_sm_workshop_session` (`workshop_session_id`),
  ADD KEY `fk_sm_uploaded_by` (`uploaded_by`);

--
-- Indexes for table `spells`
--
ALTER TABLE `spells`
  ADD PRIMARY KEY (`spells_id`),
  ADD KEY `workshop_id` (`workshop_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `fk_tasks_ws` (`workshop_session_id`);

--
-- Indexes for table `task_feedback`
--
ALTER TABLE `task_feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD UNIQUE KEY `uq_feedback_submission` (`submission_id`),
  ADD KEY `given_by` (`given_by`);

--
-- Indexes for table `task_submissions`
--
ALTER TABLE `task_submissions`
  ADD PRIMARY KEY (`submission_id`),
  ADD UNIQUE KEY `uq_user_task` (`user_id`,`task_id`),
  ADD KEY `task_id` (`task_id`,`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `committee_id` (`committee_id`),
  ADD KEY `workshop_id` (`workshop_id`),
  ADD UNIQUE KEY `idx_email` (`email`),
  ADD KEY `idx_role_status` (`role`, `status`);

--
-- Indexes for table `workshops`
--
ALTER TABLE `workshops`
  ADD PRIMARY KEY (`workshop_id`);

--
-- Indexes for table `workshop_session`
--
ALTER TABLE `workshop_session`
  ADD PRIMARY KEY (`workshop_session_id`),
  ADD UNIQUE KEY `uq_workshop_session` (`workshop_id`,`session_id`),
  ADD KEY `fk_ws_session` (`session_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `committees`
--
ALTER TABLE `committees`
  MODIFY `committee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `contactUs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `session_materials`
--
ALTER TABLE `session_materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `spells`
--
ALTER TABLE `spells`
  MODIFY `spells_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `task_feedback`
--
ALTER TABLE `task_feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `task_submissions`
--
ALTER TABLE `task_submissions`
  MODIFY `submission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `workshops`
--
ALTER TABLE `workshops`
  MODIFY `workshop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `workshop_session`
--
ALTER TABLE `workshop_session`
  MODIFY `workshop_session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `committees`
--
ALTER TABLE `committees`
  ADD CONSTRAINT `committees_ibfk_1` FOREIGN KEY (`head_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
