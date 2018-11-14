<div class="col">
    <h1 class="text-center mt-4 mb-4">Добавление задачи</h1>

    <form method="POST" action="/todos/add" enctype="multipart/form-data">
        <div class="form-group">
            <label>Имя</label>
            <input type="text" class="form-control" name="name" placeholder="Имя">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Электронная почта</label>
            <input type="email" class="form-control" name="email" placeholder="Электронная почта">
            <small id="emailHelp" class="form-text text-muted">Данные только для внутреннего пользования</small>
        </div>

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" placeholder="Title">
        </div>

        <div class="form-group">
            <label>Текст</label>
            <textarea name="text" class="form-control" placeholder="Текст задачи"></textarea>
        </div>

        <div class="form-group">
            <label>Картинка</label>
            <input type="file" class="form-control" name="image" accept="image/gif, image/jpg, image/png">
        </div>

        <button type="submit" class="btn btn-primary">Добавить</button>
    </form>
</div>

