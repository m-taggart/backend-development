<?php

/*
 * Accounts Model for site visitors
 */

//function will handle site registrations
function regClient($clientFirstName, $clientLastName, $clientEmail, $clientPassword) {

//create a connection object using the acme connection function
 // creates a new database connection object by calling the acme database connection function from the connections.php file
 $db = acmeConnect();

//the sql statement
//this is the SQL INSERT statement, but using named parameters instead of actual values as part of the prepared statement
 $sql = 'INSERT INTO clients (clientFirstName, clientLastName, clientEmail, clientPassword) VALUES (:clientFirstName, :clientLastName, :clientEmail, :clientPassword)';

//create the prepared statement using the acme connection
//sends the SQL statement to the database server where it is checked for correctness, and if it is, a PDO Prepared Statement object is created and stored into the $stmt variable
 $stmt = $db->prepare($sql);

//the next four lines replace the placeholders in the SQL statement with the actual values in the variables and tells the database the type of data it is
 $stmt->bindValue(':clientFirstName', $clientFirstName, PDO::PARAM_STR);
 $stmt->bindValue(':clientLastName', $clientLastName, PDO::PARAM_STR);
 $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
 $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);

//insert the data
 $stmt->execute();

//ask how many rows changed aa a result of our insert
 $rowsChanged = $stmt->rowCount();

//close the database interaction
 $stmt->closeCursor();

//return the indication of success (rows changed)
 return $rowsChanged;
}

//new function will check for existing emails
function checkExistingEmail($clientEmail) {
//create a connection object using the acme connection function
 $db = acmeConnect();
//this is the SQL SELECT statement, but using named parameters instead of actual values as part of the prepared statement
//The function will use a SELECT query to see if a matching email address can be found in the database table.
 $sql = 'SELECT clientEmail FROM clients WHERE clientEmail = :email';
//create the prepared statement using the acme connection
 $stmt = $db->prepare($sql);
 //the next line replace the placeholders in the SQL statement with the actual values in the variables and tells the database the type of data it is
 $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
 //insert the data
 $stmt->execute();
 //find matching emails in the database using the if else numbers
 //We only want to get a single row from the database if a match is found, so use a "fetch()" not a "fetchAll()". In addition, we can indicate that we only want a simple numeric array by adding a parameter to the fetch of "PDO::FETCH_NUM".
 $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
 $stmt->closeCursor();
 //if the array is empty return 0, if array is not empty return 1
 if (empty($matchEmail)) {
  return 0;
//  echo 'Nothing Found';
//  exit;
 } else {
  return 1;
//  echo 'Match Found';
//  exit;
 }
}

// Get client data based on an email address
function getClient($clientEmail) {
 $db = acmeConnect();
 $sql = 'SELECT clientId, clientFirstName, clientLastName, clientEmail, clientLevel, clientPassword FROM clients WHERE clientEmail = :clientEmail';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
 $stmt->execute();
 $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
 $stmt->closeCursor();
 return $clientData;
}

// Get account information by clientId
function getAccountInfo($clientId){
 $db = acmeConnect();
 $sql = 'SELECT * FROM clients WHERE clientId = :clientId';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
 $stmt->execute();
 $accountInfo = $stmt->fetch(PDO::FETCH_ASSOC);
 $stmt->closeCursor();
 return $accountInfo;
}

//function for updating account
function updateAccount($clientFirstName, $clientLastName, $clientEmail, $clientId) {

//create a connection object using the acme connection function
 $db = acmeConnect();

//the sql statement
 $sql = 'UPDATE clients SET clientFirstName = :clientFirstName, clientLastName = :clientLastName, clientEmail = :clientEmail WHERE clientId = :clientId';

//sends the SQL statement to the database server where it is checked for correctness, and if it is, a PDO Prepared Statement object is created and stored into the $stmt variable
 $stmt = $db->prepare($sql);

//these lines replace the placeholders in the SQL statement with the actual values in the variables and tells the database the type of data it is
 $stmt->bindValue(':clientFirstName', $clientFirstName, PDO::PARAM_STR);
 $stmt->bindValue(':clientLastName', $clientLastName, PDO::PARAM_STR);
 $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
 $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);

//insert the data
 $stmt->execute();

//ask how many rows changed aa a result of our insert
 $rowsChanged = $stmt->rowCount();

//close the database interaction
 $stmt->closeCursor();

//return the indication of success (rows changed)
 return $rowsChanged;
}

//update client password
function updatePassword($hashedPassword, $clientId){
//create a connection object using the acme connection function
 $db = acmeConnect();

//the sql statement
 $sql = 'UPDATE clients SET clientPassword = :hashedPassword WHERE clientId = :clientId';

//sends the SQL statement to the database server where it is checked for correctness, and if it is, a PDO Prepared Statement object is created and stored into the $stmt variable
 $stmt = $db->prepare($sql);

//these lines replace the placeholders in the SQL statement with the actual values in the variables and tells the database the type of data it is
 $stmt->bindValue(':hashedPassword', $hashedPassword, PDO::PARAM_STR);
 $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
 
//insert the data
 $stmt->execute();

//ask how many rows changed aa a result of our insert
 $rowsChanged = $stmt->rowCount();

//close the database interaction
 $stmt->closeCursor();

//return the indication of success (rows changed)
 return $rowsChanged;
}
 



