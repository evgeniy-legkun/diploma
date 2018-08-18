<template>

    <section class="content">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Стоворити склад</h3>
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
                <button @click.prevent="saveWarehouse" type="submit" class="btn btn-primary">Створити</button>
            </div>

        </div>

    </section>

</template>

<script>

    import GraphAPI from '../../api/GraphAPI';

    export default {
        data() {
            return {
                address: '',
                name: '',
                note: '',
            }
        },

        methods: {
            saveWarehouse() {

                GraphAPI.exec(`
                    mutation {
                        createWarehouse(
                            address: "${this.address}",
                            name: "${this.name}",
                            note: "${this.note}",
                        ) {
                            id
                        }
                    }
                `).then((response) => {
                    this.$router.push({name: 'warehouses-list'});
                });

            }
        }
    }

</script>