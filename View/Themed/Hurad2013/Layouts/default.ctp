<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title_for_layout; ?> | <?php echo Configure::read('General.site_name'); ?></title>
    <?php echo $this->Html->css(array('bootstrap.min', 'main')); ?>
    <?php echo $this->Html->script(array('jquery-1.9.0.min', 'bootstrap.min')); ?>
</head>
<body>

<div class="container">
    <h1 class="text-muted"><?php echo Configure::read('General.site_name'); ?></h1>

    <nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Brand</a>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <form class="navbar-form navbar-right" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="<?= __d('hurad', 'Search'); ?>">
                </div>
                <button type="submit" class="btn btn-default"><?= __d('hurad', 'Search'); ?></button>
            </form>
        </div>
    </nav>
    <div class="row">
        <div class="col-lg-9">
            <?php echo $this->fetch('content'); ?>
        </div>
        <div class="col-lg-3">
            <?php $this->Widget->sidebar('right-sidebar'); ?>
        </div>
    </div>
</div>
<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
    <p class="navbar-text"><?=
        __d(
            'hurad',
            'Powered by %s',
            $this->Html->link('Hurad', 'http://hurad.org')
        ) ?></p>

    <p class="navbar-text pull-right"><?=
        __d(
            'hurad',
            'All rights reserved &copy; %s',
            date('Y')
        ) ?></p>
</nav>
</body>
</html>