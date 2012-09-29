<h2><?php echo $title_for_layout; ?></h2>
<?php
echo $this->Form->create('Option', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false),
    'url' => array(
        'controller' => 'options',
        'action' => 'prefix',
        $prefix,
        )));
?>
<p><?php echo __('This can improve the aesthetics, usability, and forward-compatibility of your links.'); ?></p>
<h3><?php echo __('Common settings'); ?></h3>
<table class="form-table">
    <tbody>
        <tr valign="top">
            <th scope="row">
                <?php echo $this->Form->input('Permalink-common', array('options' => array('default' => __('Default')), 'type' => 'radio', 'label' => TRUE, 'hiddenField' => FALSE)); ?>
            </th>
            <td>
                <?php echo __('<code>' . $this->Link->get_home_url() . '/p/123</code>'); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <?php echo $this->Form->input('Permalink-common', array('options' => array('day_name' => __('Day and name')), 'type' => 'radio', 'label' => TRUE, 'hiddenField' => FALSE)); ?>
            </th>
            <td>
                <?php echo __('<code>' . $this->Link->get_home_url() . '/2012/09/16/sample-post/</code>'); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <?php echo $this->Form->input('Permalink-common', array('options' => array('month_name' => __('Month and name')), 'type' => 'radio', 'label' => TRUE, 'hiddenField' => FALSE)); ?>
            </th>
            <td>
                <?php echo __('<code>' . $this->Link->get_home_url() . '/2012/09/sample-post/</code>'); ?>
            </td>
        </tr>
    </tbody>
</table>

<?php echo $this->Form->input(__('Update'), array('type' => 'submit', 'class' => 'add_button')); ?>
