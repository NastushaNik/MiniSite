<?php
/**
 * Created by PhpStorm.
 * User: Yoga
 * Date: 30.10.2017
 * Time: 7:46
 */

//константа с нашим файлом с книгами
define('BOOKS_STORAGE', 'data/books.txt');

//проверяем что пришло в action, по умолчанию list
//просто list выдает ошибку, используем listAction
$action = requestGet('action', 'list') . 'Action';

if (!function_exists($action)){
    redirect('/');
}
//вызов функции ниже
$content = $action();

function listAction(){
    //вызов функции
    $books = loadBooks();

    //функция блокирует вывод в тело ответа http, и записывает
    // в оперативную память эту информацию
    ob_start();
    require 'books_list.phtml';
    //отдает информацию из буфера(оперативной памяти), и читсит буфер
    return ob_get_clean();

}

//добавление книги
function createAction(){
    //нужно самостояьельно написать валидацию!!!

    //проверка формы, если пришел массив POST
    if ($_POST){
        //записываем значение массива в переменную
        $book = $_POST;
        //генерируем случайный id
        $book['id'] = rand(1000, 99999);
        //записываем значение id в сериализ. массив
        $book = serialize($book);
        //записываем созданую книгу в файл с параметрами (1-путь к файлу,
        // 2-что записать(название массива)плюс константа переноса строки,
        // 3-дописывает данные в конец файла, иначе будут перезаписаны
        file_put_contents(BOOKS_STORAGE, $book . PHP_EOL, FILE_APPEND);

        //написать flesh сообщение о там что книга добавлена

        //редирект на файл с отображение всех книг
        redirect('/');
    }

    //магическая константа отдает название функции, файлы которые
    // мы вызываем require, можно назвать именами функции(createAction.phtml)
    //, и потом использовать эту магическую константу
    //функция блокирует вывод в тело ответа http, и записывает
    // в оперативную память эту информацию
    ob_start();
    require __FUNCTION__.'.phtml';
    //отдает информацию из буфера(оперативной памяти), и читсит буфер
    return ob_get_clean();
}

function editAction(){
    //записываем в переменную id из GET
    $id = requestGet('id');

    //если id нет, перенаправляемся на главную страницу
    if (!$id){
        redirect('/');
    }
    //вызов функции со списком книг
    $books = loadBooks();

    //книга с нужным id не найдена
    $bookFound = false;

    //проходимся по массиву и меняя ссылку мы меняем сам элемент массив
    foreach ($books as &$book){
        //если id из GET равен одному из id в списке книг
        if ($id == $book['id']){
            //книга с нужным id найдена
            $bookFound = true;
            break;
        }
    }
    //если не найдена книга - редирект
    if (!$bookFound){
        //flash;
        redirect('/');
    }
    //если форма была отправлена
    if ($_POST){
        //переписываем элементы массива, вносим новые значения после редактирования
        $book['title'] = $_POST['title'];
        $book['price'] = $_POST['price'];
        //перезаписываем файл в режиме записи, все удаляется и записывается заново
        fopen(BOOKS_STORAGE, 'w');
        fclose();

        foreach ($books as $b){
            //записываем заново все в файл, но с измененной книгой (1-путь к файлу,
            // 2-что записать(название массива)плюс константа переноса строки,
            // 3-дописывает данные в конец файла, иначе будут перезаписаны
            file_put_contents(BOOKS_STORAGE, $book . PHP_EOL, FILE_APPEND);
        }

        redirect('/');
    }

    ob_start();
    require __FUNCTION__.'.phtml';
    //отдает информацию из буфера(оперативной памяти), и читсит буфер
    return ob_get_clean();

}

function loadBooks(){
    //при помощи функции file достаем строки в виде массива
    $serializedBooks = file(BOOKS_STORAGE);
    $books = [];
    //получаем в переменную $books список книжек
    foreach ($serializedBooks as $b){
        $books[] = unserialize($b);
    }
    return $books;
}


