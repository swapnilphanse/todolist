-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 30, 2020 at 04:01 AM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `test_assessment`
--

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(200) NOT NULL,
  `hours` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `hours`) VALUES
(1, 'dfbgadfb', '94'),
(2, 'Angular', '66'),
(3, 'Test3', '12');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `eid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `hours` float NOT NULL,
  `taskname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`eid`, `pid`, `hours`, `taskname`) VALUES
(3, 1, 12, 'dfgdfb'),
(4, 1, 30, 'task2'),
(4, 1, 30, 'task3'),
(4, 1, 20, 'task5'),
(5, 1, 2, 'test6'),
(5, 2, 23, 'task2'),
(2, 2, 43, 'task4'),
(3, 3, 12, 'tadbcgas1');

--
-- Triggers `tasks`
--
DELIMITER $$
CREATE TRIGGER `sum` AFTER INSERT ON `tasks` FOR EACH ROW UPDATE project set project.hours = (SELECT SUM(tasks.hours) from tasks WHERE project.project_id = tasks.pid GROUP BY project.project_id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `admin`) VALUES
(1, 'jalaj', 'jalaj@gmail.com', '$2y$10$mYHWFdJ1DJszk0WSr/MWmuwtQhVlFgwE7MhSpWDoCpehOJ3SeBhGu', 1),
(2, 'Stuart', 'stuart@gmail.com', '$2y$10$TA0GuIL9kmV1B/UJGicJ0uEP976Ch4QRBC5eofbFXc3uQHgKTCO8q', 2),
(3, 'Tyler', 'tyler@gmail.com', '$2y$10$t0lLY0vJHsAPuueYyp1qhOrdI.xBgZL4aiqE.qH27cMz9Tse0qJD6', 2),
(4, 'Adam', 'adam@gmail.com', '$2y$10$eAlRaGPeDWvCTQSTrQvZxepbTR0U10unb8lSq6868hAG5ksfPvUhm', 2),
(5, 'Lan', 'lan@gmail.com', '$2y$10$GXzeLlWLXPuUncCtO84acuhyY3OsbOhSpkaRY.PlxAjwTPRoqTGxq', 2),
(6, 'test123', 'test123@gmail.com', '$2y$10$qzPqRIXqqdvR4QuvQDSfNuE4s2JGe7NeKGGB8HedIN9zKXjJ3rJJK', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`pid`,`taskname`),
  ADD KEY `eid` (`eid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`eid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `project` (`project_id`);
