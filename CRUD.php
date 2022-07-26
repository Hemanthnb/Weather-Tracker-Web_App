<?php $insert=false;
    $update=false;
    $server="localhost";
    $user="root";
    $password="";
    $database="crud";
    $connect=mysqli_connect($server,$user,$password,$database);

    if(isset($_GET['delete']))
    {
        $delete_sl_no=$_GET['delete'];
        $delete_record=" DELETE FROM `todo_list` WHERE `todo_list`.`sl_no` = $delete_sl_no";
        $delete_result=mysqli_query($connect,$delete_record);
    }

    if($_SERVER['REQUEST_METHOD']=='POST')
{

    if(isset($_POST['slno_edit' ]))
    {
        $edited_title=$_POST['titleedit'];
        $edited_description=$_POST['descriptionedit'];
        $edited_slno=$_POST['slno_edit'];
        $update_this="UPDATE `todo_list` SET `title` = ' $edited_title', `description` = ' $edited_description ' WHERE `todo_list`.`sl_no` = $edited_slno";
        $update_result=mysqli_query($connect,$update_this);
        if($update_result)
        {
            $update=true;
        }


    }
    else
    {

        $title=$_POST['title'];
        $des=$_POST['description'];
        $insert="INSERT INTO `todo_list`(`title`,`description`) VALUES ('$title','$des')";
        $insert_result=mysqli_query($connect,$insert);
        if($insert_result)
        {
            $insert=true;
        }
    }
}
    ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    
</head>
<body>

<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editmodal">
Editmodal
</button> -->

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editmodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
    <form action="/PHP_Files/CRUD.php" method="POST">
        <h2>Edit Note</h2>
        <div class="mb-3">
            <input type="hidden" name="slno_edit" id="slno_edit">
            <label for="titleedit" class="form-label">Title</label>
            <input type="Text" class="form-control" id="titleedit" aria-describedby="emailHelp" name ="titleedit">
        </div>
        <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a comment here" id="descriptionedit" name="descriptionedit" style="height: 100px"></textarea>
            <label for="floatingTextarea2">Description</label>
        </div>
        <button type="submit" class="btn btn-primary my-2">Update Note</button>
    </form>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="http://localhost/PHP_Files/CRUD.php">TO DO List</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact us</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <?php
if($insert)
{
    echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Sucess!</strong> Your record has been inserted Sucessfully
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}
?>
    <?php
if($update)
{
    echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Sucess!</strong> Records Updated Sucessfully
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}
?>

<div class="container my-2">
    <form action="/PHP_Files/CRUD.php" method="POST">
        <h2>Add Note</h2>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Title</label>
            <input type="Text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name ="title">
        </div>
        <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="description" style="height: 100px"></textarea>
            <label for="floatingTextarea2">Description</label>
        </div>
        <button type="submit" class="btn btn-primary my-2">Submit</button>
    </form>
</div>
    
    <div class="container">
        <?php
    $sql="SELECT * FROM `Todo_list`";
    $result=mysqli_query($connect,$sql);
    ?>
    <div class="container">
    <table class="table my-5" id="myTable">
        <thead>
            <tr>
                <th scope="col">Sl_No</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Handle</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php  // Creating php to insert values into table inside tbody
if(mysqli_num_rows($result)==0)
{
   $truncate= "TRUNCATE TABLE `crud`.`todo_list`";
   mysqli_query($connect,$truncate);
}
else{

    
    while ($data=mysqli_fetch_assoc($result)) {
        // echo $data['title']."<br>".$data['description']."<br>";
        $sl_no=$data['sl_no'];
        $date_time=$data['time_stamp'];
        echo "
        <tr>
        <th scope='row' id='slno'> $sl_no</th>
        <td>".$data['title']."</td>
        <td>".$data['description']."</td>
        <td> $date_time </td>
        <td>   <button class='edit btn btn-sm btn-primary'>Edit</button> <button class='delete btn btn-sm btn-primary'>Delete</button></td>
        </tr>";
        
    }
}
    ?>
</tbody>
</table>

</div>



<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"> </script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"> </script>

<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );
            </script>



<script>
    edits=document.getElementsByClassName("edit");
    Array.from(edits).forEach((element)=>
    {
        element.addEventListener("click",(e)=>
    {
        // e.target.parentNode.parentNode  ---> gives <tr> tag 


        let title_before_edit=(e.target.parentNode.parentNode.getElementsByTagName("td")[0].innerText);
        let Description_before_edit=(e.target.parentNode.parentNode.getElementsByTagName("td")[1].innerText);
        let slno_before_edit=(e.target.parentNode.parentNode.getElementsByTagName("th")[0].innerText);
        console.log(slno_before_edit);
        // console.log(title+"\n"+Descripion);
        titleedit.value=title_before_edit;
        descriptionedit.value=Description_before_edit;
        slno_edit.value=slno_before_edit;
        console.log(slno_edit.value)
        $('#editModal').modal('toggle');
    })
});
    </script>


    <script>


    delete_note=document.getElementsByClassName("delete");
    Array.from(delete_note).forEach((element)=>
    {
        element.addEventListener("click",(e)=>
    {
        let slno_before_delete=e.target.parentNode.parentNode.getElementsByTagName('th')[0].innerText;
        if(confirm("cnonfirm delete this record ?"))
        {
            window.location =`/PHP_Files/CRUD.php?delete=${slno_before_delete}`;

        }
    })
});

</script>
  </body>
</html>