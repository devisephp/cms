devise.define(['jquery', 'datetimepicker'], function ($, datetimepicker)
{
    // make entire "dvs-admin-card" into a link
    if($('.dvs-admin-card').length > 0) {
        $('.dvs-admin-card').click(function() {
          window.location.href = $(this).data('dvs-url');
        });
    }

    // "expand details" click listener
    $('.dvs-admin-table').on('click', '.dvs-expand-details', function() {
        togglePageDetailsRow($(this));
    });

    $('.dvs-admin-table').on('change', '.dvs-page-version-actions', function() {
        var value = $(this).val();

        switch(value) {
            case 'publish':
                publish($(this));
            break;

            case 'unpublish':
                unpublish($(this));
            break;

            case 'toggle-sharing':
                toggleSharing($(this));
            break;

            case 'delete':
                deleteVersion($(this));
            break;

            case 'create-version':
                createNewPageVersion($(this));
            break;

            case 'preview':
                window.open($(this).find(':selected').data('dvs-url'), '_blank');
            break;
        }
    });

    //  publish page version
    var publish = function(el) {
        var pageId = getSelectedPageId(el);
        var pageVersionId = getSelectedVersionId(el);

        // show datetime pickers for current version
        $('.dvs-publish-dates.'+pageVersionId).show();

        initDatetimePicker();

        // handle form submit
        $('.dvs-publish-dates.'+pageVersionId+' form').submit(function(event) {
            var $form = $(this);

            event.preventDefault();

            // at least one date value has been selected
            if($form.find('.dvs-date.start').val() != '' || $form.find('.dvs-date.end').val() != '') {

                submitAjaxForm(pageId, pageVersionId, $form.serialize());

            } else {

                alert('One date value is required.');

            }
        });
    };

    // unpublish page version
    var unpublish = function(el) {
        var pageId = getSelectedPageId(el);
        var versionId = getSelectedVersionId(el);

        unpublishPageVersion(pageId, versionId);
    };

    // toggle sharing status of page version
    var toggleSharing = function(el) {
        var pageId = getSelectedPageId(el);
        var versionId = getSelectedVersionId(el);
        var enableDisableText = el.find(":selected").text();

         enablePageVersionSharing(pageId, versionId, enableDisableText);
    };

    // page version delete
    var deleteVersion = function(el) {
        var pageId = getSelectedPageId(el);
        var versionId = getSelectedVersionId(el);

        var deleteConfirm = confirm('Are you sure?');

        if(deleteConfirm == true) {
            submitAjaxForm(pageId, versionId, null, '/admin/page-versions/'+ versionId, 'DELETE');
            return true;
        }

        return false;
    };

    // create new page version from selected version
    var createNewPageVersion = function(_this) {
        var _pageId = getSelectedPageId(_this);
        var _pageVersionId = getSelectedVersionId(_this);

        var pageName = prompt('What would you like to name this new page version?');

        if (pageName) {
            var _data = { page_version_id: _pageVersionId, name: pageName };
            submitAjaxForm(_pageId, _pageVersionId, _data, '/admin/page-versions', 'POST');
        }
    }

    /**
     * Shows/Hides "dvs-page-details" and other elements based on
     * the state (expanded/collapsed) of the details section
     * @param {object} _clickedLink  "Expand Page Details / Collapse" link which was clicked
     */
    function togglePageDetailsRow(_clickedLink) {
        var pageDetailsRow = _clickedLink.closest('tr').next();

        pageDetailsRow.toggleClass('dvs-collapsed');

        if(pageDetailsRow.height() > 0) {
            _clickedLink.text('- Collapse');
        } else {
            _clickedLink.text('+ Expand Page Details');
        }
    }

    /**
     * Handles the "un-publishing" of a given page version
     * @return {boolean}
     */
    function unpublishPageVersion(_pageId, _versionId) {
        var confirmVal = confirm('Are you sure you want to un-publish this page version?');

        if(confirmVal == true) {
            // since user confirmed the "un-publishing" of the page version.
            // Go ahead and hit the url and pass null "starts_at" and "ends_at" data
            submitAjaxForm(_pageId, _versionId, 'starts_at=&ends_at=');
            return true;
        }

        return false;
    }


    /**
     * Handles the "enable sharing" of a given page version (making it publicly available)
     * @param {int}  _pageId
     * @param {int}  _versionId  Page Version Id
     * @param {string}  Button text: "Disable Sharing" or "Enable Sharing"
     * @return {boolean}
     */
    function enablePageVersionSharing(_pageId, _versionId, _shareStatusText) {
        var sharingConfirm = confirm('Are you sure you want to "'+ _shareStatusText +'"?');

        if(sharingConfirm == true) {
            submitAjaxForm(_pageId, _versionId, null, '/admin/page-versions/'+ _versionId +'/toggle-share');
            return true;
        }

        return false;
    }


    /**
     * Submit ajax form
     * @param  {int}
     * @param  {string}  Serialized string of form/input data
     * @param  {string}  Form action url
     */
    function submitAjaxForm(_pageId, _versionId, _data, _url, _method) {
        var _url = _url || "/admin/page-versions/" + _versionId + "/dates";
        var _method = _method || "PUT";

        var jqxhr = $.ajax({
            type: _method,
            url: _url,
            data: _data,

        }).success(function() {

            var reloadUrl = $('#page-'+_pageId).data('dvs-reload-url');

            $.get(reloadUrl, function(responseHtml) {
                 $('#page-'+_pageId).html(responseHtml);
            });

        }).fail(function() {

            alert( "An error occured, please try again" ); // @TODO - Properly handle errors

        });

        return jqxhr;
    }


    /**
     * Assigns classes to top level table (".dvs-admin-table").
     * This allows alternating rows to be styled correctly.
     */
    function assignTableRowClasses() {
        $('.dvs-admin-table > tbody > tr:not(:hidden):even').addClass('dvs-table-row-even');
        $('.dvs-admin-table > tbody > tr:not(:hidden):odd').addClass('dvs-table-row-odd');
    }

    /**
     * Retrieves the version id from parent <div>
     * for any of the page version button (in dvs-button-group)
     * @param  {object}  Instance of button which was clicked
     * @return {integer}
     */
    function getSelectedVersionId($this) {
        return $this.parent().data('dvs-version-id');
    }

    /**
     * @param  {object}  Instance of button which was clicked
     * @return {integer}
     */
    function getSelectedPageId($this) {
        return $this.parent().data('dvs-page-id');
    }

    /**
     * Initializes datetime picker
     * @return {void}
     */
    function initDatetimePicker() {
        $('.dvs-date').datetimepicker({
            format:'m/d/y H:i:s'
        });
    }

    /**
     * Initialize function to be executed on page load
     */
    function initialize() {
        initDatetimePicker();
        assignTableRowClasses();
    }

    initialize();

});