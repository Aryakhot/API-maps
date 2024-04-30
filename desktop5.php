<?php
$servername ="localhost";
$username = "root";
$password ="";
$dbname = "responsiveform1";

$conn = mysqli_connect($servername,$username,$password,$dbname);

if($conn)
{
    echo "connection ok";
}
else 
{
    echo "connection failed";
}

?>

<div class="Desktop5" style="width: 1428px; height: 902px; position: relative; background: white; display:flex">
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Custom Map with Pet Day Care Centers</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <style>
    
    #map {
      display:flex;
      width: 1300px;
      height: 530px;
      position: absolute;
      left: 41px;
      top: 105px;
      z-index: 1;
    }

    .custom-marker {
      background-color: red;
      width: 20px;
      height: 20px;
      border-radius: 50%;
    }

    .highlight-marker {
      background-color: yellow;
    }

    .search-marker {
      background-color: blue;
    }

    #search-bar {
      position: absolute;
      top: 20px;
      left: 500px;
      z-index: 1000;
      width: 300px;
      height:50px
    }

    .autocomplete-items {
      position: absolute;
      z-index: 1001;
      border: 1px solid #d4d4d4;
      max-height: 150px;
      overflow-y: auto;
      background: white;
      margin-top: 5px;
      width: calc(100% - 1200px); /* Adjusted the width to match the search bar width */
      top: 70px; /* Adjusted the top position to move the suggestions below the search bar */
      left: 500px;
    }

    .autocomplete-item {
      padding: 8px;
      cursor: pointer;
    }

    .autocomplete-item:hover {
      background-color: #f5f5f5;
    }
    
    .bi-arrow-left-circle-fill,
.svg-arrow {
    left: 20px;
  position: relative;
  z-index: 2; /* Set a higher z-index value to bring the arrow on top */
  top:14px
}

.arrow-container a {
  text-decoration: none;
  color: inherit; /* Inherit the color from the parent container */
  cursor: pointer; /* Show the hand cursor on hover */
}
   
.arrow-container {
      position: relative;
      top: 4px;
    }

    .arrow-container svg {
      width: 24px; /* Adjusted size to 24px */
      height: auto;
    }

    .arrow-container a {
      text-decoration: none;
      color: black;
      cursor: pointer;
    }


  </style>
</head>
<body style="margin: 0; overflow: hidden; display: flex; flex-direction: column; height: 100vh;">

  
<div class="arrow-container" style="position: absolute; left: /* adjust as needed */; top: /* adjust as needed */;">
  <a href="javascript:history.back()">
<i class="bi bi-arrow-left-circle-fill"></i>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">  
  <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
   </svg>
   </a>
