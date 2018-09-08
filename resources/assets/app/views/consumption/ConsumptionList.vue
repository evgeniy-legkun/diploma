<template>
        <div>
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Витрати на паливо</h1>
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
                                    <th>З відки</th>
                                    <th>Куди</th>
                                    <th>Відстань</th>
                                    <th>Витрати</th>
                                    <th>Ціна</th>
                                </tr>

                                <template v-for="transaction in transactions">
                                    <tr>
                                        <td style="width: 10px">{{transaction.id}}</td>
                                        <td>{{transaction.courier.name}} ({{transaction.courier.email}})</td>
                                        <td>{{transaction.fromWarehouse.name}}</td>
                                        <td>{{transaction.toWarehouse.name}}</td>
                                        <td>відстань</td>
                                        <td>ціна</td>
                                        <td><button @click.prevent="removeTransaction(transaction.id)" class="btn btn-sm btn-danger">Видалити</button></td>
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
    import measurementUnits from '../../constants/materialUnits';
    import transactionCodes from '../../constants/transactionCodes';

    export default {


        data() {
            return {
                transactions: [],
                units: measurementUnits,
                codes: transactionCodes
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
            },

            acceptTransaction(transactionId) {
                GraphAPI.exec(`
                    mutation {
                      acceptTransaction(id: ${transactionId}) {id}
                    }
                `).then(response => {
                    this.loadTransactions();
                });
            },

            cancelTransaction(transactionId) {
                GraphAPI.exec(`
                    mutation {
                      cancelTransaction(id: ${transactionId}) {id}
                    }
                `).then(response => {
                    this.loadTransactions();
                });
            },

            removeTransaction(transactionId) {
                GraphAPI.exec(`
                    mutation {
                      removeTransaction(id: ${transactionId}) {id}
                    }
                `).then(response => {
                    this.loadTransactions();
                });
            },

            finishTransaction(transactionId) {
                GraphAPI.exec(`
                    mutation {
                      finishTransaction(id: ${transactionId}) {id}
                    }
                `).then(response => {
                    this.loadTransactions();
                });
            },

        },

        created() {
            this.loadTransactions();
        }
    }
</script>