
$(document).ready(function() {

    $("#register_form").on('submit', function(event){

        event.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });


        var hidden_id = $('#hidden_id').val();

        var titulo = $('#nome').val();
        var descricao = $('#descricao_curta').val();

        if(titulo.length>=4 && descricao.length>=10 )
        {
            if(hidden_id==-1)
            {
                $.ajax({
                    url:"/continente/gravar",
                    method:"POST",
                    data: new FormData(this),
                    contentType: false,
                    cache:false,
                    processData: false,
                    dataType:"json",
                    success:function(data) {

                        if(data.success) {
                            alert(data.success);
                            window.location = '/cpanel/admin/continente/lista?menu=continente';
                        }
                        else
                            alert(data.errors);

                    },
                    error: function(xhr, status, error){

                        var errorMessage = xhr.status + ': ' + xhr.statusText
                        alert('Error - ' + errorMessage);
                    }

                });

            }
            else
            {

                $.ajax({
                    url:"/continente/"+hidden_id+"/atualizar",
                    method:"POST",
                    data: new FormData(this),
                    contentType: false,
                    cache:false,
                    processData: false,
                    dataType:"json",
                    success:function(data) {

                        if(data.success) {
                            alert(data.success);
                            window.location = '/cpanel/admin/continente/lista?menu=continente';
                        }
                        else
                            alert(data.errors);
                    },
                    error: function(xhr, status, error){

                        var errorMessage = xhr.status + ': ' + xhr.statusText
                        alert('Error - ' + errorMessage);
                    }

                });
            }
        }
        else
        {
            alert('O nome deve ter mais de 4 caracteres e a descrição curta mais de 15');
        }

    });


    $('.activar_continente').click(function(){

        var id = $(this).attr('continente_id');

        if(confirm('Tem a certeza que pretende activar este registo?'))
        {

            activar_desactivar(id,1);
        }

    });


    $('.desactivar_continente').click(function(){

        var id = $(this).attr('continente_id');

        if(confirm('Tem a certeza que pretende desactivar este registo?'))
        {
            activar_desactivar(id,0);
        }

    });

    function activar_desactivar(id,estado)
    {

        $.ajax({
            url:"/continente/"+id+"/"+estado+"/activar_desactivar",
            method:"GET",
            data: {},
            contentType: false,
            cache:false,
            processData: false,
            dataType:"json",
            success:function(data) {

                if(data.success) {
                    alert(data.success);
                    window.location.reload();
                }
                else
                    alert(data.errors);
            },
            error: function(xhr, status, error){

                var errorMessage = xhr.status + ': ' + xhr.statusText
                alert('Error - ' + errorMessage);
            }

        });

    }


    $('.remover_continente').click(function(){

        var id = $(this).attr('continente_id');

        if(confirm('Tem a certeza que pretende remover este registo?'))
        {

            $.ajax({
                url:"/continente/"+id+"/remover",
                method:"GET",
                data: {},
                contentType: false,
                cache:false,
                processData: false,
                dataType:"json",
                success:function(data) {

                    if(data.success) {
                        alert(data.success);
                        window.location.reload();
                    }
                    else
                        alert(data.errors);
                },
                error: function(xhr, status, error){

                    var errorMessage = xhr.status + ': ' + xhr.statusText
                    alert('Error - ' + errorMessage);
                }

            });

        }

    });


    $('#button_desactivar').click(function(){


        if(confirm('Tem a certeza que deseja desactivar os registos seleccionados.'))
        {

            var continente_array = "0";

            $(".check_conjunto_seleccionavel").each(function ()
            {
                var continente_id = $(this).attr("continente_id");

                if (this.checked)
                    continente_array = continente_array + "," + continente_id;

            });

            //alert(continente_array);

            activar_desactivar_conjunto(continente_array,0);

        }


    });


    $('#button_activar').click(function(){

        if(confirm('Tem a certeza que deseja activar os registos seleccionados.'))
        {
            var continente_array = "0";

            $(".check_conjunto_seleccionavel").each(function ()
            {
                var continente_id = $(this).attr("continente_id");

                if (this.checked)
                    continente_array = continente_array + "," + continente_id;

            });

            //alert(continente_array);

            activar_desactivar_conjunto(continente_array,1);

        }

    });


    $('#button_remover').click(function(){

        if(confirm('Tem a certeza que deseja remover os registos seleccionados.'))
        {
            var continente_array = "0";

            $(".check_conjunto_seleccionavel").each(function ()
            {
                var continente_id = $(this).attr("continente_id");

                if (this.checked)
                    continente_array = continente_array + "," + continente_id;

            });

            //alert(continente_array);

            remover_conjunto(continente_array);

        }

    });


    $('.galeria_on').click(function(){

        var galeria_id = $(this).attr('continente_id');

        if(confirm('Tem a certeza que pretende activar este registo na galeria?'))
        {

            galeria_on_off(galeria_id,1);
        }

    });

    $('.galeria_off').click(function(){

        var galeria_id = $(this).attr('continente_id');

        if(confirm('Tem a certeza que pretende desactivar este registo na galeria?'))
        {
            galeria_on_off(galeria_id,0);
        }

    });

    $('#button_galeria_on').click(function(){

        if(confirm('Tem a certeza que deseja colocar na galeria os registos seleccionados.'))
        {
            var continente_array = "0";

            $(".check_conjunto_seleccionavel").each(function ()
            {
                var continente_id = $(this).attr("continente_id");

                if (this.checked)
                    continente_array = continente_array + "," + continente_id;

            });

            //alert(continente_array);

            galeria_on_off_conjunto(continente_array,1);

        }

    });


    $('#button_galeria_off').click(function(){

        if(confirm('Tem a certeza que deseja remover da galeria os registos seleccionados.'))
        {
            var continente_array = "0";

            $(".check_conjunto_seleccionavel").each(function ()
            {
                var continente_id = $(this).attr("continente_id");

                if (this.checked)
                    continente_array = continente_array + "," + continente_id;

            });

            //alert(continente_array);

            galeria_on_off_conjunto(continente_array,0);

        }

    });



    function galeria_on_off(galeria_id,estado)
    {

        $.ajax({
            url:"/continente/"+galeria_id+"/"+estado+"/galeria_on_off",
            method:"GET",
            data: {array_id:galeria_id},
            contentType: false,
            cache:false,
            processData: false,
            dataType:"json",
            success:function(data) {

                if(data.success) {
                    alert(data.success);
                    window.location.reload();
                }
                else
                    alert(data.errors);
            },
            error: function(xhr, status, error){

                var errorMessage = xhr.status + ': ' + xhr.statusText
                alert('Error - ' + errorMessage);
            }

        });

    }

    function galeria_on_off_conjunto(array_id,estado)
    {

        $.ajax({
            url:"/continente/"+array_id+"/"+estado+"/galeria_on_off_conjunto",
            method:"GET",
            data: {array_id:array_id},
            contentType: false,
            cache:false,
            processData: false,
            dataType:"json",
            success:function(data) {

                if(data.success) {
                    alert(data.success);
                    window.location.reload();
                }
                else
                    alert(data.errors);
            },
            error: function(xhr, status, error){

                var errorMessage = xhr.status + ': ' + xhr.statusText
                alert('Error - ' + errorMessage);
            }

        });

    }


    function activar_desactivar_conjunto(array_id,estado)
    {

        $.ajax({
            url:"/continente/"+array_id+"/"+estado+"/activar_desactivar_conjunto",
            method:"GET",
            data: {array_id:array_id},
            contentType: false,
            cache:false,
            processData: false,
            dataType:"json",
            success:function(data) {

                if(data.success) {
                    alert(data.success);
                    window.location.reload();
                }
                else
                    alert(data.errors);
            },
            error: function(xhr, status, error){

                var errorMessage = xhr.status + ': ' + xhr.statusText
                alert('Error - ' + errorMessage);
            }

        });

    }


    function remover_conjunto(array_id)
    {

        $.ajax({
            url:"/continente/"+array_id+"/remover_conjunto",
            method:"GET",
            data: {array_id:array_id},
            contentType: false,
            cache:false,
            processData: false,
            dataType:"json",
            success:function(data) {

                if(data.success) {
                    alert(data.success);
                    window.location.reload();
                }
                else
                    alert(data.errors);
            },
            error: function(xhr, status, error){

                var errorMessage = xhr.status + ': ' + xhr.statusText
                alert('Error - ' + errorMessage);
            }

        });

    }




});