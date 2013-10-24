<?php echo $this->element('Installer/header', array('message' => __("Welcome to Hurad installer"))); ?>
<div class="row checking">
    <div class="col-lg-12">
        <div class="check-item php-version">
            <?php
            if (version_compare(PHP_VERSION, '5.3.0', '>=')):
                echo '<span class="label label-success">';
                echo __d('hurad', 'Your version of PHP is 5.3.0 or higher.');
                echo '</span>'; else:
                echo '<span class="label label-warning">';
                echo __d('hurad', 'Your version of PHP is too low. You need PHP 5.3.0 or higher to use Hurad.');
                echo '</span>';
            endif;
            ?>
        </div>
        <div class="check-item tmp-writable">
            <?php
            if (is_writable(TMP)):
                echo '<span class="label label-success">';
                echo __d('hurad', 'Your tmp directory is writable.');
                echo '</span>'; else:
                echo '<span class="label label-warning">';
                echo __d('hurad', 'Your tmp directory is NOT writable.');
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
                echo __d('hurad', 'Your cache is NOT working. Please check the settings in APP/Config/core.php');
                echo '</span>';
            endif;
            ?>
        </div>

        <?php
        //                $filePresent = null;
        //                if (file_exists(APP . 'Config' . DS . 'database.php')):
        //                    echo '<p><span class="label label-success">';
        //                    echo __d('hurad', 'Your database configuration file is present.');
        //                    $filePresent = true;
        //                    echo '</span></p>';
        //                else:
        //                    echo '<p><span class="label label-warning">';
        //                    echo __d('hurad', 'Your database configuration file is NOT present.');
        //                    echo '<br/>';
        //                    echo __d('hurad', 'Rename APP/Config/database.php.default to APP/Config/database.php');
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
        //                        echo __d('hurad', 'Hurad is able to connect to the database.');
        //                        echo '</span></p>';
        //                    else:
        //                        echo '<p><span class="label label-warning">';
        //                        echo __d('hurad', 'Hurad is NOT able to connect to the database.');
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
            echo __d('hurad', 'PCRE has not been compiled with Unicode support.');
            echo '<br/>';
            echo __(
                'Recompile PCRE with Unicode support by adding <code>--enable-unicode-properties</code> when configuring'
            );
            echo '</span></p>';
        }
        ?>
    </div>

</div>
<div class="row">
    <div class="col-lg-12 info">
        <ul>
            <li>
                <?= $this->Html->link(__d('hurad', 'Official website'), 'http://www.hurad.org'); ?>
            </li>
            <li>
                <?= $this->Html->link(__d('hurad', 'Hurad Documentation'), 'http://docs.hurad.org'); ?>
            </li>
            <li>
                <?= $this->Html->link(__d('hurad', 'Hurad API'), 'http://api.hurad.org'); ?>
            </li>
            <li>
                <?= $this->Html->link(__d('hurad', 'Hurad Source Code'), 'http://github.com/hurad/'); ?>
            </li>
            <li>
                <?= $this->Html->link(__d('hurad', 'Hurad Issues'), 'http://github.com/hurad/hurad/issues'); ?>
            </li>
        </ul>
        <?php echo $this->Html->link(
            __d('hurad', 'If you are ready to install, then click here'),
            array('controller' => 'installer', 'action' => 'database'),
            array('class' => 'btn btn-primary')
        ); ?>
    </div>
</div>

<div class="clearfix"></div>