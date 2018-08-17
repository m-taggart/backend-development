<?php

/*
 * Reviews Model
 */

//check line fetch/fetchAll and PDO associations

//insert a review
function insertReview($reviewText, $reviewDate, $invId, $clientId) {
 $db = acmeConnect();
 $sql = 'INSERT INTO reviews (reviewText, reviewDate, invId, clientId) VALUES (:reviewText, :reviewDate, :invId, :clientId)';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
 $stmt->bindValue(':reviewDate', $reviewDate, PDO::PARAM_INT); 
 $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
 $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
 $stmt->execute();
 $rowsChanged = $stmt->rowCount();
 $stmt->closeCursor();
 return $rowsChanged;
}

//get reviews for a specific inventory item
//do I need to use a join to get the inventory id from inventory category
function getInvReviews($invId) {
 $db = acmeConnect();
  $sql = 'SELECT reviews.reviewText, reviews.reviewDate, clients.clientFirstName, clients.clientLastName FROM reviews INNER JOIN clients ON reviews.clientId = clients.clientId WHERE invId = :invId ORDER BY reviews.reviewDate';
 $stmt = $db->prepare($sql);
 //treated as an integer
 $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
 $stmt->execute();
 //requesting an associative array 
 $allReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
 $stmt->closeCursor();
 return $allReviews;
}

//get reviews written by a specific client
function getClientReviews($clientId) {
 $db = acmeConnect();
 //* means select everything
 $sql = 'SELECT reviews.reviewId, reviews.reviewText, reviews.reviewDate, inventory.invName FROM reviews INNER JOIN inventory ON reviews.invId = inventory.invId WHERE clientId = :clientId';
 $stmt = $db->prepare($sql);
 //treated as an integer
 $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
 $stmt->execute();
 //requesting an associative array 
 $clientReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
 $stmt->closeCursor();
 return $clientReviews; 
}

//get a specific review
function getSpecificReview($reviewId) {
 $db = acmeConnect();
//  $sql = 'SELECT * FROM reviews WHERE reviewId = :reviewId';
  $sql = 'SELECT reviews.reviewId, reviews.reviewText, reviews.reviewDate, inventory.invName, inventory.invId FROM reviews INNER JOIN inventory ON reviews.invId = inventory.invId WHERE reviewId = :reviewId';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
 $stmt->execute();
 $specReview = $stmt->fetch(PDO::FETCH_ASSOC);
 $stmt->closeCursor();
 return $specReview;  
}

//update a specific review
function updateReview($reviewText, $reviewId) {
//create a connection object using the acme connection function
 $db = acmeConnect();
//the sql statement
 $sql = 'UPDATE reviews SET reviewText = :reviewText WHERE reviewId = :reviewId';
//sends the SQL statement to the database server where it is checked for correctness, and if it is, a PDO Prepared Statement object is created and stored into the $stmt variable
 $stmt = $db->prepare($sql);
//these lines replace the placeholders in the SQL statement with the actual values in the variables and tells the database the type of data it is
 $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
 $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
//insert the data
 $stmt->execute();
//ask how many rows changed aa a result of our insert
 $rowsChanged = $stmt->rowCount();
//close the database interaction
 $stmt->closeCursor();
//return the indication of success (rows changed)
 return $rowsChanged;
}

//delete a specific review
function deleteReview($reviewId) {
 $db = acmeConnect();
 $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
 $stmt->execute();
 $rowsChanged = $stmt->rowCount();
 $stmt->closeCursor();
 return $rowsChanged;
}
