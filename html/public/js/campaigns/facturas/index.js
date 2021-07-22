$(function(){
    $('.selectpicker').selectpicker();

    $( "#datepicker" ).datepicker({
        "dateFormat": "yy-mm-dd"
    });

    $("#uploadFile").on("change", function(){
        $('.selectFile').css({"margin-bottom": "10px"})
        $('.success').html( $(this).val() ).fadeIn("slow")
    })

    setTimeout(function(){
        $('.dropdown-toggle').click();
    },200);

    $("body").on('input propertychange', '.soloNumeros', function(){
        var RegExPattern = /^\d+$/;
        $(this).val($(this).val().replace(/[[a-zA-Z\u00D1\u00F1\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC@ ]/gi, ""));
    });


    /*
        Hacemos una ajax para cuando un usuario selecciona un mes y
        Buscamos la informacion de los gastos asociados a ese mes
     */
    /* $('.selectMes').on('change', function(){

        if ( $(this).val() != "" ) {
            $('.tbody').html('');

            let mes = $(this).val();

            $.post( `${ url }/getGastos`, {'mes' : mes, "_token" : csrf}, function(resp) {
                if ( resp.length > 0 ) {
                    // Se hace pintado de informacion dentro de la tabla
                    $.each(resp, function(key, item) {
                        if ( item.status == 1 || gastos_asociados.includes( item.id ) ) {
                            let html = `<tr align="center">
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type='checkbox' name='gastos[]' value="${ item.id }" id='gasto${ item.id }' ${ (gastos_asociados.includes( item.id )) ? 'checked' : '' }  class="custom-control-input" />
                                                    <label class="custom-control-label" for="gasto${ item.id }">Op.</label>
                                                </div>
                                            </td>
                                            <td>${ item.talent.name }</td>
                                            <td>${ item.dealer.business_name }</td>
                                            <td>${ item.influencer.name }</td>
                                            <td>${ item.concepto }</td>
                                            <td>${ item.comentarios }</td>
                                            <td>${ changeNumToEU(item.gasto) }</td>
                                        </tr>`
                            $('.tbody').append(html);
                        }
                    })

                    console.log(resp);
                } else {
                    let html = `<tr align="center">
                                        <td colspan='10'>
                                            <h3>Sin información que mostrar</h3>
                                        </td>
                                    </tr>`
                        $('.tbody').append(html);
                }
            }, 'json')
        }
    }) */

    /**
    * Metodo para poder enviar la informacion del formulario con ajax de jquery
    */
    $("#docForm").on("submit", function(){
        //-- form data para convertir el formulario en un objeto para ajax
        var form_data 		= new FormData( $('#docForm')[0] );

        // -- Se obtiene  la url a donde se debe dirigir la informacion
        var post_url 		= $(this).attr("action");

        /*
            Se hace la lectura para poder revisar que la factura en importe bruto y
            los gastos seleccionados  coincidan
        */
        var sumaGastosAsociados = 0;
        let importeBruto        = parseFloat( changeNumToNormal( $('.importe_bruto').val() ) );

        $('.checkboxGastos').each(function(key, gasto){
            if ( $(gasto).is(':checked') ) {
                sumaGastosAsociados += parseFloat( $(gasto).data('gasto') );
            }
        });

        /* Se hace comparación de gastos para que si los hay, se manda mensaje de error */
        if ( importeBruto != sumaGastosAsociados ) {

            Swal.fire({
                icon: 'error',
                title: 'Los montos no coinciden',
                html: `<p>Importe Bruto: ${ formatNumberEU(importeBruto) }</p>
                        <p>Gastos seleccionados: ${ formatNumberEU(sumaGastosAsociados) }</p>`,
            })

            return false;
        }


        $('.backLoader').css('display', 'flex');

        // envio de informacion a controller si el importe bruto y los gastos coinciden
        $.ajax({
            url : post_url,
            type: "POST",
            data : form_data,
            contentType: false,
            cache: false,
            processData:false,
            dataType: "json",
            xhr: function(){
                //upload Progress
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', function(event) {
                        var percent 	= 0;
                        var position 	= event.loaded || event.position;
                        var total 		= event.total;

                        if (event.lengthComputable) {
                            percent = position / total * 100;
                            percent = percent.toFixed(1);
                        }

                        if (percent == "100.0") {
                            percent = "100";
                        }

                        $('.percentage').html(`${ percent } %`);

                    }, true);
                }
                return xhr;
            },
            mimeType:"multipart/form-data",
            error : function(XMLHttpRequest, textStatus, errorThrown){
                let html = "";
                for(let e in XMLHttpRequest.responseJSON.errors){
                    if(XMLHttpRequest.responseJSON.errors.hasOwnProperty(e)){
                        XMLHttpRequest.responseJSON.errors[e].map(function(error){
                            html += `<p>${error}</p>`
                        })
                    }
                }
                $('.backLoader').fadeOut('slow');
                Swal.fire({
                    icon: 'error',
                    title: 'Error al procesar',
                    html
                })
            }
        }).done(function(resp){ //

            $('.backLoader').fadeOut('slow');

            if (resp.status == "success") {

                Swal.fire({
                    position: 'center-center',
                    text: `${ resp.message }`,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000
                })

                setTimeout(() => {
                    window.location = `${ url }`
                }, 2000);

                console.log("upload finalizado =o)");
            } else {
                Swal.fire({
                    position: 'center-center',
                    text: `${ resp.message }`,
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        });

        return false;
    })
})
