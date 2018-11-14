<?php

// Автозагрузка классов
spl_autoload_register(function ($class)
{
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});

// Установка корневой директории
set_include_path(dirname(__FILE__, 2));

// JSON response
function json($data)
{
    if (is_array($data)) {
        $tmpArr = [];
        foreach ($data as $key => $value) {
            if (gettype($key) === "integer")
                continue;
            $tmpArr[$key] = $value;
        }
        return response(json_encode($tmpArr));
    }
    return response($data);
}

// Строка пути в зависимости от среды запуска
function real_path(string $path)
{
    $newPath = explode('/', $path);
    return implode(DIRECTORY_SEPARATOR, $newPath);
}

// Путь к директории изображений
function images_path()
{
    return real_path('/images/');
}

// Путь к основному шаблону
function main_template()
{
    return view_path() . real_path('templates/main.php');
}

// Путь к директории шаблонов
function view_path()
{
    return get_include_path() . real_path('/resources/views/');
}

function view(string $view, array $variables = [])
{
    extract($variables);
    $template = view_path() . real_path($view);
    include main_template();
}

function response($data)
{
    exit($data);
}
