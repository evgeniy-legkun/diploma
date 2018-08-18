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

    import GraphAPI from '../../api/GraphAPI';

    export default {
        data() {
            return {
                warehouseId: this.$route.params.id,
                address: '',
                name: '',
                note: '',
            }
        },

        methods: {

            loadWarehouse(warehouseId) {
                GraphAPI.exec(`
                    query {
                      warehouse(id: ${warehouseId}) {
                        name,
                        address,
                        note
                      }
                    }
                `).then((response) => {
                    console.log(response);
                    let warehouse = response.data.data.warehouse;
                    this.name = warehouse.name;
                    this.address = warehouse.address;
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
                            note: "${this.note}",
                        ) {
                            id
                        }
                    }
                `).then((response) => {
                    this.$router.push({name: 'warehouses-list'})
                });

            },
        },

        created() {
            this.loadWarehouse(this.warehouseId);
        }
    }

</script>