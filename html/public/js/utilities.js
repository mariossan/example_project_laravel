/**
 * @method Metodo para transformar un numero Europeo a Normal solo con los decimales
 * @param {*} numberTotransform
 */
function changeNumToNormal(numberTotransform)
{
    return Number(numberTotransform.replace(/[[, ]/gi, "."))
}


/**
 *
 * @method Metodo para regresar un numero de ISO a europeo pero solo con comas (Decimales)
 * @param {*} numberTotransform
 */
function changeNumToEU(numberTotransform)
{
    let amount  = numberTotransform.toString()
    amount      = amount.split('.').join(',')
    return amount
}


/**
 * @method Metodo para regresar un numero ISo a un numero Europeo con comas y puntos
 * @param {*} numberTotransform
 */
function formatNumberEU(numberTotransform)
{
    const options = {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      };

    let amount  = Number(numberTotransform).toLocaleString('en', options);

    if ( amount.includes(".") ) { // cuenta con deciales
        if ( amount.includes(",") ) { // cuenta con millares y mas
            // primero separamos los decimales
            let separated = amount.split(".")
            return  separated[0].split(",").join(".") + "," + separated[1]

        } else {
            return amount.split('.').join(',');

        }

    } else if ( amount.includes(",") ) { // solo tiene millares y mas
        return amount.split(",").join(".") + ",00"

    } else {

        return amount;
    }
}
