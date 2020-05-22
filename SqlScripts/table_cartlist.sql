--
-- Table structure for table `tblcartlist`
--

CREATE TABLE tblcartlist (
  UserId_FK INT Unsigned Not Null References tbluser(id),
  ProductId_FK Int Unsigned Not Null References Usertblproduct(id),
  `Quantity` int(8) NOT NULL, 
  Primary Key (UserId_FK, ProductId_FK)
);