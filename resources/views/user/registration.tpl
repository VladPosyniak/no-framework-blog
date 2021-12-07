<form action="/registration" id="article-form" method="post">
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="exampleFormControlInput1" required>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Name</label>
        <input type="text" max="16" name="name" class="form-control" id="exampleFormControlInput1" required>
    </div>
    <input type="submit" id="submit-article-form" value="Registration" class="btn btn-success">
</form>