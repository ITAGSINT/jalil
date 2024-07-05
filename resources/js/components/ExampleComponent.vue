<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div id='map' class=' border border-secondary rounded' style='height:400px; width:100%;'></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Echo from 'laravel-echo';

export default {
    props: ['order', 'customer', 'driver'],
    data() {
        return {
            map: null,
            marker: null,
            center: null,
            data: null,
            directionsService: null,
            directionsRenderer: null,
            locationButton: null,
            customerPos: this.parseCoordinates(this.customer),
            driverPos: this.parseCoordinates(this.driver)
        };
    },
    methods: {
        parseCoordinates(coords) {
            const [lat, lng] = coords.split(',').map(parseFloat);
            return { lat, lng };
        },
        MapInit() {
            this.directionsService = new google.maps.DirectionsService();
            this.directionsRenderer = new google.maps.DirectionsRenderer();

            this.map = new google.maps.Map(document.getElementById("map"), {
                zoom: 4,
                center: this.customerPos,
            });

            this.directionsRenderer.setMap(this.map);

            this.calculateAndDisplayRoute();

            this.locationButton = document.createElement("button");
            this.locationButton.textContent = "Pan to Current Location";
            this.locationButton.classList.add("custom-map-control-button");
            this.map.controls[google.maps.ControlPosition.TOP_CENTER].push(this.locationButton);

            this.locationButton.addEventListener("click", () => {
                this.map.setCenter(this.customerPos);
            });

            this.marker = new google.maps.Marker({
                map: this.map,
                position: this.driverPos,
                title: "Driver",
                animation: 'bounce',
            });
        },
        calculateAndDisplayRoute() {
            this.directionsService.route({
                origin: this.customerPos,
                destination: this.driverPos,
                travelMode: google.maps.TravelMode.TWO_WHEELER,
            }).then((response) => {
                this.directionsRenderer.setDirections(response);
            }).catch((e) => window.alert("Directions request failed due to " + e));
        },
        updateMap() {
            let newPos = this.parseCoordinates(`${this.data}`);
            // this.map.setCenter(newPos);
            this.marker.setPosition(newPos);
        },
        initMap() {
            if (typeof google !== 'undefined') {
                this.MapInit();
            } else {
                window.initMap = () => {
                    this.MapInit();
                };
            }
        }
    },
    mounted() {
        this.initMap();
    },
    created() {
axios
    .post("/test_token", {

    })
    .then(({ data }) => {

        window.axios.defaults.headers.common['Authorization'] = "Bearer " + data;
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: 'bd8bdeb106c17e8e2721',
            cluster: 'us2',
            // forceTLS: true,
            encrypted: true,
            // auth: {
            //     headers: {
            //         Authorization: 'Bearer ${Token}',
            //     },
            // },
            authorizer: (channel, options) => {
                return {
                    authorize: (socketId, callback) => {
                        axios.post("/broadcasting/auth", {
                            // method: "POST",
                            socket_id: socketId,
                            channel_name: channel.name

                        })
                            .then(response => {
                                callback(false, response.data);
                            })
                            .catch(error => {
                                callback(true, error);
                            });
                    }
                };
            },
        });
        window.Echo.private(`order-${this.order}`)
            // .listen('client-event', (e) => {
            //     this.data = e.location;
            //     this.updateMap();
            //     console.log(e);
            //     console.log('ggggg');
            // })
            .listenToAll((event, e) => {
                this.data = e;
                this.updateMap();
                // console.log(event, e);
            });
    })
    }
};
</script>
