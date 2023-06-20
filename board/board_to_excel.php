<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/db_connect.php";
$mode = (isset($_GET['mode']) && $_GET['mode'] != '') ? $_GET['mode'] : '';
switch ($mode) {
  case 'board': {
      $name = "board_board";
      $writeFlag = 0;
      break;
    }
  case 'notice': {
      $name = "board_notice";
      $writeFlag = 1;
      break;
    }
}
header("Content-type: application/vnd.ms-excel; charset=utf-8");
//filename = 저장되는 파일명을 설정합니다.
header("Content-Disposition: attachment; filename =$name.xls");
header("Content-Description: PHP4 Generated Data");

//엑셀 파일로 만들고자 하는 데이터의 테이블을 만듭니다.
$EXCEL_FILE = "
<table border='1'>
    <tr>
    <th>번호</th>
    <th>제목</th>
    <th>글쓴이</th>
    <th>첨부</th>
    <th>등록일</th>
    <th>조회</th>
    </tr>
";

$sql = "select * from board where notice_flag = :writeFlag";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':writeFlag', $writeFlag);

$result = $stmt->execute();
if (!$result) {
  die("
  <script>
  alert('데이터 로딩 오류');
  </script>");
}
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$rowArray = $stmt->fetchAll();

foreach ($rowArray as $row) {
  $EXCEL_FILE .= "
<tr>
<td>{$row['num']}</td>
<td>{$row['id']}</td>
<td>{$row['name']}</td>
<td>{$row['subject']}</td>
<td>{$row['regist_day']}</td>
<td>{$row['hit']}</td>
</tr>
";
}

$EXCEL_FILE .= "</table>";

// 만든 테이블을 출력해줘야 만들어진 엑셀파일에 데이터가 나타납니다.
echo "
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
echo $EXCEL_FILE;
