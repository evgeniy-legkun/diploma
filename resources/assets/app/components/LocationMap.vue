<template>
    <v-map ref="map"
           :style="style.mapSize"
           :options="mapOptions"
           @l-click="saveMarker($event)">
        <v-marker v-for="(marker, key) in markers"
                  :key="`marker_${key}`"
                  :lat-lng="marker.position"
                  :visible="marker.visible"
                  :icon="marker.icon"
                  :draggable="marker.draggable"
                  @l-move="updateMarkerPosition($event, marker)"
                  @l-mouseover="$event.target.openPopup()"
                  @l-click="goToViewPage(marker)"
        >
            <v-popup v-if="marker.tooltip"
                     :content="marker.tooltip">
            </v-popup>
        </v-marker>

        <v-geosearch :options="geoSearchOptions">
        </v-geosearch>

        <v-tilelayer :url="tileLayerOptions.url"
                     :attribution="tileLayerOptions.attribution">
        </v-tilelayer>
    </v-map>
</template>

<script>
  import { mapConfigs } from "../constants/mapConfigs";
  import * as Vue2Leaflet from "vue2-leaflet";
  import { EsriProvider } from "leaflet-geosearch";
  import VGeoSearch from "vue2-leaflet-geosearch";
  import { eventBus } from "../eventBus";
  import leaflet from "leaflet";

  /**
   * Fix bug
   * In beforeDestroy method we could not read property 'removeLayer'
   * because this.parent was not exist
   */
  VGeoSearch.methods.remove = function() {
    if (this.parent) {
      this.parent.removeLayer(this.markerCluster);
    }
  };

  /**
   * Fix problem with showing markers on the map
   */
  delete leaflet.Icon.Default.prototype._getIconUrl;
  leaflet.Icon.Default.mergeOptions({
    iconRetinaUrl: require("leaflet/dist/images/marker-icon-2x.png"),
    iconUrl: require("leaflet/dist/images/marker-icon.png"),
    shadowUrl: require("leaflet/dist/images/marker-shadow.png")
  });

  export default {
    components: {
      "v-map": Vue2Leaflet.Map,
      "v-tilelayer": Vue2Leaflet.TileLayer,
      "v-marker": Vue2Leaflet.Marker,
      "v-popup": Vue2Leaflet.Popup,
      "v-tooltip": Vue2Leaflet.Tooltip,
      "v-geosearch": VGeoSearch
    },

    props: [
      'options',
      'mapCenterPosition',
      'markers'
    ],

    watch: {
      /**
       * After each change of marker array we need to dispatch resize event
       * that fix the bug of vue2-leaflet library when the map not fully rendering
       */
      markers() {
        window.dispatchEvent(new Event("resize"));
      }
    },

    data() {
      return {
        /**
         * @var {object} - scoped styles
         */
        style: {
          mapSize: {
            height: this.options.size.height
          }
        },

        // # Options
        // # -------------------------------------
        /**
         * @var {object} - options for v-geosearch component
         */
        geoSearchOptions: {
          provider: new EsriProvider(),
          showMarker: false,
          popupFormat: (data) => {
            this.saveMarker(data, false);
          },
          autoClose: true,
          searchLabel: "Адреса",
          notFoundMessage: "Hе знайдено"
        },

        /**
         * @var {object} - options for v-map component
         */
        mapOptions: {
          zoom: mapConfigs.zoom,
          minZoom: mapConfigs.minZoom,
          maxZoom: mapConfigs.maxZoom,
          center: this.mapCenterPosition
        },

        /**
         * @var {object} - options for v-tilelayer component
         */
        tileLayerOptions: {
          url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
          attribution: '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        }
      };
    },

    mounted() {
      this.stopPropagationGeoSearch();
      //listening events
      eventBus.$on("pathTo", this.pathTo);

      /**
       * Dispatch resize event that fixed bug of vue2-leaflet library
       * when the map not fully rendering
       */
      setTimeout(function() {
        window.dispatchEvent(new Event("resize"));
      }, 2000);
    },

    methods: {

      /**
       * Go to view page
       *
       * @param {object} marker - current marker's data
       * @return {void}
       */
      goToViewPage(marker) {
        if (marker.hasOwnProperty("routeData")) {
          this.$router.push({
            name: marker.routeData.name,
            params: marker.routeData.params
          });

          /**
           * For open in a new window
           */
          // let routeObject = this.$router.resolve({
          //     name: marker.routeData.name,
          //     params: marker.routeData.params
          // });
          //window.open(routeObject.href, '_blank');
        }
      },

      /**
       * Save a new marker
       *
       * @param {object} data
       * @param {bool} isEventMap - marker is adding from map event or not
       * @return {void}
       */
      saveMarker(data, isEventMap = true) {
        if (isEventMap) {
          this.$emit("savedMarker", {
            position: { lat: data.latlng.lat, lng: data.latlng.lng },
            tooltip: "",
            draggable: true,
            visible: true
          });
        } else {
          this.$emit("savedMarker", {
            position: { lat: data.result.y, lng: data.result.x },
            tooltip: data.result.label,
            draggable: true,
            visible: true
          });
        }
      },

      /**
       * Stop propagation for geoSearch component
       *
       * @return {void}
       */
      stopPropagationGeoSearch() {
        let leafletControlGeoSearch = document.getElementsByClassName("leaflet-control-geosearch")[0];

        if (leafletControlGeoSearch) {
          leafletControlGeoSearch.addEventListener("click", function(e) {
            e.stopPropagation();
          });
        }
      },

      /**
       * Update marker position
       *
       * @param event - event object
       * @param marker - the marker that triggered the event
       */
      updateMarkerPosition(event, marker) {
        this.$set(marker, "position", event.latlng);
      },

      /**
       * Show the needed coordinates
       *
       * @param {object} position - needed position of marker
       * @param {bool} isResetZoom - reset zoom or not
       * @return {void}
       */
      pathTo(position, isResetZoom) {
        let mapObject = this.$refs.map.mapObject;
        mapObject.panTo(position);

        if (isResetZoom) {
          mapObject.setZoom(this.mapOptions.zoom);
        }
      }
    }
  };

</script>