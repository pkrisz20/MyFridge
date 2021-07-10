$( document ).ready(function() {
  $('body').on('click','.js-add', function(e) {
        e.preventDefault();

        var ingredient = $('.js-ingredient-input').val();

        $.ajax({
            method: "POST",
            url: "search-ajax.php",
            dataType: "json",
            data: { ingredient: ingredient },
            success: function(response) {
              if(response.status == true)
              {
                $('.js-tbody').append(response.message);
                $('.js-error').addClass("hidden");
              } else {
                $('.js-error').html(response.message);
                $('.js-error').removeClass("hidden");
              }
            },
        });
    });

    $('body').on('click','.js-delete', function(e) {
      e.preventDefault();

      $(this).closest('tr').remove();
    });
});
