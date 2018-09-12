<template>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Редагувати склад</h3>
            </div>

            <div class="box-body">
                <div class="form-group">
                    <label>Назва</label>
                    <input v-model="name" type="text" class="form-control" placeholder="Назва">
                </div>

                <div class="form-group">
                    <label>Адреса</label>
                    <input v-model="address" type="text" class="form-control" placeholder="Адрес">
                </div>
                <div class="form-group">
                    <label>Локація</label>
                    <!--  Choose location  -->
                    <ChooseLocation @updatedLocationPoint="updateLocationPoint"
                                    :currentLocationPoint="locationPoint">
                    </ChooseLocation>
                </div>
                <br>
                <br>
                <div class="form-group">
                    <label>Опис</label>
                    <textarea v-model="note" class="form-control"></textarea>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button @click.prevent="saveWarehouse" type="submit" class="btn btn-primary">Редагувати</button>
            </div>

        </div>

    </section>
</template>

<script>
  import GraphAPI from "../../api/GraphAPI";
  import ChooseLocation from "../../components/ChooseLocation";

  export default {
    components: {
      ChooseLocation
    },

    data() {
      return {
        warehouseId: this.$route.params.id,
        address: "",
        name: "",
        locationPoint: {
          latitude: null,
          longitude: null
        },
        note: ""
      };
    },

    methods: {
      updateLocationPoint(position) {
        if (position) {
          this.locationPoint.latitude = position.lat;
          this.locationPoint.longitude = position.lng;

          return;
        }

        this.locationPoint.latitude = null;
        this.locationPoint.longitude = null;
      },

      loadWarehouse(warehouseId) {
        GraphAPI.exec(`
                    query {
                      warehouse(id: ${warehouseId}) {
                        name,
                        address,
                        lat_point,
                        lng_point,
                        note
                      }
                    }
                `).then((response) => {
          let warehouse = response.data.data.warehouse;

          this.name = warehouse.name;
          this.address = warehouse.address;
          this.locationPoint.latitude = warehouse.lat_point;
          this.locationPoint.longitude = warehouse.lng_point;
          this.note = warehouse.note;
        });
      },

      saveWarehouse() {
        GraphAPI.exec(`
                    mutation {
                        updateWarehouse(
                            id: ${this.warehouseId},
                            name: "${this.name}",
                            address: "${this.address}",
                            lat_point: "${this.locationPoint.latitude}"
                            lng_point: "${this.locationPoint.longitude}"
                            note: "${this.note}",
                        ) {
                            id
                        }
                    }
                `).then((response) => {
          this.$router.push({ name: "warehouses-list" });
        });

      }
    },

    created() {
      this.loadWarehouse(this.warehouseId);
    }
  };

</script>