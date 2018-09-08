<template>
        <div>
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Транспортні витрати</h1>
            </section>
            <section class="content">
                <div class="nav-tabs-custom">
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <br/>
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Курєр</th>
                                    <th>Звідки</th>
                                    <th>Куди</th>
                                    <th>Відстань</th>
                                    <th>Паливо</th>
                                    <th>Людино-годин</th>
                                    <th>Сумма</th>
                                </tr>
                                <template v-for="transaction in transactions">
                                    <tr>
                                        <td style="width: 10px">{{transaction.id}}</td>
                                        <td>{{transaction.courier.name}} ({{transaction.courier.email}})</td>
                                        <td>{{transaction.fromWarehouse.name}}</td>
                                        <td>{{transaction.toWarehouse.name}}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>1000$</td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
</template>

<script>
    import GraphAPI from '../../api/GraphAPI';

    export default {


        data() {
            return {
                transactions: []
            }
        },

        methods: {
            loadTransactions() {
                GraphAPI.exec(`
                    query {
                      transactions {
                        id,
                        fromWarehouse { id, name, address },
                        toWarehouse { id, name, address },
                        materials { id, name, quantity, unit },
                        courier { id, name, email },
                        status_code
                      }
                    }
                `).then(response => {
                    this.transactions = response.data.data.transactions;
                    console.log(this.transactions);
                });
            }
        },

        created() {
            this.loadTransactions();
        }
    }
</script>