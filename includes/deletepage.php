<?php
if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);

    $deletepage_query = $conn->prepare("DELETE FROM `mydiary`.`page_table` WHERE id=?");
    $deletepage_query->bind_param("i", $id);
    $deletepage_query->execute();

    echo "<script>alert('Page Deleted Successfully');</script>";
} else {
    echo "<p class='text-warning'>Please select a post to delete it, id is required.<p>";
}
require_once('includes/homepage.php');
?>