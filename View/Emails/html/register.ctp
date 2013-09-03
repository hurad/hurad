<p>
    Username: <b><?php echo $username; ?></b><br>
    Password: <b><?php echo $password; ?></b><br>
    Email: <b><?php echo $email; ?></b><br>
</p>
<p>
    For activate your account please click on this link : <a
        href="<?php echo $siteUrl; ?>/users/verify/<?php echo $activationKey; ?>">Active Account</a>
</p>