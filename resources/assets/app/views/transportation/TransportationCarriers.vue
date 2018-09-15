<template>

    <section class="content">

        <div class="nav-tabs-custom">
            <TransportationTabs activeTab="transportation-carriers"></TransportationTabs>
            <div class="tab-content">
                <div class="tab-pane active">
                    <br/>

                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Кур'єр</th>
                            <th>Створені</th>
                            <th>Прийняті</th>
                            <th>Відхилені</th>
                            <th>Завершені</th>
                            <th>Створити перевезення</th>
                        </tr>

                        <template v-for="courier in couriers">
                            <tr>
                                <td style="width: 10px">{{courier.id}}</td>
                                <td>{{courier.name}} ({{courier.email}})</td>
                                <td>{{courier.createdTransactions.length}}</td>
                                <td>{{courier.acceptedTransactions.length}}</td>
                                <td>{{courier.canceledTransactions.length}}</td>
                                <td>{{courier.deliveredTransactions.length}}</td>
                                <td>
                                    <router-link :to="{name: 'transportation-create', params: {courierId: courier.id}}"
                                                 class="btn btn-sm btn-success">
                                        Створити перевезення
                                    </router-link>
                                </td>
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

    import GraphAPI from '../../api/GraphAPI';

    export default {

        data() {

            return {
                couriers: []
            }

        },

        components: {
            'TransportationTabs': require('./TransportationTabs')
        },

        methods: {
            loadCouriers() {

                GraphAPI.exec(`
                    query {
                      users (role: 1) {
                        id, name, email, role,
                        createdTransactions: transactions (status_code: 1) {
                          id,
                          status_code,
                          toWarehouse { id, name },
                          fromWarehouse { id, name }
                        },
                        acceptedTransactions: transactions (status_code: 2) {
                          id,
                          status_code,
                          toWarehouse { id, name },
                          fromWarehouse { id, name }
                        }
                        canceledTransactions: transactions (status_code: 3) {
                          id,
                          status_code,
                          toWarehouse { id, name },
                          fromWarehouse { id, name }
                        },
                        deliveredTransactions: transactions (status_code: 4) {
                          id,
                          status_code,
                          toWarehouse {id, name },
                          fromWarehouse { id, name }
                        }
                      }
                    }
                `).then(response => {
                    this.couriers = response.data.data.users;
                });

            }
        },

        created() {
            this.loadCouriers();
        }
    }
</script>