</div>
     
  <div id="map"></div>
  <input type="text" id="search-bar" placeholder="Search for a Pet Day Care Center" style=" left: 500px; text-align: center; position: absolute ;border-radius:50px ">
  
  <script>
    // Your existing code...

    // Initialize the map
    const map = L.map('map');
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Set the map view to the default location (Piya & Mia Pet care)
    map.setView([19.01610967555285, 73.00992059557919], 12);

    // Add red markers for each location
    const redMarker1 = L.marker([19.016200965507537, 73.00986695139996], {
      icon: L.divIcon({
        className: 'custom-marker',
        html: '<div style="background-color: red; width: 20px; height: 20px; border-radius: 50%;"></div>',
      }),
    }).addTo(map);

    const redMarker2 = L.marker([19.011604628900333, 73.03149328023568], {
      icon: L.divIcon({
        className: 'custom-marker',
        html: '<div style="background-color: red; width: 20px; height: 20px; border-radius: 50%;"></div>',
      }),
    }).addTo(map);

    const redMarker3 = L.marker([19.024669110287668, 73.03526108393794], {
      icon: L.divIcon({
        className: 'custom-marker',
        html: '<div style="background-color: red; width: 20px; height: 20px; border-radius: 50%;"></div>',
      }),
    }).addTo(map);

    const redMarker4 = L.marker([19.07884889759176, 73.0764412863172], {
      icon: L.divIcon({
        className: 'custom-marker',
        html: '<div style="background-color: red; width: 20px; height: 20px; border-radius: 50%;"></div>',
      }),
    }).addTo(map);

    const redMarker5 = L.marker([19.016864710242203, 73.1275963756375], {
      icon: L.divIcon({
        className: 'custom-marker',
        html: '<div style="background-color: red; width: 20px; height: 20px; border-radius: 50%;"></div>',
      }),
    }).addTo(map);

    const redMarker6 = L.marker([19.126599041806337, 72.99404382403522], {
      icon: L.divIcon({
        className: 'custom-marker',
        html: '<div style="background-color: red; width: 20px; height: 20px; border-radius: 50%;"></div>',
      }),
    }).addTo(map);

    let searchMarker = null;

    // Replace the following with your pet day care dataset
    const petDayCareData = [
      { name: 'Piya & Mia Pet Care', lat: 19.016200965507537, lon: 73.00986695139996, address: 'H no 0765, back side A-102, Ganesh apartment Gaon devi mandir karave Village poddar school, gaon, near gaondevi temple, Seawood, Seawoods, Maharashtra 400706', mapLink: 'https://maps.app.goo.gl/RVhzG7FFEgkoYfm16' },
      { name: 'Canine Home', lat: 19.011604628900333, lon: 73.03149328023568, address: '1A, Krishna Vihar, G96, Sector 20, CBD Belapur, Navi Mumbai, Maharashtra 400614', mapLink: 'https://maps.app.goo.gl/RQycGi9xEhGer2pA6' },
      { name: 'Pawss Inn', lat: 19.024669110287668, lon: 73.03526108393794, address: 'C Teja signature, Flat no 504, Sector 30/31, Mumb, CBD Belapur, Navi Mumbai, Maharashtra 400614', mapLink: 'https://maps.app.goo.gl/6eHGfTQatYYAKuWm6' },
      { name: 'Tiny Tails', lat: 19.07884889759176, lon: 73.0764412863172, address: 'A-2001, Galaxy Orion, Plot No. 50, Sector 35D, Sector 34C, Kutak Bandhan, Kharghar, Navi Mumbai, Maharashtra 410210', mapLink: 'https://maps.app.goo.gl/Gd2VjjpmrAo2LcDC9' },
      { name: 'Dog Care in Home', lat: 19.016864710242203, lon: 73.1275963756375, address: 'Home no 432, Adai Rd, New Panvel East, Panvel, Nere, Navi Mumbai, Maharashtra 410206', mapLink: 'https://maps.app.goo.gl/jMuVrVpWqR2KZ5Vm6' },
      { name: 'Diamond Paws', lat: 19.126599041806337, lon: 72.99404382403522, address: 'B/1802, cloud 36 ,ghansoli, sector 11, Palm Beach Rd, Navi Mumbai, Maharashtra 410218', mapLink: 'https://maps.app.goo.gl/nvjcPChV2VhxoRtS7' },
      // Add more entries as needed
    ];

    // Add custom markers for each pet day care center
    petDayCareData.forEach(data => {
      const marker = L.marker([data.lat, data.lon]).addTo(map);
      marker.bindPopup(`<b>${data.name}</b><br>${data.address}<br><a href="${data.mapLink}" target="_blank">Get Directions</a>`);
    });

    // Create an array to store names of pet day care centers for autocomplete
    const petNames = petDayCareData.map(data => data.name);

    // Autocomplete function
    function autocomplete(input, arr, map) {
      let currentFocus;

      input.addEventListener("input", function (e) {
        const value = this.value;
        closeAllLists();
        if (!value) {
          return false;
        }
        currentFocus = -1;

        const suggestions = arr.filter(name => name.toLowerCase().includes(value.toLowerCase()));
        const autocompleteList = document.createElement("div");
        autocompleteList.setAttribute("id", "autocomplete-list");
        autocompleteList.setAttribute("class", "autocomplete-items");

        input.parentNode.appendChild(autocompleteList);

        suggestions.forEach((suggestion, index) => {
          const suggestionItem = document.createElement("div");
          suggestionItem.classList.add("autocomplete-item");
          suggestionItem.innerHTML = `<strong>${suggestion.substr(0, value.length)}</strong>${suggestion.substr(value.length)}`;
          suggestionItem.addEventListener("click", function (e) {
            input.value = this.innerText;
            closeAllLists();

            // Find the corresponding pet day care data
            const selectedPlace = petDayCareData.find(data => data.name === this.innerText);

            // Highlight the selected place on the map
            highlightPlaceOnMap(selectedPlace, map);
          });
          autocompleteList.appendChild(suggestionItem);
        });
      });

      function closeAllLists() {
        const autocompleteList = document.getElementById("autocomplete-list");
        if (autocompleteList) {
          autocompleteList.parentNode.removeChild(autocompleteList);
        }
      }

      document.addEventListener("click", function (e) {
        closeAllLists();
      });
    }

    function highlightPlaceOnMap(place, map) {
      // Clear existing highlights
      map.eachLayer(layer => {
        if (layer instanceof L.Marker && layer !== searchMarker) {
          layer.setIcon(L.divIcon({
            className: 'custom-marker',
            html: '<div style="background-color: red; width: 20px; height: 20px; border-radius: 50%;"></div>',
          }));
        }
      });

      // Highlight the selected place
      if (searchMarker) {
        map.removeLayer(searchMarker);
      }
      searchMarker = L.marker([place.lat, place.lon], {
        icon: L.divIcon({
          className: 'custom-marker highlight-marker search-marker',
          html: '<div style="background-color: blue; width: 20px; height: 20px; border-radius: 50%;"></div>',
        }),
      }).addTo(map);

      // Fly to the highlighted place on the map
      map.flyTo([place.lat, place.lon], 14);

      // Open popup with details of the selected place
      searchMarker.bindPopup(`<b>${place.name}</b><br>${place.address}<br><a href="${place.mapLink}" target="_blank">Get Directions</a>`).openPopup();
    }

    // Attach autocomplete to the search bar
    const searchBar = document.getElementById("search-bar");
    autocomplete(searchBar, petNames, map);
  </script>

     
     <div class="Home" style="width: 134px; height: 18px; left: 1166px; top: 30px; position: absolute; color: black; font-size: 25px; font-family: Inter; font-weight: 400; word-wrap: break-word;z-index: 2 "><a href="http://localhost/learningphp/desktop1.php" style="color:black">Home</a></div>
     
   </div>
   
   <div class="Rectangle52" style="width: 1px; height: 1px; left: 0px; top: 0px; position: absolute; background: #D9D9D9"></div>
   <div class="petconnect" style="width: 150px; height: 197px; left: 70px; top: 20px; position: absolute; color:black;z-index: 2; font-size: 45px; font-family: Frank Ruhl Libre; font-weight: 400; word-wrap: break-word">
      Pet Connect</div>
      <div class="Rectangle54"
      style="width: 1441px; height: 120px; left: 0px; top: 1px; position: absolute; background:  rgba(124.84, 149.81, 130.34, 0.70)"></div>

      </body>

</html>

