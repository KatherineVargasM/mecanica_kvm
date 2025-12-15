$().ready(
  ()=>{
    carga_noticias()
  }
);
 
var carga_noticias = ()=>{
  var html='';
  $.get('https://newsapi.org/v2/everything?q=tesla&from=2025-11-08&sortBy=publishedAt&apiKey=21e19a04b593482ab81e194f16142f97%27,
    (lista_noticias) => { 
      $.each(lista_noticias.articles, (index, noticia)=>{
          html+=`
        <tr>
                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                    <strong>${noticia.title}</strong>
                    </td>
                    <td>${noticia.author}</td>
                    <td>
                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Lilian Fuller">
                                <img src="${noticia.urlToImage}" alt="Avatar" class="rounded-circle" />
                            </li>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                                <p>${noticia.description}</p>
                            </li>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Christina Parker">
                                <a href="${noticia.url}" target="_blank">Seguir mirando</a>
                            </li>
                        </ul>
                    </td>
                </tr>`;
      });
            $('#Contenido_Noticias').html(html);
     })

}