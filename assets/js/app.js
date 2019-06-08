import Vue from 'vue';

new Vue({
    el: '#page-container',
    delimiters: ['${', '}'],

    data() {
        return {
            message: 'hello'
        }
    },
    methods: {
        deleteTodo(id) {
            fetch('/todo/delete/'+id).then(() => {
                alert("Delete TODO");
            })
        }
    }
});