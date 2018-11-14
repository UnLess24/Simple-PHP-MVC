<?php

namespace App\Controllers;

use App\Kernel\MyPDO;
use App\Kernel\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function getTodos(Request $request = null)
    {
        if ($request) {
            $page = $request->page ?? 1;
            $page = ((int) $page > 0) ? (int) $page : 1;
            $limit = $request->limit ?? 3;
            $limit = ((int) $limit > 0) ? (int) $limit : 1;
        } else {
            $page = 1;
            $limit = 3;
        }

        $offset = ($page - 1) * $limit;

        $model = new Todo();
        $todos = $model->getPageTodos($limit, $offset);
        $todos['page'] = $page;
        $todos['pages'] = (int) floor($todos['todosCount'] / $limit);

        return view('todos/todos.php', $todos);
    }

    public function getAddTodo()
    {
        view('todos/add.php');
    }

    public function postAddTodo(Request $request)
    {
        $model = new Todo();
        $todo = $model->createTodo($request);

        http_response_code(201);

        return $this->getTodos();
    }

    public function putChangeTodo(Request $request, $id)
    {
        $model = new Todo();
        $changed = $model->changeTodo($id, $request);

        if ($changed) {
            http_response_code(202);
        }
        return json($changed);
    }

    public function getTodo(Request $request = null, $id)
    {
        $todo = new Todo();
        return $todo->getOneTodo($id);
    }
}
