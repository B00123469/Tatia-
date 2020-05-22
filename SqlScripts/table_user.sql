--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `id` int(8) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`id`, `firstname`, `lastname`, `password`, `role`, `email`) VALUES
(1, 'Tatia', 'Tsotskolauri', 'password', 'Admin', 'tatia09@live.com'),
(2, 'Sophia', 'Tsotskolauri', 'password', 'Customer', 'tatiababy@gmail.com');

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;