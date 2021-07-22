$(function(){
    $("#uploadFile").on("change", function(){
        $('.success').html( $(this).val() ).fadeIn("slow")
    })

    $('#summernote').summernote({
        height: 200,
        toolbar: [
            //[groupname, [button list]]

            ['style', ['bold', 'italic', 'underline']],
            // ['color', ['color']],
            // ['para', ['ul', 'ol', 'paragraph']],
            // ['view', ['codeview']],
        ]
    });


    /**
    * Metodo para poder enviar la informacion del formulario con ajax de jquery
    */
    $("#docForm").on("submit", function(){
        //-- form data para convertir el formulario en un objeto para ajax
        var form_data 		= new FormData( $('#docForm')[0] );

        // -- Se obtiene  la url a donde se debe dirigir la informacion
        var post_url 		= $(this).attr("action");

        $('.backLoader').css('display', 'flex');

        // envio de informacion a controller
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
            mimeType:"multipart/form-data"
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
