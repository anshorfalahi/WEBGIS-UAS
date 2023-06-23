
<!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <title>WEBGIS UAS Infomasi Masjid Kec. Bati-Bati</title>
          <link rel="shortcut icon" type="image/x-icon" href="https://telegra.ph/file/ef6105e92cab05d1a5eb3.jpg" />
        <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
          <!-- Bootstrap -->
        <!-- <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css"> -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">


        <link href="<?php echo base_url()?>assets/vendor/css/BootSideMenu.css" rel="stylesheet">
        <link href="<?php echo base_url()?>assets/vendor/leaflet/leaflet.css" rel="stylesheet">
        
        <!-- routing machine -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
        
        <style type="text/css">
          /* body{
            padding: 0;
            margin: 0;
            overflow: hidden;
          }
          .user{
            padding:5px;
            margin-bottom: 5px;
          } */
          #mapid {
              height: 870px;
              width: 100%;
        }
        </style>
        </head>
        <body>

          <!--Test -->
          <div id="test">
            <h2>List Masjid</h2>
            <div class="list-group">
              <?php foreach($masjid as $data) : ?>
              <a href="#" class="list-group-item" onclick="flyMarker()"><?php echo $data['nama_masjid']?></a>
              <?php endforeach; ?> 
            </div>
          </div>
          <!--End Test -->
          <div class="container-fluid">
            <h1 class="text-center">WEB GIS UAS Infomasi Masjid Kec. Bati-Bati</h1>
            <div class="row">
              <div class="col-md-12">
              <button id="deleteRouteBtn" class="btn btn-danger" style="float: left;">Hapus Routing</button>
              <button id="showPoly" class="btn btn-primary" style="float: right;">Routing</button>
              <h4 class="text-center">Muhammad Anshor Falahi</h4>

                <div id="mapid"></div>
              </div>
            </div>
          </div>


          <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
          <!-- <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script> -->
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
          <script src="<?php echo base_url() ?>/assets/vendor/js/BootSideMenu.js"></script>
          <script src="<?php echo base_url() ?>/assets/vendor/leaflet/leaflet.js"></script> 

          <!-- routing machine -->
          <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>


          <script type="text/javascript">
          $('#test').BootSideMenu({side:"left", autoClose:false});
          var map = L.map('mapid').setView([-3.5750066939866807, 114.76911666516273], 13);
          var base_url = "<?= base_url()?>";
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          }).addTo(map);

          //base map control
          var peta0 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          });
          var peta1 = L.tileLayer('https://{s}.tile-cyclosm.openstreetmap.fr/cyclosm/{z}/{x}/{y}.png', {
            maxZoom: 20,
            attribution: '<a href="https://github.com/cyclosm/cyclosm-cartocss-style/releases" title="CyclOSM - Open Bicycle render">CyclOSM</a> | Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          });
          var peta2 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
          });
          var peta3 =  L.tileLayer('https://{s}.tile.openstreetmap.de/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          });
          var peta4 =  L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png', {
            maxZoom: 20,
            attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
          });
          var baseMaps = {
              "Default": peta0,
              "Cyclosm": peta1,
              "Satelit": peta2,
              "OSM DE": peta3,
              "Dark": peta4
          };
          var layerControl = L.control.layers(baseMaps).addTo(map);

          var clickedMarker;
          function groupClick(event)
          {
            console.log("Click on marker" + event.layer.id);
            clickedMarker = event.layer;
          }


          $.getJSON(base_url+"home/datamasjid", function(result){
            var iconMasjid = L.icon({
              iconUrl: base_url+'assets/images/marker/mosque.png',
              iconSize: [25, 25],
            });
            
            $.each(result, function(i, field){
              var masjid_lat = parseFloat(result[i].latitude);
              var masjid_long = parseFloat(result[i].longitude);
              var namamasjid = result[i].nama_masjid;
              var streetview = result[i].street_view;
              var id_masjid = result[i].id_masjid;

              var myFeatureGroup = L.featureGroup()
              .on('click', groupClick, )
              .addTo(map);

              var detailmasjid = '<h6 style="text-align: center">'+namamasjid+'</h6>';
                  detailmasjid += '<button type="button" class="btn btn-success btn-sm" onclick="calculateRoute()">Go to Masjid</button> ';
                  detailmasjid += '<a href="<?= base_url()?>home/detailmasjid/'+id_masjid+'"><button type="button" class="btn btn-info btn-sm">Detail</button></a> ';
                  detailmasjid += '<a href="'+streetview+'"><button type="button" class="btn btn-warning btn-sm">Streat View</button></a>';

              markerMasjid = L.marker([masjid_long,masjid_lat], {icon: iconMasjid})
              .bindPopup(detailmasjid)
              .addTo(myFeatureGroup);
              markerMasjid.id = result[i].id_masjid;
            });
          });

          var routingControl;
          function calculateRoute() {
            if (routingControl) {
              map.removeControl(routingControl);
            }
            //ngambil lat long dari user
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(showPositionn, function() {
                //jika user tidak mengizinkan geolocation munculkan alert
                alert("Please allow location access to use this feature");
              })
            }else {
              alert("Geolocation is not supported by this browser.");
            }
            
            function showPositionn(position) {
            var userLat = position.coords.latitude;
            var userLng = position.coords.longitude;
            var latLng = clickedMarker.getLatLng();;
            routingControl = L.Routing.control({
              waypoints: [
                L.latLng(userLat, userLng),
                L.latLng(latLng.lat, latLng.lng)
              ],
              routeWhileDragging: true
            }).addTo(map)};

            document.getElementById("deleteRouteBtn").addEventListener("click", function() {
              if (routingControl) {
                map.removeControl(routingControl);
                routingControl = null;
              }
            });   
          }
          </script>
  </body>
</html>

