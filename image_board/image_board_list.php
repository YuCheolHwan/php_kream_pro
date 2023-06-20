<!DOCTYPE html>
<html>
<!-- flag 별로 new product / luxury / top / shoes 게시판으로 나뉨 -->
<!-- flag 별로 남자 man / 여자 woman 로 나뉨 -->

<head>
  <meta charset="utf-8">
  <title>이미지 게시판</title>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/common.css' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_source/ych_pro/image_board/css/image_board.css?v=<?= date('Ymdhis') ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_source/ych_pro/css/slide.css?v=<?= date('Ymdhis') ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/header.css' ?>">
  <!-- board_excel 자바스크립트 -->
  <script src="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/image_board/js/image_board.js' ?>" defer></script>
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
    include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/page_lib.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/db_connect.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/create_table.php";
    create_table($conn, "image_board");
    create_table($conn, "image_board_ripple");

    $board_flag = isset($_GET["board_flag"]) ? $_GET["board_flag"] : "";
    $gender_flag = isset($_GET["gender_flag"]) ? $_GET["gender_flag"] : "";

    switch ($board_flag) {
      case "new": {
          $h3 = "NEW PRODUCT";
          break;
        }
      case "luxury": {
          $h3 = "LUXURY";
          create_table($conn, "luxury_board");
          break;
        }
      case "top": {
          create_table($conn, "top_board");

          if ($gender_flag == "man") {
            $h3 = "MAN TOP";
          } else if ($gender_flag == "woman") {
            $h3 = "WOMAN TOP";
          }
          break;
        }
      case "shoes": {
          create_table($conn, "shoes_board");

          if ($gender_flag == "man") {
            $h3 = "MAN SHOES";
          } else if ($gender_flag == "woman") {
            $h3 = "WOMAN SHOES";
          }
          break;
        }
      default: {
          $h3 = "이미지 게시판 > 목록보기";
          break;
        }
    }
    ?>
  </header>
  <section>
    <div id="board_box">
      <h3>
        <?= $h3 ?>
      </h3>
      <ul id="board_list">
        <?php

        $page = (isset($_GET["page"]) && is_numeric($_GET["page"]) && $_GET["page"] != "") ? $_GET["page"] : 1;

        $sql = "select count(*) as cnt from image_board order by num desc";
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->execute();
        $row = $stmt->fetch();
        $total_record = $row['cnt'];
        $scale = 10;             // 전체 페이지 수($total_page) 계산

        // 전체 페이지 수($total_page) 계산 
        if ($total_record % $scale == 0)
          $total_page = floor($total_record / $scale);
        else
          $total_page = floor($total_record / $scale) + 1;

        // 표시할 페이지($page)에 따라 $start 계산  
        $start = ($page - 1) * $scale;

        $number = $total_record - $start;



        switch ($board_flag) {
          case "new": {
              $sql2 = "select * from shoes_board , top_board, luxury_board;";
              break;
            }
          case "luxury": {
              $sql2 = "select * from luxury_board order by num desc limit {$start}, {$scale}";
              break;
            }
          case "top": {
              if ($gender_flag == "man") {
                $sql2 = "select * from top_board where flag = 0 order by num desc limit {$start}, {$scale}";
              } else if ($gender_flag == "woman") {
                $sql2 = "select * from top_board where flag = 1 order by num desc limit {$start}, {$scale}";
              }
              break;
            }
          case "shoes": {
              if ($gender_flag == "man") {
                $sql2 = "select * from shoes_board where flag = 0 order by num desc limit {$start}, {$scale}";
              } else if ($gender_flag == "woman") {
                $sql2 = "select * from shoes_board where flag = 1 order by num desc limit {$start}, {$scale}";
              }
              break;
            }
          default: {
              $sql2 = "select * from image_board order by num desc limit {$start}, {$scale}";

              break;
            }
        }

        $stmt2 = $conn->prepare($sql2);
        $stmt2->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt2->execute();
        $rowArray = $stmt2->fetchAll();

        foreach ($rowArray as $row) {
          $num = $row["num"];
          $id = $row["id"];
          $name = $row["name"];
          $subject = $row["subject"];
          $regist_day = $row["regist_day"];
          $hit = $row["hit"];
          $file_name_0 = $row['file_name'];
          $file_copied_0 = $row['file_copied'];
          $file_type_0 = $row['file_type'];
          $image_width = 200;
          $image_height = 200;
        ?>
          <li>
            <span>
              <a href="image_board_view.php?board_flag=<?= $board_flag ?>&gender_flag=<?= $gender_flag ?>&num=<?= $num ?>&page=<?= $page ?>">
                <?php
                if (strpos($file_type_0, "image") !== false) {
                  echo "<img src='./data/$file_copied_0' width='$image_width' height='$image_height'><br>";
                } else {
                  echo "<img src='./img/user.jpg' width='$image_width' height='$image_height'><br>";
                }
                ?>
                <?= $subject ?></a><br>
              <?= $id ?><br>
              <?= $regist_day ?>
            </span>
          </li>
        <?php
          $number--;
        }
        ?>
      </ul>

      <div class="container d-flex justify-content-center align-items-start gap-2 mb-3">
        <?php
        $page_limit = 5;
        echo pagination($total_record, 10, $page_limit, $page);
        ?>
        <!-- <button type="button" class="btn btn-outline-primary" id="btn_excel">엑셀로 저장</button> -->
      </div>

      <ul class="buttons">
        <li>
          <button onclick="location.href='image_board_list.php?board_flag=<?= $board_flag ?>'">목록</button>
        </li>
        <li>
          <?php
          if ($userid) {
          ?>
            <button onclick="location.href='image_board_form.php?board_flag=<?= $board_flag ?>&gender_flag=<?= $gender_flag ?>'">글쓰기</button>
          <?php
          } else {
          ?>
            <a href="javascript:alert('로그인 후 이용해 주세요!')"><button>글쓰기</button></a>
          <?php
          }
          ?>
        </li>
      </ul>
    </div>
  </section>
  <footer>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/footer.php"; ?>
  </footer>
</body>

</html>