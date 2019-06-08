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
        reverseMessage() {
            this.message = this.message.split("").reverse().join("")
        }
    }
});