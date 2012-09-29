<!doctype html>
<html dir="ltr" lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo $title_for_layout; ?> | <?php echo Configure::read('General-site_name'); ?></title>

        <?php echo $this->Html->css(array('style', 'media-queries')); ?>

        <!-- respond.js (add media query support for IE) -->
        <!--[if lt IE 9]>
                <script src="http://www.truethemes.org/demo/wp-content/themes/base/js/respond.js"></script>
        <![endif]-->

        <!-- html5.js (HTML5 Shiv for IE) -->
        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- wp_header -->
        <?php echo $this->Html->script(array('theme.script')); ?> 


    </head>

    <body class="home blog">

        <div id="pagewrap">

            <header id="header" class="pagewidth">

                <hgroup>
                    <h1 id="site-logo"><a href="http://www.truethemes.org/demo/"><?php echo Configure::read('General-site_name'); ?></a></h1>
                    <h2 id="site-description"><?php echo Configure::read('General-site_description'); ?></h2>
                </hgroup>

                <nav id="main-nav-wrap">
                    <ul id="main-nav" class="main-nav clearfix">
                        <?php $this->Post->list_pages(); ?>
                    </ul>		
                </nav>

                <div id="searchform-wrap">
                    <form method="get" id="searchform" action="http://www.truethemes.org/demo/">
                        <input type="text" name="s" id="s"  placeholder="Search">
                    </form>
                </div>

                <div class="social-widget">
                    <div class="rss"><a href="http://www.truethemes.org/demo/feed">RSS</a></div>
                </div>
                <!-- /.social-widget -->

            </header>
            <!-- /#header -->

            <div id="body" class="pagewidth clearfix">		

                <div id="content" class="clearfix">


                    <?php echo $this->fetch('content'); ?>


                </div>
                <!-- /#content -->

                <aside id="sidebar">


                    <section class="widget">
                        <h4 class="widgettitle">Pages</h4>
                        <ul>
                            <?php $this->Post->list_pages(); ?>
                        </ul>
                    </section>

                    <section class="widget">
                        <h4 class="widgettitle">Category</h4>
                        <ul>
                            <?php $this->Post->list_categories(); ?>
                        </ul>
                    </section>

                </aside>
                <!-- /#sidebar -->

            </div>
            <!-- /body -->

            <footer id="footer" class="pagewidth clearfix">

                <p class="back-top"><a href="#header">&uarr;</a></p>


                <div class="footer-text clearfix">
                    &copy; 2012<br>
                    Powered by <a href="http://hurad.org">Hurad</a>
                </div>
                <!-- /footer-text --> 

            </footer>
            <!-- /#footer --> 

        </div>
        <!-- /#pagewrap -->

        <!-- wp_footer -->

    </body>
</html>
