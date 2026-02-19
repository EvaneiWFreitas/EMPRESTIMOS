const formulario_ajax = document.querySelectorAll(".FormularioAjax");
function enviar_formulario_ajax(e){
    e.preventDefault();

    let data = new FormData(this);
    let method = this.getAttribute("method");
    let action = this.getAttribute("action");
    let tipo = this.getAttribute("data-form");

    let encabezados = new Headers();

    let config = {
        method: method,
        headers: encabezados,
        mode: 'cors',
        cache: 'no-cache',
        body: data
    }

    let texto_alerta;

    if (tipo==="save"){
        texto_alerta = "Os dados serão salvos no sistema.";
    }else if(tipo==="delete"){
        texto_alerta = "Os dados serão excluidos completamente do sistema.";
    }else if(tipo==="update"){
        texto_alerta = "Os dados do sistema serão atualizados.";
    }else if(tipo==="search"){
        texto_alerta = "Buscar nome cadastrado no sistema.";
    }else if(tipo==="emprestimos"){
        texto_alerta = "Deseja remover os dados selecionados para emprestimos ou reservas.";
    }else{
        texto_alerta = "Quer realizar as operações solicitadas.";
    }

    Swal.fire({
        title: 'Você tem certeza que deseja salvar estes dados?',
        text:  texto_alerta ,
        type:  'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceitar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            fetch(action, config)
                .then(resposta=> resposta.json())
                .then(resposta => {
                    return alertas_ajax(resposta);
                });
        }
    });

}
formulario_ajax.forEach(formularios=>{
    formularios.addEventListener("submit", enviar_formulario_ajax);
});
function alertas_ajax(alerta){
    if (alerta.Alerta==="simple"){
        Swal.fire({
            title: alerta.Titulo,
            text:  alerta.Texto,
            type:  alerta.Tipo,
            confirmButtonText: 'Aceitar'
        });
    }else if(alerta.Alerta==="recarregar"){
        Swal.fire({
            title: alerta.Titulo,
            text:  alerta.Texto,
            type:  alerta.Tipo,
            confirmButtonText: 'Aceitar'
        }).then((result) => {
            if (result.value) {
                location.reload();
            }
        });
    }else if(alerta.Alerta==="limpar"){
        Swal.fire({
            title: alerta.Titulo,
            text:  alerta.Texto,
            type:  alerta.Tipo,
            confirmButtonText: 'Aceitar'
        }).then((result) => {
            if (result.value) {
                document.querySelector(".FormularioAjax").reset();
            }
        });
    }else if(alerta.Alerta==="redirecionar"){
        window.location.href=alerta.URL;
    }

}