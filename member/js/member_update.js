document.addEventListener("DOMContentLoaded", () => {
 
  let name_regx = /^[가-힣]{2,4}$|^[A-z]{4,10}$/

  const send = document.querySelector("#send");
  const cancel = document.querySelector("#cancel");

  send.addEventListener("click", () => {

    if (document.member_form.pass.value != "") {
      if (document.member_form.pass_confirm.value == "") {
        alert("비밀번호 확인을 입력하세요!");
        document.member_form.pass_confirm.focus();
        return false;
      }
    }

    if (document.member_form.pass_confirm.value != "") {
      if (document.member_form.pass.value == "") {
        alert("비밀번호를 입력하세요!");
        document.member_form.pass.focus();
        return false;
      }
    }
    if (document.member_form.pass.value != "" && document.member_form.pass_confirm !="") {
      //패턴검색 진행을 해서 안맞으면 경고메세지
      if (
        document.member_form.pass.value != document.member_form.pass_confirm.value
      ) {
        alert("비밀번호가 일치하지 않습니다.\n다시 입력해 주세요!");
        document.member_form.pass.focus();
        document.member_form.pass_confirm.value = "";
        document.member_form.pass.select();
        return false;
      }
    }
    
    if (document.member_form.name.value == "") {
      alert("이름을 입력하세요!");
      document.member_form.name.focus();
      return false;
    }
    if(document.member_form.name.value.match(name_regx) == null){
      alert("이름 한글 2글자 이상 4글자 이하, 영문4자 이상 10자 이하");
      document.member_form.name.focus();
      return false;
    }

    if (document.member_form.email1.value == "") {
      alert("이메일 주소를 입력하세요!");
      document.member_form.email1.focus();
      return false;
    }
    if (document.member_form.email2.value == "") {
      alert("이메일 주소를 입력하세요!");
      document.member_form.email2.focus();
      return false;
    }
    document.member_form.submit();
  });

  cancel.addEventListener("click", () => {
    // alert("취소버튼");
    document.member_form.pass.value = "";
    document.member_form.pass_confirm.value = "";
    document.member_form.name.value = "";
    document.member_form.email1.value = "";
    document.member_form.email2.value = "";
    return;
  });
});
  btn_zipcode.addEventListener("click", () => {
    new daum.Postcode({
      oncomplete: function (data) {
        let addr = "";
        let extra_addr = "";
        //지번, 도로명 선택
        if (data.userSelectedType == "J") {
          addr = data.jibunAddress;
        } else if (data.userSelectedType == "R") {
          addr = data.roadAddress;
        }
        //동이름 점검
        if (data.bname != "") {
          extra_addr = data.bname;
        }
        //빌딩명 점검
        if (data.buildingName != "") {
          if (extra_addr != "") {
            extra_addr += "," + data.buildingName;
          } else {
            extra_addr = data.buildingName;
          }
        }
        if (extra_addr != "") {
          extra_addr = "(" + extra_addr + ")";
        }
        addr = addr + extra_addr;

        document.member_form.zipcode.value = data.zonecode;
        document.member_form.addr1.value = addr;
      },
    }).open();
  });

function check_id() {
  if (document.member_form.id.value == "") {
    alert("아이디를 입력하세요!");
    document.member_form.id.focus();
    return false;
  }
  let id_regx = /^[A-Za-z0-9_]{3,}$/;
  if (document.member_form.id.value.match(id_regx) == null) {
    alert("영문자, 숫자,_만 입력 가능. 최소 3자이상");
    document.member_form.id.value = "";
    document.member_form.id.focus();
    return false;
  }

  // AJAX
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "./member_check.php", true);
  // 전송할 데이터 생성
  const formdata = new FormData();
  formdata.append("id", document.member_form.id.value);
  formdata.append("mode", "id_check");
  xhr.send(formdata);
  // 서버에 JSON 데이터가 도착 완료
  xhr.onload = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      // json.parse = json객체를 javascript객체로 변환
      // {'result': 'success'} => {result: 'success'}
      const data = JSON.parse(xhr.responseText);
      switch (data.result) {
        case "fail":
          alert("사용 불가능한 아이디입니다.");
          document.member_form.id.value = "";
          document.member_form.id_check.value = "0";
          document.member_form.id.focus();
          input_pwd.disabled = true;
          input_chkpwd.disabled = true;
          break;
        case "success":
          alert("사용 가능한 아이디입니다.");
          document.member_form.id_check.value = "1";
          document.member_form.pass.focus();
          input_pwd.disabled = false;
          input_chkpwd.disabled = false;
          break;
        case "empty_id":
          alert("아이디를 입력해주세요.");
          document.member_form.id_check.value = "0";
          document.member_form.id.focus();
          input_pwd.disabled = true;
          input_chkpwd.disabled = true;
          break;
        default:
      }
    } else {
      alert("서버 통신 불가");
    }
  };
}

function check_email() {
  if (!document.member_form.email1.value) {
    alert("이메일 주소를 입력하세요!");
    document.member_form.email1.focus();
    return false;
  }
  if (document.member_form.email2.value == "") {
    alert("이메일 주소를 입력하세요!");
    document.member_form.email2.focus();
    return false;
  }
  const email =
    document.member_form.email1.value + "@" + document.member_form.email2.value;
  let email_regx = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/
  if(email.match(email_regx) == null){
    alert("이메일 주소가 올바르지 않습니다.");
    document.member_form.email_check.value = "0";
    form.email1.focus();
    return false;
  }
    
  const xhr1 = new XMLHttpRequest();
  xhr1.open("POST", "./member_check.php", true);
  // 전송할 데이터 생성
  const fd1 = new FormData();
  fd1.append("email", email);
  fd1.append("mode", "email_check");
  xhr1.send(fd1);
  // console.log(xhr1)

  // 서버에서 member_check_id.php 요청 하면 돌려줄 JSON 데이터가 도착이 완료하면 발생
  xhr1.onload = () => {
    if (xhr1.status == 200) {
      // json parse를 통하여 json 객체로 만듬
      const data = JSON.parse(xhr1.responseText);
      switch (data.result1) {
        case "fail":
          alert("이미 사용중인 이메일입니다.");
          document.member_form.email_check.value = "0";
          document.member_form.email1.value = "";
          document.member_form.email2.value = "";
          document.member_form.email1.focus();
          break;
        case "success":
          alert("사용할 수 있는 이메일 입니다.");
          document.member_form.email_check.value = "1";
          break;
        case "empty_email":
          alert("이메일을 입력하세요.");
          document.member_form.email_check.value = "0";
          break;
        default:
      }
    } else {
      alert("서버 통신 불가");
    }
  };
}