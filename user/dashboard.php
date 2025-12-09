<?php
/**
 * User Dashboard
 * Classroom Resource Booking System
 */

require_once '../config/config.php';
requireLogin();

$conn = getDBConnection();
$user_id = $_SESSION['user_id'];

// Get user statistics
$stats = [];

// Total Bookings
$sql = "SELECT COUNT(*) as count FROM bookings WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stats['total_bookings'] = $result->fetch_assoc()['count'];
$stmt->close();

// Approved Bookings
$sql = "SELECT COUNT(*) as count FROM bookings WHERE user_id = ? AND status = 'approved'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stats['approved_bookings'] = $result->fetch_assoc()['count'];
$stmt->close();

// Pending Bookings
$sql = "SELECT COUNT(*) as count FROM bookings WHERE user_id = ? AND status = 'pending'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stats['pending_bookings'] = $result->fetch_assoc()['count'];
$stmt->close();

// Upcoming Bookings
$sql = "SELECT COUNT(*) as count FROM bookings WHERE user_id = ? AND booking_date >= CURDATE() AND status = 'approved'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stats['upcoming_bookings'] = $result->fetch_assoc()['count'];
$stmt->close();

// Recent Bookings
$sql = "SELECT b.*, r.resource_name, r.resource_code
        FROM bookings b
        JOIN resources r ON b.resource_id = r.resource_id
        WHERE b.user_id = ?
        ORDER BY b.created_at DESC
        LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$recent_bookings = $stmt->get_result();
$stmt->close();

closeDBConnection($conn);

$page_title = 'User Dashboard';
include '../includes/header.php';
?>

<div class="container">
    <div class="mb-4">
        <h2><i class="fas fa-tachometer-alt"></i> Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h2>
        <p class="text-muted">Manage your bookings and browse available resources</p>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Bookings</h6>
                            <h2 class="mb-0"><?php echo $stats['total_bookings']; ?></h2>
                        </div>
                        <div class="stats-icon text-primary">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stats-card success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Approved</h6>
                            <h2 class="mb-0"><?php echo $stats['approved_bookings']; ?></h2>
                        </div>
                        <div class="stats-icon text-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stats-card warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Pending</h6>
                            <h2 class="mb-0"><?php echo $stats['pending_bookings']; ?></h2>
                        </div>
                        <div class="stats-icon text-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stats-card info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Upcoming</h6>
                            <h2 class="mb-0"><?php echo $stats['upcoming_bookings']; ?></h2>
                        </div>
                        <div class="stats-icon text-info">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Bookings -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-history"></i> Recent Bookings</span>
                    <a href="<?php echo SITE_URL; ?>/user/my_bookings.php" class="btn btn-sm btn-primary">
                        View All
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if ($recent_bookings->num_rows > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Resource</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($booking = $recent_bookings->fetch_assoc()): ?>
                                    <tr>
                                        <td>#<?php echo $booking['booking_id']; ?></td>
                                        <td><?php echo htmlspecialchars($booking['resource_code']); ?></td>
                                        <td><?php echo formatDate($booking['booking_date']); ?></td>
                                        <td><?php echo formatTime($booking['start_time']); ?></td>
                                        <td>
                                            <span class="badge <?php echo getBookingStatusBadge($booking['status']); ?>">
                                                <?php echo ucfirst($booking['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <h4>No Bookings Yet</h4>
                            <p>You haven't made any bookings yet.</p>
                            <a href="<?php echo SITE_URL; ?>/user/create_booking.php" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Your First Booking
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-bolt"></i> Quick Actions
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo SITE_URL; ?>/user/create_booking.php" class="btn btn-primary btn-block mb-2">
                            <i class="fas fa-plus-circle"></i> New Booking
                        </a>
                        <a href="<?php echo SITE_URL; ?>/user/browse_resources.php" class="btn btn-success btn-block mb-2">
                            <i class="fas fa-search"></i> Browse Resources
                        </a>
                        <a href="<?php echo SITE_URL; ?>/user/my_bookings.php" class="btn btn-info btn-block mb-2">
                            <i class="fas fa-book"></i> My Bookings
                        </a>
                        <a href="<?php echo SITE_URL; ?>/profile.php" class="btn btn-secondary btn-block">
                            <i class="fas fa-user"></i> My Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Info -->
            <div class="card mt-3">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Account Information
                </div>
                <div class="card-body">
                    <p><strong>Email:</strong><br><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                    <p><strong>Role:</strong><br><span class="badge badge-primary">User</span></p>
                    <p class="mb-0"><strong>Status:</strong><br><span class="badge badge-success">Active</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
