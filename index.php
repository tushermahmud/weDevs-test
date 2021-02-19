<?php 
require_once('db_conn.php');
require_once('todos.php');
if(isset($_POST['delete'])){
    $todos = new Todos(); 
    $stmt = $todos->clear_all($title);
    header("Location:./index.php");
}
if(isset($_POST['title'])){
    $title = $_POST['title'];
    if(empty($title)){
        header("Location:./index.php");
    }else {
        $todos = new Todos(); 
        $stmt = $todos->add_todo($title);
        header("Location:./index.php"); 
    }
}else {
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To-Do List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php 
    $todos = new Todos(); 
    $data = $todos->find_todos();
    $completed = $todos->completed();
    $rowCount = $todos->rowCount("SELECT * from todos");

?>
    <div class="main-section">
       <div class="add-section">
          <form action="" method="POST" autocomplete="off">
             <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                <input type="text" 
                style="border: 0px"
                     name="title" 
                     style="border-color: #ff6666"
                     placeholder="This field is required" />

             <?php }else{ ?>
                <span style="font-size:20px">&#x002C7;<span>
              <input type="text" 
              style="border: 0px;width:90%"
                     name="title" 
                     placeholder=" What do you need to do?" />
             <?php } ?>
          </form>
       </div>
       <div class="show-todo-section">
            <!-- <?php if($rowCount == 0){ ?>
                <div class="todo-item">
                    <div class="empty">
                        <img src="img/f.png" width="100%" />
                        <img src="img/Ellipsis.gif" width="80px">
                    </div>
                </div>
            <?php } ?> -->
            <?php if(isset($_GET['status']) && $_GET['status'] == 'completed'){ ?>
                <?php while($complete = mysqli_fetch_array($completed)) { ?>
                <div class="todo-item">
                    <span id="<?php echo $complete['id']; ?>"
                          class="remove-to-do">x</span>
                    <?php if($complete['checked']){ ?> 
                        <div style="display:flex">
                            <div class="round">
                            <input type="checkbox"
                                id="checkbox"
                               class="check-box"
                               data-todo-id ="<?php echo $complete['id'];?>"
                               checked />
                               <label for="checkbox" <?php echo $complete['id'];?></label>
                            </div>
                            <h2 class="checked todo-title" style="margin-left:20px"><?php echo $complete['title'] ?></h2>
                        </div>
                        
                    <?php }else { ?>
                        <div style="display:flex">
                            <div class="round">
                            <input type="checkbox"
                                id="checkbox"
                               class="check-box"
                               data-todo-id ="<?php echo $complete['id'];?>"
                               checked />
                               <label for="checkbox" <?php echo $complete['id'];?></label>
                            </div>
                            <h2 class="todo-title" style="margin-left:20px"><?php echo $complete['title'] ?></h2>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            
            <?php } else if(isset($_GET['status']) && $_GET['status'] == 'all'){?>
                <?php while($row = mysqli_fetch_array($data)) { ?>
                <div class="todo-item">
                    <span id="<?php echo $row['id']; ?>"
                          class="remove-to-do">x</span>
                    <?php if($row['checked']){ ?> 
                        <input type="checkbox"
                               class="check-box"
                               data-todo-id ="<?php echo $row['id']; ?>"
                               checked />
                        <h2 class="checked"><?php echo $row['title'] ?></h2>
                    <?php }else { ?>
                        <input type="checkbox"
                               data-todo-id ="<?php echo $row['id']; ?>"
                               class="check-box" />
                        <h2><?php echo $row['title'] ?></h2>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php } else {?>
                <?php while($row = mysqli_fetch_array($data)) { ?>
                <div class="todo-item">
                    <span id="<?php echo $row['id']; ?>"
                          class="remove-to-do">x</span>
                    <?php if($row['checked']){ ?> 
                        <input type="checkbox"
                               class="check-box"
                               data-todo-id ="<?php echo $row['id']; ?>"
                               checked />
                        <h2 class="checked"><?php echo $row['title'] ?></h2>
                    <?php }else { ?>
                        <input type="checkbox"
                               data-todo-id ="<?php echo $row['id']; ?>"
                               class="check-box" />
                        <h2><?php echo $row['title'] ?></h2>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php }?>
       </div>
        <div class="footer" style="display:flex; justify-content:space-between;padding:0px 20px">
            <span class="item-left" href=""><?php echo $rowCount. " items left"?></span>
            <span class="all-complete">
                <?php if(isset($_GET['status']) && $_GET['status'] == 'all'){?>
                    <a href="?status=all" style="text-align:center" class="all border">All</a> 
                <?php } else {?>
                    <a href="?status=all" style="text-align:center" class="all">All</a> 
                <?php } ?>
                <?php if(isset($_GET['status']) && $_GET['status'] == 'completed'){?>
                    <a href="?status=completed" class="completed border">Completed</a>
                <?php } else {?>
                    <a href="?status=completed" class="completed">Completed</a>
                <?php } ?>

            </span>
            <form method='POST'>
                <input type="submit" value="Clear All" name="delete" style="border: 0px;background: transparent;">
                </form>
            </div>
    </div>
    

    <script src="js/jquery-3.2.1.min.js"></script>

    <script>
        $(document).ready(function(){
            $('.remove-to-do').click(function(){
                const id = $(this).attr('id');
                $('.item-left').innerHtml = "tusher"
                $.post("app/remove.php", 
                      {
                          id: id
                      },
                      (data)  => {
                         if(data){
                             $(this).parent().hide(600);
                         }
                      }
                );
            });

            $(".check-box").click(function(e){
                const id = $(this).attr('data-todo-id');
                
                $.post('app/check.php', 
                      {
                          id: id
                      },
                      (data) => {
                          console.log(data)
                              const h2 = $(this).next();
                              if(data === '1'){
                                  $('.todo-title').removeClass('checked');
                              }else {
                                $('.todo-title').addClass('checked');
                              }
                      }
                );
            });
        });
    </script>
</body>
</html>