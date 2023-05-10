jQuery(function () {
  var ajaxurl = smc_book.ajaxurl;

  jQuery("#tbl-list-book").DataTable();

  jQuery("#tbl-list-book-shelf").DataTable();

  // create book shelf code
  jQuery("#frm-add-book-shelf").validate({
    submitHandler: function () {
      var postdata = jQuery("#frm-add-book-shelf").serialize();

      postdata += "&action=admin_ajax_request&param=create_book_shelf";

      jQuery.post(ajaxurl, postdata, function (response) {
        var data = jQuery.parseJSON(response);

        if (data.status == 1) {
          alert(data.message);

          setTimeout(function () {
            location.reload();
          }, 1000);
        }
      });
    },
  });

  //delete book shelf data

  jQuery(document).on("click", ".btn-delete-book-shelf", function () {
    var self_id = jQuery(this).attr("data-id");
    var conf = confirm("Are you sure want to detele?");
    if (conf) {
      var postdata =
        "action=admin_ajax_request&param=delete_book_shelf&shelf_id=" + self_id;

      jQuery.post(ajaxurl, postdata, function (response) {
        var data = jQuery.parseJSON(response);

        if (data.status == 1) {
          alert(data.message);

          setTimeout(function () {
            location.reload();
          }, 1000);
        }
      });
    }
  });

  // processing event on button click
  jQuery(document).on("click", "#btn-first-ajax", function () {
    var postdata = "action=admin_ajax_request&param=first_simple_ajax";

    jQuery.post(ajaxurl, postdata, function (response) {
      console.log(response);
    });
  });
});
