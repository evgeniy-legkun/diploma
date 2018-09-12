<template>

    <section class="content">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Створити склад</h3>
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
                <button @click.prevent="saveWarehouse" type="submit" class="btn btn-primary">Створити</button>
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

      saveWarehouse() {
        GraphAPI.exec(`
                    mutation {
                        createWarehouse(
                            address: "${this.address}",
                            name: "${this.name}",
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
    }
  };

</script>