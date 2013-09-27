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
    <h1 class="text-muted">Test Site</h1>

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
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
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
</body>
</html>