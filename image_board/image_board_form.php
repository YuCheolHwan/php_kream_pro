<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>이미지 게시판</title>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/common.css' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_source/ych_pro/image_board/css/image_board.css?v=<?= date('Ymdhis') ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_source/ych_pro/css/slide.css?v=<?= date('Ymdhis') ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/header.css' ?>">
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
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/db_connect.php";
    ?>

    <?php
    if (!$userid) {
      die("<script>
        alert('로그인 후 이용해주세요!');
				history.go(-1);
			</script>");
    }

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

    <section>
      <?php
      $mode = isset($_POST["mode"]) ? $_POST["mode"] : "insert";
      $subject = "";
      $content = "";
      $file_name = "";

      if (isset($_POST["mode"]) && $_POST["mode"] === "modify") {
        $num = $_POST["num"];
        $page = $_POST["page"];

        $sql = "select * from image_board where num = $num";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        $writer = $row["id"];

        // 비로그인 이거나 관리자가 아닌경우
        if (!isset($userid) && $userlevel != 1) {
          die("<script>
            alert('수정권한이 없습니다.');
            history.go(-1);
          </script>");
        }

        $name = $row["name"];
        $subject = $row["subject"];
        $content = $row["content"];
        $file_name = $row["file_name"];
        if (empty($file_name)) $file_name = "없음";
      }
      ?>
      <div id="board_box">
        <h3 id="board_title">
          <?php if ($mode === "modify") : ?>
            <?= $h3 ?> > 수정 하기
          <?php else : ?>
            <?= $h3 ?> > 글 쓰기
          <?php endif; ?>
        </h3>
        <form name="image_board_form" method="post" action="image_board_insert.php?board_flag=<?= $board_flag ?>&gender_flag=<?= $gender_flag ?>" enctype="multipart/form-data">
          <?php if ($mode === "modify") : ?>
            <input type="hidden" name="num" value=<?= $num ?>>
            <input type="hidden" name="page" value=<?= $page ?>>
          <?php endif; ?>

          <input type="hidden" name="mode" value=<?= $mode ?>>
          <ul id="board_form">
            <li>
              <span class="col1">이름 : </span>
              <span class="col2"><?= $username ?></span>
            </li>

            <li>
              <span class="col1">제목 : </span>
              <span class="col2"><input name="subject" type="text" value=<?= $subject ?>></span>
            </li>
            <li id="text_area">
              <span class="col1">내용 : </span>
              <span class="col2">
                <textarea name="content"><?= $content ?></textarea>
              </span>
            </li>
            <li>
              <span class="col1"> 첨부 파일 : </span>
              <span class="col2"><input type="file" name="upfile">
                <?php if ($mode === "modify") : ?>
                  <input type="checkbox" value="yes" name="file_delete">&nbsp;파일 삭제하기
                  <br>현재 파일 : <?= $file_name ?>
                <?php endif; ?>
              </span>
            </li>
          </ul>
          <ul class="buttons">
            <li><button type="button" id="complete">완료</button></li>
            <li><button type="button" onclick="location.href='image_board_list.php?board_flag=<?= $board_flag ?>'">목록</button></li>
          </ul>
        </form>
      </div> <!-- board_box -->
    </section>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/footer.php"; ?>
    </footer>
</body>

</html>