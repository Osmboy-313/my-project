<?php

require_once __DIR__ . '/../models/post.php';
require_once __DIR__ . '/../models/category.php';
require_once __DIR__ .  '/../core/view.php';
require_once __DIR__ .  '/../core/auth.php';

define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024);        // 10MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp']);

function post_index()
{
    $posts = getUserPosts();
    $modal = view('/posts/modals');
    echo view('/posts/my', ['title' => 'My Posts', 'modals' => $modal, 'posts' => $posts], 'private');
}

// ==================================== OLd function, here just for comparison ====================================

function post_addd()
{

    $errors = [];
    $fieldsValue = [];
    $success = false;
    $uploadsPermDir = __DIR__ . '/../../public/assets/uploads/permanent/';
    $uploadsTempDir = __DIR__ . '/../../public/assets/uploads/temp/';

    if (!is_dir($uploadsPermDir)) mkdir($uploadsPermDir, 0755, true);
    if (!is_dir($uploadsTempDir)) mkdir($uploadsTempDir, 0755, true);

    if (isset($_SESSION['temp-upload'])) {
        $fieldsValue['image'] = $_SESSION['temp-upload']['original-name'];
        $fieldsValue['temp-img-exists'] = true;
    }

    // Get Request ! Render Form and Exit

    if (!isset($_POST['add-post'])) {

        echo view('/posts/add', [
            'title' => 'My Posts',
            'categories' => getAllCategories(),
            'errors' => $errors,
            'fieldsValue' => $fieldsValue,
            'success' => $success,
        ], 'private');

        return;
    }

    $title = htmlspecialchars($_POST['title'] ?? '');
    $tags = htmlspecialchars($_POST['tags'] ?? '');
    $description = htmlspecialchars($_POST['description'] ?? '');
    $category = htmlspecialchars($_POST['category'] ?? '');

    $uploadDetails = validateImage();

    if (isset($uploadDetails['error'])) {

        if ($uploadDetails['error'] && !isset($_SESSION['temp-upload'])) {
            $errors['image'] = $uploadDetails['error'];
        }
    } else if (!empty($uploadDetails)) {

        echo '<pre>';
        print_r($uploadDetails);
        echo '</pre>';

        $fileTempPath = $uploadsTempDir . $uploadDetails['storage-name'];
        if (!move_uploaded_file($uploadDetails['php-temp-dir'], $fileTempPath)) {
            $errors['image'] = 'Failed to store File temporarily';
        } else {

            $_SESSION['temp-upload'] = [
                'original-name' => $uploadDetails['original-name'],
                'storage-name' => $uploadDetails['storage-name'],
                'file-temp-path' => $fileTempPath,
            ];

            $fieldsValue['image'] = $uploadDetails['original-name'];
            $fieldsValue['storage-name'] = $uploadDetails['storage-name'];
            $fieldsValue['file-temp-path'] = $fileTempPath;
            $fieldsValue['temp-img-exists'] = true;
        }
    }

    if (empty($title)) $errors['title'] = 'Enter Post Title';
    if (empty($tags)) $errors['tags'] = 'Enter Post Tags';
    if (empty($description)) $errors['description'] = 'Enter Post Description';
    if (empty($category)) $errors['category'] = 'Select Post category';

    $fieldsValue += compact('title', 'tags', 'description', 'category');

    // Post Request ! Render form with errors and exit !

    if (!empty($errors)) {

        echo view('/posts/add', [
            'title' => 'Add Post',
            'categories' => getAllCategories(),
            'errors' => $errors,
            'fieldsValue' => $fieldsValue,
            'success' => $success,
        ], 'private');

        return;

    }

    $tempUpload = $_SESSION['temp-upload'];
    $src = $fieldsValue['file-temp-path'] ?? $tempUpload['file-temp-path'];
    $dest = $uploadsPermDir . ($fieldsValue['storage-name'] ?? $tempUpload['storage-name']);

    // Another Post Request ! render form with error if no file is moved from src to destination !

    if (!file_exists($src) || !rename($src, $dest)) {

        $errors['image'] = "Failed to save uploaded file";
        echo view('/posts/add', [
            'title' => 'My Posts',
            'categories' => getAllCategories(),
            'errors' => $errors,
            'fieldsValue' => $fieldsValue,
            'success' => $success,
        ], 'private');

        return;

    }

    unset($_SESSION['temp-upload']);
    $success = "Successfully Uploaded The Post";
    $fieldsValue = [];
    header('Location: ?c=post&a=index');
}

// ============================================ New clean up funciton with PRG technique ===============================================

