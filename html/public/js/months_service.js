
/**
 *
 * @param {date yy-mm-dd} d1
 * @param {date yy-mm-dd} d2
 * @return int  = total months between 2 dates
 */
function monthDiff(d1, d2)
{
    d1 = changeDateToRead( d1 )
    d2 = changeDateToRead( d2 )

    let months =  parseInt( ( d2.year - d1.year ) * 12 );
    months -=  parseInt( d1.month);
    months +=  parseInt( d2.month);

    return months <= 0 ? 1 : months + 1;
}

function changeDateToRead(dateToRead)
{
    let dateSeparated = dateToRead.split('-');

    return {
        'year': dateSeparated[0],
        'month': dateSeparated[1],
        'day': dateSeparated[2]
    }
}


/**
 *
 * @param {date yy-mm-dd} startDate
 * @param {date  yy-mm-dd} endDate
 * @return array = datesin array
 */
function dateRange(startDate, endDate) {
    var start       = startDate.split('-');
    var end         = endDate.split('-');
    var startYear   = parseInt(start[0]);
    var endYear     = parseInt(end[0]);
    var dates       = [];

    for (var i = startYear; i <= endYear; i++) {

        var endMonth = i != endYear ? 11 : parseInt(end[1]) - 1;
        var startMon = i === startYear ? parseInt(start[1]) - 1 : 0;

        for (var j = startMon; j <= endMonth; j = j > 12 ? j % 12 || 11 : j + 1) {
            var month           = j + 1;
            var displayMonth    = month < 10 ? '0' + month : month;
            dates.push([
                i,
                displayMonth,
                '01'
            ].join('-'));
        }
    }

    return dates;
}


function getMonthYear( dateToRead ) {
    let months = {
        "01" : 'Enero',
        "02" : 'Febrero',
        "03" : 'Marzo',
        "04" : 'Abril',
        "05" : 'Mayo',
        "06" : 'Junio',
        "07" : 'Julio',
        "08" : 'Agosto',
        "09" : 'Septiembre',
        "10" : 'Octubre',
        "11" : 'Noviembre',
        "12" : 'Diciembre',
    };

    let dateSeparated = dateToRead.split("-");

    return {
        'month' : months[dateSeparated[1]],
        'year' : dateSeparated[0]
    }
}

function getSeparatedDate( dateToRead )
{
    return dateToRead.split("-")
}

function getJustDate( dateToRead )
{
    return dateToRead.split("T");
}
