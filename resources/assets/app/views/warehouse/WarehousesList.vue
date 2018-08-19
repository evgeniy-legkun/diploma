<template>
    <section class="content">

        <div class="nav-tabs-custom">
            <WarehouseTabs activeTab="warehouses"></WarehouseTabs>
            <div class="tab-content">
                <div class="tab-pane active">
                    <br/>

                    <div class="row">
                        <div class="col-md-12">
                            <router-link :to="{name: 'warehouse-create'}" class="btn btn-success">Створити склад</router-link>
                        </div>
                    </div>

                    <br/>

                    <table class="table table-bordered">

                        <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Склад</th>
                                <th>Адреса</th>
                                <th>Опис</th>
                                <th>Редагувати</th>
                                <th>Видалити</th>
                            </tr>

                            <template v-for="warehouse in warehouses">
                                <tr>
                                    <td>{{warehouse.id}}</td>
                                    <td><router-link :to="{name: 'warehouse-materials', params: {id: warehouse.id}}">{{warehouse.name}}</router-link></td>
                                    <td>{{warehouse.name}}</td>
                                    <td>{{warehouse.note}}</td>
                                    <td><router-link :to="{name: 'warehouse-edit', params: {id: warehouse.id}}" class="btn btn-warning">Редагвати</router-link></td>
                                    <td><button @click.prevent="removeWarehouse(warehouse.id)" class="btn btn-danger">Видалити</button></td>
                                </tr>
                            </template>
                        </tbody>

                    </table>

                </div>
            </div>
        </div>


    </section>

</template>

<script>

    import GraphAPI from '../../api/GraphAPI';

    export default {

        components: {
            'WarehouseTabs': require('./WarehouseTabs')
        },

        data() {
            return {
                warehouses: [],
            };
        },

        methods: {

            removeWarehouse(warehouseId) {
                GraphAPI.exec(`
                    mutation {
                        removeWarehouse(id: ${warehouseId}) { id }
                    }
                `).then((response) => {
                    this.loadWarehouses();
                });
            },

            loadWarehouses() {
                GraphAPI.exec(`
                    query {
                        warehouses {
                            id,
                            name,
                            address,
                            note
                        }
                    }
                `).then((response) => {

                    this.warehouses = response.data.data.warehouses;

                });

            }
        },

        created() {
            this.loadWarehouses();
        }
    }
</script>