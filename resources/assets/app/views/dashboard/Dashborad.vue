<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Головна</h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Статистика</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Progress bars -->
                            <div class="clearfix">
                                <span class="pull-left">Завершені перевезення</span>
                                <small class="pull-right">{{deliveredTransactionsPercent.toFixed(2)}}%</small>
                            </div>
                            <div class="progress xs">
                                <div
                                    class="progress-bar progress-bar-green"
                                    :style="{width: deliveredTransactionsPercent + '%'}"
                                ></div>
                            </div>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- Progress bars -->
                            <div class="clearfix">
                                <span class="pull-left">Відхилені перевезення</span>
                                <small class="pull-right">{{canceledTransactionsPercent.toFixed(2)}}%</small>
                            </div>
                            <div class="progress xs">
                                <div
                                        class="progress-bar progress-bar-green"
                                        :style="{width: canceledTransactionsPercent + '%'}"
                                ></div>
                            </div>

                        </div>

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
                totalTransactions: 0,
                deliveredTransactions: 0,
                canceledTransactions: 0
            }
        },

        computed: {
            deliveredTransactionsPercent() {
                if (this.totalTransactions === 0) {
                    return 0;
                }
                return this.deliveredTransactions / this.totalTransactions * 100
            },

            canceledTransactionsPercent() {
                if (this.totalTransactions === 0) {
                    return 0;
                }
                return this.canceledTransactions / this.totalTransactions * 100
            }
        },

        methods: {
            loadData() {
                GraphAPI.exec(`
                    query {
                      transactions {
                        id,
                        status_code
                      }
                    }
                `).then(response => {
                    let transactions = response.data.data.transactions;
                    console.log(transactions);

                    for(let transaction of transactions) {
                        this.totalTransactions ++;
                        if (transaction.status_code === 3) {
                            this.canceledTransactions++;
                        }

                        if (transaction.status_code === 4) {
                            this.deliveredTransactions++;
                        }
                    }
                });
            }
        },

        created() {
            this.loadData();
        }
    }
</script>