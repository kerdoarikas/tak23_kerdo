<?php
require 'config.php';

session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$username = $_SESSION['user']['username'];

$tasks = getUserTasks($_SESSION['user']['id']);


include 'elements/head.php';
?>

<div class="container-fluid px-4 bg-white py-3 shadow">
    <div class="d-flex justify-content-between align-items-center">
    <h5 class="m-0">Tere tulemast, kasutajanimi!</h5>
    <a href="db/logout.php" class="btn btn-dark">Logi välja</a>
    </div>
</div>

<div class="row">
    <div class="col-6">
    <div class="bg-white rounded shadow mt-3 ms-3 pb-4">
    <a href="add_task.php" class="btn btn-dark mx-3 my-3"><i class="fa-solid fa-plus me-2"></i>Lisa uus</a>
    <table class="table table-hover mt-3">
        <thead>
            <tr class="table-secondary">
            <th>#</th>
            <th>Staatus</th>
            <th>Kirjeldus</th>
            <th>Lisatud</th>
            <th>Toimingud</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($tasks)): ?>
                <?php foreach($tasks as $task): ?>
                    <?php
                    if($task['status'] == 'ootel'){
                        $taskBadge = 'bg-warning';
                    }  
                    if($task['status'] == 'tegemisel'){
                        $taskBadge = 'bg-secondary';
                    }  
                    if($task['status'] == 'valmis'){
                        $taskBadge = 'bg-success';
                    }  
                        
                    ?>
                    <tr>
                        <td><?= $task['id'] ?></td>
                        <td> <span class="badge <?= $taskBadge ?>"><?= $task['status'] ?></span></td>
                        <td><?= $task['text'] ?></td>
                        <td><?= $task['added_at'] ?></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?php if(empty($tasks)): ?>
    <p class="small w-100 text-center"><i class="fa-solid fa-warning me-1"></i>Sul ei ole hetkel ühtegi ülesannet.</p>
    <?php endif; ?>
</div>
    </div>
    <div class="col-6">

    </div>
</div>

<?php include 'elements/foot.php'; ?>