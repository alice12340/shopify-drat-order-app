window.axios = require('axios');
axios.get('cart.js').then(function (response) {
    var cart_info = response.data;
    var domain = 'https://jokes-treat-cooking-asking.trycloudflare.com';
 
    axios.post(domain + '/api/saveCartInfo', cart_info).then(function (re) {
    localStorage.setItem('config', JSON.stringify(re.data));
    
    }).catch(function (e) {
    console.log(e);
    });

  
  }).catch(function (e) {
    console.log(e);
  });

  $('#cart-to-checkout').click(function () {
    $('#cart-to-checkout').addClass('disabled revy-button-loading-state');
    $('#cart-to-checkout').find('span').append("<div class=\"rbls-ring\"><div></div><div></div><div></div><div></div></div>");
    if ($('#total_custom_price').val() > 0) {
      axios.get('cart.js').then(function (response) {
        var cart_info = response.data;
        axios.post(domain + '/api/createDraftOrder', cart_info).then(function (re) {
          console.log(re.data);
          window.location.href = re.data;
        }).catch(function (e) {
          console.log(e);
        });
      }).catch(function (e) {
        console.log(e);
      });
    } else {
      $('#checkout').click();
    }
  });