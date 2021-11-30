<br>
{foreach from=$data.articles item=article}
    <div class="card">
        <div class="card-header">
            Author
        </div>
        <div class="card-body">
            <h5 class="card-title">{$article.title}</h5>
            <p class="card-text">{$article.text}</p>
            <a href="/article?id={$article.id}" class="btn btn-primary">Go to article</a>
        </div>
    </div>
    <br>
{/foreach}