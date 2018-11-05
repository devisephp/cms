(function ($) {
  'use strict';

  function floatTagHandler(element, trumbowyg) {
      var tags = [];

      if (!element.style) {
          return tags;
      }

      if (element.style.float !== '') {
        var floatDirection = element.style.float;
        tags.push('float' + floatDirection);
      }

      return tags;
  }

  // Get the selection's parent
  function getSelectionParentElement() {
    var parentEl = null,
        selection;
    if (window.getSelection) {
        selection = window.getSelection();
        if (selection.rangeCount) {
            parentEl = selection.getRangeAt(0).commonAncestorContainer;
            if (parentEl.nodeType !== 1) {
                parentEl = parentEl.parentNode;
            }
        }
    } else if ((selection = document.selection) && selection.type !== 'Control') {
        parentEl = selection.createRange().parentElement();
    }

    return parentEl;
  }

  // Add all colors in two dropdowns
  $.extend(true, $.trumbowyg, {
      plugins: {
          floats: {
              init: function (trumbowyg) {
                  trumbowyg.o.plugins.floats = trumbowyg.o.plugins.floats;
                  var floatDropdown = {
                      dropdown: buildDropdown('floatDropdown', trumbowyg)
                  };

                 trumbowyg.addBtnDef('floats', floatDropdown);
              },
              tagHandler: floatTagHandler
          }
      }
  });

  function buildDropdown(fn, trumbowyg) {
      var dropdown = [];

      var floatLeftButtonName = fn + 'FloatLeft',
      floatLeftBtnDef = {
          fn: function () {
            var parent = getSelectionParentElement();
            $(parent).css('float', 'left');
            trumbowyg.trigger('tbwchange');
          },
          text: 'Float Left',
          // style adjust for displaying the text
          style: 'text-indent: 0;line-height: 20px;padding: 0 5px;'
      };
      trumbowyg.addBtnDef(floatLeftButtonName, floatLeftBtnDef);
      dropdown.push(floatLeftButtonName);

      var floatRightButtonName = fn + 'FloatRight',
      floatRightBtnDef = {
          fn: function () {
            var parent = getSelectionParentElement();
            $(parent).css('float', 'right');
            trumbowyg.trigger('tbwchange');
          },
          text: 'Float Right',
          // style adjust for displaying the text
          style: 'text-indent: 0;line-height: 20px;padding: 0 5px;'
      };
      trumbowyg.addBtnDef(floatRightButtonName, floatRightBtnDef);
      dropdown.push(floatRightButtonName);

      var clearBothButtonName = fn + 'clearBoth',
      clearBothBtnDef = {
          fn: function () {
            var parent = getSelectionParentElement();
            $(parent).css('clear', 'both');
            trumbowyg.trigger('tbwchange');
          },
          text: 'Clear Both',
          // style adjust for displaying the text
          style: 'text-indent: 0;line-height: 20px;padding: 0 5px;'
      };
      trumbowyg.addBtnDef(clearBothButtonName, clearBothBtnDef);
      dropdown.push(clearBothButtonName);

      var floatClearButtonName = fn + 'FloatClear',
      floatClearBtnDef = {
          fn: function () {
            var parent = getSelectionParentElement();
            $(parent).css('float', '');
            $(parent).css('clear', '');
            trumbowyg.trigger('tbwchange');
          },
          text: 'Remove Styles',
          // style adjust for displaying the text
          style: 'background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAYAAACp8Z5+AAAAG0lEQVQIW2NkQAAfEJMRmwBYhoGBYQtMBYoAADziAp0jtJTgAAAAAElFTkSuQmCC);'
      };
      trumbowyg.addBtnDef(floatClearButtonName, floatClearBtnDef);
      dropdown.push(floatClearButtonName);

      return dropdown;
  }


})(jQuery);