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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
  <h1>EuroMega QR Code Generator</h1>
  <label class="url-label" for="url-input">URL:</label>
  <input type="text" id="url-input" placeholder="Enter URL">
  <label class="unique-label" for="loop-input"># of Unique QR Codes:</label>
  <input type="number" id="loop-input" min="1">
  <button onclick="generateQRImages()">Generate QR Code</button>

    <input type="button" name="generate" value="GeneratePDF" id="generate-id" disabled>
  

  <p id="duplicate-check"></p>

  <div class="container-fluid">
    <div id="qr_code" class="row"></div>
  </div>

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
      $('#qr_code').html('');
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

            // var qrCode = `<div class="col-md-6">`;

            var qrCode = new QRCode('qr_code',{
            text: `${baseUrl + randomString}`,
            width: 128,
            height: 128,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });

        // qrCode +=   `</div>`;

        // $('#qr_code').append(qrCode);

     
      }

      console.log($('#qr_code').children().length);
      if ($('#qr_code').children().length > 0) {
        $('#generate-id').removeAttr('disabled');
      } else {
        $('#generate-id').prop('disabled', true);

      }

    }


    $('#generate-id').click(function() {
      console.log($('#qr_code img'));
        var pdf = new jsPDF();


        let base64Image = $('#qr_code img').attr('src');
        pdf.addImage(base64Image, 'png', 0, 0, 40, 40);

        pdf.save("a4.pdf");

        // $('#qr_code img').forEach(element => {
        //   let base64Image = element.attr('src');
        //     console.log(base64Image);
        //    pdf.addImage(base64Image, 'png', 0, 0, 40, 40);
        // });
       
       
    });
      

  </script>


</body>

</html>