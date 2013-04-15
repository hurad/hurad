<div class="alert alert-error alert-block">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h5><?php echo $message; ?></h5>
    <ul>
        <?php foreach ($errors as $field => $error): ?>
            <li><?php echo $error[0]; ?></li>
        <?php endforeach; ?>
    </ul>
</div>
