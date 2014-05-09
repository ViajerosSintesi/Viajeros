 function render() {
    gapi.signin.render('customBtn', {
      'callback': 'signinCallback',
      'clientid': '865149418176-0ss5pal5ebfr6lc4gn842usboejduknk.apps.googleusercontent.com',
      'cookiepolicy': 'single_host_origin',
      'requestvisibleactions': 'http://schemas.google.com/AddActivity',
      'scope': 'https://www.googleapis.com/auth/plus.login'
    });
  }
  function signinCallback(authResult) {
  if (authResult['access_token']) {
    // Autorizado correctamente
    // Oculta el botón de inicio de sesión ahora que el usuario está autorizado, por ejemplo:
    //console.log(authResult['acces_token']);
    document.getElementById('customBtn').setAttribute('style', 'display: none');
  } else if (authResult['error']) {
    // Se ha producido un error.
    // Posibles códigos de error:
    //   "access_denied": el usuario ha denegado el acceso a la aplicación.
    //   "immediate_failed": no se ha podido dar acceso al usuario de forma automática.
    console.log('There was an error: ' + authResult['error']);
  }
}