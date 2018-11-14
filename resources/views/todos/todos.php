<div class="col">
    <h1 class="text-center mt-4 mb-4">Задачи <a href="/todos/add" class="btn btn-link">Добавить</a> </h1>

    <?php if (count($todos)): ?>
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>Пользователь</th>
                <th>Title</th>
                <th>Text</th>
                <th>Изображение</th>
                <th class="text-right" style="width: 10px;">Статус</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($todos as $todo): ?>

                <tr>
                    <td><?= htmlentities($todo['username']) ?></td>
                    <td><?= htmlentities($todo['title']) ?></td>
                    <td><textarea rows="6" class="form-control" readonly><?= htmlentities($todo['text']) ?></textarea></td>
                    <td><img src="<?= $todo['image'] ?>" width="320px" /></td>
                    <td class="text-rigth">
                        <input
                                type="checkbox"
                                class="form-controler"
                                <?= ($todo['complete']) ? 'checked':'' ?>
                                <?= $admin ? '':'disabled' ?>
                                data-todo-id="<?= $todo['id'] ?>"

                        />
                    </td>
                </tr>

            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if ($todosCount > count($todos)): ?>
        <div class="btn-group" role="group" aria-label="">

            <a href="/todos?page=<?= $page - 1 ?>" class="btn btn-default" style="<?= !($page - 1) ? 'pointer-events: none; color: grey;' : '' ?>">Prev</a>
            <a href="/todos?page=<?= $page + 1 ?>" class="btn btn-default" style="<?= ($page + 1 > $pages + 1) ? 'pointer-events: none; color: grey;' : '' ?>">Next</a>

        </div>
    <?php endif; ?>
</div>

<script>
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('click', changeStatus);
    }

    function changeStatus(e) {
        const id = +e.target.getAttribute('data-todo-id');
        const complete = +e.target.checked;

        const xhr = new XMLHttpRequest();
        xhr.open('PUT', '/todos/change/' + id, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send('complete=' + complete);
    }
</script>
