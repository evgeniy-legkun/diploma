<template>
    <section class="content">

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Список матеріалів в складі <b>{{warehouseName}}</b></h3>
            </div>
            <div class="box-body">
                <router-link class="btn btn-success" :to="{name: 'warehouse-material-add', params: {id: warehouseId}}" >Додати матеріал</router-link>
                <br />
                <br />

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Матеріал</th>
                            <th>Одиниця вимірювання</th>
                            <th>Кількість</th>
                            <th>Видалити</th>
                        </tr>

                        <template v-for="warehouseMaterial of warehouseMaterials">
                            <tr>
                                <td>{{warehouseMaterial.id}}</td>
                                <td>{{warehouseMaterial.name}}</td>
                                <td>{{units[warehouseMaterial.unit]}}</td>
                                <td>{{warehouseMaterial.quantity}}</td>
                                <td><button @click.prevent="removeMaterial(warehouseMaterial.id, warehouseMaterial.quantity)" class="btn btn-danger">Видалити</button></td>
                            </tr>
                        </template>

                    </tbody>
                </table>
            </div>

        </div>

    </section>
</template>

<script>

    import GraphAPI from '../../api/GraphAPI';
    import measurementUnits from '../../constants/materialUnits';

    export default {
        data() {
            return {
                units: measurementUnits,
                warehouseId: this.$route.params.id,
                warehouseName: '',
                warehouseMaterials: [],
            }
        },

        methods: {

            removeMaterial(materialId, quantity) {

                GraphAPI.exec(`
                    mutation {
                        removeWarehouseMaterial(
                            warehouseId: ${this.warehouseId},
                            materialId: ${materialId},
                            quantity: ${quantity}
                        ) {
                            id
                        }
                    }
                `).then((response) => {
                    this.loadWarehouseMaterials();
                });

            },

            loadWarehouseMaterials() {
                GraphAPI.exec(`
                    query {
                        warehouse(id: ${this.warehouseId}) {
                            id,
                            name,
                            materials {
                                id,
                                name,
                                unit,
                                quantity
                            }
                        }
                    }
                `).then((response) => {
                    let responseData = response.data.data.warehouse;
                    this.warehouseName = responseData.name;
                    this.warehouseMaterials = responseData.materials;
                });
            }
        },

        created() {
            this.loadWarehouseMaterials();
        }
    }

</script>