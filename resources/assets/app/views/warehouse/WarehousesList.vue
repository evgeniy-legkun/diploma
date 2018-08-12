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
                            <th>Редагувати</th>
                            <th>Видалити</th>
                        </tr>

                        <tr>
                            <td>#</td>
                            <td><router-link :to="{name: 'warehouse-materials'}">Склад 1</router-link></td>
                            <td>м.Вінниця Новобогданівка</td>
                            <td>
                                <router-link :to="{name: 'warehouse-edit'}" class="btn btn-warning">Редагвати</router-link>
                            </td>
                            <td>
                                <button class="btn btn-danger">Видалити</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </section>

</template>

<script>
    export default {
        components: {
            'WarehouseTabs': require('./WarehouseTabs')
        }
    }
</script>