<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Web GIS</title>
  <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
  <link href="<?= base_url()?>assets/vendor/leaflet/leaflet.css" rel="stylesheet">
  <!-- Owl Carousel -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.transitions.min.css">

  <style type="text/css">
    .user {
      padding: 5px;
      margin-bottom: 5px;
    }

    #mapid {
      height: 750px;
    }

    .peta {
      float: left;
      width: 50%;
    }

    .foto {
      float: right;
      width: 50%;
      height: 750px;
    }

    .foto img {
      height: 750px;
      width: 100%;
    }

    .detilpeta {
      width: 100%;
      align-self: center;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="detilpeta">
    <?php foreach($masjid as $data) : ?>
      <h3>Informasi Detil Masjid</h3>
      <h5>Nama Masjid : <?= $data['nama_masjid']; ?></h5>
      <h5>Alamat Masjid : <?= $data['alamat_masjid']; ?></h5>
      <h5>Luas Tanah Masjid : <?= $data['luas_tanah']; ?></h5>
      <h5>Luas Bangunan Masjid : <?= $data['luas_bangunan']; ?></h5>
      <h5>Tahun Berdiri Masjid : <?= $data['tahun_berdiri']; ?></h5>
      <?php endforeach; ?>
  </div>
    <div class="peta">
        <div id="mapid"></div>
    </div>
    <div class="foto owl-carousel">
        <?php foreach($dok as $data) { ?>
        <img src="<?= base_url()?>assets/images/<?= $data['gambar'] ?>">
        <?php } ?>
    </div>
    
    
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="<?= base_url()?>assets/vendor/leaflet/leaflet.js"></script>
    <!-- Owl Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>

<script type="text/javascript">
  var owl = $('.owl-carousel');
  owl.owlCarousel({
    items: 1,
    loop:true,
    margin:10,
    autoplay:1000,
    autoplayTimeout:2000,
    autoplayHoverPause:true,
  });
</script>

<script type="text/javascript">
  var map = L.map('mapid').setView([-3.5694066628650742, 114.79656947943958], 14);
  var base_url = "<?= base_url()?>";
  <?php foreach($masjid as $data) : ?>
    var mas_lat = <?= $data['latitude']; ?>;
    var mas_long = <?= $data['longitude']; ?>;
  <?php endforeach; ?>
  console.log(mas_lat, mas_long);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  $.getJSON(base_url+"home/datamasjid", function(result){
          var iconMasjid = L.icon({
            iconUrl: base_url+'assets/images/marker/mosque.png',
            iconSize: [25, 25],
          });
          
          $.each(result, function(i, field){
            var masjid_lat = result[i].latitude;
            var masjid_long = result[i].longitude;
            var namamasjid = result[i].nama_masjid;
            var streetview = result[i].street_view;
            var id_masjid = result[i].id_masjid;

            var myFeatureGroup = L.featureGroup()
            .on('click')
            .addTo(map);

              map.flyTo([mas_long,mas_lat], 18,{
                animate: true,
                duration: 2
              })

              var detailmasjid = '<h6>'+namamasjid+'</h6><a href="<?= base_url()?>"><button type="button" class="btn btn-success btn-sm">Back Home</button></a> ';
                  detailmasjid += '<a href="<?= base_url()?>home/detailmasjid/'+id_masjid+'"><button type="button" class="btn btn-info btn-sm">Detail</button></a> ';
                  detailmasjid += '<a href="'+streetview+'"><button type="button" class="btn btn-warning btn-sm">Streat View</button></a>';

                markerMasjid = L.marker([masjid_long,masjid_lat], {icon: iconMasjid})
                .bindPopup(detailmasjid)
                .addTo(myFeatureGroup);
                markerMasjid.id = result[i].id_masjid;
            
          });
        });
      


</script>
</body>
</html>