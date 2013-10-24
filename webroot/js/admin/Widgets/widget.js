/**
 * CloneWidget
 * When drag widget from draggable area to sortable
 * before stop(beforeStop event) widget run this class
 *
 * @param item
 * @constructor
 */
function CloneWidget(item) {

    /**
     * The jQuery object representing the current dragged element.
     *
     * @type {jQuery}
     */
    this.item = item;

    /**
     * Store widget number
     *
     * @type {number}
     */
    this.number = 0;

    /**
     * Store widget value
     *
     * @type {null}
     */
    this.value = null;

    /**
     * Initialize widget on 'beforeStop' event
     */
    this.init = function () {
        this.setNumber();
        this.setValue();
        this.changeWidgetId();
        this.updateNumber();
        this.updateFormId();
        this.updateSubmitId();
        this.updateUniqueIdValue();
        this.cleanUp();
    };

    /**
     * Set number the current dragged element
     */
    this.setNumber = function () {
        this.number = this.item.children().children().children('#number').val();
    };

    /**
     * Get number the current dragged element
     */
    this.getNumber = function () {
        return this.number;
    };

    /**
     * Set value the current dragged element
     */
    this.setValue = function () {
        this.value = this.item.attr('value');
    };

    /**
     * Get value the current dragged element
     * @return {string} Return value of current dragged element
     */
    this.getValue = function () {
        return this.value;
    };

    /**
     * Change widget id (div.widget-item) the current dragged element
     */
    this.changeWidgetId = function () {
        this.item.attr("id", this.getValue() + "-" + this.getNumber());
    };

    /**
     * Update input number (input#number) on source draggable area
     */
    this.updateNumber = function () {
        $("#draggable #" + this.getValue()).children().children().children("#number").attr("value", parseInt(this.getNumber()) + 1);
    };

    /**
     * Update form id before stop the current dragged element
     */
    this.updateFormId = function () {
        this.item.children().children("form").attr("id", format("form-{value}-{number}", {value: this.getValue(), number: this.getNumber()}));
    };

    /**
     * Update submit id before stop the current dragged element
     */
    this.updateSubmitId = function () {
        this.item.children().children().children("input[type='submit']").attr("id", format("submit-{value}-{number}", {value: this.getValue(), number: this.getNumber()}));
    };

    /**
     * Update unique id value before stop the current dragged element
     */
    this.updateUniqueIdValue = function () {
        //Set input#unique-id value
        this.item.children().children().children("#unique-id").attr("value", format("{value}-{number}", {value: this.getValue(), number: this.getNumber()}));
    };

    /**
     * Clean up item
     */
    this.cleanUp = function () {
        this.item.children(".widget-title").children("span").removeAttr("style");

        if (this.item.hasClass("ui-draggable")) {
            this.item.removeClass("ui-draggable");
        }
    };

    /**
     * Format string
     *
     * @param str
     * @param col
     * @returns {string}
     */
    var format = function (str, col) {
        col = typeof col === 'object' ? col : Array.prototype.slice.call(arguments, 1);

        return str.replace(/\{\{|\}\}|\{(\w+)\}/g, function (m, n) {
            if (m == "{{") {
                return "{";
            }
            if (m == "}}") {
                return "}";
            }
            return col[n];
        });
    };

    /**
     * Call initialize method
     */
    this.init();
}