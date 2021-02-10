function Dialogo1(){
  $( "#dialog-confirm" ).removeClass('hide').dialog({
    resizable: false,
    width: '320',
    modal: true,
    title: "Ups!",
    title_html: true,
    buttons: [
      {
        html: "&nbsp;Aceptar ",
        "class" : "btn btn-danger btn-minier",
        click: function() {
          $( this ).dialog( "close" );
        }
      }
    ]
  });
}
