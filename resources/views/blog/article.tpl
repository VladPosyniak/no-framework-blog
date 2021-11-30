<h1>{$data.title}</h1>
<b>{$data.authorID}</b> <small>({$data.created})</small>
<p>
    {$data.text}
</p>

<a href="/delete-article?id={$data.id}" class="btn btn-danger">Delete article</a>