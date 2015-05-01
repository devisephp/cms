devise.define(['require', 'jquery', 'spectrum', 'dvsLiveUpdate'], function (require, $, spectrum, liveUpdate) {

    return {
        init: function() {
            $('form.dvs-element-color').each(function(){
                var parentForm = $(this);
                var colorInput = parentForm.find('input[name="color"]');

                var _liveUpdate = liveUpdate.getInstance();
                _liveUpdate.init($, colorInput, 'color');

                var _picker = colorInput.spectrum({
                    preferredFormat: "hex",
                    flat: true,
                    allowEmpty: true,
                    showButtons: false,
                    clickoutFiresChange: true,
                    move: function(color) {
                        var _hexColor = (color !== null) ? color.toHexString() : '';
                        colorInput.val(_hexColor);
                        colorInput.trigger('input');
                    }
                });
            });
        }
    };
});