<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Карта складів</h1>
        </section>
        <section class="content">
            <div class="box">
                <div class="box-body" style="height: 550px">
                    <location-map
                            :options="mapOptions"
                            :mapCenterPosition="mapCenterPosition"
                            :markers="markers"
                    />
                </div>
            </div>
        </section>
    </div>
</template>

<script>
  import { mapConfigs } from "../../constants/mapConfigs";
  import locationMap from "../../components/LocationMap";
  import GraphAPI from '../../api/GraphAPI';

  export default {

    components: {
      "location-map": locationMap
    },

    data() {
      return {
        mapOptions: {
          size: {
            height: "100%"
          }
        },

        mapCenterPosition: {
          lat: mapConfigs.mapCenterPosition.latitude,
          lng: mapConfigs.mapCenterPosition.longitude
        },

        markers: [],

        warehouses: []
      };
    },

    created () {
      this.loadWarehouses();
    },

    methods: {
      loadWarehouses() {
        GraphAPI.exec(`
                    query {
                        warehouses {
                            id,
                            name,
                            address,
                            lat_point,
                            lng_point,
                            note
                        }
                    }
                `)
          .then((response) => {
            this.warehouses = response.data.data.warehouses;

            let markersList = [];
            for (const warehouse of this.warehouses) {
              markersList.push({
                routeData: {
                  name: 'warehouse-materials',
                  params: {
                    id: warehouse.id
                  }
                },
                position: {
                  lat: warehouse.lat_point,
                  lng: warehouse.lng_point
                },
                tooltip: warehouse.name,
                draggable: false,
                visible: true
              });
            }
            this.markers = markersList;
          });
      }
    }
  };

</script>
