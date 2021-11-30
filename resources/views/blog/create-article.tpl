<form action="/create-article" id="article-form" method="post">
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Title</label>
        <input type="text" name="title" class="form-control" id="exampleFormControlInput1" required>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Text</label>
        <textarea id="editor" name="text" class="form-control" rows="10"></textarea>
    </div>
    <input type="submit" id="submit-article-form" value="Save" class="btn btn-success">
</form>


<script src="https://cdn.tiny.cloud/1/1lxk2v13yyc7q0h6xwv396etn6l7h3jxyud40d8rbiudoczn/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>



<script>
    tinymce.init({
        selector: '#editor',
        setup: function(ed) {
            ed.on('submit', function(e) { ed.save(); });
        },
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak'
    });

</script>
