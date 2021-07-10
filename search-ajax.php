<?php

    require_once 'dbconfig.php';

    if(!empty($_POST["ingredient"])){

    $ingredient = $_POST["ingredient"];
    $select_ingredient = "SELECT groceries_name, groceries_image FROM groceries WHERE groceries_name = :ingredient";

    $query_ingredient = $pdo -> prepare($select_ingredient);
    $query_ingredient -> bindValue(":ingredient", $ingredient, PDO::PARAM_STR);
    $query_ingredient -> execute();

    if($query_ingredient -> rowCount() > 0){
        $rows1 = $query_ingredient -> fetch();

        $response["status"] = true;
        $response["message"] = '  <tr>
                <td class="grocery-image"><img src="data:image/jpg; base64, '.base64_encode($rows1["groceries_image"]).'" width="120" height="120"></td>
                <td class="grocery-name js-grocery_name">'.$rows1["groceries_name"].'</td>
                <td class="delete-icon"><a class="js-delete" href="#"><i class="fas fa-trash-alt"></i></a></td>
              </tr>';
      }
      else {
        $response["status"] = false;
        $response["message"] =  'Not found ingredient like this';

      }
    } else {
      $response["status"] = false;
      $response["message"] = 'Please fill the textbox!';
    }

    echo json_encode($response);
?>
