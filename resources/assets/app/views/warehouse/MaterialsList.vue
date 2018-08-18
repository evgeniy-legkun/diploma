<template>

    <section class="content">

        <div class="nav-tabs-custom">
            <WarehouseTabs activeTab="materials"></WarehouseTabs>
            <div class="tab-content">
                <div class="tab-pane active">
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <router-link :to="{name: 'material-create'}" class="btn btn-success">Створити матеріал</router-link>
                        </div>
                    </div>
                    <br/>

                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Матеріал</th>
                            <th>Одиниці вимірювання</th>
                            <th>Редагувати</th>
                            <th>Видалити</th>
                        </tr>

                            <template v-for="material in materials">
                                <tr>
                                    <td style="width: 10px">{{material.id}}</td>
                                    <td>{{material.name}}</td>
                                    <td>{{units[material.unit]}}</td>
                                    <td><router-link :to="{name: 'material-edit', params: {id: material.id}}" class="btn btn-warning">Редагувати</router-link></td>
                                    <td><button @click.prevent="removeMaterial(material.id)" class="btn btn-danger">Видалити</button></td>
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
    import measurementUnits from '../../constants/materialUnits';

    export default {
        components: {
            'WarehouseTabs': require('./WarehouseTabs')
        },

        data() {
            return {
                units: measurementUnits,
                materials: []
            }
        },

        methods: {

            removeMaterial(materialId) {
                GraphAPI.exec(`
                    mutation {
                        removeMaterial(id: ${materialId}) { id }
                    }
                `).then(response => {
                    this.loadMaterials();
                });
            },

            loadMaterials() {
                GraphAPI.exec(`
                    query {
                        materials {
                            id,
                            name,
                            unit
                        }
                    }
                `).then((response) => {

                    this.materials = response.data.data.materials;
                });

            }
        },

        created() {

            this.loadMaterials();
        }
    }
</script>