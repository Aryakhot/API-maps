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