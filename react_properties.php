<?php 
include 'includes/db.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>React PG Finder</title>
    <script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div id="root"></div>

    <script type="text/babel">
        const { useState, useEffect } = React;

        function App() {
            const [userId, setUserId] = useState(<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>);
            const [message, setMessage] = useState("");

            const handleInterestToggle = () => {
                if(!userId) {
                    setMessage("Please login first!");
                    return;
                }

                const formData = new FormData();
                formData.append("action", "markInterest");
                formData.append("property_id", "1");

                fetch("ajax_handler.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.text())
                .then(data => {
                    setMessage(data);
                });
            };

            return (
                <div className="container mt-5">
                    <nav className="navbar navbar-dark bg-primary p-3 rounded">
                        <div className="container">
                            <span className="navbar-brand">PG Finder (React)</span>
                            <div>
                                {userId ? 
                                    <span className="text-white">Welcome!</span> : 
                                    <a href="login.php" className="text-white">Login</a>
                                }
                            </div>
                        </div>
                    </nav>

                    <div className="card mt-5 p-4">
                        <h3>React Component Feature</h3>
                        <p>This section is powered by React!</p>
                        
                        <button className="btn btn-success w-25" onClick={handleInterestToggle}>
                            Toggle Interest
                        </button>
                        
                        <p className="mt-3 text-primary fw-bold">{message}</p>
                    </div>

                    <div className="card mt-4 p-4">
                        <h4>Property Preview (from PHP)</h4>
                        <?php
                        $sql = "SELECT * FROM properties LIMIT 2";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<div className="border-bottom py-2">';
                            echo '<strong>' . $row['name'] . '</strong> - ₹' . $row['price'];
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            );
        }

        const root = ReactDOM.createRoot(document.getElementById("root"));
        root.render(<App />);
    </script>

</body>
</html>