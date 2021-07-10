$( document ).ready(function() {
  $('body').on('click','.js-recommend', function(e) {
        e.preventDefault();

        let groceries = [];
        groceries.push($('.js-grocery_name').val());

        $.ajax({
            method: "POST",
            url: "recommend-ajax.php",
            dataType: "json",
            data: { groceries: groceries },
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
});
