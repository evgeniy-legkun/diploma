<template>
    <section class="content">

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Список матеріалів в складі</h3>
            </div>
            <div class="box-body">
                <router-link class="btn btn-success" :to="{name: 'warehouse-material-add'}" >Додати матеріал</router-link>
                <br />
                <br />

                <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Матеріал</th>
                                <th>Одиниця вимірювання</th>
                                <th>Кількість</th>
                                <th>Редагувати</th>
                                <th>Видалити</th>
                            </tr>

                            <tr>
                                <td>1</td>
                                <td>Фарба</td>
                                <td>Літри</td>
                                <td>20</td>
                                <td><router-link :to="{name: 'warehouse-material-edit'}" class="btn btn-warning">Редагувати</router-link></td>
                                <td><a class="btn btn-danger">Видалити</a></td>
                            </tr>

                        </tbody>
                </table>
            </div>

        </div>

    </section>
</template>

<script>

</script>