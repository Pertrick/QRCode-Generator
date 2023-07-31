<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>EuroMega QR Code Generator</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    h1 {
      text-align: center;
      color: green;
      /* Change the color to green */
    }

    label {
      display: inline-block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    label.url-label {
      font-size: 12px;
    }

    label.unique-label {
      font-size: 12px;
      margin-left: 20px;
    }

    input[type="text"],
    input[type="number"] {
      padding: 5px;
      font-size: 14px;
    }

    button {
      padding: 8px 16px;
      font-size: 14px;
      background-color: #4CAF50;
      color: #fff;
      border: none;
      cursor: pointer;
      margin-top: 10px;
    }

    button:hover {
      background-color: #45a049;
    }

    img {
      max-width: 100%;
      margin: 0 auto;
      text-align: center;
      /* max-height: 100px; */
    }
  </style>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://unpkg.com/@bitjson/qr-code@1.0.2/dist/qr-code.js"></script>
</head>

<body>
  <h1>EuroMega QR Code Generator</h1>
  <label class="url-label" for="url-input">URL:</label>
  <input type="text" id="url-input" placeholder="Enter URL">
  <label class="unique-label" for="loop-input"># of Unique QR Codes:</label>
  <input type="number" id="loop-input" min="1">
  <button onclick="generateQRImages()">Generate QR Code</button>

  <!-- <form action="/promo/home.php" method="post" class="d-inline"> -->
    <input type="button" name="generate" value="GeneratePDF" id="generate-id" disabled>
  <!-- </form> -->

  <p id="duplicate-check"></p>

  <div class="container-fluid">
    <div id="qr-placeholder" class="row"></div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    function generateRandomString(length) {
      var characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      var randomString = '';

      for (var i = 0; i < length; i++) {
        var randomIndex = Math.floor(Math.random() * characters.length);
        randomString += characters.charAt(randomIndex);
      }

      return randomString;
    }


    function generateQRImages() {

      var loopInput = document.getElementById('loop-input');
      var loopCount = parseInt(loopInput.value, 10);
      var qrTableBody = document.getElementById('qr-table-body');
      var duplicateCheck = document.getElementById('duplicate-check');
      var baseUrl = document.getElementById('url-input').value ?? 'www.euromega.com';

      // Clear previous table rows
      $('#qr-placeholder').html('');
      console.clear();

      var generatedCodes = new Set();

      for (var i = 0; i < loopCount; i++) {
        var randomString = generateRandomString(10);

        // Check for duplicates
        if (generatedCodes.has(randomString)) {
          duplicateCheck.textContent = 'Duplicates found';
          continue; // Skip generating QR code for duplicates
        }

        generatedCodes.add(randomString);

        console.log(randomString);

        var qrCode = `
        <div class="col-md-2">
            <qr-code
                id="qr1"
                contents= "${baseUrl + randomString}"
                module-color="#1c7d43"
                position-ring-color="#13532d"
                position-center-color="#70c559"
                style="
                    width: 200px;
                    height: 200px;
                    margin: 2em auto;
                    background-color: #fff;
                "
                >
                  <img src="soklin-logo.png" slot="icon"/>
            </qr-code>
            </div>`;

        $('#qr-placeholder').append(qrCode);

        // document.getElementById('qr1').addEventListener('codeRendered', () => {
        //   document.getElementById('qr1').animateQRCode('MaterializeIn');
        // });
      }

      console.log($('#qr-placeholder').children().length);
      if ($('#qr-placeholder').children().length > 0) {
          $('#generate-id').removeAttr('disabled');
        } else {
        $('#generate-id').prop('disabled', true);

      }


      $('#generate-id').on('click', function(){
        //console.log($('#qr-placeholder').html());
        var html = $('#qr-placeholder').html();
        console.log(html);
        $.ajax({
            url: "/promo/home.php",
            type: 'post',
            data: {"data":html},
            dataType: 'json', // added data type
            success: function(res) {
              console.log(res);
              window.open(res, '_blank');
            },
            error: function(res){
              console.log(res);

            }
          });

      });

    }
  </script>


</body>

</html>