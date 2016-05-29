<?php include 'view/head.php'; ?>
        <link rel="stylesheet" href="../main.css">
<?php include 'view/header.php'; ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAFY1B5q6i0M6emixiyYQMpyiBpRmPugXw"></script>
<?php include '/view/navigation.php'; ?>

<style>
  #gmap_canvas img {
      max-width:none!important;
      background:none!important
      }
</style>

        <section>
            <div>
                <p>
                    We are located on Main Street in Sweet Home at:
                    <a href="https://www.google.com/maps/place/2281+Main+St,+Sweet+Home,+OR+97386/@44.3995848,-122.7192477,17z/data=!3m1!4b1!4m5!3m4!1s0x54c088508d3bde91:0x123d8595010d662c!8m2!3d44.399581!4d-122.717059" target="_blank">
                        <address>
                            2281 Main Street<br>
                            Sweet Home, OR 97386
                        </address>
                    </a><br>
                </p>
            </div>
            
            <div style="text-align: center">
                <div style='overflow:hidden;height:400px;width:850px;'>
                    <div id='gmap_canvas' style='height:400px;width:850px;'></div>
                    <div>
                        <small><a href="https://termsofusegenerator.net">terms of use example</a></small>
                    </div>
                </div>
                <script type='text/javascript'>
                    function init_map() {
                        var myOptions = {
                            zoom: 18,
                            center: new google.maps.LatLng(44.399581,-122.717059),
                            mapTypeId: google.maps.MapTypeId.SATELLITE
                            };
                            
                            map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);
                            
                            marker = new google.maps.Marker({
                                map: map,
                                position: new google.maps.LatLng(44.399581,-122.717059)
                            });
                            
                            infowindow = new google.maps.InfoWindow({
                                content:'<strong>All Star Auctions</strong><br>2281 Main St Sweet Home, OR 97386<br>'
                            });
                            
                            google.maps.event.addListener(marker, 'click', function(){
                                infowindow.open(map,marker);
                            });
                            
                            infowindow.open(map,marker);
                        }
                            
                        google.maps.event.addDomListener(window, 'load', init_map);
                </script>
            </div>
        </section>

<?php include '/view/footer.php'; ?>