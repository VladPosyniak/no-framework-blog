<h1>{$data.article.title}</h1>
<b>{$data.author.name}</b> <small>({$data.article.created})</small>
<p>
    {$data.article.text}
</p>

<a href="/delete-article?id={$data.article.id}" class="btn btn-danger">Delete article</a>