function formatNumbderechos(valor)
{
  var obj = valor;
  var num = new NumberFormat();
  num.setInputDecimal('.');
  num.setNumber(obj);
  num.setPlaces('2', false);
  num.setCurrencyValue('$');
  num.setCurrency(true);
  num.setCurrencyPosition(num.LEFT_OUTSIDE);
  num.setNegativeFormat(num.LEFT_DASH);
  num.setNegativeRed(false);
  num.setSeparators(true, ',', ',');
  return num.toFormatted();
}

function formatNumber(n) {
    return n.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}
