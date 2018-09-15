<template>

    <section class="content">

        <div class="nav-tabs-custom">
            <TransportationTabs activeTab="transportation-list"></TransportationTabs>
            <div class="tab-content">
                <div class="tab-pane active">
                    <br/>

                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Курєр</th>
                            <th>Статус</th>
                            <th>З відки</th>
                            <th>Куди</th>
                            <th>Матеріали</th>
                            <th>Змінити статус</th>
                            <th>Видалити</th>
                        </tr>

                        <template v-for="transaction in transactions">
                            <tr>
                                <td style="width: 10px">{{transaction.id}}</td>
                                <td>{{transaction.courier.name}} ({{transaction.courier.email}})</td>
                                <td>{{codes[transaction.status_code]}}</td>
                                <td>{{transaction.fromWarehouse.name}}</td>
                                <td>{{transaction.toWarehouse.name}}</td>
                                <td>
                                    <ul>
                                        <li v-for="material in transaction.materials">
                                            {{material.name}} - {{material.quantity}} {{units[material.unit]}}
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <template v-if="transaction.status_code == 1">
                                        <button @click.prevent="acceptTransaction(transaction.id)" class="btn btn-sm btn-success">Прийняти</button>
                                        <button @click.prevent="cancelTransaction(transaction.id)" class="btn btn-sm btn-danger">Відхилити</button>
                                    </template>

                                    <template v-if="transaction.status_code == 2">
                                        <button @click.prevent="finishTransaction(transaction.id)"  class="btn btn-sm btn-success">Завершити</button>
                                    </template>


                                </td>
                                <td><button @click.prevent="removeTransaction(transaction.id)" class="btn btn-sm btn-danger">Видалити</button></td>
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

    import measurementUnits from '../../constants/materialUnits';
    import transactionCodes from '../../constants/transactionCodes';
    import GraphAPI from '../../api/GraphAPI';

    export default {

        components: {
            'TransportationTabs': require('./TransportationTabs')
        },

        data() {
            return {
                units: measurementUnits,
                codes: transactionCodes,
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