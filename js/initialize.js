$("#register").click(function () {
  //$(".working").html($(form));
  $.post("../payrollsystem/manageemployee/regform.php",
    {
      accounts: "accounts"
    },
    function (data, status) {
      $('.dashboard-right').html(data);
    });
});


$("#activate").click(function () {
  //$(".working").html($(form));
  $.post("../payrollsystem/manageemployee/activate.php",
    {
      accounts: "accounts"
    },
    function (data, status) {
      $('.dashboard-right').html(data);
    });
});

//event delegation search
$(document).ready(function () {
  $('.dashboard-right').on('keyup', '#search,tbody', function (event) {
    event.preventDefault();
    //console.log(event.target.value);
    $.post("../payrollsystem/manageemployee/activate.php",
      {
        search: event.target.value
      },
      function (data, status) {
        let match = JSON.parse(data);
        match.forEach(function(item){
          let d = `<tr><td> ${item['firstname']}</td><td>${item['lastname']}</td><td>${item['empnumber']}</td><td><form method="post" action="../payrollsystem/manageemployee/activate.php"><input type="hidden" name="activate" value=${item['idnumber']}><button type="submit">Activate</button></form></td></tr>`;

          $('.tbody').html(d);
          //console.log(item['empnumber']);
          
        });
        console.log(event.target.value);
        //console.log(data);
      });
  });
});