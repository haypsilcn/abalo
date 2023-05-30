import ComponentB from "./component-b.js"

export default {
    components: {
        ComponentB
    },
    data() {
        return {
            calledB: false
        }
    },
    template: '<button @click="calledB = !calledB">Show/Hide Component-B from Component-A</button>' +
        '<div v-if="calledB === true"> <Component-B/></div>'
}
