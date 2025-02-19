<?php
session_start();
require "config.php";

// Get all gigs from the database
$sql = "SELECT gigs.id, gigs.title, gigs.price, gigs.image, users.username FROM gigs JOIN users ON gigs.user_id = users.id ORDER BY gigs.created_at DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching gigs: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gigs Marketplace</title>
    <style>
        .gig-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .gig-card {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            background-color: #f9f9f9;
        }
        .gig-card h3 {
            margin: 10px 0;
        }
        .gig-card p {
            color: #555;
        }
        .gig-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .gig-card a {
            color: #28a745;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Welcome to the Gig Marketplace</h1>

<div class="gig-container">
    <?php while ($gig = $result->fetch_assoc()) { ?>
        <div class="gig-card">
            <h3><?php echo htmlspecialchars($gig['title']); ?></h3>
            <p>Posted by: <?php echo htmlspecialchars($gig['username']); ?></p>
            <p>Price: $<?php echo number_format($gig['price'], 2); ?></p>
            <?php if ($gig['image']) { ?>
                <img src="<?php echo htmlspecialchars($gig['image']); ?>" alt="Gig Image">
            <?php } ?>
            <a href="view_gig.php?id=<?php echo $gig['id']; ?>">View Gig</a>
        </div>
    <?php } ?>
</div>

</body>
</html>
