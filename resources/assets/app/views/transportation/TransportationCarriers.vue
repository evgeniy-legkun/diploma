<template>

    <section class="content">

        <div class="nav-tabs-custom">
            <TransportationTabs activeTab="transportation-carriers"></TransportationTabs>
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
                            <th>Опис</th>
                            <th>Редагувати</th>
                            <th>Видалити</th>
                        </tr>

                        <tr>
                            <td style="width: 10px">1</td>
                            <td>Фарба</td>
                            <td>Літри</td>
                            <td>Фарба акрилова</td>
                            <td>
                                <router-link :to="{name: 'material-edit'}" class="btn btn-warning">Редагувати</router-link>
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
            'TransportationTabs': require('./TransportationTabs')
        }
    }
</script>