<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<nav>
    <a href="admin_index.php">Home</a>
    
    
    <?php if (isset($_SESSION['user_id'])): ?>
        
    <?php else: ?>
        
        
    <?php endif; ?>
</nav>