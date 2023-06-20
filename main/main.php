<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="utf-8">
  <title>PHP 프로그래밍 입문</title>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/header.css' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/slide.css' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/common.css' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/main/css/main.css' ?>">
  <!-- 공통 선언 js -->
  <script src="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/js/slide.js' ?>"></script>
  <!-- 구글폰트 -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+KR:wght@200&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/6a2bc27371.js" crossorigin="anonymous"></script>

</head>

<body>
  <section>
    <div id="main_content">
      <div id="latest">
        <h4>인기 상품</h4>
        <ul>
          <!-- 최근 게시 글 DB에서 불러오기 -->
          <?php
          include_once $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/db_connect.php";
          $sql = "select * from image_board order by hit desc limit 4";
          $stmt = $conn->prepare($sql);
          $stmt->setFetchMode(PDO::FETCH_ASSOC);
          $result = $stmt->execute();
          $rowArray = $stmt->fetchAll();


          if (!$result)
            echo "게시판 DB 테이블(board)이 생성 전이거나 아직 게시글이 없습니다!";
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
                <?php
                if (strpos($file_type_0, "image") !== false) {
                  echo "<img src='http://" . $_SERVER['HTTP_HOST'] . "/php_source/ych_pro/image_board/data/$file_copied_0' width='$image_width' height='$image_height'><br>";
                } else {
                  echo "<img src='../image_board/data/$file_copied_0' width='$image_width' height='$image_height'><br>";
                }
                ?>
                <?= $subject ?></a><br>
                <?= $id ?><br>
                <?= $regist_day ?>
              </span>
            </li>

          <?php
            // $number--;

          }

          ?>


          <?php
          // foreach ($rowArray as $row) {
          //   $sub = substr($row["subject"], 0, 10);
          //   $name = substr($row["name"], 0, 10);
          //   $regist_day = substr($row["regist_day"], 0, 10);

          //   print "<li>
          //   <span> $sub </span>
          //   <span> $name </span>
          //   <span> $regist_day </span>
          // </li>";
          // }
          ?>

          <?php
          ?>
      </div>

      <div id="point_rank">
        <h4>KREAM YOUTUBE</h4>
        <iframe allowscriptaccess="always" allowfullscreen="" src="https://www.youtube.com/embed/ZSPCMrQRltk" width="350px" height="350px" frameborder="0" id="you"></iframe>
      </div>
    </div>
  </section>
</body>

</html>