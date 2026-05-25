<?php
include 'includes/db.php';

$action = $_POST['action'] ?? '';

if ($action == 'filterProperties') {
    $city = $_POST['city'];
    $gender = $_POST['gender'];
    
    $sql = "SELECT * FROM properties WHERE 1=1";
    if ($city != "") $sql .= " AND city='$city'";
    if ($gender != "") $sql .= " AND gender='$gender'";
    
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card h-100">';
            // Updated image source
            echo '<img src="https://placehold.co/400x300/007bff/ffffff?text='.urlencode($row['name']).'" class="card-img-top" alt="Property">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">'.$row['name'].'</h5>';
            echo '<p class="card-text">Location: '.$row['city'].'<br>Price: ₹'.$row['price'].'<br>Type: '.$row['gender'].'</p>';
            echo '<a href="property.php?id='.$row['id'].'" class="btn btn-primary">View Details</a>';
            echo '</div></div></div>';
        }
    } else {
        echo '<p class="text-center">No properties found.</p>';
    }
}

if ($action == 'markInterest') {
    if (!isset($_SESSION['user_id'])) {
        echo "Please login first";
        exit();
    }
    
    $user_id = $_SESSION['user_id'];
    $property_id = $_POST['property_id'];
    
    // Check if already interested
    $check = "SELECT * FROM interested_users WHERE user_id=$user_id AND property_id=$property_id";
    $res = mysqli_query($conn, $check);
    
    if (mysqli_num_rows($res) > 0) {
        // Remove interest
        mysqli_query($conn, "DELETE FROM interested_users WHERE user_id=$user_id AND property_id=$property_id");
        echo "Interest Removed";
    } else {
        // Add interest
        mysqli_query($conn, "INSERT INTO interested_users (user_id, property_id) VALUES ($user_id, $property_id)");
        echo "Interested";
    }
}

if ($action == 'checkInterest') {
    if (!isset($_SESSION['user_id'])) {
        echo "no";
    } else {
        $user_id = $_SESSION['user_id'];
        $property_id = $_POST['property_id'];
        $check = "SELECT * FROM interested_users WHERE user_id=$user_id AND property_id=$property_id";
        $res = mysqli_query($conn, $check);
        echo (mysqli_num_rows($res) > 0) ? "yes" : "no";
    }
}
?>