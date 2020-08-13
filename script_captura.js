/**
 * Created by Tecnico TI on 05/01/2020.
 */

$(document).ready(function()
{
    var data1_hidden = $("#data1_hidden").val();
    var data2_hidden = $("#data2_hidden").val();

    var str_date1 = data1_hidden.toString().split('-');
    var str_date2 = data2_hidden.toString().split('-');

    var d1 = str_date1[2];  var m1=str_date1[1]; var a1=str_date1[0];
    var d2 = str_date2[2];  var m2=str_date2[1]; var a2=str_date2[0];

    var data1 = m1+'/'+d1.split('\'')[0]+'/'+a1.split('\'')[1];
    var data2 = m2+'/'+d2.split('\'')[0]+'/'+a2.split('\'')[1];

    var today1 = moment(new Date(data1).toUTCString()).format('YYYY-MM-DD');
    var today2 = moment(new Date(data2).toUTCString()).format('YYYY-MM-DD');

    $('#data1').val(today1);
    $('#data2').val(today2);

    $("#button_excel").click(function()
    {
            var captura = $("#captura").val();

            if(captura==1)
            {
                $("#consultar_entrada_form").attr('action','/cpanel/admin/captura/excel_capturas');
                $("#consultar_entrada_form").submit();
            }
            else if(captura==2)
            {
                $("#consultar_entrada_form").attr('action','/cpanel/admin/captura/excel_captura_por_embarcacao');
                $("#consultar_entrada_form").submit();
            }
            else if(captura==3)
            {
                $("#consultar_entrada_form").attr('action','/cpanel/admin/captura/excel_captura_por_especie');
                $("#consultar_entrada_form").submit();
            }
            else
            {
                alert("NOTA: A exportação sera feita em função dos parametros do filtro");
                $("#consultar_entrada_form").attr('action','/cpanel/admin/captura/excel_entradas_total_contas_filtros');
                $("#consultar_entrada_form").submit();
            }
    });

    $(".editar_captura").click(function()
    {
        var string = $(this).attr('captura');
        var json_captura_array = JSON.parse(string);

        $('#data').val(json_captura_array.data);
        $('#embarcacao_id').val(json_captura_array.embarcacao_id);
        $('#especie').val(json_captura_array.especie);
        $('#qtd').val(json_captura_array.qtd);
        $('#hr_inicio').val(json_captura_array.hr_inicio);
        $('#hr_final').val(json_captura_array.hr_final);
        $('#sonda').val(json_captura_array.sonda);
        $('#latitude1').val(json_captura_array.latitude1);
        $('#longitude1').val(json_captura_array.longitude1);
        $('#latitude2').val(json_captura_array.latitude2);
        $('#longitude2').val(json_captura_array.longitude2);
        $('#hidden_id').val(json_captura_array.id);

        $("#btn_modal_nova_entrada").trigger("click");        

    });

    $("#btn_modal_nova_entrada_trigger").click(function()
    {
        $('#hidden_id').val(-1);
        //$("#register_form").clear();
        $("#btn_modal_nova_entrada").trigger("click");  
    });

    $("#register_form").on('submit', function(event){

        event.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        var data = $('#data').val();
        var embarcacao_id = $('#embarcacao_id').val();
        var especie = $('#especie').val();
        var qtd = $('#qtd').val();
        var hr_inicio = $('#hr_inicio').val();
        var hr_final = $('#hr_final').val();
        var sonda = $('#sonda').val();
        var latitude1 = $('#latitude1').val();
        var longitude1 = $('#longitude1').val();
        var latitude2 = $('#latitude2').val();
        var longitude2 = $('#longitude2').val();
        var hidden_id = $('#hidden_id').val();

        //alert(data+" - "+embarcacao_id+" -"+especie+" - "+qtd+" - "+hr_inicio+" - "+hr_final+" - "+sonda+" - "+latitude1+" - "+longitude1+" - "+latitude2+" - "+longitude2);

        if((data !='' && data!=null) && sonda>-1 && qtd>0 && embarcacao_id!=-1 && especie!=-1 && (hr_inicio!=null && hr_inicio!='') && (hr_final!=null && hr_final!='') && (latitude1!='' && latitude1!=null) && (longitude1!='' && longitude1!=null) && (latitude2!='' && latitude2!=null) && (longitude2!='' && longitude2!=null))
        {
            if(hidden_id==-1)
            {
                var url = "/cpanel/admin/captura/gravar";
            }
            else
            {
                var url = "/cpanel/admin/captura/actualizar";
            }
            
            $.ajax({
                url:url,
                method:"POST",
                data: new FormData(this),
                contentType: false,
                cache:false,
                processData: false,
                dataType:"json",
                success:function(data) {

                    if(data.success) {
                        alert(data.success);
                        window.location = '/cpanel/admin/captura/lista?menu=captura';
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
            alert('Todos os campos devem ser preenchidos de acordo ao seu formato, nenhum deve ficar vazio\nA quantidade deve ter valor maior que 0');
        }

    });


    $("#btn_consultar_captura").click(function(event){

        event.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        var embarcacao_filtro = $( "#embarcacao_filtro" ).val();
        var especie_filtro = $('#especie_filtro').val();
        var data1 = $('#data1').val();
        var data2 = $('#data2').val();
        var qtd1 = $('#qtd1').val();
        var qtd2 = $('#qtd2').val();
        var latitude = $('#latitude').val();

        var error = 0;
        var error_message = '';

        var chk_embarcacao = 0;
        $("#chk_embarcacao").each(function()
        {   if(this.checked)
                chk_embarcacao = 1;
            else
                chk_embarcacao = -1;

        });

        var chk_especie = 0;
        $("#chk_especie").each(function()
        {  
            if(this.checked)
                chk_especie = 1;
            else
                chk_especie = -1;

        });

        var chk_data = 0;
        $("#chk_data").each(function()
        {  
            if(this.checked)
                chk_data = 1;
            else
                chk_data = -1;

        });

        var chk_qtd = 0;
        $("#chk_qtd").each(function()
        {  
            if(this.checked)
                chk_qtd = 1;
            else
                chk_qtd = -1;

        });

        var chk_latitude = 0;
        $("#chk_latitude").each(function()
        {  
            if(this.checked)
                chk_latitude = 1;
            else
                chk_latitude = -1;

        });

        var chk_sonda = 0;
        $("#chk_sonda").each(function()
        {  
            if(this.checked)
                chk_sonda = 1;
            else
                chk_sonda = -1;

        });

        if(chk_qtd==1)
        {
            if($.isNumeric($('#qtd1').val()) && $.isNumeric($('#qtd2').val()) && (qtd1>=0 || qtd2>=0))
            {
                if(qtd1>qtd2)
                {
                    error = 1;
                    error_message += '- O valor da segunda quantidade deve ser maior ou igual ao da primeira quantidade.\n';
                }
            }
            else
            {
                error = 1;
                error_message += '- As quatidades têm de ser maior ou igual que zero e devem ser numeros.\n';
            }

        }

        if(chk_sonda==1)
        {
            if($.isNumeric($('#sonda1').val()) && $.isNumeric($('#sonda2').val()) && (sonda1>=0 || sonda2>=0))
            {
                if(sonda1>sonda2)
                {
                    error = 1;
                    error_message += '- O valor da segunda sonda deve ser maior ou igual ao da primeira sonda.\n';
                }
            }
            else
            {
                error = 1;
                error_message += '- Os valores das sondas têm de ser maior ou igual que zero e devem ser numeros.\n';
            }

        }


        if(chk_data==1)
        {
            if(dataValida.test(data1) && dataValida.test(data2))
            {
                if(data1>data2)
                {
                    error = 1;
                    error_message += '- A segunda data deve ser maior ou igual a primeira data.\n';
                }
            }
            else
            {
                error = 1;
                error_message += '- Insira datas corretas nos dois campos de data.\n';
            }

        }


        if(error==0)
        {
            var captura = $("#captura").val();

            if(captura==1)
            {
                $("#consultar_entrada_form").attr('action','/cpanel/admin/captura/consultar?menu=captura');
                $("#consultar_entrada_form").submit();
            }
            else  if(captura==2)
            {
                $("#consultar_entrada_form").attr('action','/cpanel/admin/captura/consultar_por_embarcacao?menu=captura');
                $("#consultar_entrada_form").submit();
            }
            else  if(captura==3)
            {
                $("#consultar_entrada_form").attr('action','/cpanel/admin/captura/consultar_por_especie?menu=captura');
                $("#consultar_entrada_form").submit();
            }


           
        }
        else
        {
            alert(error_message);
        }


    });

    $("#button_excel_anual").click(function()
     {
        var consultar = $(this).attr('consultar');

        $("#consultar_entrada_form").attr('action','/cpanel/admin/captura/total_anual_consulta_excel?menu=captura');
        $("#consultar_entrada_form").submit();     

     });

     $("#btn_consultar_captura_anual").click(function(event)
     {
        $("#consultar_entrada_form").attr('action','/cpanel/admin/captura/total_anual_consulta?menu=captura');
         $("#consultar_entrada_form").submit();

     });


    $("#btn_consultar_captura_por_grupo").click(function(event){

        event.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        var  tipo_pagador = $( "#tipo_pagador_2" ).val();
        var pagador = $('#pagador2').val();
        var deposito1 = new Number($('#deposito1').val());
        var deposito2 = new Number($('#deposito2').val());
        var data1 = $('#data1').val();
        var data2 = $('#data2').val();

        var error = 0;
        var error_message = '';

        var chk_tipo_pagador = 0;
        $("#chk_tipo_pagador").each(function()
        {   if(this.checked)
            chk_tipo_pagador = 1;
        else
            chk_tipo_pagador = -1;

        });

        var chk_pagador = 0;
        $("#chk_pagador").each(function()
        {  if(this.checked)
            chk_pagador = 1;
        else
            chk_pagador = -1;

        });

        var chk_data = 0;
        $("#chk_data").each(function()
        {  if(this.checked)
            chk_data = 1;
        else
            chk_data = -1;

        });

        var chk_deposito = 0;
        $("#chk_deposito").each(function()
        {  if(this.checked)
            chk_deposito = 1;
        else
            chk_deposito = -1;

        });


        if(chk_deposito==1)
        {
            if($.isNumeric($('#deposito1').val()) && $.isNumeric($('#deposito2').val()) && (deposito1>=0 || deposito2>=0))
            {
                if(deposito1>deposito2)
                {
                    error = 1;
                    error_message += '- O valor de deposito da sengunda entrada deve ser maior ou igual ao da primeira entrada.\n';
                }
            }
            else
            {
                error = 1;
                error_message += '- Os valores de deposito têm de ser maior ou igual que zero e devem ser numeros.\n';
            }

        }


        if(chk_data==1)
        {
            if(dataValida.test(data1) && dataValida.test(data2))
            {
                if(data1>data2)
                {
                    error = 1;
                    error_message += '- A segunda data deve ser maior ou igual a primeira data.\n';
                }
            }
            else
            {
                error = 1;
                error_message += '- Insira datas corretas nos dois campos de data.\n';
            }

        }

        if(error==0)
        {
            var captura = $("#captura").val();

            if(captura==1)
            {
                $("#consultar_entrada_form").attr('action','/cpanel/admin/captura/consultar?menu=captura');
            }
            else  if(captura==2)
            {
                $("#consultar_entrada_form").attr('action','/cpanel/admin/captura/total_por_parceiro_consulta?menu=captura');
            }
            else  if(captura==3)
            {
                $("#consultar_entrada_form").attr('action','/cpanel/admin/captura/total_por_banco_consulta?menu=captura');
            }
            else
            {
                $("#consultar_entrada_form").attr('action','/cpanel/admin/captura/total_por_conta_consulta?menu=captura');
            }
            //$("#consultar_entrada_form").attr('action','/cpanel/admin/captura/total_por_parceiro_consulta?menu=captura');

            $("#consultar_entrada_form").submit();
        }
        else
        {
            alert(error_message);
        }

    });


     $("#btn_consultar_captura_anual").click(function(event)
     {
        $("#consultar_entrada_form").attr('action','/cpanel/admin/captura/total_anual_consulta?menu=captura');
         $("#consultar_entrada_form").submit();

     });

     

    //var dataValida = /^(((0[1-9]|[12]\d|3[01])\/(0[13578]|1[02])\/((19|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30)\/(0[13456789]|1[012])\/((19|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/((19|[2-9]\d)\d{2}))|(29\/02\/((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$/g;
    var dataValida = /([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/;

    $('.activar_captura').click(function(){

        var id = $(this).attr('captura_id');

        if(confirm('Tem a certeza que pretende activar este registo?'))
        {

            activar_desactivar(id,1);
        }

    });


    $('.desactivar_captura').click(function(){

        var id = $(this).attr('captura_id');

        if(confirm('Tem a certeza que pretende desactivar este registo?'))
        {
            activar_desactivar(id,0);
        }

    });

    function activar_desactivar(id,estado)
    {

        $.ajax({
            url:"/cpanel/admin/captura/"+id+"/"+estado+"/activar_desactivar",
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

    $('#button_editar').click(function(){

            var captura_array = "0";
            var tipo = $(this).attr('estado');

            $(".check_conjunto_seleccionavel").each(function ()
            {
                var captura_id = $(this).attr("captura_id");

                if (this.checked)
                {
                    captura_array = captura_array + "," + captura_id;

                    $(".td_editavel[captura_id="+captura_id+"]").attr("contenteditable","true");

                }
            });


            if(captura_array == "0")
            {
                alert('seleccione pelo menos uma das linhas com o tick ou check');
                $(this).removeClass("td_bg_info");
                $(this).attr("tipo",0);
                $(".td_editavel").removeAttr("contenteditable");
                $("#button_salvar").addClass("hidden");
            }
            else
            {
                    $(this).addClass("td_bg_info");
                    $(this).attr("tipo",1);
                    $("#button_salvar").removeClass("hidden");
            }

    });


    $('#button_salvar').click(function(){

        var captura_array = "0";
        var string_objects = "[";
        var contador = 0;

        $(".check_conjunto_seleccionavel").each(function ()
        {
            var captura_id = $(this).attr("captura_id");

            if (this.checked)
            {
                captura_array = captura_array + "," + captura_id;

                $(".td_editavel[captura_id="+captura_id+"]").attr("contenteditable","true");

                if(contador==0)
                {
                    string_objects = string_objects + '{"valor_receber":"'+$(".td_valor_receber[captura_id="+captura_id+"]").text()+'",';
                    string_objects = string_objects + '"id":"'+captura_id+'",';
                    string_objects = string_objects + '"deposito":"'+$(".td_deposito[captura_id="+captura_id+"]").text()+'",';
                    string_objects = string_objects + '"data":"'+$(".td_data[captura_id="+captura_id+"]").text()+'"}';
                }
                else
                {
                    string_objects = string_objects + ',{"valor_receber":"'+$(".td_valor_receber[captura_id="+captura_id+"]").text()+'",';
                    string_objects = string_objects + '"id":"'+captura_id+'",';
                    string_objects = string_objects + '"deposito":"'+$(".td_deposito[captura_id="+captura_id+"]").text()+'",';
                    string_objects = string_objects + '"data":"'+$(".td_data[captura_id="+captura_id+"]").text()+'"}';
                }

                contador++;

            }
        });

        string_objects = string_objects + ']';

        if(captura_array == "0")
        {
            alert('seleccione pelo menos uma das linhas com o tick ou check');
        }
        else
        {
            //alert(string_objects);
            salvar_da_tabela(string_objects);
        }

    });


    function salvar_da_tabela(string_objects) {

        $.ajax({
            url: "/cpanel/admin/captura/"+string_objects+"/salvar_da_tabela",
            method: "GET",
            data: {},
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function (data) {

                if (data.success) {
                    alert(data.success);
                    window.location.reload();
                } else
                {
                    alert("Os numeros não devem conter espaços nem virgula, para casas decimais use o ponto\nas datas devem estar no formato 'Ano-Mes-Dia'");
                }

            },
            error: function (xhr, status, error) {

                var errorMessage = xhr.status + ': ' + xhr.statusText
                alert('Error - ' + errorMessage+"\nOs numeros não devem conter espaços nem virgula, para casas decimais use o ponto\nas datas devem estar no formato 'Ano-Mes-Dia'");
            }

        });

    }


    $('.remover_captura').click(function(){

        var id = $(this).attr('captura_id');

        if(confirm('Tem a certeza que pretende remover este registo?'))
        {

            $.ajax({
                url:"/cpanel/admin/captura/"+id+"/remover",
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

            var captura_array = "0";

            $(".check_conjunto_seleccionavel").each(function ()
            {
                var captura_id = $(this).attr("captura_id");

                if (this.checked)
                    captura_array = captura_array + "," + captura_id;

            });

            //alert(captura_array);

            activar_desactivar_conjunto(captura_array,0);

        }


    });


    $('#button_activar').click(function(){

        if(confirm('Tem a certeza que deseja activar os registos seleccionados.'))
        {
            var captura_array = "0";

            $(".check_conjunto_seleccionavel").each(function ()
            {
                var captura_id = $(this).attr("captura_id");

                if (this.checked)
                    captura_array = captura_array + "," + captura_id;

            });

            //alert(captura_array);

            activar_desactivar_conjunto(captura_array,1);

        }

    });


    $('#button_remover').click(function(){

        if(confirm('Tem a certeza que deseja remover os registos seleccionados.'))
        {
            var captura_array = "0";

            $(".check_conjunto_seleccionavel").each(function ()
            {
                var captura_id = $(this).attr("captura_id");

                if (this.checked)
                    captura_array = captura_array + "," + captura_id;

            });

            //alert(captura_array);

            remover_conjunto(captura_array);

        }

    });


    $('.galeria_on').click(function(){

        var galeria_id = $(this).attr('captura_id');

        if(confirm('Tem a certeza que pretende activar este registo na galeria?'))
        {

            galeria_on_off(galeria_id,1);
        }

    });

    $('.galeria_off').click(function(){

        var galeria_id = $(this).attr('captura_id');

        if(confirm('Tem a certeza que pretende desactivar este registo na galeria?'))
        {
            galeria_on_off(galeria_id,0);
        }

    });

    $('#button_galeria_on').click(function(){

        if(confirm('Tem a certeza que deseja colocar na galeria os registos seleccionados.'))
        {
            var captura_array = "0";

            $(".check_conjunto_seleccionavel").each(function ()
            {
                var captura_id = $(this).attr("captura_id");

                if (this.checked)
                    captura_array = captura_array + "," + captura_id;

            });

            //alert(captura_array);

            galeria_on_off_conjunto(captura_array,1);

        }

    });


    $('#button_galeria_off').click(function(){

        if(confirm('Tem a certeza que deseja remover da galeria os registos seleccionados.'))
        {
            var captura_array = "0";

            $(".check_conjunto_seleccionavel").each(function ()
            {
                var captura_id = $(this).attr("captura_id");

                if (this.checked)
                    captura_array = captura_array + "," + captura_id;

            });

            //alert(captura_array);

            galeria_on_off_conjunto(captura_array,0);

        }

    });



    function galeria_on_off(galeria_id,estado)
    {

        $.ajax({
            url:"/cpanel/admin/captura/"+galeria_id+"/"+estado+"/galeria_on_off",
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
            url:"/cpanel/admin/captura/"+array_id+"/"+estado+"/galeria_on_off_conjunto",
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
            url:"/cpanel/admin/captura/"+array_id+"/"+estado+"/activar_desactivar_conjunto",
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
            url:"/cpanel/admin/captura/"+array_id+"/remover_conjunto",
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
