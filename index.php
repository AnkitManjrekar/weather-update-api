<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Weather App</title>
</head>

<body>
    <header class="text-center py-1">
        <h1 class="text-white">Weather App</h1>
    </header>
    <main>
        <form class="search_div">
            <h3>City</h3>
            <input type="text" class="search_box">
            <button class="search_btn">SET</button>
        </form>
        <div class="desc_div">
            <div class="img_div" style="display: none;">
                <img src="weather-icon.png" class="img" />
            </div>
            <div class="info" style="display: none;">
                <h3 class="temperature">23°</h3>
                <h4 class="climate">Clouds</h4>
                <p class="date">Sunday, July 21</p>
            </div>
            <h1 class="no_data_msg" style="display: none;">City Not Found</h1>
            <h1 class="search_by_msg">Search By City</h1>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        // Get Elements
        let img_div = document.querySelector(".img_div")
        let info = document.querySelector(".info")
        let no_data_msg = document.querySelector(".no_data_msg")
        let search_by_msg = document.querySelector(".search_by_msg")
        let img = document.querySelector(".img")
        let temperature = document.querySelector(".temperature")
        let climate = document.querySelector(".climate")
        let date = document.querySelector(".date")


        document.querySelector('.search_div').addEventListener('submit', (e) => {
            e.preventDefault()
            let text = document.querySelector(".search_box").value
            let data = {
                city: text.toLowerCase()
            }

            fetch("http://localhost/weather-update-api/api.php", {
                method: 'POST',  // Default method is GET, so this could be omitted if not needed
                headers: {
                    'Content-Type': 'application/json'  // Assuming the server responds with JSON
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    search_by_msg.style.display = "none";
                    if (data.status) {
                        data = JSON.parse(data["data"])

                        // Temperature
                        const temperatureKelvin = data.main.temp;
                        const temperatureCelsius = parseInt(temperatureKelvin - 273.15);
                        // Weather Condition
                        const climate_info = data.weather[0].main;
                        // Date
                        const timestamp = data.dt;
                        // Image
                        const iconCode = data.weather[0].icon;
                        const iconUrl = `https://openweathermap.org/img/wn/${iconCode}@2x.png`;

                        // Update
                        img_div.style.display = "flex";
                        info.style.display = "flex";
                        no_data_msg.style.display = "none";
                        img.src = iconUrl
                        temperature.textContent = temperatureCelsius + "°C";
                        climate.textContent = climate_info
                        date.textContent = formatDate(timestamp)

                        console.log(data);

                    } else {
                        no_data_msg.style.display = "block";
                        img_div.style.display = "none";
                        info.style.display = "none";
                        console.log(data);
                    }

                })
                .catch(error => {
                    console.error('Error:', error);  // Handle any errors
                })
        })

        function formatDate(timestamp) {
            const date = new Date(timestamp * 1000); // Convert to milliseconds

            // Format the date as "Sunday, July 21"
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const formattedDate = date.toLocaleDateString('en-US', options);

            // Extract only "Sunday, July 21"
            const formattedDateString = formattedDate.split(', ').slice(0, 2).join(', ');

            return formattedDateString;
        }
    </script>
</body>

</html>