<template>

    <section class="content">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Стоворити склад</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
                <div class="box-body">
                    <div class="form-group">
                        <label >Назва</label>
                        <input v-model="name" type="text" class="form-control" placeholder="Назва">
                    </div>

                    <div class="form-group">
                        <label>Одиниця вимірювання</label>
                        <select v-model="unit" class="form-control">
                            <option v-for="(unitName, unitCode) in units" :value="unitCode">
                                {{unitName}}
                            </option>
                        </select>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button @click.prevent="saveMaterial" type="submit" class="btn btn-primary">Редагувати</button>
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
                materialId: this.$route.params.id,
                name: '',
                unit: 1,
                units: measurementUnits
            }
        },

        methods: {
            saveMaterial() {
                GraphAPI.exec(`
                    mutation {
                        updateMaterial(id: ${this.materialId}, name: "${this.name}", unit: ${this.unit}) {
                            id
                        }
                    }
                `).then((response) => {
                    this.$router.push({name: 'materials-list'});
                });
            },

            loadMaterial() {
                GraphAPI.exec(`
                    query {
                        material(id: ${this.materialId}) {
                            name,
                            unit
                        }
                    }
                `).then((response) => {
                    let material = response.data.data.material;
                    this.name = material.name;
                    this.unit = material.unit;
                })
            }
        },

        created() {
            this.loadMaterial();
        }
    }
</script>