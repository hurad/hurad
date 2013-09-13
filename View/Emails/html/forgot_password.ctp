<?php echo sprintf(__d('hurad', 'Hello %s'), $username); ?>,

<?php
$url = 'http://localhost/cakeblog/users/reset/' . $reset_key;
echo sprintf(__d('hurad', 'Please visit this link to reset your password: %s'), $url);
?>

<?php echo __d('hurad', 'If you did not request a password reset, then please ignore this email.'); ?>
