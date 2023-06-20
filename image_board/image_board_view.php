<!DOCTYPE html>
<html>


<head>
  <meta charset="utf-8">
  <title>이미지 게시글</title>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/common.css' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/board/css/board.css' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/slide.css?er=1' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/header.css' ?>">
  <script src="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/js/slide.js' ?>" defer></script>
  <!-- 부트스트랩 script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <!-- 부트스트랩 CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
  <header>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/header.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/slide.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/db_connect.php";
    $board_flag = isset($_GET["board_flag"]) ? $_GET["board_flag"] : "";
    $gender_flag = isset($_GET["gender_flag"]) ? $_GET["gender_flag"] : "";

    switch ($board_flag) {
      case "new": {
          $h3 = "NEW PRODUCT";
          break;
        }
      case "luxury": {
          $h3 = "LUXURY";
          break;
        }
      case "top": {

          if ($gender_flag == "man") {
            $h3 = "MAN TOP";
          } else if ($gender_flag == "woman") {
            $h3 = "WOMAN TOP";
          }
          break;
        }
      case "shoes": {

          if ($gender_flag == "man") {
            $h3 = "MAN SHOES";
          } else if ($gender_flag == "woman") {
            $h3 = "WOMAN SHOES";
          }
          break;
        }
      default: {
          $h3 = "이미지 게시판";
          break;
        }
    }
    ?>
  </header>
  <section>
    <div id="board_box">
      <h3 class="title">
        <?= $h3 ?> > 내용보기
      </h3>
      <?php
      $num = (isset($_GET["num"]) && $_GET["num"] != '') ? $_GET["num"] : '';
      $page = (isset($_GET["page"]) && $_GET["page"] != '') ? $_GET["page"] : 1;

      if ($num == "") {
        die("
	        <script>
          alert('저장되는 정보가 없습니다.,');
          history.go(-1)
          </script>           
          ");
      }



      switch ($board_flag) {
        case "new": {
            $sql = "select * from shoes_board , top_board, luxury_board;";
            break;
          }
        case "luxury": {
            $sql = "select * from luxury_board where num = :num";
            break;
          }
        case "top": {
            if ($gender_flag == "man") {
              $sql = "select * from top_board where flag = 0 and num = :num";
            } else if ($gender_flag == "woman") {
              $sql = "select * from top_board where flag = 1 and num = :num";
            }
            break;
          }
        case "shoes": {
            if ($gender_flag == "man") {
              $sql = "select * from shoes_board where flag = 0 and num = :num";
            } else if ($gender_flag == "woman") {
              $sql = "select * from shoes_board where flag = 1 and num = :num";
            }
            break;
          }
        default: {
            $sql = "select * from image_board where num=:num";

            break;
          }
      }


      $stmt = $conn->prepare($sql);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $stmt->bindParam(':num', $num);
      $stmt->execute();
      $row = $stmt->fetch();

      $id = $row["id"];
      $name = $row["name"];
      $regist_day = $row["regist_day"];
      $subject = $row["subject"];
      $content = $row["content"];
      $file_name = $row["file_name"];
      $file_type = $row["file_type"];
      $file_copied = $row["file_copied"];
      $hit = $row["hit"];

      $content = str_replace(" ", "&nbsp;", $content);
      $content = str_replace("\n", "<br>", $content);

      $new_hit = $hit + 1;

      $sql2 = "update image_board set hit=:new_hit where num=:num";
      $stmt2 = $conn->prepare($sql2);
      $stmt2->setFetchMode(PDO::FETCH_ASSOC);
      $stmt2->bindParam(':new_hit', $new_hit);
      $stmt2->bindParam(':num', $num);
      $stmt2->execute();

      $file_name_0 = $row['file_name'];
      $file_copied_0 = $row['file_copied'];
      $file_type_0 = $row['file_type'];
      //이미지 정보를 가져오기 위한 함수 width, height, type
      if (!empty($file_name_0)) {
        $image_info = getimagesize("./data/" . $file_copied_0);
        $image_width = $image_info[0];
        $image_height = $image_info[1];
        $image_type = $image_info[2];
        $image_width = 300;
        $image_height = 300;
        if ($image_width > 300) $image_width = 300;
      }
      ?>
      <ul id="view_content">
        <li>
          <span class="col1"><b>제목 :</b> <?= $subject ?></span>
          <span class="col2"><?= $name ?> | <?= $regist_day ?></span>
        </li>
        <li>
          <?php
          if (strpos($file_type_0, "image") !== false) {
            echo "<img src='./data/$file_copied_0' width='$image_width'><br>";
          } else if ($file_name) {
            $real_name = $file_copied;
            $file_path = "./data/" . $real_name;
            $file_size = filesize($file_path);  //파일사이즈를 구해주는 함수

            echo "▷ 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
			       		<a href='board_download.php?num=$num&real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
          }
          ?>
          <?= $content ?>
        </li>
      </ul>
      <?php
      if ($board_flag == "") {
      ?>
        <!--댓글내용시작  -->
        <div id="ripple">
          <div id="ripple1">댓글</div>
          <div id="ripple2">
            <?php
            $sql = "select * from image_board_ripple where parent=:num ";
            $stmt = $conn->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->bindParam(':num', $num);
            $stmt->execute();
            $rowArray = $stmt->fetchAll();

            foreach ($rowArray as $ripple_row) {
              $ripple_num = $ripple_row['num'];
              $ripple_id = $ripple_row['id'];
              $ripple_nick = $ripple_row['nick'];
              $ripple_date = $ripple_row['regist_day'];
              $ripple_content = $ripple_row['content'];
              $ripple_content = str_replace("\n", "<br>", $ripple_content);
              $ripple_content = str_replace(" ", "&nbsp;", $ripple_content);
            ?>
              <div id="ripple_title">
                <ul>
                  <li><?= $ripple_id . "&nbsp;&nbsp;" . $ripple_date ?></li>
                  <li id="mdi_del">
                    <?php
                    if ($_SESSION['userid'] == "admin" || $_SESSION['userid'] == $ripple_id) {
                      echo '<form style="display:inline" action="image_board_insert.php" method="post">
													<input type="hidden" name="page" value="' . $page . '">
													<input type="hidden" name="hit" value="' . $hit . '">
													<input type="hidden" name="mode" value="delete_ripple">
													<input type="hidden" name="num" value="' . $ripple_num . '">
													<input type="hidden" name="parent" value="' . $num . '">
													<span>' . $ripple_content . '</span>
													<input type="submit" value="삭제">
													</form>';
                    }
                    ?>
                  </li>
                </ul>
              </div>
            <?php
            } //end of foreach
            ?>

            <form name="ripple_form" action="image_board_insert.php" method="post">
              <input type="hidden" name="mode" value="insert_ripple">
              <input type="hidden" name="parent" value="<?= $num ?>">
              <input type="hidden" name="hit" value="<?= $hit ?>">
              <input type="hidden" name="page" value="<?= $page ?>">
              <div id="ripple_insert">
                <div id="ripple_textarea"><textarea name="ripple_content" rows="3" cols="80"></textarea></div>
                <div id="ripple_button"><button type="submit" class="btn btn-outline-primary btn-sm">등록</button></div>
              </div><!--end of ripple_insert -->
            </form>
          </div><!--end of ripple2  -->
        </div><!--end of ripple  -->
      <?php
      }
      ?>
      <div id="write_button">

        <ul class="buttons">
          <li><button onclick="location.href='image_board_list.php?page=<?= $page ?>'">목록</button></li>
          <li><button onclick="location.href='image_board_modify_form.php?num=<?= $num ?>&page=<?= $page ?>'">수정</button></li>
          <li><button onclick="location.href='image_board_delete.php?num=<?= $num ?>&page=<?= $page ?>'">삭제</button></li>
          <li><button onclick="location.href='image_board_form.php'">글쓰기</button></li>
        </ul>
      </div> <!-- board_box -->
  </section>
  <footer>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/footer.php"; ?>
  </footer>
</body>

</html>