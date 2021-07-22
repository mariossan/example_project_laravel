$(function(){
    $('.selectpicker').selectpicker();

    let objFechaInicio = {
        defaultDate: "-1m",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        minDate: '-90',
        dateFormat: 'yy-mm-dd',
        onClose: function( selectedDate ) {
          $( ".to" ).datepicker( "option", "minDate", selectedDate );
        }
    };


    let objFechaFin = {
        defaultDate: "0",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: 'yy-mm-dd',
        onClose: function( selectedDate ) {
          $( ".from" ).datepicker( "option", "maxDate", selectedDate );
        }
    };


    if ( typeof fecha_inicio != "undefined" ) {
        $( ".from" )
            .datepicker( objFechaInicio )
            .datepicker(
                "setDate",
                new Date(
                    fecha_inicio[0] ,
                    fecha_inicio[1] - 1,
                    fecha_inicio[2],
                )
            );

        $( ".to" )
            .datepicker( objFechaFin )
            .datepicker(
                "setDate",
                new Date(
                    fecha_fin[0],
                    fecha_fin[1] - 1,
                    fecha_fin[2],
                )
            );

    } else {

        $( ".from" ).datepicker( objFechaInicio ).datepicker("setDate", "0");
        $( ".to" ).datepicker(objFechaFin).datepicker("setDate", "0");
    }


    /**
    * @method Metodo donde se lee el ingreso total para la campaña
    */
    $('.ingresosIpt').on('input propertychange', function() {
        $('.presupuestoIpt').val('');
        $('.margenIpt').val('');

        $('.toPrintMonths').fadeOut("slow")
    })

    /**
     * @method Metodo donde se lee el dato de presupuesto general y se calcula el margen del ingreso total
     * @return void
     */
    $('.presupuestoIpt').on('input propertychange', function(){
        $('.toPrintMonths').fadeOut("slow")

        if ( changeNumToNormal( $('.ingresosIpt').val() ) > 0 ) {
            /* se hace el cálculo de  para ver cuanto queda de margen */
           let presupuesto  = changeNumToNormal( $(this).val() )
           let ingresos     = changeNumToNormal ( $('.ingresosIpt').val() )

           let margen       = Math.floor( 100 - ( ( presupuesto * 100 ) / ingresos ) );
           $('.margenIpt').val( margen )
        }
    })

    /**
     * @method Metodo donde se lee el argen y se calcula el presupuesto restante del ingreso total
     * @return void
     */
    $('.margenIpt').on('input propertychange', function(){

        $('.toPrintMonths').fadeOut("slow")

        if ( changeNumToNormal ($('.ingresosIpt').val() ) > 0 ) {
            /* se hace el cálculo de  para ver cuanto queda de margen */
           let margen       = $(this).val();
           let ingresos     = changeNumToNormal ( $('.ingresosIpt').val() )
           let presupuesto  = ingresos - ( ingresos * ( margen / 100 ) )
           $('.presupuestoIpt').val( changeNumToEU(presupuesto) )
        }
    })

    /* a mostrar la tabla de llenado de informacion */
    $('.btnShowTable').on("click", function(){

        let ingresos    = changeNumToNormal ( $('.ingresosIpt').val() )
        let presupuesto = changeNumToNormal ( $('.presupuestoIpt').val() )

        if ( ingresos  > 0 ) {
            $('.toPrintMonths').fadeIn("slow")

            let difference = monthDiff(
                $('.from').val(),
                $('.to').val()
            )

            // calculo de montos
            let ingresoPorMes       = ingresos / difference;
            let presupuestoPorMes   = presupuesto / difference;


            /* Print total months */
            $('.totalMonths').val(difference).change()

            /* calculate all months diff */
            let months = dateRange($('.from').val(), $('.to').val())

            $(".toPrintMonths").html(`
                <div class="row">
                    <div class="col">Mes</div>
                    <div class="col">Ingresos</div>
                    <div class="col">Presupuesto</div>
                </div>`);

            let sumaIngresos    = 0
            let sumaPresupuesto = 0

            for (const month of months) {
                let response    =  getMonthYear( month )
                sumaIngresos    += parseFloat(ingresoPorMes.toFixed(2))
                sumaPresupuesto += parseFloat(presupuestoPorMes.toFixed(2))

                if ( sumaIngresos > ingresos ) {
                    ingresoPorMes = parseFloat(ingresoPorMes.toFixed(2)) - (sumaIngresos - ingresos)

                }

                if ( sumaPresupuesto > presupuesto ) {
                    presupuestoPorMes = parseFloat(presupuestoPorMes.toFixed(2)) - ( sumaPresupuesto - presupuesto );

                }

                /* Se pinta cada mes para poder agregar un presupuesto individual */
                $(".toPrintMonths").append(`<div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <input type="text" name="mes[]" class="form-control" value="${ response.month } ${ response.year }" readonly>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <input type="text" name="ingresosMes[]" class="form-control ingresoData soloNumeros" value="${ changeNumToEU( ingresoPorMes.toFixed(2) ) }" placeholder="Ingreso €" required>
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="form-group">
                                                        <input type="text" name="presupuestosMes[]" class="form-control presupuestoData soloNumeros" value="${ changeNumToEU( presupuestoPorMes.toFixed(2) ) }" placeholder="Presupuesto €" required >
                                                    </div>
                                                </div>
                                            </div>`);
            }
        }
    })

    /**
     *
     * METHOD TO READ MOTNS BETWEEN DATES
     *
     */

    $('.from,.to').on('change', function(){

        // $('.toPrintMonths').fadeOut("fast")

        let difference = monthDiff(
            $('.from').val(),
            $('.to').val()
        )

        /* Print total months */
        $('.totalMonths').val(difference).change()

    })



    $("body").on('input propertychange', '.soloNumeros', function(){
        var RegExPattern = /^\d+$/;
        $(this).val($(this).val().replace(/[[a-zA-Z\u00D1\u00F1\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC@ ]/gi, ""));
    });


    /**
     * @method metodo para validar que la suma de ingresos mensuales no superen el total
     */
    $('body').on('input propertychange', ".ingresoData", function(){
        checkIngresos();
    })

    /**
     * @method metodo para validar que la suma de presupuestos mensuales no superen el total
     */
    $('body').on('input propertychange', ".presupuestoData", function(){
        checkPresupuestos()
    })


    function checkIngresos()
    {
        let ingresosTotales = changeNumToNormal( $('.ingresosIpt').val() )
        /* lectura de todos los valores en la tabla */
        let suma = 0
        $('.ingresoData').each(function(key, value){
            suma += changeNumToNormal( $(value).val() );
        })
        suma = suma.toFixed(2);
        if ( suma > ingresosTotales ) {
            Swal.fire({
                position: 'center',
                text: `Ingreso excedido por € ${ formatNumberEU(suma - ingresosTotales) }`,
                icon: 'error',
                showConfirmButton: false,
                timer: 2000
            })

            return false;
        }

        return true;
    }

    function checkPresupuestos()
    {
        let ingresosTotales = changeNumToNormal( $('.presupuestoIpt').val() )
        /* lectura de todos los valores en la tabla */
        let suma = 0
        $('.presupuestoData').each(function(key, value){
            suma += changeNumToNormal( $(value).val() );
        })
        suma = suma.toFixed(2);
        if ( suma > ingresosTotales ) {
            Swal.fire({
                position: 'center',
                text: `Presupuesto excedido por € ${ formatNumberEU(suma - ingresosTotales) }`,
                icon: 'error',
                showConfirmButton: false,
                timer: 2000
            })

            return false;
        }

        return true;
    }

    setTimeout(function(){
        $('.dropdown-toggle').click();
        $('.from,.to').change();
    },200);


    $('#formCampaign').on('submit', function(){
        if ( checkPresupuestos() && checkIngresos() ) {
            return true;
        }

        return false;
    })


    /**
     * Lectura de formulario para agregar un mes nuevo
     */
    $('.btnAddNewMonth').on('click', function() {

        let month   = $('.slctNewMonth').val();
        let year    = $('.selectAnios').val();
        if ( month != '' && year != '' ) {
            $('.btnCloseModal').click()
            /* se pinta info tipo form */
            $('.toPrintMonths').append(`
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="text" name="mes[]" class="form-control" value="${ month } ${year}" readonly>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="text" name="ingresosMes[]" class="form-control ingresoData soloNumeros" value="0" placeholder="Ingreso €" required>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <input type="text" name="presupuestosMes[]" class="form-control presupuestoData soloNumeros" value="0" placeholder="Presupuesto €" required>
                        </div>
                    </div>
                </div>
            `);
        }
        return false;
    });

})


/* const amount = 654321.987;

const options1 = { style: 'currency', currency: 'RUB' };
const numberFormat1 = new Intl.NumberFormat('ru-RU', options1);

console.log(numberFormat1.format(amount));
// expected output: "654 321,99 ₽"

const options2 = { style: 'currency', currency: 'USD' };
const numberFormat2 = new Intl.NumberFormat('en-US', options2);

console.log(numberFormat2.format(amount));
// expected output: "$654,321.99" */
