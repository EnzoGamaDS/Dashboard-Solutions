<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container py-5">
        <div class="mb-4 text-center">
            <h3 class="fw-bold">Últimas Notícias - G1</h3>
        </div>

        <div class="mb-4">
            <label for="category" class="form-label fw-semibold">Filtrar por categoria:</label>
            <select id="category" class="form-select w-auto">
                <option value="g1">Todas</option>
                <option value="economia">Economia</option>
                <option value="tecnologia">Tecnologia</option>
                <option value="politica">Política</option>
                <option value="mundo">Mundo</option>
                <option value="educacao">Educação</option>
                <option value="ciencia">Ciência</option>
                <option value="saude">Saúde</option>
            </select>
        </div>

        <div id="news-container" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4"></div>
        <div id="loading" class="text-center text-muted">Carregando notícias...</div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const categorySelect = document.getElementById('category');

            function loadNews(category = 'g1') {
                const url = `https://api.rss2json.com/v1/api.json?rss_url=https://g1.globo.com/rss/${category}/`;
                const newsContainer = document.getElementById('news-container');
                const loading = document.getElementById('loading');

                newsContainer.innerHTML = '';
                loading.style.display = 'block';

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        loading.style.display = 'none';

                        if (data.items && data.items.length > 0) {
                            data.items.slice(0, 9).forEach(article => {
                                const card = `
                                    <div class="col">
                                        <div class="card h-100 border-0 shadow rounded">
                                            ${article.thumbnail ? `<img src="${article.thumbnail}" class="card-img-top rounded-top" alt="Imagem da notícia">` : ''}
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title fw-bold">${article.title}</h5>
                                                <p class="card-text">${article.description.substring(0, 120)}...</p>
                                                <a href="${article.link}" target="_blank" class="btn btn-outline-primary mt-auto">Ler mais</a>
                                            </div>
                                            <div class="card-footer text-muted small">
                                                Publicado em: ${new Date(article.pubDate).toLocaleDateString('pt-BR')} às ${new Date(article.pubDate).toLocaleTimeString('pt-BR')}
                                            </div>
                                        </div>
                                    </div>
                                `;
                                newsContainer.insertAdjacentHTML('beforeend', card);
                            });
                        } else {
                            newsContainer.innerHTML = `<p class="text-center text-muted">Nenhuma notícia encontrada.</p>`;
                        }
                    })
                    .catch(error => {
                        loading.textContent = 'Erro ao carregar notícias.';
                        console.error('Erro:', error);
                    });
            }

            // Carregar notícias iniciais
            loadNews();

            // Recarregar ao mudar categoria
            categorySelect.addEventListener('change', () => {
                loadNews(categorySelect.value);
            });
        });
    </script>
</x-app-layout>