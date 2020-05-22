--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`id`, `name`, `code`, `image`, `price`) VALUES
(1, 'White high heels shoes', 'WH1', '../images/Shoes1.jpg', 1500.00),
(2, 'Black high heels thin strip', 'BHT1', '../images/Shoes2.jpg', 800.00),
(3, 'Black spiral shoes', 'BS1', '../images/Shoes3.jpg', 300.00),
(4, 'White high heels shoes', 'WH2', '../images/Shoes4.jpg', 800.00),
(5, 'Flat shoe with strips', 'FS1', '../images/Shoes5.jpg', 500.00),
(6, 'Flat shoe with white strips', 'FS2', '../images/Shoes6.jpg', 1800.00),
(7, 'Flat shoe with blue feathers', 'FS3', '../images/Shoes7.jpg', 600.00),
(8, 'Flat shoes black', 'FS4', '../images/Shoes8.jpg', 450.00);

--
-- Indexes for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`code`);

--

--
-- AUTO_INCREMENT for table `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;