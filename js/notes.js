//chronomètre, timer en js : 

<script>
  function timer(n) {
    $(".progress-bar").css("width", n + "%");
    if(n < 100) {
      setTimeout(function() {
        timer(n + 10);
      }, 200);
    }
  }
  $(function (){
    $("#animer").click(function() {
      timer(0);
    });
  });
</script>