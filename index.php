<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>EuroMega QR Code Generator</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
</head>

<body>
  <div class="container mt-4">
    <h1>EuroMega QR Code Generator</h1>

    <div class="m-5 form-inline">
      <div class="form-group mr-3">
        <label class="url-label mr-1" for="url-input">URL:</label>
        <input class="form-control" type="text" id="url-input" placeholder="Enter URL">
      </div>

      <div class="form-group mr-3">
        <label for="url-input" class="unique-label mr-1"># of Unique QR Codes:</label>
        <input class="form-control" type="number" id="loop-input" min="1">
      </div>

      <button class="btn btn-success" onclick="generateQrImagesToPdf()">Generate QR Code to PDF</button>
    </div>

    <div class="modal" id="loadingDiv">
      <div class="center">
        <img alt="" id="img-id"/>
      </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
      const loader = ["assets/files/loader/giphy.gif","assets/files/loader/loader-giphy.gif","assets/files/loader/spinner.gif"];
      $("#img-id").attr("src", loader[Math.floor(Math.random() * 2)]);

      $('#loadingDiv').hide();

      jQuery(document).ajaxStart(function() {
          $('#loadingDiv').show();
        })
        .ajaxStop(function() {
          $('#loadingDiv').hide();
        });

      function generateQrImagesToPdf() {
        var count = $('#loop-input').val();
        var url = $('#url-input').val()

        if (count.length == "" || count.length == '0' || url.length == "" || url.length == '0') {
          swal({
            title: `All input fields are required`,
            text: "kindly provide a url and no. of qr codes to be generated!",
            icon: "error",
            button: "close!",
          });
        } else {
          $.ajax({
            url: "/promo/QrCodeController.php",
            type: 'post',
            data: {
              'data': count,
              'url': url
            },
            dataType: 'json',
            success: function(res) {
              console.log(res);
              swal({
                title: `${res.total} QrCodes generated successfully`,
                icon: "success",
                button: "close!",
              }).then((value) => {
                window.open(res.result, '_blank');
              });


            },
            error: function(res) {
              console.log(res);
              swal({
                title: `failed to generate unique codes`,
                icon: "error",
                button: "close!",
              });
            }
          });
        }
      }
    </script>
</body>

</html>