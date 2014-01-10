var numbers = new makeArray0('','one','two','three','four','five','six','seven','eight','nine','ten','eleven','twelve','thirteen','fourteen','fifteen','sixteen','seventeen','eighteen','nineteen');

var numbers10 = new makeArray0('','ten','twenty','thirty','fourty','fifty','sixty','seventy','eighty','ninety');

String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

function makeArray0() {
  for (i = 0; i<makeArray0.arguments.length; i++)
  this[i] = makeArray0.arguments[i];
}

function getCheckamount(input) {
  var dollars = Math.floor(input);
  var cents = Math.round((input*100 - dollars*100));
  var centsraw = fN(cents);
  var centsfmt = centsraw.capitalize();

  var millions = (dollars - dollars % 1000000) / 1000000;
  dollars -= millions * 1000000;
  var hundredthousands = (dollars - dollars % 100000) / 100000;
  dollars -= hundredthousands * 100000;
  var thousands = (dollars - dollars % 1000) / 1000;
  dollars -= thousands * 1000;
  var hundreds = (dollars - dollars % 100) / 100;
  dollars -= hundreds * 100;

  var output = '';

  output += (millions > 0 ? fN(millions) + ' million ' : '') +
            (hundredthousands > 0 ? fN(hundredthousands) + ' hundred thousand ' : '') +
            (thousands > 0 ? fN(thousands) + ' thousand ' : '') +
            (hundreds > 0 ? fN(hundreds) + ' hundred ' : '') +
            (dollars > 0 ? fN(dollars) + ' ' : '') +
            ((thousands > 0 || hundreds > 0 || dollars > 0) ? 'Dollars and ' : 'Zero Dollars and ') +
            (cents > 0 ? centsfmt + ' Cents' : ' Zero Cents');

  return output.substring(0,1).toUpperCase() + output.substring(1);
}

function fN(i) {
  if (i<20) return numbers[i];
  var tens = (i - i % 10) / 10, units = i - (i - i % 10);
  return numbers10[tens] + ((tens > 0 && units > 0) ? '-' : '') + numbers[units];
}