
//window.addEventListener("load", function(){
$(document).ready(function(){
    /**
     * TEST BUSCADOR
     */

        $(".search-input").on('keyup', function(){
            var _q = $(this).val();
            //console.log(_q); //recoje bien el valor
            var valor = $(".search-input").val();
            //console.log('VALOR: '+valor);

            if(valor.length == 0){
                $(".search-result").empty();
            }

            if(_q.length >= 1){
                $.ajax({
                    url:"http://127.0.0.1:8000/search", //CAMBIAR ESTO POR ALGO MAS ESCALABLE
                    //GET http://127.0.0.1:8000/%7B%7B%20url('search')%20%7D%7D?q=sss 404 (Not Found)
                    data: {//para añadir parametros a la url y que viaje en Request?
                        q: _q
                    },
                    dataType: 'json',
                    beforeSend: function(){//esta parte funciona
                        //esto mostrara una animacion mientras el resultado no es mostrado
                        $(".search-result").html('<li>Loading...</li>');
                    },
                    success: function(res){//entra aqui
                        //console.log(res);
                        //console.log(res.data);
                        //MOSTRAR EL RESULTADO
                        var _html = '';
                        $.each(res.data, function(index, data){
                            _html += '<li style="list-style: none;">'+data.titulo+'</li>';
                        });
                        $(".search-result").html(_html);
                
                        if(res.data.length === 0){
                            _html += '<li style="list-style: none;">No hay resultados</li>';
                            $(".search-result").html(_html);
                        }
                    },
                    error: function(jqXHR, status, error){
                        $(".search-result").html('<li>Ha habido un error en la búsqueda...</li>');
                    }
                });

            }
        });

    console.log( "ready!" );



    //TEST FILTROS
    function filterResults () {
        let subcategoriaIds = getIds("subcategoria");//llama a la funcion getIds y le pasa el name 'brand' del form?
        let idiomaIds = getIds("idioma");
        let precioIds = getIds("precio");
        let ordenaIds = getIds("ordena");
        let href;

        if(subcategoriaIds.length || idiomaIds.length || precioIds.length || ordenaIds.length){
            href = 'recursos?';//cambiar por recursos (define una parte de la url)
        }
        
        if(!subcategoriaIds.length && !idiomaIds.length && !precioIds.length && !ordenaIds.length){
            href = 'recursos'; 
        }

        if(subcategoriaIds.length) {
            if(href.slice(-1) == '?'){
                href += 'categoria=' + subcategoriaIds[0];
            }else{
                href += '&categoria=' + subcategoriaIds[0];
            }
        }
        if(subcategoriaIds.length > 1){
            //recorrer el array desde [1]
            for (var i=1; i<subcategoriaIds.length; i++){
                href += ',' + subcategoriaIds[i];
            }
        }

        if(idiomaIds.length) {
            if(href.slice(-1) == '?'){
                href += 'idioma=' + idiomaIds[0];
            }else{
                href += '&idioma=' + idiomaIds[0];
            }
        }

        if(idiomaIds.length > 1){
            //recorrer el array desde [1]
            for (var i=1; i<idiomaIds.length; i++){
                href += ',' + idiomaIds[i];
            }
        }

        if(precioIds.length) {
            if(href.slice(-1) == '?'){
                href += 'precio=' + precioIds[0];
            }else{
                href += '&precio=' + precioIds[0];
            }
        }
        if(precioIds.length > 1){
            //recorrer el array desde [1]
            for (var i=1; i<precioIds.length; i++){
                href += ',' + precioIds[i];
            }
        }

        if(ordenaIds.length) {
            if(href.slice(-1) == '?'){
                href += 'ordena=' + ordenaIds[0];
            }else{
                href += '&ordena=' + ordenaIds[0];
            }
        }
        if(ordenaIds.length > 1){
            //recorrer el array desde [1]
            for (var i=1; i<ordenaIds.length; i++){
                href += ',' + ordenaIds[i];
            }
        }

        //recursos?filter[subcategoria]=musica&filter[subcategoria]=mates
        document.location.href=href;//refreshes the page with the url containing the brand and categories to filter.
    }


    /*
    Recoje todos los checkbox para los nombres de brand y/o categoria
    Entonces los filtra y recoje los valores de los checkbox marcados
    */
    function getIds(checkboxName) {//es el name del form? (subcategoria?) -> "subcategoria"
        //console.log(checkBoxName);
        let checkBoxes = document.getElementsByName(checkboxName);//recoje 'array'(elements) a través del nombre

        //console.log(document.getElementsByName(checkboxName));
        /*
        devuelve una copia de una parte del array dentro de un nuevo array empezando por inicio hasta fin (fin no incluido). 
        El array original no se modificará.
        El método slice puede ser usado para convertir objetos parecidos a arrays o colecciones a un nuevo Array. 
        Simplemente debe enlazar el método al objeto. -> Array.prototype.slice.call(arguments, 0);
        */
        let ids = Array.prototype.slice.call(checkBoxes)
                        .filter(ch => ch.checked==true)//filter() crea un nuevo array con todos los elementos que cumplan la condición implementada por la función dada.
                        .map(ch => ch.value);//map() crea un nuevo array con los resultados de la llamada a la función indicada aplicados a cada uno de sus elementos
        return ids;//retorna los checkbox marcados separados por comas: mates,musica...
    }

    /*
    Evento para cuando se haga click al botón con id filter, llame a la funcion filterResults
    */
    //document.getElementById("filter").addEventListener("click", filterResults);
    var element = document.getElementById("filter");
    if(element)
    {
        element.addEventListener("click",filterResults,false);//3er parametro false porque?
    }









    /**
     * Sección que deselecciona todos los checkboxes marcados en index recursos
     */
    var itemForm = document.getElementById('sidebar-filtros-recursos');// getting the parent container of all the checkbox inputs
    var checkBoxes = itemForm.querySelectorAll('input[type="checkbox"]');// get all the check box

    document.getElementById('deSelectAll').addEventListener('click', deSelectAll); //add a click event to the deSelectAll button

    function deSelectAll() {
        checkBoxes.forEach(item => {
            item.checked = false;
        })
    }



});