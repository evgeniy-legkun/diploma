<template>

    <section class="content">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Додати матеріал до склад</h3>
            </div>

            <form role="form">
                <div class="box-body">


                    <div class="form-group">
                        <label>Матеріал</label>
                        <select v-model="material" class="form-control">
                            <option v-for="materialType in materials" :value="materialType.id">
                                {{materialType.name}} ({{units[materialType.unit]}})
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label >Назва</label>
                        <input v-model="quantity" type="text" min="0" class="form-control" placeholder="Кількість">
                    </div>

                </div>

                <div class="box-footer">
                    <button @click.prevent="addMaterialToWarehouse" type="submit" class="btn btn-primary">Зберегти</button>
                </div>
            </form>
        </div>

    </section>

</template>

<script>
    import measurementUnits from '../../constants/materialUnits';
    import GraphAPI from '../../api/GraphAPI';

    export default {
        data() {
            return {
                warehouseId: this.$route.params.id,
                material: null,
                materials: [],
                quantity: 0,
                units: measurementUnits
            }
        },

        methods: {

            addMaterialToWarehouse() {
                GraphAPI.exec(`
                    mutation {
                        addWarehouseMaterial(
                            warehouseId: ${this.warehouseId},
                            materialId: ${this.material},
                            quantity: ${this.quantity}
                        ) { id }
                    }
                `).then(response => {
                    this.$router.push({
                        name: 'warehouse-materials',
                        params: {id: this.warehouseId}
                    });
                })
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
                    this.material = this.materials[0].id;
                })
            }
        },

        created() {
            this.loadMaterials();
        }
    }
</script>