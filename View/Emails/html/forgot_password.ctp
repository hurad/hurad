<?php echo sprintf(__('Hello %s', true), $username); ?>,

<?php
$url = 'http://localhost/cakeblog/users/reset/' . $reset_key;
echo sprintf(__('Please visit this link to reset your password: %s'), $url);
?>

<?php echo __('If you did not request a password reset, then please ignore this email.', true); ?>
