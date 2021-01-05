<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Querying features</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />

    <!-- Load Leaflet from CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

    <!-- Load Esri Leaflet from CDN -->
    <script src="https://unpkg.com/esri-leaflet@2.5.2/dist/esri-leaflet.js" integrity="sha512-vC48cQq5LmjsPvqNIIoED0aUZ8POSJ0Z1mVexOqjVjAsJo32QUoT/2Do4kFKJjuPLIonpb/Hns7EqZ1LrlwSzw==" crossorigin=""></script>

    <!-- Load Esri Leaflet Renderers plugin to use feature service symbology -->
    <script src="https://unpkg.com/esri-leaflet-renderers@2.1.2" integrity="sha512-/McnqdlwYvfeOEWqoniEagFRQnLi/TNbkHe4EJypmZI02LBT7vBU/+PZ5W3FSsFFlRbnMCsJvnbp5MX8XOBrnQ==" crossorigin=""></script>

    <style> body { margin:0; padding:0; } #map { position: absolute; top:0; bottom:0; right:0; left:0; } </style>
</head>
<body>

<style> #query { position: absolute; top: 10px; right: 10px; z-index: 1000; background: white; padding: 1em; } #query select { font-size: 16px; } </style>

<div id="map"></div>

<div id="query" class="leaflet-bar">
    <label>
        Zoning District:
        <select id="district">
            <!-- make sure to encase string values in single quotes for valid sql -->
            <option value="1=1">Any</option>
            <option value="ZONE_SMRY='OPEN SPACE'">Open Space</option>
            <option value="ZONE_SMRY='AGRICULTURE'">Agriculture</option>
            <option value="ZONE_SMRY='RESIDENTIAL'">Residential</option>
            <option value="ZONE_SMRY='COMMERCIAL'">Commercial</option>
            <option value="ZONE_SMRY='INDUSTRIAL'">Industrial</option>
            <option value="ZONE_SMRY='PARKING'">Parking</option>
            <option value="ZONE_SMRY='PUBLIC FACILITY'">Public Facility</option>
        </select>
    </label>
</div>

<script>
var map = L.map('map').setView([21.516734,39.2583899], 20);
L.esri.basemapLayer('Gray').addTo(map);
var zoning = L.esri.featureLayer({
    url: 'https://services5.arcgis.com/7nsPwEMP38bSkCjy/arcgis/rest/services/TEST_PYTHON_ZONING/FeatureServer/1',
    simplifyFactor: 0.5, precision: 4
}).addTo(map);


var zoningDistrict = document.getElementById('district');
zoningDistrict.addEventListener('change', function () {
    zoning.setWhere(zoningDistrict.value);
});

</script>

</body>
</html>