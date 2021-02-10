function __ajax(route, token, type, datos){
  var ajax = $.ajax({
    url: route,
    headers: {
      'X-CSRF-TOKEN': token
    },
    type: type,
    dataType: 'json',
    data: datos
	})
	return ajax;
}
