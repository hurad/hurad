<?php $this->Html->css(array('admin/Widgets/widgets'), null, array('inline' => false)); ?>
<?php $this->Html->script(array('admin/Widgets/widget'), array('block' => 'scriptHeader')); ?>

<script>
    jQuery(document).ready(function () {
        //Show widget inside(div.widget-inside)
        $(document).on("click", "span.widget-inside-click", function (event) {
            var item_id = $(this).parent().parent().attr("id");
            $("#" + item_id).children(".widget-inside").slideToggle("slow");
            return false;
        });
        //Edit widget data
        $(document).on("submit", "form", function (event) {
            //Get img.ajax-feedback
            var ajax_feedback = $(this).children(".widget-control-actions").children("div.pull-right").children("img");
            //Visible img.ajax-feedback
            $(ajax_feedback).css("visibility", "visible");
            //Serialize all form's input
            var inputData = $(this).serializeArray();
            //Get unique-id
            var id = $(this).parent().parent().attr("id");
            var widget_data = {};

            widget_data[id] = inputData;

            $.ajax({
                type: 'POST',
                url: Hurad.basePath + 'admin/widgets/edit',
                data: widget_data,
                success: function () {
                    if ($("#form-" + id + " input[name='title']").val() != '') {
                        $("#" + id).children(".widget-title").children(".in-widget-title").text(": " + $("#form-" + id + " input[name='title']").val());
                    }
                    //Hidden img.ajax-feedback
                    $(ajax_feedback).css("visibility", "hidden");
                }});
            return false;
        });
    });
</script>
<div class="row">
<div class="col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5><?php echo __d('hurad', 'Available Widgets'); ?></h5>
        </div>
        <div id="draggable" class="panel-body">
            <?php
            foreach (Configure::read('widgets') as $widget_id => $widget) {
                echo $this->Html->div('panel panel-default widget-item', null, array('value' => $widget['id'], 'id' => $widget['id']));
                echo $this->Html->div('panel-heading widget-title', null);
                echo $widget['title'];
                echo '<span class="in-widget-title"></span>';
                if ($this->Widget->formExist($widget['element'])) {
                    echo '<span class="widget-inside-click" style="display: none;"><i class="glyphicon glyphicon-chevron-down"></i></span>';
                }
                echo '</div>'; //Close div.widget-title
                echo $this->Html->div('widget-inside', null, array('style' => 'display: none;'));
                echo '<form id="form-' . $widget['id'] . '" class="widget-form" accept-charset="utf-8" method="post" action="">';
                if (isset($widget['element']) && $this->Widget->formExist($widget['element'])) {
                    echo $this->Html->div('widget-content', null);
                    echo $this->element('Widgets/' . $widget['element'] . '-form', array('data' => array()));
                    echo "</div>"; //Close div.widget-content
                }
                echo '<input id="number" type="hidden" value="' . HuradWidget::maxNumber(
                        $widget['id']
                    ) . '" name="number">';
                echo '<input id="widget-id" type="hidden" value="' . $widget['id'] . '" name="widget-id">';
                echo '<input id="unique-id" type="hidden" value="" name="unique-id">';
                echo $this->Html->div('widget-control-actions', null);
                echo $this->Html->div('pull-right', null);
                echo $this->Html->image(
                    'ajax-fb.gif',
                    array('class' => 'ajax-feedback', 'style' => 'visibility: hidden;')
                );
                echo '<input id="submit-' . $widget['id'] . '" type="submit" class="btn btn-default widget-submit" value="Save">';
                echo '</div>'; //Close div.pull-right
                echo '<div class="clear"></div>';
                echo '</div>'; //Close div.widget-control-actions
                echo "</form>"; //Close form.widget-form
                echo "</div>"; //Close div.widget-inside
                echo "</div>"; //Close div.widget-item
            }
            ?>
            <span class="clearfix"></span>
        </div>
    </div>
    <?php
    if (Configure::check('sidebars') && !is_null(Configure::read('sidebars'))) {
        $side = array();
        foreach (Configure::read('sidebars') as $sidebarID => $sidebar) {
            $side[] = '#' . $sidebarID;
        }
        ?>
        <script>
            $(function () {
                $("#draggable div.widget-item").draggable({
                    connectToSortable: "<?php echo implode(', ', array_values($side)); ?>",
                    helper: "clone",
                    revert: "invalid"
                });
                $("ul, li").disableSelection();
            });
        </script>
    <?php } ?>
