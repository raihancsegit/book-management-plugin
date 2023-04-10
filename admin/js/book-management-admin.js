jQuery(function () {
  var ajaxurl = smc_book.ajaxurl;

  // processing event on button click
  jQuery(document).on("click", "#btn-first-ajax", function () {
    var postdata = "action=admin_ajax_request&param=first_simple_ajax";

    jQuery.post(ajaxurl, postdata, function (response) {
      alert("working");
      console.log(response);
    });
  });
});
