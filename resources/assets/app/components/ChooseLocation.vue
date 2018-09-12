<template>

    <div>
        <div style="padding-left: 0" class="col-sm-2 show-modal">
            <button @click.prevent="toggleModal" class="btn btn-success" type="submit">
                Виберіть локацію
            </button>
        </div>

        <transition v-if="showModal" name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">

                        <div class="modal-header">
                            <h3>Локація</h3>
                        </div>

                        <div class="modal-body">
                            <location-map :options="mapOptions"
                                          :mapCenterPosition="mapCenterPosition"
                                          :markers="current.markers"
                                          @savedMarker="saveMarker">
                            </location-map>
                        </div>

                        <div class="modal-footer">
                            <button @click.prevent="savePosition" class="btn btn" type="submit">
                                Зберегти маркер
                            </button>
                            <button @click.prevent="removeMarker" class="btn btn" type="submit">
                                Видалити маркер
                            </button>
                            <button @click.prevent="toggleModal" class="btn btn" type="submit">
                                Закрити
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
  import { mapConfigs } from '../constants/mapConfigs';
  import locationMap from "./LocationMap";

  export default {

    components: {
      "location-map": locationMap
    },

    props: [
      "currentLocationPoint"
    ],

    computed: {

      /**
       * Return center position for map
       *
       * @return {object} - map center position
       */
      mapCenterPosition: function() {
        if (this.currentLocationPoint.latitude
          && this.currentLocationPoint.longitude) {
          //Add current marker if it not exists
          if (this.current.markers.length === 0) {
            this.saveMarker({
              position: {
                lat: this.currentLocationPoint.latitude,
                lng: this.currentLocationPoint.longitude
              },
              tooltip: "",
              draggable: true,
              visible: true
            });
          }

          return {
            lat: this.currentLocationPoint.latitude,
            lng: this.currentLocationPoint.longitude
          };
        }

        return this.centerPosition;
      }
    },

    data() {
      return {
        /**
         * @var {bool} - show and hide modal
         */
        showModal: false,

        /**
         * @var {object} - map options
         */
        mapOptions: {
          size: {
            height: "600px"
          }
        },

        /**
         * @var {object} - map center position
         */
        centerPosition: {
          lat: mapConfigs.mapCenterPosition.latitude,
          lng: mapConfigs.mapCenterPosition.longitude
        },

        /**
         * @var {object} - current markers
         */
        current: {
          markers: []
        }
      };
    },

    methods: {

      /**
       * Toggle modal
       *
       * @return {void}
       */
      toggleModal() {
        this.showModal = !this.showModal;
      },

      /**
       * Save a new marker
       *
       * @param {object} data - object of new marker
       * @return {void}
       */
      saveMarker(data) {
        if (this.current.markers.length >= 1) {
          this.current.markers = [];
        }

        this.current.markers = [data];
      },

      /**
       * Remove selected marker
       *
       * @return {void}
       */
      removeMarker() {
        if (this.current.markers.length) {
          this.current.markers = [];
          //Remove current location point
          this.currentLocationPoint.latitude = null;
          this.currentLocationPoint.longitude = null;
        }
      },

      /**
       * Save selected position
       *
       * @return {void}
       */
      savePosition() {
        let marker = {};
        let position = null;

        if (this.current.markers.length !== 0) {
          marker = this.current.markers[0];
          position = marker.position;
        }

        this.$emit("updatedLocationPoint", position);
        //Close modal
        this.toggleModal();
      }
    }
  };

</script>