/**
* Method to filter dealers by word
* @param object dealers
* @param string filtro in upper case
* @retun object dealers with filter
* */
let printTable  = (dataToTable, filtro = null ) => {

    let dataToPrint = dataToTable.filter(function (simpleData, index, array) {

        if ( filtro !== null ) {
            let name     = simpleData['name'].toUpperCase();
            if ( name.includes(filtro) ) { return true; }

        } else { return true; }

        return false;
    });

    formatTable(dataToPrint);
};


/**
* Method to print dealers like a table
* @param object dealersToPrint
* @return void
* */
let formatTable = ( dataToPrint ) => {

    if ( dataToPrint.length > 0 ) {

        $(`${ searchTarget } .tbody`).html('');

        for ( dataItem of dataToPrint ) {
            let html = `<tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="check${ dataItem.id }" name="producer">
                                    <label class="custom-control-label" for="check${ dataItem.id }">${ dataItem.name }</label>
                                </div>

                            </td>
                        </tr>`;
            $('.tbody').append(html);
        }

    } else {
        $('.tbody').html(`  <tr>
                                <td colspan='10'>
                                    <h3 align='center'>No se encontraron coincidencias</h3>
                                </td>
                            </tr>`);
    }
};


printTable(dataToTable);

/**
*  Method to filter dealers and information
*
* */
$('#autocomplete').on('keyup', function(){
    printTable(dataToTable,  $(this).val().toUpperCase() );
})
