export default {
    data() {
        return {
            counter: 0
        }
    },
    template: '<div>Counter: {{ counter }}</div>' +
        '<button v-on:click="counter--">Decrease</button>' +
        '<button v-on:click="counter++">Increase</button>'
}
