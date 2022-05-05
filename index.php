<?php
    require(__DIR__.'/function.php');
?>
<html>
<head>
    <title>Pagination</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/style.css"/>
</head>
<body>
        
    <div class="container inner" >
        <form method="post" action="<?= $_SERVER['PHP_SELF']; ?>" name = "queries">
            <input type="radio" name="query" value = "1" id="training"/><label for="training">На стажировке</label>
            <input type="radio" name="query" value = "2" id="dismissed"/><label for="dismissed">Уволенные</label>
            <input type="radio" name="query" value = "3" id="last_employee"/><label for="last_employee">Последние нанятые</label>
            <input type="submit"  value="Подтвердить"/>
        </form>
        <?php
            if( isset( $_POST['query'] ) ){
                switch( $_POST['query'] ){
                    case '1':?>
                        <table border = 1 >
                        <tr>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                            <th>Дата приёма на работу</th>
                        </tr>
                        <?php
                            while ($newb=mysqli_fetch_assoc($myresult))	:?>
		                        <tr><td><?= $newb['last_name']?></td><td><?= $newb['first_name']?></td>
                                <td><?= $newb['middle_name']?></td><td><?= $newb['created_at']?></td></tr>
                            <?php endwhile?>
                        </table>
                        <ul class="pagination">
                            <!--li><a href="?pageno=1">First</a></li-->
                            <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
                            </li>
                            <li class="disabled">
                                <a href="#"><?= $pageno?></a>
                            </li>
                            <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
                            </li>
                            <!--li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li-->
                        </ul>
                        <?php break;
                    case '2':?>
                        <table border = 1 >
                        <tr>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                            <th>Причина увольнения</th>
                        </tr>
                            <?php
                                while ($row = mysqli_fetch_array($res_data)):?>
                                <tr><td><?= $row['last_name']?></td><td><?= $row['first_name']?></td>
                                    <td><?= $row['middle_name']?></td><td><?= $row['descript']?></td></tr>
                            <?php endwhile;?>
                        </table>
                        <ul class="pagination">
                            <!--li><a href="?pageno=1">First</a></li-->
                            <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
                            </li>
                            <li class="disabled">
                                <a href="#"><?= $pageno?></a>
                            </li>
                            <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
                            </li>
                            <!--li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li-->
                        </ul>
                        <?php break;
                    case '3':?>
                        <table border = 1 >
                        <tr>
                            <th>Отдел</th>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                            <!--th>Фамиия подчиненного</th-->
                        </tr>
                            <?php 
                                while ($rw = mysqli_fetch_array($myresult_1)):?>
                                <tr><td><?= $rw['name']?></td><td><?= $rw['last_name']?></td>
                                    <td><?= $rw['first_name']?></td><td><?= $rw['middle_name']?></td></tr>
                            <?php endwhile;?>
                                
                        </table>
                        </table>
                        <ul class="pagination">
                            <!--li><a href="?pageno=1">First</a></li-->
                            <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
                            </li>
                            <li class="disabled">
                                <a href="#"><?= $pageno?></a>
                            </li>
                            <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
                            </li>
                            <!--li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li-->
                        </ul>
                       <?php break;
                }
            } 
        ?>
        
		
        
    </div>
</body>
</html>


