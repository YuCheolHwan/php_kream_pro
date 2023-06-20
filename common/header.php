<?php
//로그인을 하면 session에 정보를 저장하고 각 페이지들에서 모두 사용하고자 함.
//로그인에 띠라 화면구성이 다르기에 세션에 저장되어 있는 회원정보 중 id, name, level 값 읽어오기
//회원등급 : 1~9등급 [1등급:관리자, 9등급:신규회원]
//세션을 저장하든 읽어오든 사용하고자 하면 이 함수로 시작
session_start();
$num       = (isset($_SESSION['num']) && $_SESSION['num'] != "") ? $_SESSION['num'] : "";
$userid    = (isset($_SESSION['userid']) && $_SESSION['userid'] != "") ? $_SESSION['userid'] : "";
$username  = (isset($_SESSION['username']) && $_SESSION['username'] != "") ? $_SESSION['username'] : "";
$userlevel = (isset($_SESSION['userlevel']) && $_SESSION['userlevel'] != "") ? $_SESSION['userlevel'] : "";
$userpoint = (isset($_SESSION['userpoint']) && $_SESSION['userpoint'] != "") ? $_SESSION['userpoint'] : "";
?>

<!-- 헤더 영역의 로고와 회원가입/로그인 표시 영역 -->
<div id="top">
  <!-- 1. 로고영역 -->
  <div class="logo">
    <!-- <i class="fa-solid fa-user" id="icon"></i> -->
    <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/php_source/ych_pro/index.php" id="title"><img src="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/img/kream.jpg' ?>"></a>
  </div>
  <!-- include되면 삽입된 문서의 위치를 기준으로 -->

  <!-- 2. 회원가입/로그인 버튼 표시 영역 -->
  <ul id="top_menu">
    <!-- 로그인 안되었을 때 -->
    <?php if (!$userid) {  ?>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/member/member_form.php' ?>">회원가입</a></li>
      <li> | </li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/login/login_form.php' ?>">로그인</a></li>
    <?php } else { ?>
      <?= $username . "님" ?>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/login/logout.php' ?>">로그아웃</a></li>
      <li> | </li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/member/member_update_form.php' ?>">회원수정</a></li>

    <?php } ?>

    <!-- 관리자모드로 로그인되었을 때 추가로.. -->
    <?php if ($userlevel == 1) { ?>
      <li> | </li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/admin/admin.php' ?>">관리자모드</a></li>
      <li> | </li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/member/member_list.php' ?>">회원리스트</a></li>
    <?php } ?>
  </ul>
</div>

<!-- 헤더 영역의 네비게이션 메뉴 영역 -->
<div id="menu_bar">
  <ul>
    <li><a href="#">홈</a></li>
    <li><a href="#">남성</a></li>
    <li><a href="#">여성</a></li>
    <li><a href="#">게시판</a></li>
    <li><a href="#">쪽지</a></li>
  </ul>
  <div class="hide_menu">
    <ul>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/index.php' ?>">HOME</a></li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/image_board/image_board_list.php?board_flag=new' ?>">NEW</a></li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/image_board/image_board_list.php?board_flag=new' ?>">NEW</a></li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/board/board_list.php?mode=notice' ?>">공지사항</a></li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/message/message_form.php' ?>">쪽지</a></li>
    </ul>
    <ul>
      <li><a href="#"></a></li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/image_board/image_board_list.php?board_flag=luxury' ?>">럭셔리</a></li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/image_board/image_board_list.php?board_flag=luxury' ?>">럭셔리</a></li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/board/board_list.php?mode=board'  ?>">게시판</a></li>
      <li><a href="#"></a></li>
    </ul>
    <ul>
      <li><a href="#"></a></li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/image_board/image_board_list.php?board_flag=shoes&gender_flag=man' ?>">인기 신발</a></li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/image_board/image_board_list.php?board_flag=shoes&gender_flag=woman' ?>">인기 신발</a></li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/image_board/image_board_list.php' ?>">이미지게시판</a></li>
      <li><a href="#"></a></li>
    </ul>
    <ul>
      <li><a href="#"></a></li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/image_board/image_board_list.php?board_flag=top&gender_flag=man' ?>">인기 상의</a></li>
      <li><a href="http://<?= $_SERVER['HTTP_HOST'] . '/php_source/ych_pro/image_board/image_board_list.php?board_flag=top&gender_flag=woman' ?>">인기 상의</a></li>
      <li><a href="#"></a></li>
      <li><a href="#"></a></li>
    </ul>
  </div>
  <!-- 



 -->

</div>