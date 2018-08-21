<template>
    <section class="content">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Стоворити склад</h3>
            </div>

            <form role="form">

                <div class="box-body">
                    <div class="form-group">
                        <label>Із складу</label>
                        <select v-model="fromWarehouse" class="form-control">
                            <option v-for="warehouse in warehouses" :value="warehouse.id">
                                {{warehouse.name}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>В склад</label>
                        <select v-model="toWarehouse" class="form-control">
                            <option v-for="warehouse in warehouses" :value="warehouse.id">
                                {{warehouse.name}}
                            </option>
                        </select>
                    </div>

                    <h3 v-if="warehouseMaterials.length > 0">Матеріали</h3>

                    <template v-for="warehouseMaterial in warehouseMaterials">
                        <div class="form-group">
                            <label>{{warehouseMaterial.name}} ({{warehouseMaterial.quantity}} {{units[warehouseMaterial.unit]}})</label>
                            <input class="form-control" type="number" value="0" min="0" :max="warehouseMaterial.quantity">
                        </div>
                    </template>

                </div>

                <div class="box-footer">
                    <button @click.prevent="saveMaterial" type="submit" class="btn btn-primary">Створити</button>
                </div>
            </form>
        </div>

    </section>
</template>

<script>

    import GraphAPI from '../../api/GraphAPI';
    import measurementUnits from '../../constants/materialUnits';

    export default {
        data() {
            return {
                courierId: this.$route.params.courierId,
                warehouses: [],
                courier: null,
                units: measurementUnits,

                fromWarehouse: null,
                toWarehouse: null,
                warehouseMaterials: []
            }
        },

        watch: {
            fromWarehouse(warehouseId) {
                this.warehouseMaterials = [];
                if (warehouseId) {
                    let warehouse = this.getWarehouseById(warehouseId);
                    if (warehouse) {
                        this.warehouseMaterials = warehouse.materials;
                    }
                }
            }
        },

        methods: {

            getWarehouseById(warehouseId) {
                for(let warehouse of this.warehouses) {
                    if (warehouse.id == warehouseId) {
                        return warehouse;
                    }
                }
            },

            loadData() {
                GraphAPI.exec(`
                    query {
                      warehouses {
                        id, name,
                        materials { id, name, unit, quantity }
                      }
                    }
                `).then(response => {
                    this.warehouses = response.data.data.warehouses;
                });
            },

        },

        created() {
            this.loadData();
        }

    }
</script>