<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>PHP 프로그래밍 입문</title>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/common.css' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/message/css/message.css' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_source/ych_pro/css/slide.css?v=<?= date('Ymdhis') ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/header.css' ?>">
  <script src="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/message/js/message.js' ?>"></script>

</head>

<body>
  <header>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/header.php"; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/slide.php"; ?>
  </header>
  <?php
  if ($userid == "") {
    echo ("<script>
				alert('로그인 후 이용해주세요!');
				self.location.href = 'http://{$_SERVER['HTTP_HOST']}/php_source/ych_pro/login/login_form.php';
				</script>
			");
    exit;
  }
  ?>
  <section>
    <div id="message_box">
      <h3 id="write_title">
        쪽지 보내기
      </h3>
      <ul class="top_buttons">
        <li><span><a href="message_box.php?mode=rv">수신 쪽지함 </a></span></li>
        <li><span><a href="message_box.php?mode=send">송신 쪽지함</a></span></li>
      </ul>
      <form name="message_form" method="post" action="message_insert.php" autocomplete="off">
        <input type="hidden" name="send_id" value="<?= $userid ?>">
        <div id="write_msg">
          <ul>
            <li>
              <span class="col1">보내는 사람 : </span>
              <span class="col2"><?= $userid ?></span>
            </li>
            <li>
              <span class="col1">수신 아이디 : </span>
              <span class="col2"><input name="rv_id" type="text"></span>
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
          </ul>
          <button type="button" id="message_send">보내기</button>
        </div>
      </form>
    </div> <!-- message_box -->
  </section>
  <footer>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/footer.php"; ?>
  </footer>
</body>

</html>