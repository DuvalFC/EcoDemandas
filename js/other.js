window.onscroll = ()=>{
	if(document.body.scrollTop > 50 || document.documentElement.scrollTop > 50){
		//console.log('abajo');
		cargarPost(4);

	}else{
		//console.log('arriba');
	}
}
let offset=0;
let nodeContent = document.getElementById('publi');
function cargarPost(num){
	let urlApi = `http://localhost/EcoDemandas/api.php?offset=${offset}&limit=${num}`;
	axios({
		method:'get',
		url: urlApi,
		responseType:'json'
	})
	.then((response) =>	{
		console.log(response);
		let vTotal = response.data.publicacion.length;
		for(let i=0; i< vTotal; i++){
			offset++;
			let item = response.data.publicacion[i];
			let html = `
            <div class="publicacion">
            <div class="imgPerfil">
                <img src="img/contenedor/perfil/${item.perfil}">
            </div>
            <div class="info">
            <a href="index.php?op=4&id=${item.id}"><h2>${item.titulo}</h2></a>
                <p>
                    Publicado el <b>${item.fecha_publicacion}</b> Por <b>${item.usuario}</b>
                </p>
            </div>

            <ul class="icon">
                <li>
                    <ion-icon name="share-social-outline"></ion-icon>
                </li>
                <li>
                    <ion-icon name="cloud-download-outline"></ion-icon>
                </li>
                <li>
                    <ion-icon name="eye-outline"></ion-icon>
                </li>
                <li>
                    <ion-icon name="flag-outline"></ion-icon>
                    </ion-icon>
                </li>
                <li>
                    <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                </li>
            </ul>
        </div>`;
			nodeContent.innerHTML += html	
		}    
	})
	.catch((error)=> console.log(error));
}

cargarPost(20);


