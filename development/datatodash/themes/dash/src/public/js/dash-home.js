document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('dd-cta__contact-form').addEventListener('submit', function(e) {
    e.preventDefault();

    let form_action = 'https://script.google.com/a/datatodash.com.br/macros/s/AKfycbwEsvmFktzVFgQfnfFkJqdKw8ai26XLNNSdmLRorA/exec?a=o';
    let form_method = 'post';
    let fields = {
      name: 'dd-FULLNAME',
      email: 'dd-EMAIL',
      phone: 'dd-PHONE',
      company: 'dd-COMPANY',
      jobtitle: 'dd-JOBTITLE'
    };

    registerContact(form_action, fields, (status, result) => {
      if (status == 200) {
        window.dataLayer = window.dataLayer || [];

        window.dataLayer.push({
          'event': 'forms',
          'category': 'form_submission',
          'action': 'raise_hand',
          'label': window.location.href,
          'value': 1
        });
      }

      window.alert(result);
    });
  });
});
