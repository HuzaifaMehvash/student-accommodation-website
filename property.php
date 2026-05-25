<?php 
include 'includes/db.php'; 
include 'includes/header.php'; 

$id = $_GET['id'] ?? 0;
$sql = "SELECT * FROM properties WHERE id = $id";
$result = mysqli_query($conn, $sql);
$property = mysqli_fetch_assoc($result);

$amenitySql = "SELECT a.name FROM amenities a 
               JOIN property_amenities pa ON a.id = pa.amenity_id 
               WHERE pa.property_id = $id";
$amenityResult = mysqli_query($conn, $amenitySql);
?>

<?php if($property): ?>
<div class="row">
    <div class="col-md-6">
        <!-- Updated image source -->
        <img src="https://placehold.co/600x400/007bff/ffffff?text=<?php echo urlencode($property['name']); ?>" class="img-fluid" alt="<?php echo $property['name']; ?>">
    </div>
    <div class="col-md-6">
        <h2><?php echo $property['name']; ?></h2>
        <p><strong>City:</strong> <?php echo $property['city']; ?></p>
        <p><strong>Price:</strong> ₹<?php echo $property['price']; ?>/month</p>
        <p><strong>Type:</strong> <?php echo $property['gender']; ?></p>
        <hr>
        <h4>Amenities:</h4>
        <ul>
            <?php while($am = mysqli_fetch_assoc($amenityResult)): ?>
                <li><?php echo $am['name']; ?></li>
            <?php endwhile; ?>
        </ul>
        <hr>
        <p><?php echo $property['description']; ?></p>
        
        <button id="interestBtn" class="btn btn-success" onclick="markInterest(<?php echo $property['id']; ?>)">Loading...</button>
        <p id="msg" class="mt-2"></p>
    </div>
</div>

<script>
function markInterest(pid) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var btn = document.getElementById('interestBtn');
            var msg = document.getElementById('msg');
            
            if(this.responseText.includes("Please login")) {
                msg.innerHTML = "<a href='login.php'>Login</a> to mark interest.";
            } else {
                btn.innerText = this.responseText;
                btn.className = (this.responseText == "Interested") ? "btn btn-danger" : "btn btn-success";
                msg.innerText = "";
            }
        }
    };
    xhttp.open("POST", "ajax_handler.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=markInterest&property_id=" + pid);
}

window.onload = function() {
    var pid = <?php echo $id; ?>;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var btn = document.getElementById('interestBtn');
            if(this.responseText == "yes") {
                btn.innerText = "Interested";
                btn.className = "btn btn-danger";
            } else {
                btn.innerText = "I'm Interested";
                btn.className = "btn btn-success";
            }
        }
    };
    xhttp.open("POST", "ajax_handler.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=checkInterest&property_id=" + pid);
};
</script>

<?php else: ?>
    <p>Property not found.</p>
<?php endif; ?>

</div>
</body>
</html>