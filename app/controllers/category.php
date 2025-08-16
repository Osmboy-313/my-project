<?php

require_once __DIR__ . '/../models/category.php';
require_once __DIR__ . '/../models/post.php';
require_once __DIR__ .  '/../core/view.php';
require_once __DIR__ .  '/../core/auth.php';

function category_index()
{
    // 🔐 Check if user is logged in
    auth_require_login();

    // $modals = view('/categories/modals');
    $modals = view('/components/modals');

    echo view('/categories/index', ['title' => 'Category', 'modals' => $modals], 'private');
}

function category_add()
{


    header('Content-Type: application/json');

     if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $data = json_decode(file_get_contents('php://input'), true);
        $response = [];

        $name = trim($data['name']);
        $nameAlreadyExists = categoryExistenceCheck($name) ? true : false;

        if (empty($name)) $response['errors']['name'] = "Enter category name";
        if (!empty($name) && $nameAlreadyExists) $response['errors']['name'] = "Category Already Exists";

        if (!isset($response['errors'])) {

            $result = addCategory($name);

            if ($result) {
                $response['success'] = "Category Has Been Added!";
            } else {
                $response['failure'] = "Failed To Add Category";
            }
        }

        echo json_encode($response);
    }

    exit;
}

function category_fetchAll()
{

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $categories = getAllCategories();
        echo json_encode(['categories' => $categories]);
    }
}

function category_populate()
{

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = json_decode(file_get_contents('php://input'), true);

        $category = getSingleCategory($id);

        echo json_encode($category);
    }
}

function category_existenceCheck()
{

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        $id = $data['id'] ?? 0;
        $name = trim($data['name']);
        if (empty($name)) return;

        $check = categoryExistenceCheck($name, $id);
        $exists = false;

        if (!empty($check)) {
            $exists = true;
        }

        echo json_encode(['exists' => $exists, 'id' => $id, 'name' => $name]);
    }
}

function category_edit()
{

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $reponse = [];
        $id = trim($data['id']);
        $name = trim($data['name']);
        $nameExistenceCheck = categoryExistenceCheck($name, $id);

        if (empty($name)) $response['errors']['name'] = "Enter Category Name";
        if (!empty($name) && !empty($nameExistenceCheck)) $response['errors']['name'] = "Category Already Exists";

        if (!isset($response['errors'])) {
            if (editCategory($id, $name)) {
                $response['success'] = "Successfully Edited Category";
            } else {
                $response['failure'] = "Failed To Edit Category";
            }
        }
        echo json_encode($response);
    }
}

function category_delete()
{

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $data = json_decode(file_get_contents('php://input'), true);
        $response = [];
        $id   = isset($data['id']) ? (int)$data['id'] : 0;

        
        
        // 1) Fetch all images for this category

        $images     = getPostsByCategoryId($id);
        $permFolder = __DIR__ . '/../../public/assets/uploads/permanent/';
        

        // $response['images'] = $images;
    
        // 2) Delete File of each post
        foreach ($images as $img) {
            $filename = $img['post_image'];
            $path     = $permFolder . $filename;

            if (is_file($path)) {
                unlink($path);
            }
        }

        // 3) Delete the post aswell
        $okPosts = deletePostsByCategory($id);

        // 4) Delete the Category too !!
        $okCat = deleteCategory($id);

        if ($okPosts && $okCat) {
            $response['success'] = "Successfully Removed Category and its Posts";
        }
        else{
            $response['failure'] = "Failed Removed Category";
        }

        echo json_encode($response);
    }
}
