<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/db_connect.php";

$sql = "select * from members order by name";
$stmt = $conn->prepare($sql);
$result = $stmt->execute();
if (!$result) {
  die("
  <script>
  alert('데이터 삽입 오류');
  </script>");
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="utf-8">
  <title>회원리스트</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- 슬라이드 스크립트 -->
  <script src="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/js/slide.js' ?>"></script>
  <!-- 회원가입폼 스크립트 -->
  <script src="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/member/js/member.js' ?>"></script>
  <script src="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/member/js/member_list.js' ?>"></script>
  <!-- 부트스트랩 CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <!-- 부트스트랩 JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <!-- 공통, 슬라이드, 해더 스타일 -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/common.css' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/slide.css?er=1' ?>">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/css/header.css' ?>">
  <!--회원가입폼 스타일 -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/member/css/member.css' ?>">
  <!-- 구글폰트 -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+KR:wght@200&display=swap" rel="stylesheet">

</head>

<body>
  <header>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/header.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/page_lib.php";

    include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/slide.php";
    $page = (isset($_GET["page"]) && is_numeric($_GET["page"]) && $_GET["page"] != "") ? $_GET["page"] : 1;


    $sql1 = "select count(*) as cnt from members";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->setFetchMode(PDO::FETCH_ASSOC);

    $result = $stmt1->execute();
    $row1 = $stmt1->fetch();
    $total_record = $row1['cnt'];
    $scale = 10;
    // 전체 페이지 수($total_page) 계산 
    if ($total_record % $scale == 0)
      $total_page = floor($total_record / $scale);
    else
      $total_page = floor($total_record / $scale) + 1;

    // 표시할 페이지($page)에 따라 $start 계산  
    $start = ($page - 1) * $scale;
    ?>

  </header>
  <div class="container w-70">
    <!-- 테이블시작 -->
    <h3 class="text-center  mt-5">회원리스트</h3>
    <table class="table table-hover mb-5">
      <thead>
        <tr>
          <th scope="col">NUM</th>
          <th scope="col">ID</th>
          <th scope="col">PASS</th>
          <th scope="col">NAME</th>
          <th scope="col">EMAIL</th>
          <th scope="col">ZIPCODE</th>
          <th scope="col">ADDRESS1</th>
          <th scope="col">ADDRESS2</th>
          <th scope="col">DATE</th>
          <th scope="col">LEVEL</th>
          <th scope="col">POINT</th>
          <th scope="col">삭제</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rowArray = $stmt->fetchAll();

        // for ($i = 0; $i < $count; $i++) {
        foreach ($rowArray as $row) {
          print "
            <tr>
              <th scope='row'>{$row['num']}</th>
              <td>{$row['id']}</td>
              <td>{$row['pass']}</td>
              <td>{$row['name']}</td>
              <td>{$row['email']}</td>
              <td>{$row['zipcode']}</td>
              <td>{$row['addr1']}</td>
              <td>{$row['addr2']}</td>
              <td>{$row['regist_day']}</td>
              <td>{$row['level']}</td>
              <td>{$row['point']}</td>
              <td><button type ='button'
               onclick='location.href=\"http://{$_SERVER['HTTP_HOST']}/php_source/ych_pro/member/member_delete.php?num={$row['num']}\"'>삭제</button></td>
            </tr>";
        }
        ?>
      </tbody>
    </table>
    <!-- 테이블종료 -->
  </div>
  <div class="container d-flex justify-content-center align-items-start gap-2 mb-3">
    <?php
    $page_limit = 5;
    echo pagination($total_record, 10, $page_limit, $page, null);
    ?>
    <button type="button" class="btn btn-outline-primary" id="btn_excel">엑셀로 저장</button>

  </div>
  <footer>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/footer.php"; ?>
  </footer>
</body>

</html>