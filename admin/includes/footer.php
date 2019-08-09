  <?php
  $comment = new Comment(new Database);
  $user = new User(new Database);
  $photo = new Photo(new Database);
  ?>
  </div>
  <!-- /#wrapper -->

  <!-- Text Editor -->
  <script src="https://cloud.tinymce.com/5/tinymce.min.js"></script>

  <!-- jQuery -->
  <script src="js/jquery.js"></script>

  <!-- Bootstrap Core JavaScript -->
  <script src="js/bootstrap.min.js"></script>

  <script src="js/dropzone.js"></script>

  <script src="js/script.js"></script>

  <script>
    setTimeout(function() {
      $('#msg').fadeOut();
    }, 2000);
  </script>

  <script type="text/javascript">
    google.charts.load("current", {
      packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['Views', <?php echo $session->count; ?>],
        ['Comments', <?php echo $comment->count_all(); ?>],
        ['Users', <?php echo $user->count_all(); ?>],
        ['Photos', <?php echo $photo->count_all(); ?>]
      ]);

      var options = {
        legend: 'none',
        pieSliceText: 'label',
        pieHole: 0.4,
        backgroundColor: 'transparent',
      };

      var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
      chart.draw(data, options);

    }
  </script>

  </body>

  </html>