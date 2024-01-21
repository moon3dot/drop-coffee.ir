window.addEventListener('elementor/init', () => {
    var jdatePickerControl = elementor.modules.controls.BaseData.extend({
        onReady() {
            this.control_select = this.$el.find('.elementor-jdate-time-picker');
            this.save_input = this.control_select;
            setTimeout(function () {
                jQuery('.elementor-jdate-time-picker').persianDatepicker({
                    cellWidth: 55,
                    cellHeight: 40,
                    fontSize: 16,
                    showGregorianDate: false,
                    persianNumbers: false,
                    prevArrow: '<i class="eicon-chevron-left"></i>',
                    nextArrow: '<i class="eicon-chevron-right"></i>',
                    formatDate: "YYYY-0M-0D 0h:0m",
                    onSelect: function () {
                        jQuery('.elementor-jdate-time-picker').trigger('change');
                    }
                });
            }, 300);

            this.control_select.on('change', () => {
                this.saveValue();
            });
        },

        saveValue() {
            this.setValue(this.save_input.val());
        },

        onBeforeDestroy() {
            this.saveValue();
        }
    });

    elementor.addControlView('jdate_picker', jdatePickerControl);
});