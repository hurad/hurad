<div class="well installer">
    <?php echo $this->element('Installer/header', array('message' => __("Welcome to Hurad installer"))); ?>
    <div class="container-fluid checking">
        <div class="row">
            <div class="check-item php-version">
                <?php
                if (version_compare(PHP_VERSION, '5.3.0', '>=')):
                    echo '<span class="label label-success">';
                    echo __('Your version of PHP is 5.3.0 or higher.');
                    echo '</span>'; else:
                    echo '<span class="label label-warning">';
                    echo __('Your version of PHP is too low. You need PHP 5.3.0 or higher to use Hurad.');
                    echo '</span>';
                endif;
                ?>
            </div>
            <div class="check-item tmp-writable">
                <?php
                if (is_writable(TMP)):
                    echo '<span class="label label-success">';
                    echo __('Your tmp directory is writable.');
                    echo '</span>'; else:
                    echo '<span class="label label-warning">';
                    echo __('Your tmp directory is NOT writable.');
                    echo '</span>';
                endif;
                ?>
            </div>
            <div class="check-item cache-setting">
                <?php
                $settings = Cache::settings();
                if (!empty($settings)):
                    echo '<span class="label label-success">';
                    echo __(
                        'The %s is being used for core caching. To change the config edit APP/Config/core.php ',
                        '<em>' . $settings['engine'] . 'Engine</em>'
                    );
                    echo '</span>'; else:
                    echo '<span class="label label-warning">';
                    echo __('Your cache is NOT working. Please check the settings in APP/Config/core.php');
                    echo '</span>';
                endif;
                ?>
            </div>

            <?php
            //                $filePresent = null;
            //                if (file_exists(APP . 'Config' . DS . 'database.php')):
            //                    echo '<p><span class="label label-success">';
            //                    echo __('Your database configuration file is present.');
            //                    $filePresent = true;
            //                    echo '</span></p>';
            //                else:
            //                    echo '<p><span class="label label-warning">';
            //                    echo __('Your database configuration file is NOT present.');
            //                    echo '<br/>';
            //                    echo __('Rename APP/Config/database.php.default to APP/Config/database.php');
            //                    echo '</span></p>';
            //                endif;
            ?>

            <?php
            //            if (isset($filePresent)) {
            //                App::uses('ConnectionManager', 'Model');
            //                try {
            //                    $connected = ConnectionManager::getDataSource('default');
            //                } catch (Exception $connectionError) {
            //                    $connected = false;
            //                    $errorMsg = $connectionError->getMessage();
            //                    if (method_exists($connectionError, 'getAttributes')) {
            //                        $attributes = $connectionError->getAttributes();
            //                        if (isset($errorMsg['message'])) {
            //                            $errorMsg .= '<br />' . $attributes['message'];
            //                        }
            //                    }
            //                }
            ?>
            <?php
            //                    if ($connected && $connected->isConnected()):
            //                        echo '<p><span class="label label-success">';
            //                        echo __('Hurad is able to connect to the database.');
            //                        echo '</span></p>';
            //                    else:
            //                        echo '<p><span class="label label-warning">';
            //                        echo __('Hurad is NOT able to connect to the database.');
            //                        echo '<br /><br />';
            //                        echo $errorMsg;
            //                        echo '</span></p>';
            //                    endif;
            ?>
            <?php //} ?>
            <?php
            App::uses('Validation', 'Utility');
            if (!Validation::alphaNumeric('hurad')) {
                echo '<p><span class="label label-warning">';
                echo __('PCRE has not been compiled with Unicode support.');
                echo '<br/>';
                echo __(
                    'Recompile PCRE with Unicode support by adding <code>--enable-unicode-properties</code> when configuring'
                );
                echo '</span></p>';
            }
            ?>
        </div>
        <div class="row">
            <div class="info">
                <ul>
                    <li>
                        <a href="http://www.hurad.org"><?php echo __('Hurad'); ?> </a>
                        <ul>
                            <li><?php echo __('Official website'); ?></li>
                        </ul>
                    </li>
                    <li>
                        <a href="http://docs.hurad.org"><?php echo __('Hurad Documentation'); ?> </a>
                        <ul>
                            <li><?php echo __('Your Development Document'); ?></li>
                        </ul>
                    </li>
                    <li>
                        <a href="http://api.hurad.org"><?php echo __('Hurad API'); ?> </a>
                        <ul>
                            <li><?php echo __('Quick Reference'); ?></li>
                        </ul>
                    </li>
                    <li>
                        <a href="http://github.com/hurad/"><?php echo __('Hurad Code'); ?> </a>
                        <ul>
                            <li><?php echo __('For the Development of Hurad Git repository, Downloads'); ?></li>
                        </ul>
                    </li>
                    <li>
                        <a href="http://github.com/hurad/hurad/issues"><?php echo __('Hurad Issues'); ?> </a>
                        <ul>
                            <li><?php echo __('Hurad issue tracking system'); ?></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <?php echo $this->Html->link(
                __('If you are ready to install, then click here'),
                array('controller' => 'installer', 'action' => 'database'),
                array('class' => 'btn btn-success')
            ); ?>
        </div>

        <div class="clearfix"></div>
    </div>
</div>