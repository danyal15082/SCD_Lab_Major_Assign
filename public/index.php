<?php
/**
 * Home Page
 * Classroom Resource Booking System
 */

require_once 'config/config.php';

// If user is logged in, redirect to appropriate dashboard
if (isLoggedIn()) {
    if (isAdmin()) {
        redirect(SITE_URL . '/admin/dashboard.php');
    } else {
        redirect(SITE_URL . '/user/dashboard.php');
    }
}

$page_title = 'Home';
include 'includes/header.php';
?>

<div class="container">
    <!-- Hero Section -->
    <div class="jumbotron bg-gradient-primary text-white text-center mt-5">
        <h1 class="display-4"><i class="fas fa-calendar-check"></i> Welcome!</h1>
        <p class="lead">Classroom Resource Booking System</p>
        <hr class="my-4 bg-white">
        <p>Efficient management of classrooms, labs, and equipment booking for your institution.</p>
        <div class="mt-4">
            <a class="btn btn-light btn-lg mr-2" href="<?php echo SITE_URL; ?>/login.php">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
            <a class="btn btn-outline-light btn-lg" href="<?php echo SITE_URL; ?>/register.php">
                <i class="fas fa-user-plus"></i> Register
            </a>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row mb-5">
        <div class="col-md-12">
            <h2 class="text-center mb-4">Key Features</h2>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="stats-icon text-primary">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <h5 class="card-title mt-3">Resource Management</h5>
                    <p class="card-text">Manage classrooms, labs, conference rooms, and equipment efficiently.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="stats-icon text-success">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h5 class="card-title mt-3">Easy Booking</h5>
                    <p class="card-text">Book resources quickly with our intuitive booking system.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="stats-icon text-warning">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h5 class="card-title mt-3">Reports & Analytics</h5>
                    <p class="card-text">Track resource utilization with comprehensive reports.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="row mb-5">
        <div class="col-md-12">
            <h2 class="text-center mb-4">How It Works</h2>
        </div>
        <div class="col-md-3 text-center mb-3">
            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" 
                 style="width: 80px; height: 80px; font-size: 2rem;">
                <i class="fas fa-user-plus"></i>
            </div>
            <h5 class="mt-3">1. Register</h5>
            <p class="text-muted">Create your account</p>
        </div>
        <div class="col-md-3 text-center mb-3">
            <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center" 
                 style="width: 80px; height: 80px; font-size: 2rem;">
                <i class="fas fa-search"></i>
            </div>
            <h5 class="mt-3">2. Browse</h5>
            <p class="text-muted">Find available resources</p>
        </div>
        <div class="col-md-3 text-center mb-3">
            <div class="rounded-circle bg-warning text-white d-inline-flex align-items-center justify-content-center" 
                 style="width: 80px; height: 80px; font-size: 2rem;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <h5 class="mt-3">3. Book</h5>
            <p class="text-muted">Make your reservation</p>
        </div>
        <div class="col-md-3 text-center mb-3">
            <div class="rounded-circle bg-info text-white d-inline-flex align-items-center justify-content-center" 
                 style="width: 80px; height: 80px; font-size: 2rem;">
                <i class="fas fa-check-circle"></i>
            </div>
            <h5 class="mt-3">4. Confirm</h5>
            <p class="text-muted">Get approval and use</p>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card bg-light text-center">
                <div class="card-body py-5">
                    <h3>Ready to Get Started?</h3>
                    <p class="lead text-muted">Join our platform and start booking resources today!</p>
                    <a href="<?php echo SITE_URL; ?>/register.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus"></i> Create Account
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
