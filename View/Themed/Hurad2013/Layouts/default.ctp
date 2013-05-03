<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $title_for_layout; ?> | <?php echo Configure::read('General.site_name'); ?></title>
        <?php echo $this->Html->css('bootstrap.min'); ?>
        <?php echo $this->Html->script(array('jquery-1.9.0.min', 'bootstrap.min')); ?>
    </head>
    <body>
        <style>
            body {
                padding-bottom: 60px;
                padding-top: 20px;
            }
        </style>

        <div class="container">
            <div class="row-fluid">
                <div class="span12">
                    <h1>Test Site</h1>
                    <div class="navbar">
                        <div class="navbar-inner">
                            <a class="brand" href="#">Home</a>
                            <ul class="nav">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        Test
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                        <li><a tabindex="-1" href="#">Action</a></li>
                                        <li><a tabindex="-1" href="#">Another action</a></li>
                                        <li><a tabindex="-1" href="#">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span8">
                    <?php echo $this->fetch('content'); ?>
                </div>
                <div class="span4">
                    <?php $this->Widget->sidebar('right-sidebar'); ?>
                </div>
            </div>
        </div>
    </body>
</html>