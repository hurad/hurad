<?php $this->Html->css(array('admin/Widgets/widgets'), null, array('inline' => false)); ?>

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
<div class="row-fluid">
    <div class="span8">
        <div class="draggable-header">
            <h5><?php echo __d('hurad', 'Available Widgets'); ?></h5>
        </div>
        <div id="draggable">
            <?php
            foreach (Configure::read('widgets') as $widget_id => $widget) {
                echo $this->Html->div('widget-item', null, array('value' => $widget['id'], 'id' => $widget['id']));
                echo $this->Html->div('widget-title', null);
                echo $widget['title'];
                echo '<span class="in-widget-title"></span>';
                if ($this->Widget->formExist($widget['element'])) {
                    echo '<span class="widget-inside-click" style="display: none;"><i class="icon-chevron-down"></i></span>';
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
                echo '<input id="submit-' . $widget['id'] . '" type="submit" class="btn widget-submit" value="Save">';
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
                        revert: "invalid",
                    });
                    $("ul, li").disableSelection();
                });
            </script>
        <?php } ?>
    </div>
    <div class="span4">
        <?php
        if (Configure::check('sidebars') && !is_null(Configure::read('sidebars'))) {
            foreach (Configure::read('sidebars') as $sidebarID => $sidebar):
                ?>
                <div class="sortable-header <?php echo "sortable-header-" . $sidebar['id']; ?>">
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
                <div class="sortable-description">
                    <?php echo $sidebar['description']; ?>
                </div>
                <div id="<?php echo $sidebarID; ?>" class="sortable">
                    <?php
                    $sidebars_widgets = unserialize(Configure::read(Configure::read('template') . '.widgets'));
                    $widget = Configure::read('widgets');

                    if (isset($sidebars_widgets[$sidebarID])) {
                        foreach ($sidebars_widgets[$sidebarID] as $wgdb) {
                            echo '<div class="widget-item" value="' . $wgdb['widget-id'] . '" id="' . $wgdb['unique-id'] . '">';
                            echo '<div class="widget-title">';
                            echo $widget[$wgdb['widget-id']]['title'];
                            echo isset($wgdb['title']) && !empty($wgdb['title']) ? '<span class="in-widget-title">: ' . $wgdb['title'] . '</span>' : '<span class="in-widget-title"></span>';
                            if ($this->Widget->formExist($widget[$wgdb['widget-id']]['element'])) {
                                echo '<span class="widget-inside-click"><i class="icon-chevron-down"></i></span>';
                            }
                            echo "</div>"; //Close div.widget-title
                            echo $this->Html->div('widget-inside', null, array('style' => 'display: none;'));
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
                            echo '<input id="submit-' . $wgdb['unique-id'] . '" type="submit" class="btn widget-submit" value="Save">';
                            echo '</div>'; //Close div.pull-right
                            echo '<div class="clear"></div>';
                            echo '</div>'; //Close div.widget-control-actions
                            echo "</form>"; //Close form.widget-form
                            echo "</div>"; //Close div.widget-inside
                            echo "</div>"; //Close div.widget-item
                        }
                    }
                    ?>

                    <span class="clearfix"></span>
                </div>

                <script>

                    $("#<?php echo $sidebarID; ?>").sortable({
                            revert: true,
                            placeholder: "placeholder",
                            beforeStop: function (event, ui) {
                                var widget = {};
                                //Get input number
                                widget.number = ui.item.children().children().children('#number').val();
                                //Get div.widget-item value attribute
                                widget.darg_value = ui.item.attr('value');
                                //Change div.widget-item id attribute
                                widget.id = ui.item.attr("id", widget.darg_value + "-" + widget.number);

                                //Update input#number value attribute
                                $("#draggable #" + widget.darg_value).children().children().children("#number").attr("value", parseInt(widget.number) + 1);
                                //Set form id
                                ui.item.children().children("form").attr("id", "form-" + widget.darg_value + "-" + widget.number);
                                //Set submit id
                                ui.item.children().children().children("input[type='submit']").attr("id", "submit-" + widget.darg_value + "-" + widget.number);
                                //Set input#unique-id value
                                ui.item.children().children().children("#unique-id").attr("value", widget.darg_value + "-" + widget.number);

                                ui.item.children(".widget-title").children("span").removeAttr("style");

                                if (ui.item.hasClass("ui-draggable")) {
                                    ui.item.removeClass("ui-draggable");
                                }
                                $("#<?php echo $sidebarID; ?> .clearfix").remove();
                                $("#<?php echo $sidebarID; ?>").append('<span class="clearfix"></span>');
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

                            },
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