$(document).ready(function () {
        $('#submitButton').click(function () {
                    $('#form').ajaxForm({
                        url: 'CargarArchivos.php',
                        beforeSubmit: function () {
                                  $("#salidaImagen").hide();
                                                                    
                            $("#progressDivId").css("display", "block");
                            var percentValue = '0%';
    
                            $('#progressBar').width(percentValue);
                            $('#percent').html(percentValue);
                        },
                        uploadProgress: function (event, position, total, percentComplete) {
    
                            var percentValue = percentComplete + '%';
                            $("#progressBar").animate({
                                width: '' + percentValue + ''
                            }, {
                                duration: 5000,
                                easing: "linear",
                                step: function (x) {
                            percentText = Math.round(x * 100 / percentComplete);
                                    $("#percent").text(percentText + "%");
                            if(percentText == "100") {
                                       $("#salidaImagen").show();
                            }
                                }
                            });
                        },
                        error: function (response, status, e) {
                            alert('Oops something went.');
                        },
                        
                        complete: function (xhr) {
                            if (xhr.responseText && xhr.responseText != "error")
                            {
                                      $("#salidaImagen").html(xhr.responseText);
                            }
                            else{  
                                       $("#salidaImagen").show();
                                        $("#salidaImagen").html("<div class='error'>Problema al cargar el archivo.</div>");
                                        $("#progressBar").stop();
                            }
                        }
                    });
        });
    });