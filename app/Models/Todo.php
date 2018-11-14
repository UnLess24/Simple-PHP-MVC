<?php

namespace App\Models;


use App\Kernel\MyPDO;
use App\Kernel\Request;

class Todo
{
    private $pdo;

    /**
     * Post constructor.
     */
    public function __construct()
    {
        $this->pdo = new MyPDO();
    }

    public function getTodos()
    {
        $todos = $this->pdo->prepare('SELECT * FROM todos');
        $todos->execute();
        $todos->setFetchMode(\PDO::FETCH_ASSOC);
        return $todos->fetchAll();
    }

    public function getPageTodos(int $limit, int $offset)
    {
        $todos = $this->pdo->prepare('SELECT * FROM todos LIMIT ?,?');
        $todos->bindParam(1, $offset, \PDO::PARAM_INT);
        $todos->bindParam(2, $limit, \PDO::PARAM_INT);
        $todos->execute();
        $todos->setFetchMode(\PDO::FETCH_ASSOC);
        $result['todos'] = $todos->fetchAll();

        $todosCount = $this->pdo->prepare('SELECT count(*) FROM todos');
        $todosCount->execute();
        $result['todosCount'] = (int) $todosCount->fetch()[0];
        return $result;
    }

    public function createTodo(Request $request)
    {
        $todoData = [
            ':username' => $request->name,
            ':email' => $request->email,
            ':title' => $request->title,
            ':text' => $request->text,
            ':image' => null
        ];

        if ($_FILES['image']['name']) {
            list($uploadedName, $uploadedExt) = explode('.', $_FILES['image']['name']);
            $fileName = md5(time() . $uploadedName);
            $hashName = implode('.', [$fileName, $uploadedExt]);
            $uploadedFile = images_path() . $hashName;
            move_uploaded_file($_FILES['image']['tmp_name'], get_include_path() . $uploadedFile);
            $todoData[':image'] = $uploadedFile;
        }

        $todo = $this->pdo->prepare('INSERT INTO todos (username, email, title, text, image) VALUES (:username, :email, :title, :text, :image)');
        $todo->execute($todoData);
        return $this->getOneTodo((int) $this->pdo->lastInsertId());
    }

    public function changeTodo(int $id, Request $request)
    {
        $todo = $this->pdo->prepare('UPDATE todos SET complete = :complete WHERE id = :id');
        $todo->execute([
            ':id' => $id,
            ':complete' => $request->complete
        ]);
        return $this->getOneTodo($id);
    }

    public function getOneTodo(int $id)
    {
        $todo = $this->pdo->prepare('SELECT * FROM todos WHERE id = :id LIMIT 0,1');
        $todo->execute([':id' => $id]);
        $todo->setFetchMode(\PDO::FETCH_ASSOC);
        return $todo->fetch();
    }
}
