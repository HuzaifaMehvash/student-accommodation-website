<?php include 'includes/db.php'; include 'includes/header.php'; ?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2>Find Your PG</h2>
        <div class="row g-3">
            <div class="col-md-4">
                <select class="form-select" id="cityFilter">
                    <option value="">Select City</option>
                    <option value="Delhi">Delhi</option>
                    <option value="Mumbai">Mumbai</option>
                    <option value="Bangalore">Bangalore</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-select" id="genderFilter">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Unisex">Unisex</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-primary w-100" onclick="filterProperties()">Search</button>
            </div>
        </div>
    </div>
</div>

<div id="loader" class="text-center" style="display:none;">
    <div class="spinner-border text-primary" role="status"></div>
    <p>Loading...</p>
</div>

<div class="row" id="propertyList">
    <?php
    $sql = "SELECT * FROM properties";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card h-100">';
            // Using placehold.co for reliable images
            echo '<img src="https://placehold.co/400x300/007bff/ffffff?text='.urlencode($row['name']).'" class="card-img-top" alt="Property">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">'.$row['name'].'</h5>';
            echo '<p class="card-text">Location: '.$row['city'].'<br>Price: ₹'.$row['price'].'<br>Type: '.$row['gender'].'</p>';
            echo '<a href="property.php?id='.$row['id'].'" class="btn btn-primary">View Details</a>';
            echo '</div></div></div>';
        }
    }
    ?>
</div>

<script>
function filterProperties() {
    var city = document.getElementById('cityFilter').value;
    var gender = document.getElementById('genderFilter').value;
    
    document.getElementById('propertyList').style.display = 'none';
    document.getElementById('loader').style.display = 'block';
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('propertyList').innerHTML = this.responseText;
            document.getElementById('loader').style.display = 'none';
            document.getElementById('propertyList').style.display = 'flex';
        }
    };
    xhttp.open("POST", "ajax_handler.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=filterProperties&city="+city+"&gender="+gender);
}
</script>

</div>
</body>
</html>