<style>
    #draggable, .sortable {
        background-color: #F5F5F5;
        border-color: #E3E3E3;
        border-style: solid;
        border-width: 0 1px 1px 1px;
        border-radius: 0 0 4px 4px;
        margin-bottom: 20px;
        padding: 15px 15px 10px 15px;
        min-height: 80px;
    }
    #draggable div.widget-title {
        padding: 0 0 0 10px;
        line-height: 30px;
        background-color: #FAFAFA;
        background-image: linear-gradient(to bottom, #FFFFFF, #F2F2F2);
        background-repeat: repeat-x;
        border: 1px solid #D4D4D4;
        border-radius: 4px 4px 4px 4px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.067);
    }
    #draggable div.widget-item {
        width: 250px;
        margin: 0 20px 10px 0;
        float: left;
        cursor: move;
    }
    .sortable div.widget-item {
        width: 100%;
        float: left;
        margin-bottom: 10px;
        cursor: move;

    }
    .sortable div.widget-title {
        line-height: 30px;
        background-color: #FAFAFA;
        background-image: linear-gradient(to bottom, #FFFFFF, #F2F2F2);
        background-repeat: repeat-x;
        border: 1px solid #D4D4D4;
        border-radius: 4px 4px 4px 4px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.067);
        padding: 0 0 0 10px;
        cursor: move;
    }
    .sortable-header, .draggable-header{
        background: -moz-linear-gradient(center top , #EFEFEF, #CACACA) repeat scroll 0 0 transparent;
        border:1px solid #E3E3E3;
        border-radius: 4px 4px 0 0;
        clear: none;
        color: #222222;
        display: block;
        margin: 0;
        padding: 4px 0 4px 8px;

    }
    .sortable-header img{
        padding: 8px 10px 4px 0px;

    }
    .sortable-header h5, .draggable-header h5{
        font-size: 12px;
        line-height: 10px;
        text-decoration: none;
        text-shadow: 1px 1px #EEEEEE;
    }
    .sortable-description{
        background-color: #F5F5F5;
        border-color: #E3E3E3;
        border-style: solid;
        border-width: 0 1px 0 1px;
        padding: 12px 15px 0 15px;
        color: #828282;
        font-style: italic;
        font-size: small;
    }
    .in-widget-title{
        color: #696969;
        font-size: small;
    }
    .widget-inside-click{
        float: right;
        height: 30px;
        width: 22px;
        cursor: pointer !important;
        border-left: #D4D4D4 solid 1px;
        padding: 0 0 0 8px;
    }
    .widget-inside{
        background-color: #FFFFFF;
        border-width: 0 1px 1px 1px;
        border-color: #D4D4D4;
        border-style: solid;
        border-radius: 0 0 4px 4px;
        padding: 8px;
    }
    .widget-form{
        margin: 0;
    }
    .ajax-feedback {
        padding: 0 5px 0 0;
    }
    div.clear {
        clear: both;
        height: 2px;
        line-height: 2px;
    }
    .placeholder{
        float: left;
        border: 1px dashed #a2a2a2;
        border-radius: 4px 4px 4px 4px;
        height: 30px;
        width: 100%;
        margin-bottom: 10px;
    }
</style>
<script>
    jQuery(document).ready(function() {
        //Show widget inside(div.widget-inside)
        $(document).on("click", "span.widget-inside-click", function(event) {
            var item_id = $(this).parent().parent().attr("id");
            $("#" + item_id).children(".widget-inside").slideToggle("slow");
            return false;
        });
        //Edit widget data
        $(document).on("submit", "form", function(event) {
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
                url: '/hurad/admin/widgets/edit',
                data: widget_data,
                success: function() {
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
            <h5><?php echo __('Available Widgets'); ?></h5>
        </div>
        <div id="draggable">
            <?php
            foreach (Configure::read('widgets') as $widget_id => $widget) {
                echo $this->Html->div('widget-item', NULL, array('value' => $widget['id'], 'id' => $widget['id']));
                echo $this->Html->div('widget-title', NULL);
                echo $widget['title'];
                echo '<span class="in-widget-title"></span>';
                if ($this->Widget->formExist($widget['element'])) {
                    echo '<span class="widget-inside-click" style="display: none;"><i class="icon-chevron-down"></i></span>';
                }
                echo '</div>'; //Close div.widget-title
                echo $this->Html->div('widget-inside', NULL, array('style' => 'display: none;'));
                echo '<form id="form-' . $widget['id'] . '" class="widget-form" accept-charset="utf-8" method="post" action="">';
                if (isset($widget['element']) && $this->Widget->formExist($widget['element'])) {
                    echo $this->Html->div('widget-content', NULL);
                    echo $this->element('Widgets/' . $widget['element'] . '-form', array('data' => array()));
                    echo "</div>"; //Close div.widget-content
                }
                echo '<input id="number" type="hidden" value="' . HuradWidget::maxNumber($widget['id']) . '" name="number">';
                echo '<input id="widget-id" type="hidden" value="' . $widget['id'] . '" name="widget-id">';
                echo '<input id="unique-id" type="hidden" value="" name="unique-id">';
                echo $this->Html->div('widget-control-actions', NULL);
                echo $this->Html->div('pull-right', NULL);
                echo $this->Html->image('ajax-fb.gif', array('class' => 'ajax-feedback', 'style' => 'visibility: hidden;'));
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
                $(function() {
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
                        <?php echo $this->Html->image('ajax-fb.gif', array('class' => 'ajax-feedback', 'style' => 'visibility: hidden;')); ?>
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
                            echo $this->Html->div('widget-inside', NULL, array('style' => 'display: none;'));
                            echo '<form id="form-' . $wgdb['unique-id'] . '" class="widget-form" accept-charset="utf-8" method="post" action="">';
                            if (isset($widget[$wgdb['widget-id']]['element']) && $this->Widget->formExist($widget[$wgdb['widget-id']]['element'])) {
                                echo $this->Html->div('widget-content', NULL);
                                echo $this->element($widget[$wgdb['widget-id']]['element'] . '-form', array('data' => HuradWidget::getWidgetData($wgdb['unique-id'])));
                                echo "</div>"; //Close div.widget-content
                            }
                            echo '<input id="number" type="hidden" value="' . $wgdb['number'] . '" name="number">';
                            echo '<input id="widget-id" type="hidden" value="' . $wgdb['widget-id'] . '" name="widget-id">';
                            echo '<input id="unique-id" type="hidden" value="' . $wgdb['unique-id'] . '" name="unique-id">';
                            echo '<div class="widget-control-actions">';
                            echo $this->Html->div('pull-right', NULL);
                            echo $this->Html->image('ajax-fb.gif', array('class' => 'ajax-feedback', 'style' => 'visibility: hidden;'));
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
                        beforeStop: function(event, ui) {
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
                        update: function(event, ui) {
                            //Create order array
                            var order = [];
                            $('#<?php echo $sidebarID; ?> div.widget-item').each(function() {
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

                            $.post("/hurad/admin/widgets", {'<?php echo $sidebarID; ?>': order}, function(data) {
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
                    <h5><?php echo __('Disable Sidebar'); ?></h5>
                </div>
                <div class="clear"></div>
            </div>
            <div class="sortable-description">
                <?php echo __('In this theme not supported dynamic sidebar.'); ?>
            </div>
            <div class="sortable">
                <span class="clearfix"></span>
            </div>
        <?php } ?>
    </div>
</div>