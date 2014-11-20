define(['jquery', 'app/bindings/data-dvs-replacement'], function ($)
{

  // make entire "dvs-admin-card" into a link
  if($('.dvs-admin-card').length > 0) {
    $('.dvs-admin-card').click(function() {
      window.location.href = $(this).data('dvs-url');
    });
  }

});
