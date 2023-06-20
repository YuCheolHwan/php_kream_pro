<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_source/ych_pro/common/db_connect.php";

header("Content-type: application/vnd.ms-excel; charset=utf-8");
//filename = 저장되는 파일명을 설정합니다.
header("Content-Disposition: attachment; filename =members_list.xls");
header("Content-Description: PHP4 Generated Data");

//엑셀 파일로 만들고자 하는 데이터의 테이블을 만듭니다.
$EXCEL_FILE = "
<table border='1'>
    <tr>
    <th>NUM</th>
    <th>ID</th>
    <th>PASS</th>
    <th>NAME</th>
    <th>EMAIL</th>
    <th>ZIPCODE</th>
    <th>ADDRESS1</th>
    <th>ADDRESS2</th>
    <th>DATE</th>
    <th>LEVEL</th>
    <th>POINT</th>
    </tr>
";

$sql = "select * from members order by name";
$stmt = $conn->prepare($sql);
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
<td>{$row['pass']}</td>
<td>{$row['name']}</td>
<td>{$row['email']}</td>
<td>{$row['zipcode']}</td>
<td>{$row['addr1']}</td>
<td>{$row['addr2']}</td>
<td>{$row['regist_day']}</td>
<td>{$row['level']}</td>
<td>{$row['point']}</td>
</tr>
";
}

$EXCEL_FILE .= "</table>";

// 만든 테이블을 출력해줘야 만들어진 엑셀파일에 데이터가 나타납니다.
echo "
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
echo $EXCEL_FILE;