</div>
<div class="col-md-4">
    <?php
    if (Configure::check('sidebars') && !is_null(Configure::read('sidebars'))) {
    foreach (Configure::read('sidebars') as $sidebarID => $sidebar):
    ?>
    <div class="panel panel-default sortable">
        <div class="panel-heading <?php echo "sortable-header-" . $sidebar['id']; ?>">
            <div class="pull-left">
                <h5><?php echo $sidebar['name']; ?></h5>
            </div>
            <div class="pull-right">
                <?php echo $this->Html->image(
                    'ajax-fb.gif',
                    array('class' => 'ajax-feedback', 'style' => 'visibility: hidden;')
                ); ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="panel-description">
            <?php echo $sidebar['description']; ?>
        </div>
        <div id="<?php echo $sidebarID; ?>" class="panel-body">
            <?php
            $sidebars_widgets = unserialize(Configure::read(Configure::read('template') . '.widgets'));
            $widget = Configure::read('widgets');

            if (isset($sidebars_widgets[$sidebarID])) {
                foreach ($sidebars_widgets[$sidebarID] as $wgdb) {
                    echo '<div class="panel panel-default widget-item" value="' . $wgdb['widget-id'] . '" id="' . $wgdb['unique-id'] . '">';
                    echo '<div class="panel-heading widget-title">';
                    echo $widget[$wgdb['widget-id']]['title'];
                    echo isset($wgdb['title']) && !empty($wgdb['title']) ? '<span class="in-widget-title">: ' . $wgdb['title'] . '</span>' : '<span class="in-widget-title"></span>';
                    if ($this->Widget->formExist($widget[$wgdb['widget-id']]['element'])) {
                        echo '<span class="widget-inside-click"><i class="glyphicon glyphicon-chevron-down"></i></span>';
                    }
                    echo "</div>"; //Close div.widget-title
                    echo $this->Html->div('panel-body widget-inside', null, array('style' => 'display: none;'));
                    echo '<form id="form-' . $wgdb['unique-id'] . '" class="widget-form" accept-charset="utf-8" method="post" action="">';
                    if (isset($widget[$wgdb['widget-id']]['element']) && $this->Widget->formExist(
                            $widget[$wgdb['widget-id']]['element']
                        )
                    ) {
                        echo $this->Html->div('widget-content', null);
                        echo $this->element(
                            'Widgets/' . $widget[$wgdb['widget-id']]['element'] . '-form',
                            array('data' => HuradWidget::getWidgetData($wgdb['unique-id']))
                        );
                        echo "</div>"; //Close div.widget-content
                    }
                    echo '<input id="number" type="hidden" value="' . $wgdb['number'] . '" name="number">';
                    echo '<input id="widget-id" type="hidden" value="' . $wgdb['widget-id'] . '" name="widget-id">';
                    echo '<input id="unique-id" type="hidden" value="' . $wgdb['unique-id'] . '" name="unique-id">';
                    echo '<div class="widget-control-actions">';
                    echo $this->Html->div('pull-right', null);
                    echo $this->Html->image(
                        'ajax-fb.gif',
                        array('class' => 'ajax-feedback', 'style' => 'visibility: hidden;')
                    );
                    echo '<input id="submit-' . $wgdb['unique-id'] . '" type="submit" class="btn btn-default widget-submit" value="Save">';
                    echo '</div>'; //Close div.pull-right
                    echo '<div class="clear"></div>';
                    echo '</div>'; //Close div.widget-control-actions
                    echo "</form>"; //Close form.widget-form
                    echo "</div>"; //Close div.widget-inside
                    echo "</div>"; //Close div.widget-item
                }
            }
            ?>

        </div>
    </div>
</div>

<script>

    $("#<?php echo $sidebarID; ?>").sortable({
            revert: true,
            placeholder: "placeholder",
            beforeStop: function (event, ui) {
                new CloneWidget(ui.item);
            },
            update: function (event, ui) {
                //Create order array
                var order = [];
                $('#<?php echo $sidebarID; ?> div.widget-item').each(function () {
                    var item = $(this).children(".widget-inside").children("form").serializeArray();
                    //get the widget id
                    var id = $(this).attr('id');
                    //Create widget object
                    var widget = {};
                    widget[id] = item;
                    //Push object to array
                    order.push(widget);
                });

                var sidebarID = ui.item.parent().attr("id");
                $(".sortable-header-" + sidebarID).children("div.pull-right").children("img").css("visibility", "visible");

                $.post(Hurad.basePath + "admin/widgets", {'<?php echo $sidebarID; ?>': order}, function (data) {
                    $(".sortable-header-" + sidebarID).children("div.pull-right").children("img").css("visibility", "hidden");
                });

            }
        }

    );

</script>


<?php
endforeach;
} else {
    ?>
    <div class="sortable-header">
        <div class="pull-left">
            <h5><?php echo __d('hurad', 'Disable Sidebar'); ?></h5>
        </div>
        <div class="clear"></div>
    </div>
    <div class="sortable-description">
        <?php echo __d('hurad', 'In this theme not supported dynamic sidebar.'); ?>
    </div>
    <div class="sortable">
        <span class="clearfix"></span>
    </div>
<?php } ?>
</div>
</div>