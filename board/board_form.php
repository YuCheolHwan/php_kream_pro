<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>PHP 프로그래밍 입문</title>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/common.css' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/board/css/board.css' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/slide.css?er=1' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/header.css' ?>">
  <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/php_source/ych_pro/board/js/board.js?v=<?= date('Ymdhis') ?>"></script>
  <script src="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/js/slide.js' ?>" defer></script>
</head>

<body>
  <header>
    <header>
      <?php
      include_once $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/db_connect.php";

      include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/header.php";
      include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/slide.php";
      include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/create_table.php";
      create_table($conn, "board");
      $mode = (isset($_GET['mode']) && $_GET['mode'] != '') ? $_GET['mode'] : '';
      switch ($mode) {
        case 'board': {
            $h3 = "게시판 > 글 쓰기";
            $action = "board_insert.php?mode=board";
            break;
          }
        case 'notice': {
            $h3 = "공지사항 > 글 쓰기";
            $action = "board_insert.php?mode=notice";
            break;
          }
      }
      ?>
    </header>
    <section>
      <div id="board_box">
        <h3 id="board_title">
          <?= "$h3" ?>
        </h3>
        <form name="board_form" method="post" action="<?= $action ?>" enctype="multipart/form-data">
          <ul id="board_form">
            <li>
              <span class="col1">이름 : </span>
              <span class="col2"><?= $_SESSION["username"] ?></span>
            </li>
            <li>
              <span class="col1">제목 : </span>
              <span class="col2"><input name="subject" type="text"></span>
            </li>
            <li id="text_area">
              <span class="col1">내용 : </span>
              <span class="col2">
                <textarea name="content"></textarea>
              </span>
            </li>
            <li>
              <span class="col1"> 첨부 파일</span>
              <span class="col2"><input type="file" name="upfile"></span>
            </li>
          </ul>
          <ul class="buttons">
            <li><button type="button" id="complete">완료</button></li>
            <li><button type="button" onclick="location.href='board_list.php?mode=<?= $mode ?>'">목록</button></li>
          </ul>
        </form>
      </div>
    </section>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/footer.php"; ?>
    </footer>
</body>

</html>