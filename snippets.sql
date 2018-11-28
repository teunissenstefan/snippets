-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 28, 2018 at 09:25 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `snippets`
--

-- --------------------------------------------------------

--
-- Table structure for table `gebruikers`
--

CREATE TABLE `gebruikers` (
  `id` varchar(15) NOT NULL,
  `gebruikersnaam` varchar(255) NOT NULL,
  `voornaam` varchar(64) NOT NULL,
  `achternaam` varchar(64) NOT NULL,
  `wachtwoord` char(64) NOT NULL,
  `salt` char(16) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefoonnummer` varchar(25) NOT NULL,
  `rol` int(11) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language`) VALUES
('bash', 'Bash'),
('basic', 'BASIC'),
('cpp', 'C++'),
('csharp', 'C#'),
('css', 'CSS'),
('dos', 'DOS'),
('excel', 'Excel'),
('glsl', 'OpenGL Shading Language'),
('html', 'HTML'),
('java', 'Java'),
('javascript', 'JavaScript'),
('json', 'JSON'),
('lua', 'Lua'),
('makefile', 'Makefile'),
('markdown', 'Markdown'),
('perl', 'Perl'),
('php', 'PHP'),
('powershell', 'PowerShell'),
('processing', 'Processing'),
('python', 'Python'),
('ruby', 'Ruby'),
('scss', 'SCSS'),
('shell', 'Shell'),
('sql', 'SQL'),
('typescript', 'TypeScript'),
('vbnet', 'VB.net'),
('vbscript', 'VBScript'),
('vim', 'Vim Script'),
('x86asm', 'x86 Assembly');

-- --------------------------------------------------------

--
-- Table structure for table `rollen`
--

CREATE TABLE `rollen` (
  `id` int(11) NOT NULL,
  `rol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rollen`
--

INSERT INTO `rollen` (`id`, `rol`) VALUES
(1, 'Admin'),
(2, 'Snippet Creator'),
(3, 'Gebruiker');

-- --------------------------------------------------------

--
-- Table structure for table `snippets`
--

CREATE TABLE `snippets` (
  `id` varchar(20) NOT NULL,
  `beschrijving` varchar(255) NOT NULL,
  `snippet` text NOT NULL,
  `aangemaaktdoor` varchar(15) NOT NULL,
  `language` varchar(20) NOT NULL,
  `datum_aangemaakt` datetime NOT NULL,
  `datum_update` datetime NOT NULL,
  `private` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol` (`rol`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rollen`
--
ALTER TABLE `rollen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `snippets`
--
ALTER TABLE `snippets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language` (`language`),
  ADD KEY `aangemaaktdoor` (`aangemaaktdoor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rollen`
--
ALTER TABLE `rollen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD CONSTRAINT `gebruikers_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rollen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `snippets`
--
ALTER TABLE `snippets`
  ADD CONSTRAINT `snippets_ibfk_1` FOREIGN KEY (`language`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `snippets_ibfk_2` FOREIGN KEY (`aangemaaktdoor`) REFERENCES `gebruikers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;