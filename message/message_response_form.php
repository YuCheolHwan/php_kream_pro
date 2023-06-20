<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>쪽지 답변</title>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/common.css' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/message/css/message.css' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/slide.css?er=2' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/header.css' ?>">
  <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/php_source/ych_pro/message/js/message_response.js?v=<?= date('Ymdhis') ?>"></script>
</head>

<body>
  <header>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/header.php"; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/slide.php"; ?>
  </header>
  <section>
    <div id="message_box">
      <h3 id="write_title">
        답변 쪽지 보내기
      </h3>
      <?php
      $num = (isset($_GET["num"]) && $_GET["num"] != "") ? $_GET["num"] : "";
      if ($num == "") {
        die("
        <script>
        alert('경고');
        history.go(-1);
        </script>
        ");
      }

      include_once $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/db_connect.php";

      // sql 침입방지
      $sql = "select * from message where num=:num";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':num', $num);
      $stmt->execute();

      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $rowArray = $stmt->fetchAll();
      foreach ($rowArray as $row) {
        $send_id = $row["send_id"];
        $rv_id = $row["rv_id"];
        $subject = $row["subject"];
        $content = $row["content"];
      }
      var_dump($row);
      exit;


      $subject = "RE: " . $subject;

      $content = "> " . $content;
      $content = str_replace("\n", "\n>", $content);
      $content = "\n\n\n-----------------------------------------------\n" . $content;

      // sql 침입방지
      $sql = "select name from members where id=:send_id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':send_id', $send_id);
      $stmt->execute();

      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $rowArray = $stmt->fetchAll();
      foreach ($rowArray as $record) {
        $send_name = $record["name"];
      }
      ?>
      <form name="message_form" method="post" action="message_insert.php?send_id=<?= $userid ?>">
        <input type="hidden" name="rv_id" value="<?= $send_id ?>">
        <input type="hidden" name="send_id" value="<?= $rv_id ?>">
        <div id="write_msg">
          <ul>
            <li>
              <span class="col1">보내는 사람 : </span>
              <span class="col2"><?= $userid ?></span>
            </li>
            <li>
              <span class="col1">수신 아이디 : </span>
              <span class="col2"><?= $send_name ?>(<?= $send_id ?>)</span>
            </li>
            <li>
              <span class="col1">제목 : </span>
              <span class="col2"><input name="subject" type="text" value="<?= $subject ?>"></span>
            </li>
            <li id="text_area">
              <span class="col1">글 내용 : </span>
              <span class="col2">
                <textarea name="content"><?= $content ?></textarea>
              </span>
            </li>
          </ul>
          <button type="button" id="message_send">보내기</button>
        </div>
      </form>
    </div>
  </section>
  <footer>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/footer.php"; ?>
  </footer>
</body>

</html>