let goBack = () => {
  window.history.back();
};

let registerContact = (action, fields, callback) => {
  let form_method = 'post';
  let form_params = {};
  let to_return = null;

  for (let [p, v] of Object.entries(fields)) {
    form_params[p] = document.getElementById(v).value;
  }

  let xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState == XMLHttpRequest.DONE) {
      callback(this.status, this.responseText);
    }
  };

  xhttp.open(form_method, action, true);
  xhttp.send(JSON.stringify(form_params));
};
