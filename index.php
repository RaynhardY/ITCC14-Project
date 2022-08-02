<!DOCTYPE html>
<html lang="en" >

<head>

  <meta charset="UTF-8">
    
  <link rel="apple-touch-icon" type="image/png" href="https://cpwebassets.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png" />
  <link rel="mask-icon" type="" href="https://cpwebassets.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg" color="#111" />
  <link rel="stylesheet" href="style/main.css">

  <title>CConverter</title>
    
  <style>
  @charset "UTF-8";
  @import url(https://fonts.googleapis.com/css?family=Oswald|Roboto);
  </style>

  <script>
    window.console = window.console || function(t) {};
  </script>

  <script>
    if (document.location.search.match(/type=embed/gi)) {
      window.parent.postMessage("resize", "*");
    }
  </script>

</head>

<body translate="no" >
  
  <?php
    $ch = curl_init();
    $url = "http://localhost:3000/history";

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
  ?>
  <div class="container">
    <div class="box">

    </div>
  <div class="container-forms">
    <div class="container-info">
      <div class="info-item">
        <div class="table">
          <div class="table-cell">
            <p>
              
            </p>
            <div class="btn">
              Convert again
            </div>
          </div>
        </div>
      </div>
      <div class="info-item">
        <div class="table">
          <div class="table-cell">
            <p></p>
            <div class="btn">
              See history
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-form">
      <div class="form-item log-in">
        <div class="table">
          <div class="table-cell">
            <input id="value" placeholder="Value"/><br />
            <input id="from" placeholder="Convert from"/><br />
            <input id="to" placeholder="Convert to"/><br />
            <div class="btn" onclick="postMethod()">
              Convert
            </div>
          </div>
        </div>
      </div>
      <div class="form-item sign-up" id="scrollable">
        <table class="styled-table">
          <thead>
              <tr>
                  <th>Value</th>
                  <th>Converted from</th>
                  <th>Converted to</th>
                  <th>Converted value</th>
                  <th></th>
              </tr>
          </thead>
          <tbody>
            <?php foreach (json_decode($response)->data as $key => $value): ?>
              <tr>
                <td><?= $value->value; ?></td>
                <td><?php switch ($value->from) {
                  case 'cm':
                    echo 'Centimeter';
                    break;
                  case 'm':
                    echo 'Meter';
                    break;
                  case 'km':
                    echo 'Kilometer';
                    break;
                  default:
                    echo $value->from;
                    break;
                } ?></td>
                <td><?php switch ($value->to) {
                  case 'cm':
                    echo 'Centimeter';
                    break;
                  case 'm':
                    echo 'Meter';
                    break;
                  case 'km':
                    echo 'Kilometer';
                    break;
                  default:
                    echo $value->from;
                    break;
                } ?></td>
                <td><?= $value->converted_value; ?></td>
                <td>
                  <div class="deleteBtn" onclick="deleteMethod(<?= $value->id; ?>)">Delete</div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
  <script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-1b93190375e9ccc259df3a57c1abc0e64599724ae30d7ea4c6877eb615f89387.js"></script>

  <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
  <script id="rendered-js" > $(".info-item .btn").click(function () {
      $(".container").toggleClass("log-in");
    });
      $(".container-form .btn").click(function () {
      $(".container").toggleClass("log-in");
    });
  </script>

  

</body>

<script>
  const postMethod = async () => {
    const value = document.getElementById("value").value;
    const from = document.getElementById("from").value;
    const to = document.getElementById("to").value;
    const form = new FormData();

    form.append('value', value)
    form.append('from', from)
    form.append('to', to)

    await fetch('http://localhost:3000/history', {
      method: 'POST',
      body: form
    }).then(() => {
      window.location.replace("http://localhost/itcc14")
    })
  }

  const deleteMethod = async (id) => {
    const form = new FormData();

    form.append('id', id)

    await fetch('http://localhost:3000/history', {
      mode: "cors",
      method: 'DELETE',
      body: form
    }).then(() => {
      window.location.replace("http://localhost/itcc14")
    })
  }
</script>

</html>