function post_add(){

    $errors = $_SESSION['errors'] ?? [];
    $oldValues = $_SESSION['old-form'] ?? [];
    $status = $_SESSION['status'] ?? ['pending' => 'status is pending!'];

    unset($_SESSION['errors'], $_SESSION['old-form'], $_SESSION['status']);

    $uploadsPermDir = __DIR__ . '/../../public/assets/uploads/permanent/';
    $uploadsTempDir = __DIR__ . '/../../public/assets/uploads/temp/';

    if (!is_dir($uploadsPermDir)) mkdir($uploadsPermDir, 0755, true);
    if (!is_dir($uploadsTempDir)) mkdir($uploadsTempDir, 0755, true);


    // Get Request ! Render Form with error, success or anything 

    $title = 'Add Post';
    $categories = getAllCategories();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        if(empty($oldValues) && isset($_SESSION['temp-upload'])){
            unlink($_SESSION['temp-upload']['file-temp-path']);
            unset($_SESSION['temp-upload']);
        }

        echo view('/posts/add', compact('title', 'categories', 'errors', 'oldValues', 'status'),'private');

        return;
    }

    $title = htmlspecialchars($_POST['title'] ?? '');
    $tags = htmlspecialchars($_POST['tags'] ?? '');
    $description = htmlspecialchars($_POST['description'] ?? '');
    $category = htmlspecialchars($_POST['category'] ?? '');

    $image_O_Name = $_SESSION['temp-upload']['original-name'] ?? '';
    $image_S_Name = $_SESSION['temp-upload']['storage-name'] ?? '';
    $didImgUpload = $_SESSION['temp-upload']['didImgUpload'] ?? false;

    $uploadDetails = validateImage();

    if (isset($uploadDetails['error'])) {

        if ($uploadDetails['error'] && !isset($_SESSION['temp-upload'])) {
            $errors['image'] = $uploadDetails['error'];
        }

    } 
    else if (!empty($uploadDetails)) {

        $fileTempPath = $uploadsTempDir . $uploadDetails['storage-name'];
        if (!move_uploaded_file($uploadDetails['php-temp-dir'], $fileTempPath)) {
            $errors['image'] = 'Failed to store File temporarily';
        } else {

            $_SESSION['temp-upload'] = [
                'original-name' => $uploadDetails['original-name'],
                'storage-name' => $uploadDetails['storage-name'],
                'file-temp-path' => $fileTempPath,
                'didImgUpload' => true,
            ];
            $image_O_Name = $uploadDetails['original-name'];
            $image_S_Name = $uploadDetails['storage-name'];
            $didImgUpload = true;
            
        }
    }

    if (empty($title)) $errors['title'] = 'Enter Post Title';
    if (empty($tags)) $errors['tags'] = 'Enter Post Tags';
    if (empty($description)) $errors['description'] = 'Enter Post Description';
    if (empty($category)) $errors['category'] = 'Select Post category';

    $oldValues = compact('title', 'tags', 'description', 'category', 'didImgUpload', 'image_O_Name');

    // Post Request ! Redirect to same page with errors and exit !

    if (!empty($errors)) {

        $_SESSION['errors'] = $errors;
        $_SESSION['old-form'] = $oldValues;
        header('location: ?c=post&a=add');
        exit;

    }

    $tempUpload = $_SESSION['temp-upload'];
    $src = $oldValues['file-temp-path'] ?? $tempUpload['file-temp-path'];
    $dest = $uploadsPermDir . ($oldValues['storage-name'] ?? $tempUpload['storage-name']);

    // Another Post Request ! redirect to same page with error if no file is moved from src to destination and then exit !

    if (!file_exists($src) || !rename($src, $dest)) {

        $errors['image'] = '';
        $_SESSION['errors'] = $errors;
        $_SESSION['old-form'] = $oldValues;
        header('location: ?c=post&a=add');
        exit;

    }

    $addPost = addPost($title,$tags, $description, $category, $image_O_Name, $image_S_Name);
    unset($_SESSION['temp-upload']);

    if($addPost){
        $_SESSION['status'] = ['success' => 'Successfully Uploaded The Post !'];
        header('Location: ?c=post&a=add');
        exit;
    }
    else{
        $_SESSION['status'] = ['error' => 'Failed To Upload Post !'];
        header('Location: ?c=post&a=add');
        exit;
    }


}

// ==================================== Remove Session + temp file if user select another picture ======================================

function post_clearTempFile()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['temp-upload'])) {

        $tempPath = $_SESSION['temp-upload']['file-temp-path'];

        if (file_exists($tempPath)) {
            unlink($tempPath);
        }
        unset($_SESSION['temp-upload']);
        echo json_encode(['status' => 'success']);
        exit;
    }
    echo json_encode(['status' => 'error']);
    exit;
}


// ======================= Helper Function for validation of Images =======================

function validateImage()
{

    if (!$_FILES['image'] || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
        return ['error' => 'Select a Post Image'];
    }

    $file = $_FILES['image'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'Upload Error (' . $file['error'] . ')'];
    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, ALLOWED_EXTENSIONS, true)) {
        return ['error' => 'Invalid file type. Allowed type : ' . implode(',', ALLOWED_EXTENSIONS)];
    }

    if ($file['size'] > MAX_UPLOAD_SIZE) {
        return ['error' => 'Maximum File Size Allowed : ' . MAX_UPLOAD_SIZE];
    }

    return [
        'original-name' => $file['name'],
        'storage-name' => uniqid('img_', true) . '.' . $extension,
        'php-temp-dir' => $file['tmp_name'],
        'extension' => $extension,
    ];
}


function post_edit(){

    echo view('/posts/edit', ['title' => 'My Posts'], 'private');

}