
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('example-component', require('./components/Example.vue').default);

Vue.component('button-counter', {
    data: function () {
      return {
        count: 0
      }
    },
    template: '<button v-on:click="count++">You clicked me {{ count }} times.</button>'
  })

Vue.component('friend-component', {
    props: ['friend'],
    filters: {
        fullName(value) {
            return `${value.first} ${value.last}`;
        },
    },
    methods: {
        incrementAge(friend) {
            friend.age = friend.age + 1;
        },
        decrementAge(friend) {
            friend.age = friend.age - 1;
        },
    },
    template: `
    <div>
        <h4>{{friend | fullName}}</h4>
        <h5>Age: {{friend.age}}</h5>
        <button v-on:click="incrementAge(friend)">+</button>
        <button v-on:click="decrementAge(friend)">-</button>
        <input v-model="friend.first"/>
        <input v-model="friend.last"/>
    </div>
    `
})
const app = new Vue({
    el: '#app',
    data: {
        friends: [
            {
                first: "Chodny",
                last: "King",
                age: 24,
            },
            {
                first: "Molly",
                last: "John",
                age: 22,
            }
        ],
    },
    template: `
        <div>
            <example-component> </example-component>
            <friend-component v-for="item in friends" v-bind:friend="item" v-bind:key="item.id" />
            <button-counter> </button-counter>
        </div>
    `
});
