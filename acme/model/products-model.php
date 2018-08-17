<?php

/*
 * Products Model
 */

//function for insert a new category to the categories table
function newCategory($categoryName) {

//create a connection object using the acme connection function
 $db = acmeConnect();

//this is the SQL INSERT statement, but using named parameters instead of actual values as part of the prepared statement
 $sql = 'INSERT INTO categories (categoryName) VALUES (:categoryName)';

//create the prepared statement using the acme connection
//sends the SQL statement to the database server where it is checked for correctness, and if it is, a PDO Prepared Statement object is created and stored into the $stmt variable
 $stmt = $db->prepare($sql);

//the next four lines replace the placeholders in the SQL statement with the actual values in the variables and tells the database the type of data it is
 $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);

//insert the data
 $stmt->execute();

//ask how many rows changed aa a result of our insert
 $rowsChanged = $stmt->rowCount();

//close the database interaction
 $stmt->closeCursor();

//return the indication of success (rows changed)
 return $rowsChanged;
}

//function for inserting a new product to the inventory table
function newInventory($invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $categoryId, $invVendor, $invStyle) {

//create a connection object using the acme connection function
 $db = acmeConnect();

//the sql statement
 $sql = 'INSERT INTO inventory (invName, invDescription, invImage, invThumbnail, invPrice, invStock, invSize, invWeight, invLocation, categoryId, invVendor, invStyle) VALUES (:invName, :invDescription, :invImage, :invThumbnail, :invPrice, :invStock, :invSize, :invWeight, :invLocation, :categoryId, :invVendor, :invStyle)';

//sends the SQL statement to the database server where it is checked for correctness, and if it is, a PDO Prepared Statement object is created and stored into the $stmt variable
 $stmt = $db->prepare($sql);

//these lines replace the placeholders in the SQL statement with the actual values in the variables and tells the database the type of data it is
 $stmt->bindValue(':invName', $invName, PDO::PARAM_STR);
 $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
 $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
 $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
 $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR); //check how to store price
 $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
 $stmt->bindValue(':invSize', $invSize, PDO::PARAM_STR);
 $stmt->bindValue(':invWeight', $invWeight, PDO::PARAM_INT);
 $stmt->bindValue(':invLocation', $invLocation, PDO::PARAM_STR);
 $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT); //param_int??
 $stmt->bindValue(':invVendor', $invVendor, PDO::PARAM_STR);
 $stmt->bindValue(':invStyle', $invStyle, PDO::PARAM_STR);

//insert the data
 $stmt->execute();

//ask how many rows changed aa a result of our insert
 $rowsChanged = $stmt->rowCount();

//close the database interaction
 $stmt->closeCursor();

//return the indication of success (rows changed)
 return $rowsChanged;
}

//getProductBasics() will get basic product information from the inventory table
function getProductBasics() {
 $db = acmeConnect();
 //get name and id from inventory
 $sql = 'SELECT invName, invId FROM inventory ORDER BY invName ASC';
 $stmt = $db->prepare($sql);
 $stmt->execute();
 //get an associative array for each item
 $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
 $stmt->closeCursor();
 return $products;
}

// Get product information by invId
function getProductInfo($invId) {
 $db = acmeConnect();
 //* means select everything
 $sql = 'SELECT * FROM inventory WHERE invId = :invId';
 $stmt = $db->prepare($sql);
 //treated as an integer
 $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
 $stmt->execute();
 //requesting an associative array 
 $prodInfo = $stmt->fetch(PDO::FETCH_ASSOC);
 $stmt->closeCursor();
 return $prodInfo;
}

//update products from inventory
function updateProduct($invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $categoryId, $invVendor, $invStyle, $invId) {

//create a connection object using the acme connection function
 $db = acmeConnect();

//the sql statement
 $sql = 'UPDATE inventory SET invName = :invName, invDescription = :invDescription, invImage = :invImage, invThumbnail = :invThumbnail, invPrice = :invPrice, invStock = :invStock, invSize = :invSize, invWeight = :invWeight, invLocation = :invLocation, categoryId = :categoryId, invVendor = :invVendor, invStyle = :invStyle WHERE invId = :invId';

//sends the SQL statement to the database server where it is checked for correctness, and if it is, a PDO Prepared Statement object is created and stored into the $stmt variable
 $stmt = $db->prepare($sql);

//these lines replace the placeholders in the SQL statement with the actual values in the variables and tells the database the type of data it is
 $stmt->bindValue(':invName', $invName, PDO::PARAM_STR);
 $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
 $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
 $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
 $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR); //check how to store price
 $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
 $stmt->bindValue(':invSize', $invSize, PDO::PARAM_STR);
 $stmt->bindValue(':invWeight', $invWeight, PDO::PARAM_INT);
 $stmt->bindValue(':invLocation', $invLocation, PDO::PARAM_STR);
 $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT); //param_int??
 $stmt->bindValue(':invVendor', $invVendor, PDO::PARAM_STR);
 $stmt->bindValue(':invStyle', $invStyle, PDO::PARAM_STR);
 $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);

//insert the data
 $stmt->execute();

//ask how many rows changed aa a result of our insert
 $rowsChanged = $stmt->rowCount();

//close the database interaction
 $stmt->closeCursor();

//return the indication of success (rows changed)
 return $rowsChanged;
}

//delete products from inventory
function deleteProduct($invId) {
//create a connection object using the acme connection function
 $db = acmeConnect();
//the sql statement
 $sql = 'DELETE FROM inventory WHERE invId = :invId';
//sends the SQL statement to the database server where it is checked for correctness, and if it is, a PDO Prepared Statement object is created and stored into the $stmt variable
 $stmt = $db->prepare($sql);
//these lines replace the placeholders in the SQL statement with the actual values in the variables and tells the database the type of data it is
 $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
//insert the data
 $stmt->execute();
//ask how many rows changed aa a result of our insert
 $rowsChanged = $stmt->rowCount();
//close the database interaction
 $stmt->closeCursor();
//return the indication of success (rows changed)
 return $rowsChanged;
}

//Get a list of products based on the category
function getProductsByCategory($type){
 $db = acmeConnect();
 $sql = 'SELECT * FROM inventory WHERE categoryId IN (SELECT categoryId FROM categories WHERE categoryName = :catType)';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':catType', $type, PDO::PARAM_STR);//:catList
 $stmt->execute();
 $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
 $stmt->closeCursor();
 return $products; 
}

//retrieve information about a specific inventory item and return to controller
function getProductDetail($invId) {
 $db = acmeConnect();
 $sql = 'SELECT * FROM inventory WHERE invId = :invId';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
 $stmt->execute();
 $description = $stmt->fetch(PDO::FETCH_ASSOC);
 $stmt->closeCursor();
 return $description; 
}
