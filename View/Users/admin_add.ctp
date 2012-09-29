<h2><?php echo $title_for_layout; ?></h2>
<p><?php echo __('Create a brand new user and add it to this site.'); ?></p>
<?php
echo $this->Form->create('User', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>

<div id="wrap-body">
    <div id="wrap-body-content">
        <table class="form-table">
            <tbody><tr class="form-field form-required">
                    <th scope="row"><?php echo $this->Form->label('username', 'Username'); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
                    <td><?php echo $this->Form->input('username', array('type' => 'text')); ?></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><?php echo $this->Form->label('email', 'Email'); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
                    <td><?php echo $this->Form->input('email', array('type' => 'text')); ?></td>
                </tr>
                <tr class="form-field">
                    <th scope="row"><?php echo $this->Form->label('firstname', 'First Name'); ?></th>
                    <td><?php echo $this->Form->input('firstname', array('type' => 'text')); ?></td>
                </tr>
                <tr class="form-field">
                    <th scope="row"><?php echo $this->Form->label('lastname', 'Last Name'); ?></th>
                    <td><?php echo $this->Form->input('lastname', array('type' => 'text')); ?></td>
                </tr>                
                <tr class="form-field form-required">
                    <th scope="row"><?php echo $this->Form->label('password', 'Password'); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
                    <td><?php echo $this->Form->input('password', array('type' => 'password')); ?></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><?php echo $this->Form->label('confirm_password', 'Retype Password'); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
                    <td><?php echo $this->Form->input('confirm_password', array('type' => 'password')); ?></td>
                </tr>
                <tr class="form-field">
                    <th scope="row"><?php echo $this->Form->label('role', 'Role'); ?></th>
                    <td>
                        <?php
                        echo $this->Form->input('role', array('options' =>
                            array(
                                'admin' => 'Administrator',
                                'editor' => 'Editor',
                                'author' => 'Author',
                                'user' => 'User'
                                )));
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php echo $this->Form->input(__('Add New User'), array('type' => 'submit', 'class' => 'add_button')); ?>
    </div>
</div>


