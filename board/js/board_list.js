document.addEventListener("DOMContentLoaded",()=>{
  const btn_excel_board = document.querySelector("#btn_excel_board")
  const btn_excel_notice = document.querySelector("#btn_excel_notice")
  if(btn_excel_board == null){
    const btn_excel_notice = document.querySelector("#btn_excel_notice")
    btn_excel_notice.addEventListener("click", ()=>{
      // alert("aaaa");
      self.location.href = "./board_to_excel.php?mode=notice";
  
  
    })
  } 
  if(btn_excel_notice == null){
    const btn_excel_board = document.querySelector("#btn_excel_board")
    btn_excel_board.addEventListener("click", ()=>{
      // alert("aaaa");
      self.location.href = "./board_to_excel.php?mode=board";
  
  
    })
  }
  
})