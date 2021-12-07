<br>
{foreach from=$data.articles item=article}
    <div class="card">
        <div class="card-header">
            By {$article.authorName}
        </div>
        <div class="card-body">
            <h5 class="card-title">{$article.title}</h5>
            <div class="card-text">
                <p class="card-text">{$article.text}</p>
            </div>
            <br>
            <a href="/article?id={$article.id}" class="btn btn-primary">Go to article</a>
        </div>
    </div>
    <br>
{/foreach}