--
-- Table structure for table `tblwishlist`
--

CREATE TABLE tblwishlist (
  UserId_FK INT Unsigned Not Null References tbluser(id),
  ProductId_FK Int Unsigned Not Null References tblproduct(id),
  Primary Key (UserId_FK, ProductId_FK)
);