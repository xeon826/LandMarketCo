$(document).ready(function() {
  $.ajax({
    type: 'POST',
    url: 'functions.php',
    data: ({
      action: 'get_current_inv',
      query: $('.query').val()
    }),
    success: function(response) {
      $('main').html(response);
    }
  });
  $('.view-edit').on('click', function() {
    $('main').html($('.edit-wrapper').html());
  })
  $('body').on('click', '.edit-product', function() {
//     <input value="'.$row["ProductName"].'" class="product-name"></input>
// <input value="'.$row["Label"].'" class="label"></input>
// <input value="'.$row["StartingInventory"].'" class="starting-inventory"></input>
// <input value="'.$row["MinimumRequired"].'" class="minimum-required"></input>
    $.ajax({
      type:'POST',
      url: 'functions.php',
      data: ({
        action:$(this).parent().data('id'),
        id:$(this).parent(),
        product_name: $(this).siblings('.product-name').val(),
        label: $(this).siblings('.label').val(),
        starting_inventory: $(this).siblings('.starting-inventory').val(),
        minimum_required: $(this).siblings('.minimum-required').val(),
      }),
      success: function(response) {
        $('.parCreate').html(response);
      }
    })

  })
  $('body').on('click', '.manage', function() {
    // alert($(this).parent().data('id'));
    $('.mod').css({
      'display': 'block',
    }).animate({
      'opacity': '1'
    })
    $.ajax({
      type: 'POST',
      url: 'functions.php',
      data: ({
        product_id: $(this).parent().data('id'),
        action: 'get_product',
      }),
      success: function(response) {
        $('.mod').html(response);
      }
    });
  })
  $('body').on('click', '.view', function() {
    var $action = $(this).data('action');
    $.ajax({
      type: 'POST',
      url: 'functions.php',
      data: ({
        action: $action,
        query: $('.query').val()
      }),
      success: function(response) {
        $('main').html(response);
      }
    });
  })
  $('.current-inventory').addClass('active');
  $('.nav-bar').children().each(function(i, obj) {
    $(this).on('click', function() {
      $('.nav-bar *').removeClass('active');
      $(this).addClass('active');
    })
  })
  var container = $('.mod');
  $(document).mouseup(function(e) {
    if (!container.is(e.target) && container.has(e.target).length === 0) {
      container.attr("style", "");
    }
  });
})
