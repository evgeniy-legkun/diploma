<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Карта перевезень</h1>
        </section>
        <section class="content">
            <div class="box">
                <div class="box-body" style="height: 550px">
                    <location-map :options="mapOptions"
                                  :mapCenterPosition="mapCenterPosition"
                                  :markers="markers">
                    </location-map>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import { mapConfigs } from '../../constants/mapConfigs';
    import locationMap from '../../components/LocationMap';

    export default {

        components: {
            'location-map': locationMap
        },

        data() {
            return {

                /**
                 * @var {object} - map options
                 */
                mapOptions: {
                    size: {
                        height: '100%'
                    }
                },

                /**
                 * @var {object} - map center position
                 */
                mapCenterPosition: {
                    lat: mapConfigs.mapCenterPosition.latitude,
                    lng: mapConfigs.mapCenterPosition.longitude
                },

                /**
                 * @var {array} - list of markers
                 */
                markers: []
            }
        },

        methods: {

        }
    }

</script>
