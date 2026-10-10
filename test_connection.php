<?php
require_once "db.php";

$connection_status = "Connected successfully to MySQL database 'studenthub_db' using PHP PDO!";

// Prepared Statement 1: Fetch events
$event_stmt = $pdo->prepare("SELECT event_id, title, event_date, venue, capacity FROM events ORDER BY event_date ASC");
$event_stmt->execute();
$events = $event_stmt->fetchAll();

// Prepared Statement 2: Fetch joined registrations
$reg_query = "SELECT 
                r.reg_id,
                s.student_id,
                s.full_name,
                s.email,
                e.title AS event_title,
                e.event_date,
                r.status,
                r.registration_date
              FROM registrations r
              INNER JOIN students s ON r.student_id = s.student_id
              INNER JOIN events e ON r.event_id = e.event_id
              ORDER BY r.reg_id ASC";

$reg_stmt = $pdo->prepare($reg_query);
$reg_stmt->execute();
$registrations = $reg_stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practical 8: StudentHub PDO Connection & Prepared Statements</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

    <!-- Header -->
    <header>
        <img src="charusat logo.jpg" alt="Charusat Logo" style="max-height: 80px; width: auto;" onerror="this.style.display='none'">
        <h1 class="brand-title">CHARUSAT Student Portal</h1>
    </header>

    <!-- Navigation -->
    <nav>
        <a href="index.html">Home</a>
        <a href="login.html">Login</a>
        <a href="dashboard-student.html">Student Dashboard</a>
        <a href="dashboard-admin.html">Admin Dashboard</a>
        <a href="profile.html">Profile</a>
        <a href="courses.html">Courses</a>
        <a href="registration.html">Registration</a>
        <a href="test_connection.php" class="active">DB Verification (Practical 8)</a>
        <a href="results.html">Grades</a>
        <a href="logout.html">Logout</a>
    </nav>

    <!-- Main Content -->
    <main>
        <h2>Practical 8: PDO Database Connectivity & Prepared Statements</h2>

        <div class="status-badge">
            &#10004; <?= htmlspecialchars($connection_status) ?>
        </div>

        <h3>1. Active Campus Events (Prepared Statement Query)</h3>
        <table>
            <thead>
                <tr>
                    <th>Event ID</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Venue</th>
                    <th>Capacity</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['event_id']) ?></td>
                            <td><strong><?= htmlspecialchars($row['title']) ?></strong></td>
                            <td><?= htmlspecialchars($row['event_date']) ?></td>
                            <td><?= htmlspecialchars($row['venue']) ?></td>
                            <td><?= htmlspecialchars($row['capacity']) ?> Seats</td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5">No events found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h3>2. Event Registrations (Multi-Table JOIN via PDO)</h3>
        <table>
            <thead>
                <tr>
                    <th>Reg ID</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Event Title</th>
                    <th>Event Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($registrations)): ?>
                    <?php foreach ($registrations as $reg): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($reg['reg_id']) ?></td>
                            <td><?= htmlspecialchars($reg['student_id']) ?></td>
                            <td><?= htmlspecialchars($reg['full_name']) ?></td>
                            <td><?= htmlspecialchars($reg['email']) ?></td>
                            <td><?= htmlspecialchars($reg['event_title']) ?></td>
                            <td><?= htmlspecialchars($reg['event_date']) ?></td>
                            <td><span class="badge-tag"><?= htmlspecialchars($reg['status']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7">No registered records available.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 CHARUSAT University. All rights reserved.</p>
    </footer>

    <!-- Shreyas Patel 25CS080 -->
</body>
</html>