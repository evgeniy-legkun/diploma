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
                                <th>Кур'єр</th>
                                <th>Звідки</th>
                                <th>Куди</th>
                                <th>Відстань, км</th>
                                <th>Паливо, л</th>
                                <th>Людино-годин, год</th>
                                <th>Загальні витрати, $</th>
                            </tr>
                            <template v-for="transaction in transactions">
                                <tr :class="{'min-cost': transaction.isMin, 'max-cost': transaction.isMax}">
                                    <td style="width: 10px">{{transaction.id}}</td>
                                    <td>{{transaction.courier.name}} ({{transaction.courier.email}})</td>
                                    <td>{{transaction.fromWarehouse.name}}</td>
                                    <td>{{transaction.toWarehouse.name}}</td>
                                    <td>{{transaction.distance}}</td>
                                    <td>{{transaction.fuelConsumption}}</td>
                                    <td>{{transaction.peopleHours}}</td>
                                    <td>{{transaction.totalCosts}} $</td>
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
  import GraphAPI from "../../api/GraphAPI";

  export default {


    data() {
      return {
        transactions: []
      };
    },

    methods: {
      loadTransactions() {
        GraphAPI.exec(`
                    query {
                      transactions {
                        id,
                        fromWarehouse { id, name, lat_point, lng_point, address },
                        toWarehouse { id, name, lat_point, lng_point, address },
                        materials { id, name, quantity, unit },
                        courier { id, name, email },
                        status_code
                      }
                    }
                `)
          .then(response => {
            this.transactions = response.data.data.transactions;

            let transactionsTemp = this.transactions;
            // count distance for each transaction
            for (const transaction of transactionsTemp) {
                transaction.distance = this.calculateDistance(transaction.fromWarehouse, transaction.toWarehouse);
                transaction.fuelConsumption = this.calculateFuelConsumption(transaction.distance);
                transaction.peopleHours = this.calculatePeopleHours(transaction.distance);
                transaction.totalCosts = this.calculateTotalCosts(transaction.distance);
            }

            // add marks for the most expensive transactions
            const { min: minTotalCost, max: maxTotalCost } = this.getMinMaxTotalCost(transactionsTemp);

            for (const transaction of transactionsTemp) {
                transaction.isMin = transaction.totalCosts === minTotalCost;
                transaction.isMax = transaction.totalCosts === maxTotalCost;
            }

            this.transactions = transactionsTemp;
          });
      },

      getMinMaxTotalCost(transactions) {
        let arrayAllCosts = [];
        for (const transaction of transactions) {
          if (!arrayAllCosts.includes(transaction.totalCosts)) {
            arrayAllCosts.push(transaction.totalCosts);
          }
        }

        return {
          min: Math.min(...arrayAllCosts),
          max: Math.max(...arrayAllCosts)
        };
      },

      calculateDistance(firstPoint, secondPoint) {
        let R = 6371e3; // metres
        let f1 = this.toRadians(firstPoint.lat_point);
        let f2 = this.toRadians(secondPoint.lat_point);

        let af = this.toRadians(secondPoint.lat_point - firstPoint.lat_point);
        let av = this.toRadians(secondPoint.lng_point - firstPoint.lng_point);

        let a = Math.sin(af / 2) * Math.sin(af / 2) +
          Math.cos(f1) * Math.cos(f2) *
          Math.sin(av / 2) * Math.sin(av / 2);

        let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

        return (Math.ceil(R * c) / 1000).toFixed(2);
      },

      calculateFuelConsumption(distance) {
        return (distance * 0.147).toFixed(2);
      },

      calculatePeopleHours(distance) {
        return (distance * 0.15).toFixed(2);
      },

      calculateTotalCosts(distance) {
        const peopleHours = this.calculatePeopleHours(distance);
        return parseFloat((peopleHours * 7.5).toFixed(2));
      },

      toRadians(degrees) {
        return degrees * Math.PI / 180;
      }
    },

    created() {
      this.loadTransactions();
    }
  };
</script>

<style scoped>
    .min-cost {
        background-color: #00a65a;
    }
    .max-cost {
        background-color: #dd4b39;
    }
</style>