<?php

define('DSN', 'mysql:host=localhost;dbname=test;charset=utf8mb4');
define('DB_USER', 'ss1190');
define('DB_PASS', '119089');

try {
  $pdo = new PDO(
    DSN,
    DB_USER,
    DB_PASS,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]
  );
} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}

function getTodos($pdo)
{
  $stmt = $pdo->query("SELECT * FROM todos ORDER BY id DESC");
  $todos = $stmt->fetchAll();
  return $todos;
}

function singleGetTodo($pdo, $taskId)
{
    $stmt = $pdo->query("SELECT * FROM todos WHERE id = $taskId");
}

function addTodo($pdo, $title)
{
  // $stmt = $pdo->query("INSERT INTO todos (title) VALUES ($title)");
  // $stmt->execute();
  // $b = 'ff';

  $stmt = $pdo->prepare("INSERT INTO todos (title) VALUES (:title)");
  $stmt->bindValue('title', $title, PDO::PARAM_STR);
  $stmt->execute();
}

function deleteTodo($pdo, $taskId)
{
  $stmt = $pdo->query("DELETE FROM todos WHERE id = $taskId");

}

function updateTodo($pdo, $id, $title)
{
  $stmt = $pdo->prepare("UPDATE todos SET title = :title WHERE id = :id");
  $stmt->bindValue('title', $title, PDO::PARAM_STR);
  $stmt->bindValue('id', $id, PDO::PARAM_INT);
  $stmt->execute();
}


if (isset($pos))
{
    $pos = file_get_contents('php://input');
    $posde = json_decode($pos, true);

    if ($posde['action'] == 'fetchAll')
    {
      $todos = getTodos($pdo);
      $stmt = $pdo->query("SELECT * FROM todos ORDER BY id DESC");
      header('Content-Type: application/json');
      $todosdata = json_encode($todos); 
      echo $todosdata;
    }
    
    if ($posde['action'] == 'delete')
    {
      $id = $posde['id'];
      deleteTodo($pdo, $id);
    
      $output = ['message' => 'Data Deleted'];
    
      echo json_encode($output);
    
    }
    
    if ($posde['action'] == 'insert')
    {
        error_log("Error message", 3, "log.log");

      $title = $posde['title'];
      addTodo($pdo, $title);
      $output = ['message' => 'Data Inseted'];
    
      echo json_encode($output);
    }
    
    if ($posde['action'] == 'update')
    {
      $title = $posde['title'];
      $id = $posde['id'];
    
      updateTodo($pdo, $id, $title);
    
      $output = ['message' => 'Data Updated'];
    
      echo json_encode($output);
    
    }
}



?>